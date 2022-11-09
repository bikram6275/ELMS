import 'package:dio/dio.dart' as D;
import 'package:elms/constant/api_path.dart';
import 'package:elms/constant/app_strings.dart';
import 'package:elms/infrastructure/api_service/api_service.dart';
import 'package:elms/infrastructure/hive_database/answer_hive_object.dart';
import 'package:elms/models/sync_answer/sync_answer_model.dart';
import 'package:elms/utils/connection_status/connection_status.dart';
import 'package:elms/utils/debugger/debugger.dart';
import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:hive_flutter/hive_flutter.dart';

import '../../../../utils/snackbar/snackbar.dart';
import '../../survey_question_controller.dart';

class Question5Controller extends GetxController {
  final SurveyQuestionController _surveyQuestionController = Get.find();
  late Box box;

  final AppStrings _strings = Get.find();
  final ApiService _apiService = Get.find();
  final ApiPath _path = Get.find();

  RxBool totalCountUpdater = false.obs;

  // q 5_1
  RxList<List<TextEditingController>> q5_1CountersList =
      RxList<List<TextEditingController>>.generate(
    5,
    (item) => List<TextEditingController>.generate(
        6, (item) => TextEditingController(text: "0")),
  );

  // q 5_2
  RxList<List<TextEditingController>> q5_2CountersList =
      RxList<List<TextEditingController>>.generate(
    5,
    (item) => List<TextEditingController>.generate(
        6, (item) => TextEditingController(text: "0")),
  );

  // q 5_3
  RxList<List<TextEditingController>> q5_3CountersList =
      RxList<List<TextEditingController>>.generate(
    5,
    (item) => List<TextEditingController>.generate(
        6, (item) => TextEditingController(text: "0")),
  );

  // answer ids
  int? employerManagerialAnswerId = 0,
      employerTechnicalAnswerId = 0,
      employerAdministrativeAnswerId = 0,
      employerAssistingAnswerId = 0,
      familyMemberManagerialAnswerId = 0,
      familyMemberTechnicalAnswerId = 0,
      familyMemberAdministrativeAnswerId = 0,
      familyMemberAssistingAnswerId = 0,
      employeesManagerialAnswerId = 0,
      employeesTechnicalAnswerId = 0,
      employeesAdministrativeAnswerId = 0,
      employeesAssistingAnswerId = 0;

  @override
  onInit() async {
    box = await Hive.openBox("db");
    syncAnswerFromDatabase();
    super.onInit();
  }

  @override
  onClose() {
    killAllFormFieldControllers();
  }

  killAllFormFieldControllers() {
    for (var element in q5_1CountersList) {
      for (var e in element) {
        e.dispose();
      }
    }
    for (var element in q5_2CountersList) {
      for (var e in element) {
        e.dispose();
      }
    }
    for (var element in q5_3CountersList) {
      for (var e in element) {
        e.dispose();
      }
    }
  }

  getConditionStatus(String hr, String workers) {
    if (hr == "Employer" && workers == "Assisting") {
      return false;
    } else if (hr == "Family Member" && workers == "Assisting") {
      return false;
    } else {
      return true;
    }
  }

  getAnswerIdsFromQuestionResponse(
      {required questionData, required questionNumber}) {
    Map question5Data = questionData;
    List question5Answer = question5Data["answer"];
    for (var element in question5Answer) {
      switch (element["resource_type"]) {
        case "employer":
          switch (element["working_type"]) {
            case "managerial":
              employerManagerialAnswerId = element["id"];
              break;
            case "technical":
              employerTechnicalAnswerId = element["id"];
              break;
            case "administrative":
              employerAdministrativeAnswerId = element["id"];
              break;
            case "assisting":
              employerAssistingAnswerId = element["id"];
              break;
          }
          break;
        case "family_member":
          switch (element["working_type"]) {
            case "managerial":
              familyMemberManagerialAnswerId = element["id"];
              break;
            case "technical":
              familyMemberTechnicalAnswerId = element["id"];
              break;
            case "administrative":
              familyMemberAdministrativeAnswerId = element["id"];
              break;
            case "assisting":
              familyMemberAssistingAnswerId = element["id"];
              break;
          }
          break;
        case "employees":
          switch (element["working_type"]) {
            case "managerial":
              employeesManagerialAnswerId = element["id"];
              break;
            case "technical":
              employeesTechnicalAnswerId = element["id"];
              break;
            case "administrative":
              employeesAdministrativeAnswerId = element["id"];
              break;
            case "assisting":
              employeesAssistingAnswerId = element["id"];
              break;
          }
          break;
      }
    }
  }

