import 'package:dio/dio.dart' as D;
import 'package:elms/constant/api_path.dart';
import 'package:elms/constant/app_strings.dart';
import 'package:elms/features/survey_question/survey_question_controller.dart';
import 'package:elms/infrastructure/api_service/api_service.dart';
import 'package:elms/infrastructure/hive_database/answer_hive_object.dart';
import 'package:elms/infrastructure/hive_database/hive_keys.dart';
import 'package:elms/models/sync_answer/sync_answer_model.dart';
import 'package:elms/utils/connection_status/connection_status.dart';
import 'package:elms/utils/debugger/debugger.dart';
import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:hive_flutter/hive_flutter.dart';

import '../../../../utils/snackbar/snackbar.dart';

class MultipleInputQuestionController extends GetxController {
  final SurveyQuestionController _surveyQuestionController = Get.find();
  late Box box;

  final AppStrings _strings = Get.find();
  final ApiService _apiService = Get.find();
  final ApiPath _path = Get.find();

  // q 12
  RxList<TextEditingController> q12TextEditingController =
      RxList.generate(4, (item) => TextEditingController());

  // q 20
  RxList<TextEditingController> q20TextEditingController =
      RxList.generate(6, (item) => TextEditingController());

  @override
  void onInit() async {
    box = await Hive.openBox("db");
    syncAnswersFromDatabase();
    super.onInit();
  }

  @override
  void onClose() {
    disposeAllControllers();
    super.onClose();
  }

  disposeAllControllers() {
    for (var element in q12TextEditingController) {
      element.dispose();
    }
    for (var element in q20TextEditingController) {
      element.dispose();
    }
  }

  syncAnswersFromDatabase() {
    var dataList = _surveyQuestionController.dataList;
    // question 12
    AnswerHiveObject? answerQuestion12 =
        box.get("25${dataList[0]}${dataList[1]}");
    if (answerQuestion12 != null) {
      List list = answerQuestion12.extraData!["answers"];

      for (int i = 0; i < list.length; i++) {
        q12TextEditingController[i].text = list[i] ?? "";
      }
    }

    // question 20
    AnswerHiveObject? answerQuestion20 =
        box.get("33${dataList[0]}${dataList[1]}");
    if (answerQuestion20 != null) {
      List list = answerQuestion20.extraData!["answers"];

      for (int i = 0; i < list.length; i++) {
        q20TextEditingController[i].text = list[i] ?? "";
      }
    }
  }

  getOptionsIdFromQuestionResponse(String questionNumber) {
    try {
      List finalOptionsList = [];
      var dataList = _surveyQuestionController.dataList;

      List questions =
          box.get(HiveKeys.getQuestionKey(dataList[0], dataList[1]));

      for (var element in questions) {
        if (element["qsn_number"] == questionNumber) {
          List optionsList = element["question_options"];
          finalOptionsList =
              optionsList.map((e) => e["id"].toString()).toList();
        }
      }
      return finalOptionsList;
    } catch (e, s) {
      debugger(error: e, stacktrace: s);
    }
  }

  getMultipleInputControllers(questionNumber) {
    switch (questionNumber) {
      case "12":
        return q12TextEditingController;
      case "20":
        return q20TextEditingController;
    }
  }

  question12_20Condition(questionNumber) {
    bool validation = true;
    if (questionNumber == "12") {
      List duplication = [];
      List temp = [];
      for (var element in q12TextEditingController) {
        if (temp.contains(element.text)) duplication.add(element.text);
        temp.add(element.text);
      }
      if (duplication.isNotEmpty) {
        validation = false;
        snackBar("Notice",
            "Please use unique value between 1-4 for each tile to submit rank",
            error: true);
      }
    } else if (questionNumber == "20") {
      // todo : duplicate values disabled by employer you can enable it with uncomment below code
      // List duplication = [];
      // List temp = [];
      // for (var element in q20ControllersList) {
      //   if (temp.contains(element.text)) duplication.add(element.text);
      //   temp.add(element.text);
      // }
      // if (duplication.isNotEmpty) {
      //   validation = false;
      //   snackBar("Notice",
      //       "Please use unique value between 1-5 for each tile to submit rank",
      //       error: true);
      // }
    }

    return validation;
  }

  answerMultipleInputQuestion(
      questionId,
      RxList<TextEditingController> editControllersList,
      questionType,
      questionNumber) async {
    bool internetStatus = await ConnectionStatus.checkConnection();

    List<String?> answerStrings = [];
    Map? answerData;
    Map formData;
    List optionsId = [];

    // get value of controllers to submit quesitons
    for (var element in editControllersList) {
      if (element.text.isEmpty) {
        answerStrings.add("");
      } else {
        answerStrings.add(element.text);
      }
    }

    optionsId = getOptionsIdFromQuestionResponse(questionNumber);

    if (questionNumber == "12") {
      answerData = {
        optionsId[0]: answerStrings[0],
        optionsId[1]: answerStrings[1],
        optionsId[2]: answerStrings[2],
        optionsId[3]: answerStrings[3]
      };
    } else if (questionNumber == "20") {
      answerData = {
        optionsId[0]: answerStrings[0],
        optionsId[1]: answerStrings[1],
        optionsId[2]: answerStrings[2],
        optionsId[3]: answerStrings[3],
        optionsId[4]: answerStrings[4],
        optionsId[5]: answerStrings[5],
      };
    }

    formData = {
      "pivot_id": _surveyQuestionController.dataList[1],
      "question_id": questionId,
      "answer": [
        answerData ?? {},
      ],
      "answer_id":
          _surveyQuestionController.getAnswerIdByQuestionName(questionNumber),
    };

    if (question12_20Condition(questionNumber)) {
      if (internetStatus) {
        try {
          if (_surveyQuestionController
              .checkListOfFormFieldsControllers(editControllersList)) {
            _surveyQuestionController.answerQuestionLoading(true);

            D.Response response = await _apiService.post(
              path: _path.answer,
              needToken: true,
              formData: formData,
            );

            if (response.statusCode == 200) {
              /// push indicator index to next question
              _surveyQuestionController.goToNextQuestion();

              /// save object in hive

              var answerModel = AnswerHiveObject()
                ..questionId = questionId
                ..fieldValue = " "
                ..questionType = questionType
                ..extraData = {"answers": answerStrings};

              /// key of each object is question id|surveyId|pivotId
              box.put(
                  "$questionId${_surveyQuestionController.dataList[0]}${_surveyQuestionController.dataList[1]}",
                  answerModel);
            } else {
              snackBar(_strings.failedTitle,
                  "Failed to answer question please try again",
                  error: true);
            }
            _surveyQuestionController.answerQuestionLoading(false);
          } else {
            snackBar(_strings.failedTitle, "Please fill one field at least.",
                error: true);
          }
        } catch (e, s) {
          _surveyQuestionController.answerQuestionLoading(false);

          debugger(stacktrace: s, error: e);
        }
      } else {
        /// add question to update required list to sync with server later
        _surveyQuestionController.addQuestionToUpdateList(
          data: SyncAnswerModel(
              formData: formData,
              questionId: questionId,
              questionNumber: questionNumber),
        );

        _surveyQuestionController.goToNextQuestion();

        /// save object in hive

        var answerModel = AnswerHiveObject()
          ..questionId = questionId
          ..fieldValue = " "
          ..questionType = questionType
          ..extraData = {"answers": answerStrings};

        /// key of each object is question id|surveyId|pivotId
        box.put(
            "$questionId${_surveyQuestionController.dataList[0]}${_surveyQuestionController.dataList[1]}",
            answerModel);
      }
    }
  }
}
