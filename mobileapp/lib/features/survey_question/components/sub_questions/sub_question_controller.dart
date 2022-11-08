import 'package:elms/constant/api_path.dart';
import 'package:elms/features/survey_question/survey_question_controller.dart';
import 'package:elms/infrastructure/api_service/api_service.dart';
import 'package:elms/infrastructure/custom_storage/custom_storage.dart';
import 'package:elms/infrastructure/hive_database/answer_hive_object.dart';
import 'package:elms/infrastructure/hive_database/hive_keys.dart';
import 'package:elms/models/answer/drop_down_model.dart';
import 'package:elms/models/sync_answer/sync_answer_model.dart';
import 'package:elms/utils/connection_status/connection_status.dart';
import 'package:elms/utils/debugger/debugger.dart';
import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:hive_flutter/hive_flutter.dart';
import 'package:dio/dio.dart' as D;

class SubQuestionController extends GetxController {
  final SurveyQuestionController _surveyQuestionController = Get.find();
  late Box box;

  List<String> titles = [
    "FNCCI",
    "FNCSI",
    "CNI",
    "FCAN",
    "HAN",
  ];

  List<DropDownModel> yearDropDownList = [];
  List<DropDownModel> monthDropDownList = [];

  final ApiService _apiService = Get.find();
  final ApiPath _path = Get.find();
  final CustomStorage _storage = Get.find();

  @override
  void onInit() async {
    box = await Hive.openBox("db");
    fillYearAndMonthList();
    super.onInit();
  }

  @override
  void onClose() {
    clearAllControllers();
    super.onClose();
  }

  fillYearAndMonthList() {
    List year = box.get(HiveKeys.nYearKey);
    List month = box.get(HiveKeys.nMonthKey);

    for (var element in year) {
      yearDropDownList
          .add(DropDownModel(element["year"].toString(), element["id"]));
    }
    for (var element in month) {
      monthDropDownList
          .add(DropDownModel(element["month"].toString(), element["id"]));
    }
    yearDropDownList.insert(0, const DropDownModel("Clear Field", 1001));
    monthDropDownList.insert(0, const DropDownModel("Clear Field", 1001));
  }

  clearAllControllers() {
    List<List<TextEditingController>> list =
        _surveyQuestionController.q2ControllersList;

    for (var element in list) {
      for (var element in element) {
        element.dispose();
      }
    }
  }

  createQuestion2FormData() {
    var answerForm = {};
    for (int i = 0; i < _surveyQuestionController.questionIdList.length; i++) {
      answerForm.addAll({
        _surveyQuestionController.questionIdList[i].toString(): {
          "answer_id": _surveyQuestionController.oldAnswersId[i],
          "data": {
            _surveyQuestionController.answerDataId[i][0]:
                _surveyQuestionController.q2ControllersList[i][0].text
          }
        }
      });
    }
    // _surveyQuestionController.answerDataId[i][1]:
    //     _surveyQuestionController.q2ControllersList[i][1].text,
    return answerForm;
  }

  createValueListFromControllerList() {
    List<List<String?>> values = [];
    for (var element in _surveyQuestionController.q2ControllersList) {
      List<String?> textValue = [element[0].text, element[1].text];
      values.add(textValue);
    }
    return values;
  }

  answerSubQuestion(questionId, List<List<TextEditingController>> controllers,
      questionType, questionNumber) async {
    bool internetStatus = await ConnectionStatus.checkConnection();

    var dataList = _surveyQuestionController.dataList;

    Map<String, dynamic> formData = {
      "pivot_id": dataList[1],
      "question_id": questionId,
      "answer": createQuestion2FormData(),
    };

    if (internetStatus) {
      try {
        _surveyQuestionController.answerQuestionLoading(true);

        D.Response response = await _apiService.post(
          path: _path.answer,
          needToken: true,
          formData: formData,
        );

        if (response.statusCode == 200) {
          _surveyQuestionController.goToNextQuestion();

          /// save answer in hive

          var answerModel = AnswerHiveObject()
            ..questionId = questionId
            ..fieldValue = " "
            ..questionType = questionType
            ..extraData = {"answer": createValueListFromControllerList()};

          /// key of each object is questionid|surveyId|pivotId
          box.put("$questionId${dataList[0]}${dataList[1]}", answerModel);
        }
        _surveyQuestionController.answerQuestionLoading(false);
      } catch (e, s) {
        _surveyQuestionController.answerQuestionLoading(false);
        debugger(stacktrace: s, error: e);
      }
    } else {
      /// add question to update required list to sync with server later
      /// add question to update required list to sync with server later
      _surveyQuestionController.addQuestionToUpdateList(
        data: SyncAnswerModel(
            formData: formData,
            questionId: questionId,
            questionNumber: questionNumber),
      );

      _surveyQuestionController.goToNextQuestion();

      /// save answer in hive

      var answerModel = AnswerHiveObject()
        ..questionId = questionId
        ..fieldValue = " "
        ..questionType = questionType
        ..extraData = {"answer": createValueListFromControllerList()};

      /// key of each object is question id|surveyId|pivotId
      box.put("$questionId${dataList[0]}${dataList[1]}", answerModel);
    }
  }
}
