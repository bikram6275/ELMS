// ignore_for_file: avoid_print

import 'package:dio/dio.dart' as D;
import 'package:elms/constant/api_path.dart';
import 'package:elms/constant/app_colors.dart';
import 'package:elms/constant/app_routes.dart';
import 'package:elms/constant/app_strings.dart';
import 'package:elms/features/organization/organization_controller.dart';
import 'package:elms/features/survey_question/components/custom_size_box.dart';
import 'package:elms/global_widgets/custom_button/custom_button.dart';
import 'package:elms/global_widgets/custom_from_field/custom_form_fields.dart';
import 'package:elms/infrastructure/api_service/api_service.dart';
import 'package:elms/infrastructure/custom_storage/custom_storage.dart';
import 'package:elms/infrastructure/global_controller/global_controller.dart';
import 'package:elms/infrastructure/hive_database/answer_hive_object.dart';
import 'package:elms/infrastructure/hive_database/hive_keys.dart';
import 'package:elms/models/occupation/occupation_model.dart';
import 'package:elms/models/product_service/product_service_model.dart';
import 'package:elms/models/sub_sector/sub_sector_model.dart';
import 'package:elms/models/sync_answer/sync_answer_model.dart';
import 'package:elms/utils/connection_status/connection_status.dart';
import 'package:elms/utils/debugger/debugger.dart';
import 'package:flutter/material.dart';
import 'package:flutter_datetime_picker/flutter_datetime_picker.dart';
import 'package:get/get.dart';
import 'package:hive_flutter/hive_flutter.dart';
import 'package:scrollable_positioned_list/scrollable_positioned_list.dart';

import '../../utils/snackbar/snackbar.dart';

class SurveyQuestionController extends GetxController {
  RxList<SyncAnswerModel> updateRequiredQuestionList = <SyncAnswerModel>[].obs;
  ItemScrollController scrollController = ItemScrollController();
  TextEditingController respondentNameController = TextEditingController();
  TextEditingController designationController = TextEditingController();
  RxString selectedDate = "".obs;

  final GlobalController _globalController = Get.find();
  final OrganizationController _organizationController = Get.find();

  // old answer variables
  late List<int> answersList;

  RxBool getQuestionsLoading = false.obs;
  RxBool getQuestionsError = false.obs;
  RxBool sendRemainingQuestionLoading = false.obs;
  RxBool sendRemainingQuestionError = false.obs;

  RxBool finishSurveyLoading = false.obs;
  RxBool finishSurveyError = false.obs;

  RxBool answerQuestionLoading = false.obs;
  RxList questionList = <dynamic>[].obs;
  RxList filteredQuestionList = <dynamic>[].obs;
  RxList<OccupationModel> occupationList = <OccupationModel>[].obs;
  RxList<ProductAndService> productAndServiceList = <ProductAndService>[].obs;
  RxList<SectorModel> subSectorsList = <SectorModel>[].obs;
  RxInt selectedQuestion = 0.obs;

  // q 2 area
  RxList<List<TextEditingController>> q2ControllersList =
      <List<TextEditingController>>[].obs;

  List<int> questionIdList = [];
  List<int?> oldAnswersId = [];
  List<List<String>> answerDataId = [
    ["19", "20"],
    ["21", "22"],
    ["23", "24"],
    ["25", "26"],
    ["27", "28"],
  ];

  // q2 area

  final AppStrings _strings = Get.find();
  final ApiService _apiService = Get.find();
  final AppColors _colors = Get.find();
  final ApiPath _path = Get.find();
  final CustomStorage _storage = Get.find();
  final AppRoutes _routes = Get.find();
  late Box box;

  // 0 => surveyId 1 => pivotId
  List<int> dataList = Get.arguments;

  @override
  onInit() async {
    box = await Hive.openBox("db");
    getAllProductsFromOfflineDatabase();
    getAllSubSectorsFromOfflineDatabase();

    _globalController.fetchFinishSurveys();
    _globalController.fetchStartSurveys();

    onInitHandle();

    getInitValueOfUpdateList();

    super.onInit();
  }

  @override
  onClose() {
    respondentNameController.dispose();
    designationController.dispose();
    super.onClose();
  }

