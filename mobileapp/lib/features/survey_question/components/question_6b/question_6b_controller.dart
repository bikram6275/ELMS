import 'package:dio/dio.dart' as D;
import 'package:elms/constant/api_path.dart';
import 'package:elms/constant/app_strings.dart';
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
import '../../survey_question_controller.dart';

class Question6bController extends GetxController {
  final SurveyQuestionController _surveyQuestionController = Get.find();

  //q 6.b
  RxList<List<TextEditingController>> q6bControllersList =
      <List<TextEditingController>>[].obs;
  late Box box;

  final AppStrings _strings = Get.find();
  final ApiService _apiService = Get.find();
  final ApiPath _path = Get.find();

  @override
  void onInit() {
    initializeMethod();
    super.onInit();
  }

  @override
  void onClose() {
    disposeAllControllers();
    super.onClose();
  }

  initializeMethod() async {
    box = await Hive.openBox("db");

    createControllerForFields();
    syncAnswersFromDatabase();
  }

  getValueOfControllers() {
    List<List<String?>> list = [];
    for (var element in q6bControllersList) {
      List<String?> temps = [];
      for (var controller in element) {
        temps.add(controller.text);
      }
      list.add(temps);
    }
    return list;
  }

  disposeAllControllers() {
    for (var element in q6bControllersList) {
      for (var element in element) {
        element.dispose();
      }
    }
  }

  getSpecificQuestionMapByQuestionNumberOffline(questionNumber) {
    List questions = box.get(HiveKeys.getQuestionKey(
        _surveyQuestionController.dataList[0],
        _surveyQuestionController.dataList[1]));

    Map data = {};
    for (var element in questions) {
      if (element["qsn_number"] == questionNumber) {
        data = element;
        return data;
      }
    }
    return data;
  }

  createControllerForFields() {
    Map question6b = getSpecificQuestionMapByQuestionNumberOffline("6.b");
    List list = question6b["occupations"];

    /// define a bool to create list once
    for (var element in list) {
      TextEditingController q6bWorkingNumber =
          TextEditingController(text: 0.toString());
      TextEditingController q6bRequiredNumber =
          TextEditingController(text: 0.toString());
      TextEditingController q6bEstimateRequired2Year =
          TextEditingController(text: 0.toString());
      TextEditingController q6bEstimateRequired5Year =
          TextEditingController(text: 0.toString());
      q6bControllersList.add(
        [
          q6bWorkingNumber,
          q6bRequiredNumber,
          q6bEstimateRequired2Year,
          q6bEstimateRequired5Year
        ],
      );
    }
  }

  getOldAnswerIds() {
    Map question6b = getSpecificQuestionMapByQuestionNumberOffline("6.b");
    List answers = question6b["answer"];
    List tempAnswer = [];
    if (answers.isNotEmpty) {
      for (var element in answers) {
        tempAnswer.add(element["id"]);
      }
    }
    return tempAnswer;
  }

  syncAnswersFromDatabase() async {
    var dataList = _surveyQuestionController.dataList;

    // q 6.b
    AnswerHiveObject? answerQuestion6b =
        box.get("18${dataList[0]}${dataList[1]}");
    if (answerQuestion6b != null) {
      List items = answerQuestion6b.extraData!["answer"];
      for (var i = 0; i < items.length; i++) {
        List controllers = items[i];
        for (var j = 0; j < controllers.length; j++) {
          q6bControllersList[i][j].text = controllers[j];
        }
      }
    }
  }

  checkQ6Controllers() {
    bool status = true;
    for (var element in q6bControllersList) {
      for (var controller in element) {
        if (controller.text.isEmpty) {
          status = false;
        }
      }
    }
    if (!status) {
      return status;
    } else {
      return status;
    }
  }

  createKeyValueToAnswer() {
    var occupationStatus = {};
    Map question6b = getSpecificQuestionMapByQuestionNumberOffline("6.b");
    List occupationsList = question6b["occupations"];
    List answers = getOldAnswerIds();

    int diff = occupationsList.length - answers.length;

    while (diff > 0) {
      answers.add(0);
      diff--;
    }

    print("listststst" + answers.length.toString());
    print("asdfasdfasdf" + occupationsList.length.toString());

    for (var i = 0; i < occupationsList.length; i++) {
      dynamic occupationItem = occupationsList[i];
      List<TextEditingController> controllers = q6bControllersList[i];
      int? answerId;
      if (answers.isNotEmpty && answers[i] != null) {
        answerId = answers[i];
      }
      occupationStatus.addAll(
        {
          occupationItem["id"].toString(): {
            "id": answerId ?? 0,
            "working_number": controllers[0].text,
            "required_number": controllers[1].text,
            "for_two_years": controllers[2].text,
            "for_five_years": controllers[3].text
          }
        },
      );
    }
    return occupationStatus;
  }

  answerQuestion6b(questionId, questionType, questionNumber) async {
    bool internetStatus = await ConnectionStatus.checkConnection();

    var formData = {
      "pivot_id": _surveyQuestionController.dataList[1],
      "question_id": questionId,
      "occupation_status": createKeyValueToAnswer()
    };

    if (internetStatus) {
      try {
        if (checkQ6Controllers()) {
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
              ..extraData = {"answer": getValueOfControllers()};

            /// key of each object is questionId|surveyId|pivotId
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
          snackBar(_strings.failedTitle, "Please fill fields.", error: true);
        }
      } catch (e, s) {
        _surveyQuestionController.answerQuestionLoading(false);

        debugger(stacktrace: s, error: e);
      }
    } else {
      if (checkQ6Controllers()) {
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
          ..extraData = {"answer": getValueOfControllers()};

        /// key of each object is questionId|surveyId|pivotId
        box.put(
            "$questionId${_surveyQuestionController.dataList[0]}${_surveyQuestionController.dataList[1]}",
            answerModel);
      } else {
        snackBar(_strings.failedTitle, "Please fill fields.", error: true);
      }
    }
  }
}
