import 'package:elms/features/survey_question/survey_question_controller.dart';
import 'package:elms/infrastructure/hive_database/answer_hive_object.dart';
import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:hive_flutter/hive_flutter.dart';

class CheckBoxQuestionController extends GetxController {
  final SurveyQuestionController _surveyQuestionController = Get.find();
  late Box box;

  // q 1.3
  RxList<int> q1_3checkbox = <int>[].obs;
  TextEditingController q1_3OtherController = TextEditingController();
  // q 5
  RxList<int> q5checkbox = <int>[].obs;
  // q 19
  RxList<int> q19checkbox = <int>[].obs;

  @override
  void onInit() async {
    box = await Hive.openBox("db");
    syncAnswersFromDatabase();
    super.onInit();
  }

  @override
  void onClose() {
    q1_3OtherController.dispose();

    super.onClose();
  }

  syncAnswersFromDatabase() {
    var dataList = _surveyQuestionController.dataList;
    // question 1.3
    AnswerHiveObject? answerQuestion1_3 =
        box.get("3${dataList[0]}${dataList[1]}");
    if (answerQuestion1_3 != null) {
      q1_3OtherController.text = answerQuestion1_3.fieldValue!;
      q1_3checkbox.addAll(answerQuestion1_3.extraData!["answer"]);
    }

    // question 5
    AnswerHiveObject? answerQuestion5 =
        box.get("39${dataList[0]}${dataList[1]}");
    if (answerQuestion5 != null) {
      q5checkbox.addAll(answerQuestion5.extraData!["answer"]);
      print(q5checkbox);
    }

    // question 19
    AnswerHiveObject? answerQuestion19 =
        box.get("32${dataList[0]}${dataList[1]}");
    if (answerQuestion19 != null) {
      q19checkbox.addAll(answerQuestion19.extraData!["answer"]);
    }
  }

  getControllerOfQuestionInputQuestion(questionNumber) {
    if (questionNumber == "1.3") {
      return q1_3OtherController;
    }
  }

  getCheckBoxValueOfQuestion(questionNumber) {
    if (questionNumber == "1.3") {
      return q1_3checkbox;
    } else if (questionNumber == "5") {
      return q5checkbox;
    } else if (questionNumber == "19") {
      return q19checkbox;
    }
  }
}
