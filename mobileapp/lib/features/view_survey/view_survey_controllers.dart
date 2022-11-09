// ignore_for_file: library_prefixes

import 'package:elms/constant/api_path.dart';
import 'package:elms/features/survey_question/survey_question_controller.dart';
import 'package:elms/infrastructure/api_service/api_service.dart';
import 'package:elms/infrastructure/hive_database/hive_keys.dart';
import 'package:elms/utils/connection_status/connection_status.dart';
import 'package:elms/utils/debugger/debugger.dart';
import 'package:get/get.dart';
import 'package:dio/dio.dart' as D;
import 'package:hive_flutter/hive_flutter.dart';

class ViewSurveyController extends GetxController {
  RxBool getQeustionsLoading = false.obs;
  RxBool getQuesstionsError = false.obs;
  RxList questionList = <dynamic>[].obs;

  final ApiService _apiService = Get.find();
  final ApiPath _path = Get.find();
  final SurveyQuestionController _surveyQuestionController = Get.find();
  late Box box;

  // 0 => surveyId 1 => pivotId
  List<int> dataList = Get.arguments;

  @override
  void onInit() async {
    box = await Hive.openBox("db");

    onInitHandle();
    super.onInit();
  }

  getSubSectorNameById(id) {
    for (var element in _surveyQuestionController.subSectorsList) {
      if (element.id == id) {
        return element.subSectorName;
      }
    }
  }

  getCheckedCheckBoxNames(
      {required String questionNumber, required List<int> checkedValue}) {
    Map questionData = _surveyQuestionController
        .getSpecificQuestoinMapByQuestionNumber(questionNumber);
    List<String> nameOfOptinos = [];
    List options = [];
    if (questionData["question_options"] != null) {
      options = questionData["question_options"];
    }
    if (options.isNotEmpty) {
      for (var element in options) {
        if (checkedValue.contains(element["id"])) {
          nameOfOptinos.add(element["option_name"]);
        }
      }
    }
    return nameOfOptinos;
  }

  getCheckedCheckBoxNamesQuestion4(
    List<int> checkedValue,
  ) {
    List<String> checkListNames = [];
    for (var element in _surveyQuestionController.productAndServiceList) {
      for (var item in checkedValue) {
        if (element.id == item) {
          checkListNames.add(element.productAndServicesName);
        }
      }
    }
    return checkListNames;
  }

  getQuestion13WorkerList() {
    List<String> options = [];
    for (var element in questionList) {
      if (element["qsn_number"] == "13") {
        Map map = element["worker_skills"];
        map.forEach((key, value) {
          options.add(value);
        });
      }
    }
    return options;
  }

  getMultipleQuestionTitleList(questionNumber) {
    List<String> options = [];
    for (var element in questionList) {
      if (element["qsn_number"] == questionNumber) {
        List list = element["question_options"];
        for (var element in list) {
          options.add(element["option_name"]);
        }
      }
    }
    return options;
  }

  getCheckBoxList(List<int> list, String questionNumber) {
    List<String> listOfTitle = [];
    for (var element in questionList) {
      if (element["qsn_number"] == questionNumber) {
        List tempList = element["question_options"];
        for (var element in tempList) {
          if (list.contains(element["id"])) {
            listOfTitle.add(element["option_name"]);
          }
        }
      }
    }
  }

  getRadioValue(int radioValue) {
    if (questionList.isNotEmpty) {
      for (var element in questionList) {
        if (element["ans_type"] == "radio") {
          List options = element["question_options"];
          for (var subElement in options) {
            if (subElement["id"] == radioValue) {
              return subElement["option_name"];
            }
          }
        }
      }
    }
    return " ";
  }

  getQuestionObjectWithQuestionNumber(questionNumber) {
    for (var element in questionList) {
      if (element["qsn_number"] == questionNumber) {
        return element;
      }
    }
  }

  getConditionRadioValue(int radioValue) {
    if (questionList.isNotEmpty) {
      for (var element in questionList) {
        if (element["ans_type"] == "cond_radio") {
          List options = element["question_options"];
          for (var subElement in options) {
            if (subElement["id"] == radioValue) {
              return subElement["option_name"];
            }
          }
        }
      }
    }
    return " ";
  }

  onInitHandle() async {
    bool interetStatus = await ConnectionStatus.checkConnection();
    if (interetStatus) {
      getQuestions(surveyId: dataList[0], pivotId: dataList[1]);
    } else {
      getAllQuestionsFromOfflineDatabase();
    }
  }

  getAllQuestionsFromOfflineDatabase() {
    getQeustionsLoading(true);

    List quesitons = box.get(HiveKeys.getQuestionKey(dataList[0], dataList[1]));

    questionList.addAll(quesitons);

    getQeustionsLoading(false);
  }

  getQuestions({required int surveyId, required int pivotId}) async {
    try {
      getQeustionsLoading(true);

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
        getQuesstionsError(true);
      }
      getQeustionsLoading(false);
    } catch (e, s) {
      getQuesstionsError(true);
      debugger(error: e, stacktrace: s);
    }
  }
}
