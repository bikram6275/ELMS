import 'package:dio/dio.dart' as D;
import 'package:elms/constant/api_path.dart';
import 'package:elms/constant/app_strings.dart';
import 'package:elms/features/survey_question/components/question_5/question_5_controller.dart';
import 'package:elms/features/survey_question/survey_question_controller.dart';
import 'package:elms/infrastructure/api_service/api_service.dart';
import 'package:elms/infrastructure/hive_database/answer_hive_object.dart';
import 'package:elms/infrastructure/hive_database/hive_keys.dart';
import 'package:elms/models/question_6a_answer/question_6a_answer_model.dart';
import 'package:elms/models/sync_answer/sync_answer_model.dart';
import 'package:elms/utils/connection_status/connection_status.dart';
import 'package:elms/utils/debugger/debugger.dart';
import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:hive_flutter/hive_flutter.dart';

import '../../../../utils/snackbar/snackbar.dart';

class Question6aController extends GetxController {
  RxBool getQuestionsLoading = false.obs;
  RxBool getQuestionsError = false.obs;
  RxBool showOtherOccupationField = false.obs;
  RxList questionList = <dynamic>[].obs;

  final SurveyQuestionController _surveyQuestionController = Get.find();
  final Question5Controller _question5controller = Get.find();
  late Box box;

  // q 6.a
  RxList occupationList = [].obs;
  RxList<Question6AAnswerModel> q6aAnswersList = <Question6AAnswerModel>[].obs;
  TextEditingController q6aWorkExperiencePosition = TextEditingController();
  TextEditingController q6aWorkExperienceOccupation = TextEditingController();
  TextEditingController empNameController = TextEditingController();
  TextEditingController otherOccupationValueController =
      TextEditingController();

  RxInt educationalQualificationGeneral = 0.obs,
      educationalQualificationTvet = 0.obs;
  RxString gender = "".obs,
      occupations = "".obs,
      workingHours = "".obs,
      nature = "".obs,
      training = "".obs,
      q6aOjt = "".obs;

  // edit fields
  RxString occupationsEditField = "".obs;
  RxInt educationalQualificationGeneralEditField = 0.obs,
      educationalQualificationTvetEditField = 0.obs;

  final AppStrings _strings = Get.find();
  final ApiService _apiService = Get.find();
  final ApiPath _path = Get.find();

  @override
  void onInit() async {
    box = await Hive.openBox("db");
    syncAnswersFromDatabase();
    super.onInit();
  }

  @override
  void onClose() {
    q6aWorkExperiencePosition.dispose();
    q6aWorkExperienceOccupation.dispose();
    empNameController.dispose();
    otherOccupationValueController.dispose();
    super.onClose();
  }

  replaceEditedItem(int index) {
    q6aAnswersList.removeAt(index);
    q6aAnswersList.insert(
        index,
        Question6AAnswerModel(
            id: null,
            otherOccupationValue: otherOccupationValueController.text,
            empName: empNameController.text,
            gender: getEnumOfValues(gender.value),
            workingTime: getEnumOfValues(workingHours.value),
            workNature: getEnumOfValues(nature.value),
            training: getEnumOfValues(training.value),
            ojtApprentice: q6aOjt.value,
            workExp1: q6aWorkExperiencePosition.text,
            workExp2: q6aWorkExperienceOccupation.text,
            occupationId: int.parse(occupationsEditField.value),
            eduQuaGeneralId: educationalQualificationGeneralEditField.value,
            eduQuaTvetId: educationalQualificationTvetEditField.value));
  }

  assignValuesFromObjectToVariables(Question6AAnswerModel item) {
    otherOccupationValueController.text = item.otherOccupationValue;
    empNameController.text = item.empName;
    gender(getValueOfEnums(item.gender));
    workingHours(getValueOfEnums(item.workingTime));
    nature(getValueOfEnums(item.workNature));
    training(getValueOfEnums(item.training));
    q6aOjt(getValueOfEnums(item.ojtApprentice));
    q6aWorkExperiencePosition.text = item.workExp1;
    q6aWorkExperienceOccupation.text = item.workExp2;
    occupationsEditField(item.occupationId.toString());
    educationalQualificationGeneralEditField(item.eduQuaGeneralId);
    educationalQualificationTvetEditField(item.eduQuaTvetId);
  }

