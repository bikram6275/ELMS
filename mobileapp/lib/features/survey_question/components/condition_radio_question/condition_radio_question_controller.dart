import 'package:elms/constant/api_path.dart';
import 'package:elms/constant/app_strings.dart';
import 'package:elms/features/survey_question/survey_question_controller.dart';
import 'package:elms/infrastructure/api_service/api_service.dart';
import 'package:elms/infrastructure/custom_storage/custom_storage.dart';
import 'package:elms/infrastructure/hive_database/answer_hive_object.dart';
import 'package:elms/models/occupation/occupation_model.dart';
import 'package:elms/models/question18_answer/question18_answer_model.dart';
import 'package:elms/models/question8_answer/question8_answer_model.dart';
import 'package:elms/models/sub_sector/sub_sector_model.dart';
import 'package:elms/models/sync_answer/sync_answer_model.dart';
import 'package:elms/utils/connection_status/connection_status.dart';
import 'package:elms/utils/debugger/debugger.dart';
import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:hive_flutter/hive_flutter.dart';
import 'package:dio/dio.dart' as D;

import '../../../../infrastructure/hive_database/hive_keys.dart';
import '../../../../utils/snackbar/snackbar.dart';

class ConditionRadioQuestionController extends GetxController {
  final SurveyQuestionController _surveyQuestionController = Get.find();
  late Box box;
  RxList occupationList = [].obs;

  // q 9
  RxInt q9RadioValue = 0.obs;
  TextEditingController question9Controller = TextEditingController();

  // q 8
  RxInt q8RadioValue = 0.obs;
  TextEditingController q8DemandController = TextEditingController();
  TextEditingController q8EstimateDemand2YearsController =
      TextEditingController();
  TextEditingController q8EstimateDemand5YearsController =
      TextEditingController();
  RxList<Question8AnswerModel> q8AnswerList = <Question8AnswerModel>[].obs;
  RxString q8occupationName = "".obs;

  // q 17
  int? q17oldAnswerId;
  RxInt q17RadioValue = 0.obs;
  TextEditingController q17TechController = TextEditingController();
  RxInt q17SelectedSectorId = 0.obs;

  // RxInt q17SelectedSubSectorId = 0.obs;

  // q 18
  RxInt q18RadioValue = 0.obs;
  TextEditingController q18SkillLevelController = TextEditingController();
  TextEditingController q18RequiredNumberController = TextEditingController();
  RxString q18incorporatePossibleGreenSkills = "".obs;
  RxInt q18SelectedSectorId = 0.obs;
  RxInt q18SelectedOccupationId = 0.obs;
  RxList<Question18AnswerModel> q18AnswerList = <Question18AnswerModel>[].obs;

  int q8ConditionId = 38,
      q9ConditionId = 41,
      q17ConditionId = 73,
      q18ConditionId = 89;

  @override
  void onInit() async {
    box = await Hive.openBox("db");
    syncAnswersFromDatabase();
    super.onInit();
  }

  final AppStrings _strings = Get.find();
  final ApiService _apiService = Get.find();
  final ApiPath _path = Get.find();
  final CustomStorage _storage = Get.find();

  @override
  void onClose() {
    question9Controller.dispose();
    q8DemandController.dispose();
    q8EstimateDemand2YearsController.dispose();
    q8EstimateDemand5YearsController.dispose();
    q18SkillLevelController.dispose();
    q18RequiredNumberController.dispose();
    q17TechController.dispose();

    super.onClose();
  }

  getSectorTitle(int id, String qsnNumber) {
    String title = " ";
    for (var element in _surveyQuestionController.questionList) {
      if (element["qsn_number"] == qsnNumber) {
        List sectors = element["sector"];

        for (var element in sectors) {
          if (element["id"] == id) {
            title = element["sector_name"];
          }
        }
      }
    }
    return title;
  }

