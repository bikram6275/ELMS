import 'package:elms/constant/api_path.dart';
import 'package:elms/constant/app_strings.dart';
import 'package:elms/features/survey_question/survey_question_controller.dart';
import 'package:elms/infrastructure/api_service/api_service.dart';
import 'package:elms/infrastructure/hive_database/answer_hive_object.dart';
import 'package:elms/infrastructure/hive_database/hive_keys.dart';
import 'package:elms/models/input_question/input_question.dart';
import 'package:elms/models/sync_answer/sync_answer_model.dart';
import 'package:elms/utils/connection_status/connection_status.dart';
import 'package:elms/utils/debugger/debugger.dart';
import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:hive_flutter/hive_flutter.dart';
import 'package:dio/dio.dart' as D;

import '../../../../utils/snackbar/snackbar.dart';

class InputQuestionController extends GetxController {
  final SurveyQuestionController _surveyQuestionController = Get.find();
  late Box box;
  RxList<InputQuestionModel> listOfQuestions = <InputQuestionModel>[].obs;
  RxBool getInputQuestionsLoading = true.obs;

  final AppStrings _strings = Get.find();
  final ApiService _apiService = Get.find();
  final ApiPath _path = Get.find();

  @override
  void onClose() {
    disposeAllControllers();
    super.onClose();
  }

  @override
  void onInit() async {
    box = await Hive.openBox("db");
    getListOfInputQuestion();
    syncAnswersFromDatabase();
    super.onInit();
  }

  disposeAllControllers() {
    for (var element in listOfQuestions) {
      element.textEditingController.dispose();
    }
  }

  getListOfInputQuestion() {
    getInputQuestionsLoading(true);
    var dataList = _surveyQuestionController.dataList;
    List questions = box.get(HiveKeys.getQuestionKey(dataList[0], dataList[1]));
    for (var element in questions) {
      if (element["ans_type"] == "input") {
        TextEditingController editingController = TextEditingController();
        InputQuestionModel item = InputQuestionModel(
          textEditingController: editingController,
          questionNumber: element["qsn_number"],
        );
        listOfQuestions.add(item);
      }
    }
    getInputQuestionsLoading(false);
  }

  syncAnswersFromDatabase() {
    var dataList = _surveyQuestionController.dataList;

    for (var element in listOfQuestions) {
      AnswerHiveObject? answer = box.get(
          "${_surveyQuestionController.getQuestionIdByQuestionNumber(element.questionNumber)}${dataList[0]}${dataList[1]}");
      if (answer != null) {
        element.textEditingController.text = answer.fieldValue!;
      }
    }
  }

  getControllerOfQuestionInputQuestion(questionNumber) {
    for (var element in listOfQuestions) {
      if (element.questionNumber == questionNumber) {
        return element.textEditingController;
      }
    }
  }

  validationsOnInputQuestions(
      questionNumber, TextEditingController editController) {
    if (questionNumber == "1.6") {
      if (editController.text.isNotEmpty) {
        if (editController.text.length < 9) {
          snackBar(_strings.failedTitle, "Please enter 9 digits.", error: true);
          return false;
        }
      }
      return true;
    } else {
      if (editController.text.isNotEmpty) {
        return true;
      } else {
        snackBar(_strings.failedTitle, "Please fill fields.", error: true);
        return false;
      }
    }
  }

  answerInputQuestion(
      questionId, editController, questionType, questionNumber) async {
    bool internetStatus = await ConnectionStatus.checkConnection();
    var dataList = _surveyQuestionController.dataList;

    var formData = {
      "pivot_id": dataList[1],
      "question_id": questionId,
      "answer": [editController.text],
      "other_answer": null,
      "answer_id":
          _surveyQuestionController.getAnswerIdByQuestionName(questionNumber),
    };

    if (validationsOnInputQuestions(questionNumber, editController)) {
      _surveyQuestionController.answerQuestionLoading(true);

      if (internetStatus) {
        try {
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
              ..fieldValue = editController.text
              ..questionType = questionType
              ..extraData = {};

            /// key of each object is question id|surveyId|pivotId
            box.put("$questionId${dataList[0]}${dataList[1]}", answerModel);
          } else {
            snackBar(_strings.failedTitle,
                "Failed to answer question please try again",
                error: true);
          }
          _surveyQuestionController.answerQuestionLoading(false);
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
          ..fieldValue = editController.text
          ..questionType = questionType
          ..extraData = {};

        /// key of each object is question id|surveyId|pivotId
        box.put("$questionId${dataList[0]}${dataList[1]}", answerModel);
      }
      _surveyQuestionController.answerQuestionLoading(false);
    }
  }
}