  getQuestion5ListDataFromDatabase(
      {required List<dynamic> list, required questionNumber}) {
    if (questionNumber == "5.1") {
      for (var i = 0; i < list.length; i++) {
        for (var j = 0; j < list[i].length; j++) {
          q5_1CountersList[i][j].text = list[i][j].toString();
        }
      }
    } else if (questionNumber == "5.2") {
      for (var i = 0; i < list.length; i++) {
        for (var j = 0; j < list[i].length; j++) {
          q5_2CountersList[i][j].text = list[i][j].toString();
        }
      }
    } else if (questionNumber == "5.3") {
      for (var i = 0; i < list.length; i++) {
        for (var j = 0; j < list[i].length; j++) {
          q5_3CountersList[i][j].text = list[i][j].toString();
        }
      }
    }
  }

  syncAnswerFromDatabase() {
    var dataList = _surveyQuestionController.dataList;
    // q 5_1
    AnswerHiveObject? answerQuestion5_1 = box.get(
        "${_surveyQuestionController.getQuestionIdByQuestionNumber("5.1")}${dataList[0]}${dataList[1]}");
    if (answerQuestion5_1 != null) {
      List<dynamic> allAnswers = answerQuestion5_1.extraData!["answer"];
      getQuestion5ListDataFromDatabase(list: allAnswers, questionNumber: "5.1");
    }
    // q 5_2
    AnswerHiveObject? answerQuestion5_2 = box.get(
        "${_surveyQuestionController.getQuestionIdByQuestionNumber("5.2")}${dataList[0]}${dataList[1]}");
    if (answerQuestion5_2 != null) {
      List<dynamic> allAnswers = answerQuestion5_2.extraData!["answer"];
      getQuestion5ListDataFromDatabase(list: allAnswers, questionNumber: "5.2");
    }
    // q 5_3
    AnswerHiveObject? answerQuestion5_3 = box.get(
        "${_surveyQuestionController.getQuestionIdByQuestionNumber("5.3")}${dataList[0]}${dataList[1]}");
    if (answerQuestion5_3 != null) {
      List<dynamic> allAnswers = answerQuestion5_3.extraData!["answer"];
      getQuestion5ListDataFromDatabase(list: allAnswers, questionNumber: "5.3");
    }
  }

  getTotalOfAnswers({required List<TextEditingController> list}) {
    int sum = 0;
    for (var i = 0; i < 3; i++) {
      sum = sum + int.parse((list[i].text.isEmpty) ? "0" : list[i].text);
    }
    return sum;
  }

  getError(Map data) {
    String categoryErrorTitle = " ";
    String subCategoryErrorTitle = " ";

    switch (data["i"]) {
      case 0:
        categoryErrorTitle = "Employer";
        break;
      case 1:
        categoryErrorTitle = "Family Member";
        break;
      case 2:
        categoryErrorTitle = "Employees";
        break;
      case 3:
        categoryErrorTitle = "Others";
        break;
    }

    switch (data["j"]) {
      case 0:
        subCategoryErrorTitle = "Managerial";
        break;
      case 1:
        subCategoryErrorTitle = "Technical";
        break;
      case 2:
        subCategoryErrorTitle = "Administrative";
        break;
      case 3:
        subCategoryErrorTitle = "Assisting";
        break;
    }

    return "Invalid value in $categoryErrorTitle/$subCategoryErrorTitle.";
  }