  getValueOfEnums(value) {
    switch (value) {
      case "full":
        return "Full time(40 hours and +)";
      case "part":
        return "Part time(less than 40 hours)";
      case "regular":
        return "Regular";
      case "seasonal":
        return "Seasonal";
      case "trained":
        return "Trained";
      case "untrained":
        return "Untrained";
      case "general":
        return "General";
      case "tvet":
        return "Tvet";
      case "male":
        return "Male";
      case "female":
        return "Female";
      case "sexual_minority":
        return "Sexual Minority";
      case "ojt":
        return "OJT";
      case "apprentice":
        return "Apprentice";
      case "none":
        return "None";
      default:
        {
          return value;
        }
    }
  }

  getEnumOfValues(value) {
    switch (value) {
      case "Full time(40 hours and +)":
        return "full";
      case "Part time(less than 40 hours)":
        return "part";
      case "Regular":
        return "regular";
      case "Seasonal":
        return "seasonal";
      case "Trained":
        return "trained";
      case "Untrained":
        return "untrained";
      case "General":
        return "general";
      case "Tvet":
        return "tvet";
      case "Male":
        return "male";
      case "Female":
        return "female";
      case "Sexual Minority":
        return "sexual_minority";
    }
  }

  checkNullStrings(str) {
    if (str == null) {
      return ' - ';
    } else {
      return str;
    }
  }

  getSelectedItemForEdit(int index) {
    return q6aAnswersList[index];
  }

  getOccupationTitle(id) {
    String title = " ";
    for (var element in _surveyQuestionController.occupationList) {
      if (element.id == id) {
        title = element.occupationName;
      }
    }
    return title;
  }

  getOccupationTitleFromList(id, list) {
    String title = " ";
    for (var element in list) {
      if (element["id"] == id) {
        title = element["occupation_name"];
      }
    }
    return title;
  }

  getEduTitleFromList(id, List<dynamic> list, List<dynamic> list2) {
    String title = " ";
    List<dynamic> temp = [...list, ...list2];
    for (var element in temp) {
      if (element["id"] == id) {
        title = element["name"];
      }
    }
    return title;
  }

  getEduTitle({required int id, required List questionList}) {
    String title = " ";
    for (var element in questionList) {
      if (element["qsn_number"] == "6.a") {
        List eduList1 = element["educational_qualification_general"];
        eduList1.addAll(element["educational_qualification_tvet"]);

        for (var element in eduList1) {
          if (element["id"] == id) {
            title = element["name"];
          }
        }
      }
    }
    return title;
  }

  getQuestions({required int surveyId, required int pivotId}) async {
    try {
      getQuestionsLoading(true);
      getQuestionsError(false);

      D.Response? response = await _apiService.get(
        path: _path.questions
            .replaceFirst("{{survey_id}}", surveyId.toString())
            .replaceFirst("{{pivot_id}}", pivotId.toString()),
        needToken: true,
      );

      if (response != null) {
        questionList.addAll(response.data["data"] as List);

        /// save question in offline database
        box.put(
            HiveKeys.getQuestionKey(surveyId, pivotId), response.data["data"]);
      } else {
        getQuestionsError(true);
      }
      getQuestionsLoading(false);
    } catch (e, s) {
      getQuestionsError(true);
      debugger(error: e, stacktrace: s);
    }
  }

  clearAllFields() {
    q6aWorkExperiencePosition.clear();
    q6aWorkExperienceOccupation.clear();
    empNameController.clear();
    otherOccupationValueController.clear();
    gender("");
    workingHours("");
    nature("");
    training("");
    q6aOjt("");
    occupationsEditField("");
    educationalQualificationTvetEditField(0);
    educationalQualificationGeneralEditField(0);
  }

  clearDropDowns() {
    occupations("");
    educationalQualificationTvet(0);
    educationalQualificationGeneral(0);
  }

  checkQ6Controllers() {
    if (q6aWorkExperiencePosition.text.isEmpty ||
        q6aWorkExperienceOccupation.text.isEmpty ||
        empNameController.text.isEmpty ||
        (showOtherOccupationField.value &&
            otherOccupationValueController.text.isEmpty)) {
      snackBar(_strings.failedTitle, "Please fill all fields", error: true);
      return false;
    } else {
      return true;
    }
  }

