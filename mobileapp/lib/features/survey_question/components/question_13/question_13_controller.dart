import 'package:elms/constant/api_path.dart';
import 'package:elms/constant/app_strings.dart';
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
import '../../survey_question_controller.dart';

class Question13Controller extends GetxController {
  final SurveyQuestionController _surveyQuestionController = Get.find();

  final AppStrings _strings = Get.find();
  final ApiService _apiService = Get.find();
  final ApiPath _path = Get.find();
  final CustomStorage _storage = Get.find();
  late Box box;

  // q 13
  TextEditingController q13TrainedCommunicationSkill = TextEditingController();
  TextEditingController q13UnTrainedCommunicationSkill =
      TextEditingController();
  TextEditingController q13TrainedPunctuality = TextEditingController();
  TextEditingController q13UnTrainedPunctuality = TextEditingController();
  TextEditingController q13TrainedTeamWork = TextEditingController();
  TextEditingController q13UnTrainedTeamWork = TextEditingController();
  TextEditingController q13TrainedInterPersonal = TextEditingController();
  TextEditingController q13UnTrainedInterPersonal = TextEditingController();
  TextEditingController q13TrainedLeaderShip = TextEditingController();
  TextEditingController q13UnTrainedLeaderShip = TextEditingController();
  RxList<List<TextEditingController>> q13ControllersList =
      <List<TextEditingController>>[].obs;

  int? communicationAnswerId,
      punctualityAnswerId,
      teamWorkAnswerId,
      leaderShipAnswerId,
      interpersonalAnswerId;

  @override
  void onInit() async {
    q13ControllersList([
      [q13TrainedCommunicationSkill, q13UnTrainedCommunicationSkill],
      [q13TrainedPunctuality, q13UnTrainedPunctuality],
      [q13TrainedTeamWork, q13UnTrainedTeamWork],
      [q13TrainedInterPersonal, q13UnTrainedInterPersonal],
      [q13TrainedLeaderShip, q13UnTrainedLeaderShip]
    ]);

    box = await Hive.openBox("db");

    syncAnswersFromDatabase();

    super.onInit();
  }

  @override
  void onClose() {
    q13TrainedCommunicationSkill.dispose();
    q13UnTrainedCommunicationSkill.dispose();
    q13TrainedPunctuality.dispose();
    q13UnTrainedPunctuality.dispose();
    q13TrainedTeamWork.dispose();
    q13UnTrainedTeamWork.dispose();
    q13TrainedInterPersonal.dispose();
    q13UnTrainedInterPersonal.dispose();
    q13TrainedLeaderShip.dispose();
    q13UnTrainedLeaderShip.dispose();
    super.onClose();
  }

  syncAnswersFromDatabase() {
    var dataList = _surveyQuestionController.dataList;
    // question 13
    AnswerHiveObject? answerQuestion13 =
        box.get("27${dataList[0]}${dataList[1]}");
    if (answerQuestion13 != null) {
      List list = answerQuestion13.extraData!["answers"];
      q13TrainedCommunicationSkill.text = list[0];
      q13UnTrainedCommunicationSkill.text = list[1];
      q13TrainedPunctuality.text = list[2];
      q13UnTrainedPunctuality.text = list[3];
      q13TrainedTeamWork.text = list[4];
      q13UnTrainedTeamWork.text = list[5];
      q13TrainedInterPersonal.text = list[6];
      q13UnTrainedInterPersonal.text = list[7];
      q13TrainedLeaderShip.text = list[8];
      q13UnTrainedLeaderShip.text = list[9];
    }
  }

  checkQuestion13Fields() {
    if (q13TrainedCommunicationSkill.text.isNotEmpty &&
        q13UnTrainedCommunicationSkill.text.isNotEmpty &&
        q13TrainedPunctuality.text.isNotEmpty &&
        q13UnTrainedPunctuality.text.isNotEmpty &&
        q13TrainedTeamWork.text.isNotEmpty &&
        q13UnTrainedTeamWork.text.isNotEmpty &&
        q13TrainedInterPersonal.text.isNotEmpty &&
        q13UnTrainedInterPersonal.text.isNotEmpty &&
        q13TrainedLeaderShip.text.isNotEmpty &&
        q13UnTrainedLeaderShip.text.isNotEmpty) {
      return true;
    } else {
      return false;
    }
  }