  onInitHandle() async {
    bool internetStatus = await ConnectionStatus.checkConnection();
    if (internetStatus) {
      getQuestions(surveyId: dataList[0], pivotId: dataList[1]);
      getOccupation();
    } else {
      getAllQuestionsFromOfflineDatabase();
      getAllOccupationsFromOfflineDatabase();
      getOldAnswerIds();
    }
  }

  TextInputType? parseDynamicInputFields(String? input) {
    if (input == "number") {
      return TextInputType.number;
    } else if (input == "string") {
      return TextInputType.text;
    } else {
      return TextInputType.text;
    }
  }

  createQ2ControllersOnInit(Map questionData) {
    List subQuestions = questionData["sub_questions"];
    for (var element in subQuestions) {
      // create all controllers from response
      TextEditingController yController = TextEditingController();
      TextEditingController mController = TextEditingController();
      List<TextEditingController> controllersList = [yController, mController];
      q2ControllersList.add(controllersList);
    }
    getAnswerIdsFromQuestionResponse(questionData);
    syncQ2AnswersFromDatabase();
  }

  /// use this method to get id of each question with help of name / number of question
  /// you can use this method to save and read questions answer from database
  getQuestionIdByQuestionNumber(String questionNumber) {
    int? id;
    List? questions =
        box.get(HiveKeys.getQuestionKey(dataList[0], dataList[1]));
    if (questions != null) {
      for (var element in questions) {
        if (element["qsn_number"] == questionNumber) {
          id = element["id"];
        }
      }
    }
    return id;
  }

  getAnswerIdsFromQuestionResponse(Map questionData) {
    oldAnswersId.clear();
    questionIdList.clear();

    List subQuestions = questionData["sub_questions"];
    for (var subElement in subQuestions) {
      // add question id from response
      questionIdList.add(subElement["id"]);

      // add old answer id from response
      List answer = subElement["answer"];
      int? id;
      if (answer.isNotEmpty) {
        id = answer.first["id"];
      }
      oldAnswersId.add(id);
      // add answer data id

      // if (answer.isNotEmpty) {
      //   List<String> dataIdList = [];
      //   Map subAnswer = answer.first["answer"];
      //   subAnswer.forEach((key, value) {
      //     dataIdList.add(key);
      //   });
      //   answerDataId.add(dataIdList);
      // }
    }
  }

  getAnswerFromQuestionResponseByQuestionNumber(
      List<dynamic> questionList, String questionNumber) {
    List<dynamic> answer = [];
    for (var element in questionList) {
      if (element["qsn_number"] == questionNumber) {
        answer = element["answer"];
      }
    }
    return answer;
  }

  saveSurveyInOfflineMode(Map finishSurvey) {
    List<dynamic> list = [];
    List? items = box.get(HiveKeys.getFinishSurveyKey());
    if (items != null) {
      list.addAll(items);
    }
    if (!list.contains(finishSurvey)) {
      list.add(finishSurvey);
    }
    box.put(HiveKeys.getFinishSurveyKey(), list);
  }

  getMessageFromQuesitonNumbers(List numbers) {
    String temp = " ";
    for (var element in numbers) {
      temp += "- question number $element \n";
    }
    return temp;
  }

  finishSurvey() async {
    try {
      List notAnsweredQuestion = [];
      finishSurveyLoading(true);
      finishSurveyError(false);

      for (var element in filteredQuestionList) {
        AnswerHiveObject? item =
            box.get("${element["id"]}${dataList[0]}${dataList[1]}");
        if (item == null) {
          print(element);
          notAnsweredQuestion.add(element["qsn_number"]);
          print(notAnsweredQuestion);
        }
      }

      if (notAnsweredQuestion.isEmpty) {
        if (respondentNameController.text.isNotEmpty &&
            designationController.text.isNotEmpty &&
            selectedDate.value != "") {
          bool internetStatus = await ConnectionStatus.checkConnection();
          if (internetStatus) {
            D.Response? response = await _apiService
                .post(path: _path.finishSurvey, needToken: true, formData: {
              "pivot_id": dataList[1],
              "respondent_name": respondentNameController.text,
              "designation": designationController.text,
              "interview_date": selectedDate.value,
            });

            if (response != null && response.statusCode == 200) {
              _organizationController.statusCompleteOrganizationOffline(
                  pivotId: dataList[1]);
              clearFinishSurveyInfo();
              Get.offAllNamed(_routes.organization, arguments: dataList[0]);
            }
          } else {
            _organizationController.statusCompleteOrganizationOffline(
                pivotId: dataList[1]);
            saveSurveyInOfflineMode({
              "pivot_id": dataList[1],
              "respondent_name": respondentNameController.text,
              "designation": designationController.text,
              "interview_date": selectedDate.value,
            });
            Get.offAllNamed(_routes.organization, arguments: dataList[0]);
          }
        } else {
          snackBar(_strings.failedTitle, "Please fill all fields ",
              error: true);
        }
      } else {
        snackBar(_strings.failedTitle,
            "Please answer to these questions : \n ${getMessageFromQuesitonNumbers(notAnsweredQuestion)}",
            error: true);
      }

      finishSurveyLoading(false);
    } catch (e, s) {
      finishSurveyLoading(false);
      finishSurveyError(true);

      debugger(error: e, stacktrace: s);
    }
  }