  checkVariablesInEditPage() {
    if (gender.value != "" &&
        occupationsEditField.value != "" &&
        workingHours.value != "" &&
        nature.value != "" &&
        training.value != "" &&
        educationalQualificationGeneralEditField.value != 0 &&
        educationalQualificationTvetEditField.value != 0) {
      return true;
    } else {
      snackBar(_strings.failedTitle, "Please fill all fields", error: true);
      return false;
    }
  }
  checkVariables() {
    if (gender.value != "" &&
        occupations.value != "" &&
        workingHours.value != "" &&
        nature.value != "" &&
        training.value != "" &&
        educationalQualificationGeneral.value != 0 &&
        educationalQualificationTvet.value != 0) {
      return true;
    } else {
      snackBar(_strings.failedTitle, "Please fill all fields", error: true);
      return false;
    }
  }

  getOccupationList() {
    return box.get(HiveKeys.occupationKey);
  }

  syncAnswersFromDatabase() {
    var dataList = _surveyQuestionController.dataList;
    occupationList.addAll(box.get(HiveKeys.occupationKey));
    // q 6.a
    AnswerHiveObject? answerQuestion6a =
        box.get("17${dataList[0]}${dataList[1]}");
    if (answerQuestion6a != null) {
      List<dynamic> allAnswers = answerQuestion6a.extraData!["answers"];
      for (var element in allAnswers) {
        q6aAnswersList.add(Question6AAnswerModel.fromJson(element));
      }
    }
  }

  int getSumOfTechnicalNumbers() {
    int q5_1 = _question5controller.getTotalOfAnswers(
        list: _question5controller.q5_1CountersList[1]);
    int q5_2 = _question5controller.getTotalOfAnswers(
        list: _question5controller.q5_2CountersList[1]);
    int q5_3 = _question5controller.getTotalOfAnswers(
        list: _question5controller.q5_3CountersList[1]);
    return q5_1 + q5_2 + q5_3;
  }

  validationForTechnicalNumbers() {
    int sum = getSumOfTechnicalNumbers();
    if (sum == 0) {
      /// here we should check array of employee and don't let user to put something new into list and should
      /// send empty list to server
      if (q6aAnswersList.isNotEmpty) {
        snackBar(_strings.failedTitle,
            "You can't add employee please clear list, to add employee you should enter number of them in question 5.1,5.2,5.3",
            error: true);
        return false;
      } else {
        return true;
      }
    } else {
      /// here we should check sum with size of list and these parameters should be equal
      if (q6aAnswersList.length < sum) {
        snackBar(
          _strings.failedTitle,
          "You should enter information of $sum employees",
          error: true,
        );
        return false;
      } else if (q6aAnswersList.length > sum) {
        snackBar(
          _strings.failedTitle,
          "You should enter information of $sum employees , please clear extra information",
          error: true,
        );
        return false;
      } else {
        return true;
      }
    }
  }

  answerQuestion6a(questionId, questionType,
      List<Question6AAnswerModel> answerList, questionNumber) async {
    bool internetStatus = await ConnectionStatus.checkConnection();

    List<dynamic> technicalList = [];

    for (Question6AAnswerModel element in answerList) {
      technicalList.add({
        "id": null,
        "emp_name": element.empName,
        "gender": element.gender,
        "occupation_id": element.occupationId,
        "other_occupation_value": element.otherOccupationValue,
        "working_time": element.workingTime,
        "work_nature": element.workNature,
        "training": element.training,
        "ojt_apprentice": element.ojtApprentice,
        "edu_qua_general": element.eduQuaGeneralId,
        "edu_qua_tvet": element.eduQuaTvetId,
        "work_exp1": element.workExp1,
        "work_exp2": element.workExp2,
      });
    }

    var formData = {
      "pivot_id": _surveyQuestionController.dataList[1],
      "question_id": questionId,
      "technical": technicalList,
    };
    if (validationForTechnicalNumbers()) {
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
            saveQuestionsInDatabase(
                questionId: questionId,
                questionType: questionType,
                technicalList: technicalList);
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

        saveQuestionsInDatabase(
            questionId: questionId,
            questionType: questionType,
            technicalList: technicalList);
      }
    }
  }

  saveQuestionsInDatabase({questionId, questionType, technicalList}) {
    _surveyQuestionController.goToNextQuestion();

    /// save object in hive

    var answerModel = AnswerHiveObject()
      ..questionId = questionId
      ..fieldValue = " "
      ..questionType = questionType
      ..extraData = {"answers": technicalList};

    /// key of each object is question id|surveyId|pivotId
    box.put(
        "$questionId${_surveyQuestionController.dataList[0]}${_surveyQuestionController.dataList[1]}",
        answerModel);
  }
}