  updateAnswerIds(questionData) {
    List answers = questionData["answer"];
    for (var element in answers) {
      if (element["skill"] == "communication") {
        communicationAnswerId = element["id"];
      } else if (element["skill"] == "punctuality") {
        punctualityAnswerId = element["id"];
      } else if (element["skill"] == "team_work") {
        teamWorkAnswerId = element["id"];
      } else if (element["skill"] == "leadership") {
        leaderShipAnswerId = element["id"];
      } else if (element["skill"] == "interpersonal") {
        interpersonalAnswerId = element["id"];
      }
    }
  }

  bool checkQuestion13UniqueFields() {
    bool validation = true;
    if (q13TrainedCommunicationSkill.text ==
        q13UnTrainedCommunicationSkill.text) {
      validation = false;
      snackBar(
          "Notice", "Please enter unique value for Communication skill fields",
          error: true);
    } else if (q13TrainedPunctuality.text == q13UnTrainedPunctuality.text) {
      validation = false;
      snackBar("Notice",
          "Please enter unique value for Punctuality/Integrity fields",
          error: true);
    } else if (q13TrainedTeamWork.text == q13UnTrainedTeamWork.text) {
      validation = false;
      snackBar(
          "Notice", "Please enter unique value for Team work behaviors fields",
          error: true);
    } else if (q13TrainedLeaderShip.text == q13UnTrainedLeaderShip.text) {
      validation = false;
      snackBar(
          "Notice", "Please enter unique value for Leadership skills fields",
          error: true);
    } else if (q13TrainedInterPersonal.text == q13UnTrainedInterPersonal.text) {
      validation = false;
      snackBar(
          "Notice", "Please enter unique value for Interpersonal skills fields",
          error: true);
    }
    return validation;
  }

  answerQuestion13(
    questionId,
    questionType,
    questionNumber,
  ) async {
    bool internetStatus = await ConnectionStatus.checkConnection();

    var dataList = _surveyQuestionController.dataList;

    var formData = {
      "pivot_id": dataList[1],
      "question_id": questionId,
      "skill": {
        "communication": {
          "id": communicationAnswerId,
          "formally_trained": q13TrainedCommunicationSkill.text,
          "formally_untrained": q13UnTrainedCommunicationSkill.text
        },
        "punctuality": {
          "id": punctualityAnswerId,
          "formally_trained": q13TrainedPunctuality.text,
          "formally_untrained": q13UnTrainedPunctuality.text
        },
        "team_work": {
          "id": teamWorkAnswerId,
          "formally_trained": q13TrainedTeamWork.text,
          "formally_untrained": q13UnTrainedTeamWork.text
        },
        "leadership": {
          "id": leaderShipAnswerId,
          "formally_trained": q13TrainedInterPersonal.text,
          "formally_untrained": q13UnTrainedInterPersonal.text
        },
        "interpersonal": {
          "id": interpersonalAnswerId,
          "formally_trained": q13TrainedLeaderShip.text,
          "formally_untrained": q13UnTrainedLeaderShip.text
        }
      }
    };
    // if (checkQuestion13UniqueFields()) {
    if (internetStatus) {
      try {
        if (checkQuestion13Fields()) {
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
                "answers": [
                  q13TrainedCommunicationSkill.text,
                  q13UnTrainedCommunicationSkill.text,
                  q13TrainedPunctuality.text,
                  q13UnTrainedPunctuality.text,
                  q13TrainedTeamWork.text,
                  q13UnTrainedTeamWork.text,
                  q13TrainedInterPersonal.text,
                  q13UnTrainedInterPersonal.text,
                  q13TrainedLeaderShip.text,
                  q13UnTrainedLeaderShip.text
                ]
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
          snackBar(_strings.failedTitle, "Please fill fields.", error: true);
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
        ..extraData = {
          "answers": [
            q13TrainedCommunicationSkill.text,
            q13UnTrainedCommunicationSkill.text,
            q13TrainedPunctuality.text,
            q13UnTrainedPunctuality.text,
            q13TrainedTeamWork.text,
            q13UnTrainedTeamWork.text,
            q13TrainedInterPersonal.text,
            q13UnTrainedInterPersonal.text,
            q13TrainedLeaderShip.text,
            q13UnTrainedLeaderShip.text
          ]
        };

      /// key of each object is question id|surveyId|pivotId
      box.put("$questionId${dataList[0]}${dataList[1]}", answerModel);
    }
  }
// }
}