  sendRemainingQuestionToServer() async {
    bool internetStatus = await ConnectionStatus.checkConnection();

    if (internetStatus) {
      try {
        sendRemainingQuestionLoading(true);

        /// here we should create list of dio request and then call future.wait on it
        List requests = [];
        D.Dio _dio = Get.find();

        for (SyncAnswerModel element in updateRequiredQuestionList) {
          requests.add(
            _dio
                .post(
              _path.answer,
              data: element.formData,
              options: D.Options(headers: {
                "Content-Type": "application/json",
                "Accept": "application/json",
                "Authorization": "Bearer ${_storage.readToken()}",
              }),
            )
                .then((value) {
              removeSpecificQuestionFromUpdateList(data: element);
            }).catchError((e, s) {
              debugger(error: e, stacktrace: s);
            }),
          );
        }

        sendRemainingQuestionLoading(false);
      } catch (e, s) {
        sendRemainingQuestionLoading(false);
        sendRemainingQuestionError(true);
        debugger(error: e, stacktrace: s);
      }
    } else {
      snackBar(
          _strings.failedTitle, "Please check your connection and try again !",
          error: true);
    }
  }

  addQuestionToUpdateList({required SyncAnswerModel data}) {
    bool isExist = false;
    SyncAnswerModel? existObject;
    for (var element in updateRequiredQuestionList) {
      if (element.questionId == data.questionId) {
        isExist = true;
        existObject = element;
      }
    }
    if (isExist) {
      updateRequiredQuestionList.remove(existObject);
    }
    updateRequiredQuestionList.add(data);
    box.put(
      "${dataList[0]}${dataList[1]}",
      {
        "list": SyncAnswerModel.toJsonList(
          updateRequiredQuestionList,
        )
      },
    );
  }

  removeSpecificQuestionFromUpdateList({required SyncAnswerModel data}) {
    updateRequiredQuestionList.remove(data);
    box.put(
      "${dataList[0]}${dataList[1]}",
      {
        "list": SyncAnswerModel.toJsonList(
          updateRequiredQuestionList,
        )
      },
    );
  }

  clearUpdateList() {
    updateRequiredQuestionList.clear();
    box.put(
      "${dataList[0]}${dataList[1]}",
      {
        "list": SyncAnswerModel.toJsonList(
          updateRequiredQuestionList,
        )
      },
    );
  }

  getInitValueOfUpdateList() {
    var data = box.get("${dataList[0]}${dataList[1]}");
    List list;
    if (data != null) {
      list = data["list"];
    } else {
      list = [];
    }
    updateRequiredQuestionList(SyncAnswerModel.toModelList(list));
  }

  getAnswerIdByQuestionName(questionNumber) {
    var index = getIndexOfQuestionsByQuestionNumber(questionNumber);
    if (index == null) {
      return null;
    } else {
      var answerIndex = answersList[index];
      if (answerIndex == 0) {
        return null;
      } else {
        return answerIndex;
      }
    }
  }

  getOldAnswerIds() {
    // fill all list with 0 value
    answersList = List<int>.generate(questionList.length, (i) => 0);
    // fill all list with null value
    for (var i = 0; i < questionList.length; i++) {
      if (questionList[i]["answer"].isNotEmpty) {
        answersList[i] = questionList[i]["answer"].first["id"];
      } else {
        answersList[i] = 0;
      }
    }
  }