  checkConditionsBeforeAnswerQuestion(questionNumber) {
    List<Map> conditions = [];
    bool lastCondition = false;
    late RxList<List<TextEditingController>> data;
    String allError = "";

    if (questionNumber == "5.1") {
      data = q5_1CountersList;
    } else if (questionNumber == "5.2") {
      data = q5_2CountersList;
    } else if (questionNumber == "5.3") {
      data = q5_3CountersList;
    }

    for (var j = 0; j < 4; j++) {
      var condition1 = int.parse(getValueOrZero(data[j][0].text)) +
          int.parse(getValueOrZero(data[j][1].text)) +
          int.parse(getValueOrZero(data[j][2].text));
      var condition2 = int.parse(getValueOrZero(data[j][3].text)) +
          int.parse(getValueOrZero(data[j][4].text)) +
          int.parse(getValueOrZero(data[j][5].text));
      if (condition1 != condition2) {
        conditions.add({"j": j});
      }
    }

    for (var element in conditions) {
      allError = allError + " - " + getError(element) + "\n";
    }

    if (conditions.isEmpty) {
      lastCondition = true;
    } else {
      snackBar(_strings.failedTitle, allError, error: true);
      lastCondition = false;
    }

    return lastCondition;
  }

  getValueOrZero(String data) {
    if (data.isEmpty) {
      return "0";
    } else {
      return data;
    }
  }

