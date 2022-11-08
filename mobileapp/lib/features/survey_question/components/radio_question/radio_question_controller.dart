// ignore_for_file: non_constant_identifier_names, unused_field

import 'package:elms/constant/api_path.dart';
import 'package:elms/constant/app_strings.dart';
import 'package:elms/features/survey_question/survey_question_controller.dart';
import 'package:elms/infrastructure/api_service/api_service.dart';
import 'package:elms/infrastructure/custom_storage/custom_storage.dart';
import 'package:elms/infrastructure/hive_database/answer_hive_object.dart';
import 'package:elms/models/sync_answer/sync_answer_model.dart';
import 'package:elms/utils/connection_status/connection_status.dart';
import 'package:elms/utils/debugger/debugger.dart';
import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:hive_flutter/hive_flutter.dart';
import 'package:dio/dio.dart' as D;

import '../../../../utils/snackbar/snackbar.dart';

class RadioQuestionController extends GetxController {
  final SurveyQuestionController _surveyQuestionController = Get.find();
  late Box box;

  final AppStrings _strings = Get.find();
  final ApiService _apiService = Get.find();
  final ApiPath _path = Get.find();
  final CustomStorage _storage = Get.find();

  // q 1.4
  RxInt q1_4RadioValue = 0.obs;

  // q 1.6
  RxInt q1_6RadioValue = 0.obs;

  // q 1.7
  RxInt q1_7RadioValue = 0.obs;

  // q 1.8
  RxInt q1_8RadioValue = 0.obs;

  // q 7
  RxInt q7RadioValue = 0.obs;

  // q 10
  RxInt q10RadioValue = 0.obs;
  TextEditingController q10_OtherAnswer = TextEditingController();

  // q 11
  RxInt q11RadioValue = 0.obs;

  // q 14
  RxInt q14RadioValue = 0.obs;

  // q 15
  RxInt q15RadioValue = 0.obs;

  // q 16
  RxInt q16RadioValue = 0.obs;

  // q 21
  RxInt q21RadioValue = 0.obs;
  TextEditingController q21_OtherAnswer = TextEditingController();

  @override
  void onInit() async {
    box = await Hive.openBox("db");
    syncAnswersFromDatabase();
    super.onInit();
  }

  @override
  void onClose() {
    q21_OtherAnswer.dispose();
    q10_OtherAnswer.dispose();
    super.onClose();
  }

  getQuestion16OptionName({required questionData}) {
    String option = " ";
    List questionOptions = questionData["question_options"];

    for (var element in questionOptions) {
      if (element["id"] == q16RadioValue.value) {
        option = element["option_number"];
      }
    }

    return option;
  }

  checkQuestion1_5Condition(questionData) {
    bool status = true;
    if ((questionData["question_options"] as List).isNotEmpty) {
      for (var element in (questionData["question_options"] as List)) {
        if (element["option_name"] == "Individual Proprietor") {
          if (q1_4RadioValue.value == element["id"]) {
            status = false;
          }
        }
      }
    } else {
      status = true;
    }
    return status;
  }

  getRadioButtonValue(questionNumber) {
    switch (questionNumber) {
      case "1.4":
        return q1_4RadioValue;
      case "2.1":
        return q1_6RadioValue;
      case "2.2":
        return q1_7RadioValue;
      case "2.3":
        return q1_8RadioValue;
      case "7":
        return q7RadioValue;
      case "10":
        return q10RadioValue;
      case "11":
        return q11RadioValue;
      case "14":
        return q14RadioValue;
      case "15":
        return q15RadioValue;
      case "16":
        return q16RadioValue;
      case "21":
        return q21RadioValue;
    }
  }

  getRadioDataFromDatabase(qId) {
    var dataList = _surveyQuestionController.dataList;
    AnswerHiveObject? answer = box.get("$qId${dataList[0]}${dataList[1]}");
    if (answer != null) {
      return answer.extraData!["answer"];
    } else {
      return 0;
    }
  }