  getIndexOfQuestionsByQuestionNumber(questionNumber) {
    int? id;
    for (var element in questionList) {
      if (element["qsn_number"] == questionNumber) {
        id = questionList.indexOf(element);
        return id;
      }
    }
    return id;
  }

  getSpecificQuestoinMapByQuestionNumber(questionNumber) {
    Map data = {};
    for (var element in questionList) {
      if (element["qsn_number"] == questionNumber) {
        data = element;
        return data;
      }
    }
    return data;
  }

  getAllProductsFromOfflineDatabase() {
    var data = box.get(HiveKeys.productsServicesKey);

    List<dynamic> list = data["data"];
    for (var element in list) {
      productAndServiceList.add(ProductAndService.fromJson(element));
    }
  }

  getAllSubSectorsFromOfflineDatabase() {
    var data = box.get(HiveKeys.subSectorKey);

    List<dynamic> list = data["data"];
    for (var element in list) {
      subSectorsList.add(SectorModel.fromJson(element));
    }
  }

  getAllQuestionsFromOfflineDatabase() {
    getQuestionsLoading(true);
    List questions = box.get(HiveKeys.getQuestionKey(dataList[0], dataList[1]));

    questionList.addAll(questions);
    createQ2ControllersOnInit(getSpecificQuestoinMapByQuestionNumber("2"));

    getQuestionsLoading(false);
  }

  getAllOccupationsFromOfflineDatabase() {
    getQuestionsLoading(true);

    List occupationTemps = box.get(HiveKeys.occupationKey);

    for (var element in occupationTemps) {
      occupationList.add(OccupationModel.fromJson(element));
    }

    getQuestionsLoading(false);
  }

  List<ProductAndService> filterProductAndServiceList() {
    int? subSecId = _storage.readSubSecId();
    List<ProductAndService> list = [];
    if (subSecId != null && subSecId != 0) {
      for (ProductAndService element in productAndServiceList) {
        if (element.subSectorId == subSecId) {
          list.add(element);
        }
      }
    }
    return list;
  }

  checkQuestionColorState(key) {
    AnswerHiveObject? item = box.get(key);
    if (item != null) {
      return true;
    }
    return false;
  }

  answerCheckBoxQuestion(
      {questionId,
      required List listOfValues,
      TextEditingController? otherController,
      questionType,
      questionNumber}) async {
    bool internetStatus = await ConnectionStatus.checkConnection();

    var formData = {
      "pivot_id": dataList[1],
      "question_id": questionId,
      "answer": listOfValues,
      "other_answer": (otherController != null) ? otherController.text : null,
      "answer_id": getAnswerIdByQuestionName(questionNumber),
    };
    if (listOfValues.isEmpty) {
      snackBar(_strings.failedTitle,
          "Please select one item to answer the question!",
          error: true);
    } else if (otherController != null &&
        otherController.text.isEmpty &&
        listOfValues.contains(6) &&
        questionNumber == "1.3") {
      snackBar(_strings.failedTitle, "Please Fill Text Field", error: true);
    } else if (listOfValues.isNotEmpty) {
      if (internetStatus) {
        try {
          answerQuestionLoading(true);
          D.Response response = await _apiService.post(
            path: _path.answer,
            needToken: true,
            formData: formData,
          );

          if (response.statusCode == 200) {
            /// push indicator index to next question
            goToNextQuestion();

            /// save object in hive

            var answerModel = AnswerHiveObject()
              ..questionId = questionId
              ..fieldValue =
                  (otherController != null) ? otherController.text : " "
              ..questionType = questionType
              ..extraData = {"answer": listOfValues};

            /// key of each object is question id|surveyId|pivotId
            box.put("$questionId${dataList[0]}${dataList[1]}", answerModel);

            answerQuestionLoading(false);
          } else {
            snackBar(_strings.failedTitle, "Please check an item.",
                error: true);
          }
        } catch (e, s) {
          answerQuestionLoading(false);

          debugger(stacktrace: s, error: e);
        }
      } else {
        /// add question to update required list to sync with server later
        addQuestionToUpdateList(
          data: SyncAnswerModel(
              formData: formData,
              questionId: questionId,
              questionNumber: questionNumber),
        );

        /// push indicator index to next question
        goToNextQuestion();

        /// answer when no internet access
        var answerModel = AnswerHiveObject()
          ..questionId = questionId
          ..fieldValue = (otherController != null) ? otherController.text : " "
          ..questionType = questionType
          ..extraData = {"answer": listOfValues};

        /// key of each object is question id|surveyId|pivotId
        box.put("$questionId${dataList[0]}${dataList[1]}", answerModel);
      }
    }
  }

