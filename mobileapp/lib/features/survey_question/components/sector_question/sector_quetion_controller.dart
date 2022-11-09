import 'package:elms/constant/api_path.dart';
import 'package:elms/constant/app_strings.dart';
import 'package:elms/infrastructure/api_service/api_service.dart';
import 'package:elms/infrastructure/custom_storage/custom_storage.dart';
import 'package:elms/infrastructure/hive_database/answer_hive_object.dart';
import 'package:elms/models/sync_answer/sync_answer_model.dart';
import 'package:elms/utils/connection_status/connection_status.dart';
import 'package:elms/utils/debugger/debugger.dart';
import 'package:get/get.dart';
import 'package:hive_flutter/hive_flutter.dart';
import 'package:dio/dio.dart' as D;

import '../../../../utils/snackbar/snackbar.dart';
import '../../survey_question_controller.dart';

class SectorQuestionController extends GetxController {
  final SurveyQuestionController _surveyQuestionController = Get.find();

  // q 3
  RxString subSectorName = "".obs;
  RxInt subSectorId = 0.obs;
  late Box box;

  final AppStrings _strings = Get.find();
  final ApiService _apiService = Get.find();
  final ApiPath _path = Get.find();
  final CustomStorage _storage = Get.find();

  @override
  void onInit() async {
    box = await Hive.openBox("db");
    syncAnswersFromDatabase();
    super.onInit();
  }

  @override
  void onClose() {
    super.onClose();
  }

  syncAnswersFromDatabase() {
    var dataList = _surveyQuestionController.dataList;

    // q 3
    AnswerHiveObject? answerQuestion3 =
        box.get("14${dataList[0]}${dataList[1]}");
    if (answerQuestion3 != null) {
      subSectorName(answerQuestion3.fieldValue!);
      subSectorId(answerQuestion3.extraData!["subSectorId"]);
    }
  }

  answerSectorQuestion(
      questionId, answerName, questionType, subSectorId, questionNumber) async {
    bool internetStatus = await ConnectionStatus.checkConnection();

    var formData = {
      "pivot_id": _surveyQuestionController.dataList[1],
      "question_id": questionId,
      "answer": [subSectorId.toString()],
      "answer_id":
          _surveyQuestionController.getAnswerIdByQuestionName(questionNumber),
    };

    if (internetStatus) {
      try {
        if (answerName.isNotEmpty) {
          _surveyQuestionController.answerQuestionLoading(true);

          _storage.saveSubSecId(subSectorId);

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
              ..fieldValue = answerName
              ..questionType = questionType
              ..extraData = {"subSectorId": subSectorId};

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
          snackBar(
              _strings.failedTitle, "Please fill fields or select on item.",
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
        ..fieldValue = answerName
        ..questionType = questionType
        ..extraData = {"subSectorId": subSectorId};

      /// key of each object is questionid|surveyId|pivotId
      box.put(
          "$questionId${_surveyQuestionController.dataList[0]}${_surveyQuestionController.dataList[1]}",
          answerModel);
    }
  }
}