  answerQuestion5(questionId, questionType, questionNumber) async {
    bool internetStatus = await ConnectionStatus.checkConnection();

    var dataList = _surveyQuestionController.dataList;
    late RxList<List<TextEditingController>> answers;

    List<List<String>> countersListForSave = List<List<String>>.generate(
        4, (item) => List<String>.generate(6, (item) => "0")).toList();

    if (questionNumber == "5.1") {
      answers = q5_1CountersList;
    } else if (questionNumber == "5.2") {
      answers = q5_2CountersList;
    } else if (questionNumber == "5.3") {
      answers = q5_3CountersList;
    }

    for (var j = 0; j < 4; j++) {
      for (var k = 0; k < 6; k++) {
        countersListForSave[j][k] =
            (answers[j][k].text.isEmpty) ? "0" : answers[j][k].text;
      }
    }

    late Map formData;

    if (questionNumber == "5.1") {
      formData = {
        "pivot_id": dataList[1],
        "question_id":
            _surveyQuestionController.getQuestionIdByQuestionNumber("5.1"),
        "human_resource": {
          "managerial": {
            "id": "112",
            "male_count": getValueOrZero(answers[0][0].text),
            "female_count": getValueOrZero(answers[0][1].text),
            "minority_count": getValueOrZero(answers[0][2].text),
            "nepali_count": getValueOrZero(answers[0][3].text),
            "neighboring_count": getValueOrZero(answers[0][4].text),
            "foreigner_count": getValueOrZero(answers[0][5].text),
            "total": getTotalOfAnswers(list: answers[0])
          },
          "technical": {
            "id": "163",
            "male_count": getValueOrZero(answers[1][0].text),
            "female_count": getValueOrZero(answers[1][1].text),
            "minority_count": getValueOrZero(answers[1][2].text),
            "nepali_count": getValueOrZero(answers[1][3].text),
            "neighboring_count": getValueOrZero(answers[1][4].text),
            "foreigner_count": getValueOrZero(answers[1][5].text),
            "total": getTotalOfAnswers(list: answers[1])
          },
          "administrative": {
            "id": "200",
            "male_count": getValueOrZero(answers[2][0].text),
            "female_count": getValueOrZero(answers[2][1].text),
            "minority_count": getValueOrZero(answers[2][2].text),
            "nepali_count": getValueOrZero(answers[2][3].text),
            "neighboring_count": getValueOrZero(answers[2][4].text),
            "foreigner_count": getValueOrZero(answers[2][5].text),
            "total": getTotalOfAnswers(list: answers[2])
          }
        }
      };
    } else if (questionNumber == "5.2") {
      formData = {
        "pivot_id": dataList[1],
        "question_id":
            _surveyQuestionController.getQuestionIdByQuestionNumber("5.2"),
        "human_resource": {
          "managerial": {
            "id": "112",
            "male_count": getValueOrZero(answers[0][0].text),
            "female_count": getValueOrZero(answers[0][1].text),
            "minority_count": getValueOrZero(answers[0][2].text),
            "nepali_count": getValueOrZero(answers[0][3].text),
            "neighboring_count": getValueOrZero(answers[0][4].text),
            "foreigner_count": getValueOrZero(answers[0][5].text),
            "total": getTotalOfAnswers(list: answers[0])
          },
          "technical": {
            "id": "163",
            "male_count": getValueOrZero(answers[1][0].text),
            "female_count": getValueOrZero(answers[1][1].text),
            "minority_count": getValueOrZero(answers[1][2].text),
            "nepali_count": getValueOrZero(answers[1][3].text),
            "neighboring_count": getValueOrZero(answers[1][4].text),
            "foreigner_count": getValueOrZero(answers[1][5].text),
            "total": getTotalOfAnswers(list: answers[1])
          },
          "administrative": {
            "id": "200",
            "male_count": getValueOrZero(answers[2][0].text),
            "female_count": getValueOrZero(answers[2][1].text),
            "minority_count": getValueOrZero(answers[2][2].text),
            "nepali_count": getValueOrZero(answers[2][3].text),
            "neighboring_count": getValueOrZero(answers[2][4].text),
            "foreigner_count": getValueOrZero(answers[2][5].text),
            "total": getTotalOfAnswers(list: answers[2])
          },
        }
      };
    } else if (questionNumber == "5.3") {
      formData = {
        "pivot_id": dataList[1],
        "question_id":
            _surveyQuestionController.getQuestionIdByQuestionNumber("5.3"),
        "human_resource": {
          "managerial": {
            "id": "112",
            "male_count": getValueOrZero(answers[0][0].text),
            "female_count": getValueOrZero(answers[0][1].text),
            "minority_count": getValueOrZero(answers[0][2].text),
            "nepali_count": getValueOrZero(answers[0][3].text),
            "neighboring_count": getValueOrZero(answers[0][4].text),
            "foreigner_count": getValueOrZero(answers[0][5].text),
            "total": getTotalOfAnswers(list: answers[0])
          },
          "technical": {
            "id": "163",
            "male_count": getValueOrZero(answers[1][0].text),
            "female_count": getValueOrZero(answers[1][1].text),
            "minority_count": getValueOrZero(answers[1][2].text),
            "nepali_count": getValueOrZero(answers[1][3].text),
            "neighboring_count": getValueOrZero(answers[1][4].text),
            "foreigner_count": getValueOrZero(answers[1][5].text),
            "total": getTotalOfAnswers(list: answers[1])
          },
          "administrative": {
            "id": "200",
            "male_count": getValueOrZero(answers[2][0].text),
            "female_count": getValueOrZero(answers[2][1].text),
            "minority_count": getValueOrZero(answers[2][2].text),
            "nepali_count": getValueOrZero(answers[2][3].text),
            "neighboring_count": getValueOrZero(answers[2][4].text),
            "foreigner_count": getValueOrZero(answers[2][5].text),
            "total": getTotalOfAnswers(list: answers[2])
          },
          "assisting": {
            "id": null,
            "male_count": getValueOrZero(answers[3][0].text),
            "female_count": getValueOrZero(answers[3][1].text),
            "minority_count": getValueOrZero(answers[3][2].text),
            "nepali_count": getValueOrZero(answers[3][3].text),
            "neighboring_count": getValueOrZero(answers[3][4].text),
            "foreigner_count": getValueOrZero(answers[3][5].text),
            "total": getTotalOfAnswers(list: answers[3])
          }
        }
      };
    }

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
            ..fieldValue = " "
            ..questionType = questionType
            ..extraData = {
              "answer": countersListForSave,
            };

          /// key of each object is questionid|surveyId|pivotId
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

      var answerModel = AnswerHiveObject()
        ..questionId = questionId
        ..fieldValue = " "
        ..questionType = questionType
        ..extraData = {"answer": countersListForSave};

      /// key of each object is questionid|surveyId|pivotId
      box.put("$questionId${dataList[0]}${dataList[1]}", answerModel);
    }
  }
}