  syncAnswersFromDatabase() {
    var dataList = _surveyQuestionController.dataList;
    // question 1.4
    q1_4RadioValue(getRadioDataFromDatabase(4));
    // question 1.6
    q1_6RadioValue(getRadioDataFromDatabase(6));
    // question 1.7
    q1_7RadioValue(getRadioDataFromDatabase(7));
    // question 1.8
    q1_8RadioValue(getRadioDataFromDatabase(38));
    // question 7
    q7RadioValue(getRadioDataFromDatabase(19));
    // question 10
    q10RadioValue(getRadioDataFromDatabase(23));
    // question 11
    q11RadioValue(getRadioDataFromDatabase(24));
    // question 14
    q14RadioValue(getRadioDataFromDatabase(28));
    // question 15
    q15RadioValue(getRadioDataFromDatabase(29));
    // question 16
    q16RadioValue(getRadioDataFromDatabase(30));
    // question 21
    q21RadioValue(getRadioDataFromDatabase(35));

    AnswerHiveObject? answerQuestion10 =
        box.get("23${dataList[0]}${dataList[1]}");

    if (answerQuestion10 != null) {
      q10_OtherAnswer.text = answerQuestion10.fieldValue!;
    }

    AnswerHiveObject? answerQuestion21 =
        box.get("35${dataList[0]}${dataList[1]}");

    if (answerQuestion21 != null) {
      q21_OtherAnswer.text = answerQuestion21.fieldValue!;
    }
  }

  question10HasError(questionNumber, radioValue) {
    if (questionNumber == "10") {
      if (radioValue == 49 && q10_OtherAnswer.text.isEmpty) {
        return true;
      } else {
        return false;
      }
    }
    return false;
  }

  question21HasError(questionNumber, radioValue) {
    if (questionNumber == "21") {
      if (radioValue == 85 && q21_OtherAnswer.text.isEmpty) {
        return true;
      } else {
        return false;
      }
    }
    return false;
  }

  answerRadioQuestion(
      questionId, radioValue, questionType, questionNumber) async {
    bool internetStatus = await ConnectionStatus.checkConnection();

    var dataList = _surveyQuestionController.dataList;
    String? otherAnswer;

    if (questionNumber == "21") {
      otherAnswer = q21_OtherAnswer.text;
    } else if (questionNumber == "10") {
      otherAnswer = q10_OtherAnswer.text;
    }

    var formData = {
      "pivot_id": dataList[1],
      "question_id": questionId,
      "answer": [radioValue],
      "other_answer": otherAnswer,
      "answer_id":
          _surveyQuestionController.getAnswerIdByQuestionName(questionNumber),
    };
    if (question10HasError(questionNumber, radioValue)) {
      snackBar(_strings.failedTitle, "Please fill field.", error: true);
    } else if (question21HasError(questionNumber, radioValue)) {
      snackBar(_strings.failedTitle, "Please fill field.", error: true);
    } else {
      if (internetStatus) {
        try {
          if (radioValue != 0) {
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
                ..fieldValue = otherAnswer
                ..questionType = questionType
                ..extraData = {"answer": radioValue};

              /// key of each object is question id|surveyId|pivotId
              box.put("$questionId${dataList[0]}${dataList[1]}", answerModel);
            } else {
              snackBar(_strings.failedTitle,
                  "Failed to answer question please try again",
                  error: true);
            }
            _surveyQuestionController.answerQuestionLoading(false);
          } else {
            snackBar(_strings.failedTitle, "Please select an item.",
                error: true);
          }
        } catch (e, s) {
          _surveyQuestionController.answerQuestionLoading(false);

          debugger(stacktrace: s, error: e);
        }
      } else {
        if (radioValue != 0) {
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
            ..fieldValue = otherAnswer
            ..questionType = questionType
            ..extraData = {"answer": radioValue};

          /// key of each object is question id|surveyId|pivotId
          box.put("$questionId${dataList[0]}${dataList[1]}", answerModel);
        } else {
          snackBar(_strings.failedTitle, "Please select an item.", error: true);
        }
      }
    }
  }
}