  checkListOfFormFieldsControllers(RxList<TextEditingController> list) {
    bool filled = false;
    for (var element in list) {
      if (element.text.isNotEmpty) {
        filled = true;
      }
    }
    if (filled) {
      return true;
    } else {
      return false;
    }
  }

  getSuggestionList(List<dynamic> data) {
    List<String> list = [];
    for (var element in data) {
      list.add(element["sector_name"]);
    }
    return list;
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

        getOldAnswerIds();
        createQ2ControllersOnInit(getSpecificQuestoinMapByQuestionNumber("2"));
      } else {
        getQuestionsError(true);
      }
      getQuestionsLoading(false);
    } catch (e, s) {
      getQuestionsError(true);
      debugger(error: e, stacktrace: s);
    }
  }

  syncQ2AnswersFromDatabase() {
    // q 2
    AnswerHiveObject? answerQuestion2 =
        box.get("8${dataList[0]}${dataList[1]}");
    if (answerQuestion2 != null) {
      List<dynamic> list = answerQuestion2.extraData!["answer"];
      for (var i = 0; i < list.length; i++) {
        q2ControllersList[i][0].text = list[i][0];
        // q2ControllersList[i][1].text = list[i][1];
      }
    }
  }

  getOccupation() async {
    try {
      getQuestionsLoading(true);
      getQuestionsError(false);

      D.Response? response = await _apiService.get(
        path: _path.occupation,
        needToken: true,
      );

      if (response != null) {
        for (var element in (response.data["data"] as List)) {
          occupationList.add(OccupationModel.fromJson(element));
        }

        /// save question in offline database
        box.put(HiveKeys.occupationKey, response.data["data"]);
      } else {
        getQuestionsError(true);
      }
      getQuestionsLoading(false);
    } catch (e, s) {
      getQuestionsError(true);
      getQuestionsLoading(false);
      debugger(error: e, stacktrace: s);
    }
  }

  goToNextQuestion() {
    if (selectedQuestion.value < filteredQuestionList.length - 1) {
      FocusManager.instance.primaryFocus?.unfocus();
      selectedQuestion(selectedQuestion.value + 1);
      scrollController.scrollTo(
        index: selectedQuestion.value,
        duration: const Duration(milliseconds: 100),
      );
    } else if (selectedQuestion.value == filteredQuestionList.length - 1) {
      Get.defaultDialog(
        title: "Finish Survey.",
        content: Column(
          children: [
            CustomFormField(
              editController: respondentNameController,
              hint: "Name",
            ),
            sizedBox(),
            CustomFormField(
              editController: designationController,
              hint: "Designation",
            ),
            sizedBox(),
            TextButton(
                onPressed: () {
                  DatePicker.showDatePicker(
                    Get.context!,
                    showTitleActions: true,
                    minTime: DateTime(2018, 3, 5),
                    maxTime: DateTime(2040, 6, 7),
                    onChanged: (date) {},
                    onConfirm: (date) {
                      print('confirm ${date.year}-${date.month}-${date.day}');
                      selectedDate('${date.year}-${date.month}-${date.day}');
                    },
                    currentTime: DateTime.now(),
                  );
                },
                child: Column(
                  children: [
                    const Text(
                      'Show date time picker',
                      style: TextStyle(color: Colors.blue),
                    ),
                    Obx(() => Text(selectedDate.value)),
                  ],
                )),
          ],
        ),
        cancel: Container(),
        confirm: CustomButton(
            radius: 20,
            child: const Text("Save"),
            width: 200,
            height: 50,
            color: _colors.buttonColor,
            onPressed: () {
              Get.back();
              finishSurvey();
            }),
      );
    }
  }

  clearFinishSurveyInfo() {
    designationController.clear();
    respondentNameController.clear();
    selectedDate("");
  }

  goToPreviousQuestion() {
    selectedQuestion(selectedQuestion.value - 1);
    scrollController.scrollTo(
      index: selectedQuestion.value,
      duration: const Duration(milliseconds: 100),
    );
  }
}