  getSubSectorTitle(id) {
    String title = " ";
    for (var element in _surveyQuestionController.subSectorsList) {
      if (element.id == id) {
        title = element.subSectorName;
      }
    }
    return title;
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

  getOccupationTitleFromListQuestion18(int id, List<OccupationModel> list) {
    String title = " ";
    for (var element in list) {
      if (element.id == id) {
        title = element.occupationName;
      }
    }
    return title;
  }

  getSectorTitleFromList(id, list) {
    String title = " ";
    for (var element in list) {
      if (element["id"] == id) {
        title = element["sector_name"];
      }
    }
    return title;
  }

  clearQuestion18Fields() {
    q18SkillLevelController.clear();
    q18RequiredNumberController.clear();
    q18incorporatePossibleGreenSkills("");
  }

  syncAnswersFromDatabase() {
    try {
      List data = _surveyQuestionController.dataList;
      occupationList.addAll(box.get(HiveKeys.occupationKey));
      // question 9
      AnswerHiveObject? answerQuestion9 = box.get("21${data[0]}${data[1]}");
      if (answerQuestion9 != null) {
        q9RadioValue(answerQuestion9.extraData!["answers"]["radioValue"]);
        question9Controller.text = answerQuestion9.fieldValue ?? "";
      }

      // question 8
      AnswerHiveObject? answerQuestion8 = box.get("20${data[0]}${data[1]}");
      if (answerQuestion8 != null) {
        q8RadioValue(answerQuestion8.extraData!["answers"]["radioValue"]);
        List<dynamic> allAnswers =
            answerQuestion8.extraData!["answers"]["question8Answers"];
        for (var element in allAnswers) {
          q8AnswerList.add(Question8AnswerModel.fromJson(element));
        }
      }

      // question 17
      AnswerHiveObject? answerQuestion17 = box.get("31${data[0]}${data[1]}");
      if (answerQuestion17 != null) {
        q17RadioValue(answerQuestion17.extraData!["answers"]["radioValue"]);
        q17TechController.text = answerQuestion17.extraData!["answers"]
            ["question17Answers"]["technology"]["technology"];
        q17SelectedSectorId(int.parse(answerQuestion17.extraData!["answers"]
                ["question17Answers"]["technology"]["sector_id"]
            .toString()));
        // q17SelectedSubSectorId(int.parse(answerQuestion17.extraData!["answers"]
        //         ["question17Answers"]["technology"]["sub_sector_id"]
        //     .toString()));
      }

      // question 18
      AnswerHiveObject? answerQuestion18 = box.get("37${data[0]}${data[1]}");

      if (answerQuestion18 != null) {
        q18RadioValue(answerQuestion18.extraData!["answers"]["radioValue"]);
        List allAnswers =
            answerQuestion18.extraData!["answers"]["question18Answers"];

        for (var element in allAnswers) {
          q18AnswerList.add(Question18AnswerModel.fromJson(element));
        }
      }
    } catch (e, s) {
      print(e);
      print(s);
    }
  }

  getConditionValueFromQuestionResponse() {
    for (var element in _surveyQuestionController.questionList) {
      if (element["qsn_number"] == "8") {
        q8ConditionId = getYesItemId(element["question_options"]);
      } else if (element["qsn_number"] == "9") {
        q9ConditionId = getYesItemId(element["question_options"]);
      } else if (element["qsn_number"] == "17") {
        q17ConditionId = getYesItemId(element["question_options"]);
      } else if (element["qsn_number"] == "18") {
        q18ConditionId = getYesItemId(element["question_options"]);
      }
    }
  }

  getYesItemId(List list) {
    for (var element in list) {
      if (element["option_name"] == "Yes") {
        return element["id"];
      }
    }
  }

  question17HasError(questionNumber) {
    if (questionNumber == "17") {
      if ((q17RadioValue.value == q17ConditionId)) {
        if (q17TechController.text.isEmpty || q17SelectedSectorId.value == 0) {
          return true;
        } else {
          return false;
        }
      } else {
        return false;
      }
    } else {
      return false;
    }
  }

  answerConditionalQuestion(
      questionId, questionType, questionNumber, radioValue) async {
    bool internetStatus = await ConnectionStatus.checkConnection();
    List dataList = _surveyQuestionController.dataList;
    String? otherAnswer;
    List<dynamic> question8AnswerList = [];
    List<dynamic> question18AnswerList = [];
    Map formData = {};

    if (questionNumber == "9") {
      otherAnswer = question9Controller.text;
      formData = {
        "pivot_id": dataList[1],
        "question_id": questionId,
        "answer_id":
            _surveyQuestionController.getAnswerIdByQuestionName(questionNumber),
        "answer": radioValue,
        "optionalAnswer": {"22": otherAnswer}
      };
    }

    if (questionNumber == "8") {
      for (Question8AnswerModel element in q8AnswerList) {
        question8AnswerList.add(
          {
            "id": element.id,
            "occupation_id": element.occupationId,
            "present_demand": element.presentDemand,
            "demand_two_year": element.demandTwoYear,
            "demand_five_year": element.demandFiveYear
          },
        );
      }
      formData = {
        "pivot_id": dataList[1],
        "question_id": questionId,
        "answer": [radioValue],
        "other_answer": otherAnswer,
        "answer_id":
            _surveyQuestionController.getAnswerIdByQuestionName(questionNumber),
        "occu": question8AnswerList,
      };
    }

    if (questionNumber == "17") {
      formData = {
        "pivot_id": dataList[1],
        "question_id": questionId,
        "answer_id":
            _surveyQuestionController.getAnswerIdByQuestionName(questionNumber),
        "answer": radioValue.toString(),
        "technology": {
          "id": q17oldAnswerId,
          "sector_id": q17SelectedSectorId.value.toString(),
          // "sub_sector_id": q17SelectedSubSectorId.toString(),
          "technology": q17TechController.text,
        }
      };
    }

    if (questionNumber == "18") {
      for (Question18AnswerModel element in q18AnswerList) {
        question18AnswerList.add(
          {
            "id": element.id,
            "sector_id": element.sectorId,
            "occupation_id": element.occupationId,
            "level": element.level,
            "required_number": element.requiredNumber,
            "incorporate_possible": element.incorporatePossible,
          },
        );
      }
      formData = {
        "pivot_id": dataList[1],
        "question_id": questionId,
        "answer": radioValue.toString(),
        "answer_id":
            _surveyQuestionController.getAnswerIdByQuestionName(questionNumber),
        "skilled": question18AnswerList,
      };
    }
    if (question17HasError(questionNumber)) {
      snackBar(_strings.failedTitle, "Please select Sector and fill field",
          error: true);
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
                ..fieldValue = question9Controller.text
                ..questionType = questionType
                ..extraData = {
                  "answers": {
                    "radioValue": radioValue,
                    "question8Answers": question8AnswerList,
                    "question17Answers": formData,
                    "question18Answers": question18AnswerList,
                  }
                };

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
            ..fieldValue = question9Controller.text
            ..questionType = questionType
            ..extraData = {
              "answers": {
                "radioValue": radioValue,
                "question8Answers": question8AnswerList,
                "question17Answers": formData,
                "question18Answers": question18AnswerList,
              }
            };

          /// key of each object is question id|surveyId|pivotId
          box.put("$questionId${dataList[0]}${dataList[1]}", answerModel);
        } else {
          snackBar(_strings.failedTitle, "Please select an item.", error: true);
        }
      }
    }
  }

  getRadioButtonValue(questionNumber) {
    switch (questionNumber) {
      case "8":
        return q8RadioValue;
      case "9":
        return q9RadioValue;
      case "17":
        return q17RadioValue;
      case "18":
        return q18RadioValue;
    }
  }

  List<SectorModel> filterSubSectorList(subId) {
    List<SectorModel> list = [];

    if (subId != null) {
      for (SectorModel element in _surveyQuestionController.subSectorsList) {
        if (element.sectorId == subId) {
          list.add(element);
        }
      }
    } else {
      list = [];
    }

    return list;
  }

  List<OccupationModel> filterOccupationList(subId) {
    List<OccupationModel> list = [];

    if (subId != null) {
      for (OccupationModel element
          in _surveyQuestionController.occupationList) {
        if (element.sectorId == subId) {
          list.add(element);
        }
      }
    } else {
      list = [];
    }

    return list;
  }

  question18AnswerValidation() {
    if (q18RadioValue.value != 0 &&
        q18SkillLevelController.text.isNotEmpty &&
        q18RequiredNumberController.text.isNotEmpty &&
        q18incorporatePossibleGreenSkills.value != "" &&
        q18SelectedOccupationId.value != 0 &&
        q18SelectedSectorId.value != 0) {
      return true;
    } else {
      snackBar(_strings.failedTitle, "Please fill and select all fields!",
          error: true);
      return false;
    }
  }

  question8AnswerValidation() {
    if (q8RadioValue.value != 0 &&
        q8DemandController.text.isNotEmpty &&
        q8EstimateDemand2YearsController.text.isNotEmpty &&
        q8EstimateDemand5YearsController.text.isNotEmpty) {
      return true;
    } else {
      snackBar(_strings.failedTitle, "Please fill and select all fields!",
          error: true);
      return false;
    }
  }
}
