import 'package:elms/infrastructure/hive_database/answer_hive_object.dart';
import 'package:get/get.dart';
import 'package:hive_flutter/hive_flutter.dart';

import '../../../../models/product_service/product_service_model.dart';
import '../../survey_question_controller.dart';

class ServiceQuestionController extends GetxController {
  final SurveyQuestionController _surveyQuestionController = Get.find();

  // q 4
  RxList<int> q4checkbox = <int>[].obs;
  late Box box;

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
    // question 4
    AnswerHiveObject? answerQuestion4 =
        box.get("15${dataList[0]}${dataList[1]}");
    if (answerQuestion4 != null) {
      q4checkbox.addAll(answerQuestion4.extraData!["answer"]);
    }
  }

  clearCheckBoxListFromUnUsableData(List<ProductAndService> mainDataList) {
    List ids = mainDataList.map((e) => e.id).toList();
    List extraIds = [];
    q4checkbox.forEach((element) {
      if (!ids.contains(element)) {
        extraIds.add(element);
      }
    });

    extraIds.forEach((element) {
      q4checkbox.remove(element);
    });
  }
}
