// ignore_for_file: avoid_print

import 'package:dio/dio.dart' as D;
import 'package:elms/constant/api_path.dart';
import 'package:elms/constant/app_routes.dart';
import 'package:elms/constant/app_strings.dart';
import 'package:elms/infrastructure/api_service/api_service.dart';
import 'package:elms/infrastructure/custom_storage/custom_storage.dart';
import 'package:elms/infrastructure/global_controller/global_controller.dart';
import 'package:elms/infrastructure/hive_database/answer_hive_object.dart';
import 'package:elms/infrastructure/hive_database/hive_keys.dart';
import 'package:elms/models/organozation/organization_model.dart';
import 'package:elms/utils/connection_status/connection_status.dart';
import 'package:elms/utils/custom_geo_locator/custom_geo_locator.dart';
import 'package:elms/utils/debugger/debugger.dart';
import 'package:geolocator/geolocator.dart';
import 'package:get/get.dart';
import 'package:hive/hive.dart';

import '../../utils/snackbar/snackbar.dart';

class OrganizationController extends GetxController {
  RxList<OrganizationModel> organizationList = <OrganizationModel>[].obs;
  RxBool getOrganizationLoading = false.obs;
  RxBool getOrganizationError = false.obs;

  RxBool startSurveyLoading = false.obs;
  RxBool startSurveyError = false.obs;

  RxBool getAllQuestionsLoading = false.obs;
  RxBool getAllQuestionsError = false.obs;

  RxBool viewSurveyLoading = false.obs;

  RxInt clickedIndex = 0.obs;

  final ApiService _apiService = Get.find();
  final ApiPath _path = Get.find();
  final AppStrings _strings = Get.find();
  final AppRoutes _routes = Get.find();
  final CustomStorage _storage = Get.find();
  final surveyId = Get.arguments;
  late Box box;

  final GlobalController _globalController = Get.find();

  @override
  onInit() async {
    box = await Hive.openBox("db");

    _globalController.fetchFinishSurveys();
    _globalController.fetchStartSurveys();

    checkAndOnInit();
    super.onInit();
  }

  checkAndOnInit() async {
    bool internetStatus = await ConnectionStatus.checkConnection();
    if (internetStatus) {
      getOrganization();
    } else {
      getOrganizationLoading(true);
      organizationList.clear();

      List organization = box.get(HiveKeys.organizationKey);

      for (var element in organization) {
        organizationList.add(OrganizationModel.fromJson(element));
      }

      getOrganizationLoading(false);
    }
  }

  saveSurveyOnDatabaseOnOffline(Map data) {
    List<dynamic> list = [];
    List? items = box.get(HiveKeys.getStartSurveyKey());
    if (items != null) {
      list.addAll(items);
    }
    if (!list.contains(data)) {
      list.add(data);
    }
    box.put(HiveKeys.getStartSurveyKey(), list);
  }

  statusStartOrganizationOffline({
    required int pivotId,
  }) {
    late OrganizationModel item;
    late int index;

    for (var element in organizationList) {
      if (element.pivotId == pivotId) {
        item = element;
        index = organizationList.indexOf(element);
      }
    }
    if (item.status != "Completed") {
      organizationList.removeAt(index);
      organizationList.insert(
        index,
        OrganizationModel(
          id: item.id,
          orgName: item.orgName,
          phoneNo: item.phoneNo,
          establishDate: item.establishDate,
          pivotId: item.pivotId,
          status: "In Progress",
          sector: item.sector,
          districtName: item.districtName,
        ),
      );
      saveOrganizationInHive(
          organizationList.map((element) => element.toJson()).toList());
    }
  }

  statusCompleteOrganizationOffline({
    required int pivotId,
  }) {
    late OrganizationModel item;
    late int index;

    for (var element in organizationList) {
      if (element.pivotId == pivotId) {
        item = element;
        index = organizationList.indexOf(element);
      }
    }

    organizationList.removeAt(index);
    organizationList.insert(
      index,
      OrganizationModel(
        id: item.id,
        orgName: item.orgName,
        phoneNo: item.phoneNo,
        establishDate: item.establishDate,
        pivotId: item.pivotId,
        status: "Completed",
        sector: item.sector,
        districtName: item.districtName,
      ),
    );
    saveOrganizationInHive(
        organizationList.map((element) => element.toJson()).toList());
  }

  startSurvey({required int pivotId, required int surveyId}) async {
    try {
      print("****************************");
      print("$surveyId / $pivotId");
      print("****************************");

      // information for test start survey
      startSurveyLoading(true);
      startSurveyError(false);

      Position? locationData = await CustomGetLocator.determindPosition();

      bool internetStatus = await ConnectionStatus.checkConnection();

      if (internetStatus) {
        /// get refresh question to save for offline use
        D.Response? questionResponse = await _apiService.get(
          path: _path.questions
              .replaceFirst("{{survey_id}}", surveyId.toString())
              .replaceFirst("{{pivot_id}}", pivotId.toString()),
          needToken: true,
        );

        if (questionResponse == null) {
          snackBar("Notice!", "Please check device connection and try again",
              error: true);
          startSurveyError(true);
          startSurveyLoading(false);
        } else {
          D.Response? response = await _apiService
              .post(path: _path.startSurvey, needToken: true, formData: {
            "pivot_id": pivotId,
            "latitude": locationData!.latitude,
            "longitude": locationData.longitude,
          });

          if (response != null) {
            /// save question to use it in offline mode
            box.put(HiveKeys.getQuestionKey(surveyId, pivotId),
                questionResponse.data["data"]);

            /// parse answer from question response
            await parseAnswersFromQuestionJson(
                [surveyId, pivotId], questionResponse.data["data"]);

            /// change status of organization
            statusStartOrganizationOffline(pivotId: pivotId);
            Get.toNamed(_routes.surveyQuestion, arguments: [surveyId, pivotId]);
          } else {
            startSurveyError(true);
          }
        }
      } else {
        List? questions = box.get(HiveKeys.getQuestionKey(surveyId, pivotId));
        if (questions == null) {
        } else {
          statusStartOrganizationOffline(pivotId: pivotId);
          saveSurveyOnDatabaseOnOffline({
            "pivot_id": pivotId,
            "latitude": locationData!.latitude,
            "longitude": locationData.longitude,
          });
          await parseAnswersFromQuestionJson([surveyId, pivotId], questions);
          Get.toNamed(_routes.surveyQuestion, arguments: [surveyId, pivotId]);
        }
      }

      startSurveyLoading(false);
    } catch (e, s) {
      startSurveyError(true);
      startSurveyLoading(false);
      if (e ==
          "Location permissions are permanently denied, we cannot request permissions.") {
        snackBar(_strings.failedTitle,
            "Location permissions are permanently denied, we cannot request permissions.",
            error: true);
      }
      debugger(error: e, stacktrace: s);
    }
  }

  viewSurvey({required int pivotId, required int surveyId}) async {
    try {
      bool internetStatus = await ConnectionStatus.checkConnection();
      viewSurveyLoading(true);

      if (internetStatus) {
        D.Response? response = await _apiService.get(
          path: _path.questions
              .replaceFirst("{{survey_id}}", surveyId.toString())
              .replaceFirst("{{pivot_id}}", pivotId.toString()),
          needToken: true,
        );

        if (response != null) {
          /// save question to use it in offline mode
          box.put(HiveKeys.getQuestionKey(surveyId, pivotId),
              response.data["data"]);

          /// parser answers from json of questions
          await parseAnswersFromQuestionJson(
              [surveyId, pivotId], response.data["data"]);

          /// navigation to next page when request is success
          Get.toNamed(_routes.viewSurvey, arguments: [surveyId, pivotId]);
        } else {
          snackBar("Notice!", "Please check device connection and try again",
              error: true);
        }

        viewSurveyLoading(false);
      } else {
        /// do same operation in offline mode
        List? questions = box.get(HiveKeys.getQuestionKey(surveyId, pivotId));
        if (questions == null) {
          snackBar("Notice!",
              "Questions don't exist in offline database please check device connection",
              error: true);
        } else {
          /// parser answers from json of questions
          await parseAnswersFromQuestionJson([surveyId, pivotId], questions);
          Get.toNamed(_routes.viewSurvey, arguments: [surveyId, pivotId]);
        }
      }
      viewSurveyLoading(false);
    } catch (e, s) {
      viewSurveyLoading(false);

      debugger(error: e, stacktrace: s);
      snackBar("Notice!", "Please check device connection and try again",
          error: true);
    }
  }

  saveOrganizationInHive(List response) {
    box.put(HiveKeys.organizationKey, response);
  }

  getOrganization() async {
    try {
      getOrganizationLoading(true);
      getOrganizationError(false);
      organizationList.clear();

      D.Response? response = await _apiService.get(
        path: _path.organizations
            .replaceFirst("{{survey_id}}", surveyId.toString()),
        needToken: true,
      );

      if (response != null) {
        organizationList(organizationModelFromJson(response.data["data"]));
        saveOrganizationInHive(response.data["data"]);

        /// todo : this method disabled today and we should call it in other page
        // getAllQuestionsAndSaveInLocal();
      } else {
        getOrganizationError(true);
      }
      getOrganizationLoading(false);
    } catch (e, s) {
      getOrganizationError(false);
      getOrganizationLoading(false);
      debugger(error: e, stacktrace: s);
    }
  }

  getAllQuestionsAndSaveInLocal() async {
    try {
      getAllQuestionsLoading(true);
      getAllQuestionsError(false);
      for (OrganizationModel element in organizationList) {
        D.Response? response = await _apiService.get(
          path: _path.questions
              .replaceFirst("{{survey_id}}", surveyId.toString())
              .replaceFirst("{{pivot_id}}", element.pivotId.toString()),
          needToken: true,
        );

        if (response != null) {
          /// save question in offline database
          box.put(HiveKeys.getQuestionKey(surveyId, element.pivotId),
              response.data["data"]);
          bool? syncOnline = _storage.readSyncOnline();
          print("***************");
          print(syncOnline);
          print("***************");

          print("survey : $surveyId , pivot : ${element.pivotId}");

          if (syncOnline == null) {
            print("****** answer synced from database ******");
            parseAnswersFromQuestionJson(
                [surveyId, element.pivotId], response.data["data"]);
          }
        } else {
          snackBar(_strings.failedTitle,
              "Failed to get ${element.orgName}'s questions, Please try again!",
              error: true);
          getAllQuestionsError(true);
        }
      }
      _storage.saveSyncOnline();

      getAllQuestionsLoading(false);
    } catch (e, s) {
      snackBar(_strings.failedTitle,
          "Failed to get all questions , Please try again!",
          error: true);
      getAllQuestionsError(true);
      getAllQuestionsLoading(false);
      debugger(error: e, stacktrace: s);
    }
  }

  /// in this method I will parse question json and then write all data on local database
  /// hive used as local database
  parseAnswersFromQuestionJson(List dataList, List questionList) async {
    try {
      for (var element in questionList) {
        var questionType = element["ans_type"];
        var questionId = element["id"];
        var questionNumber = element["qsn_number"];
        List listOfAnswer = element["answer"];

        if (questionType == "input" && listOfAnswer.isNotEmpty) {
          var value = listOfAnswer.first["answer"];

          var answerModel = AnswerHiveObject()
            ..questionId = questionId
            ..fieldValue = value
            ..questionType = questionType
            ..extraData = {};

          /// key of each object is question id|surveyId|pivotId
          box.put("$questionId${dataList[0]}${dataList[1]}", answerModel);
        } else if (questionType == "external_table" &&
            questionNumber == "6.a" &&
            listOfAnswer.isNotEmpty) {
          List<dynamic> technicalList = [];

          for (var element in listOfAnswer) {
            technicalList.add({
              "id": element["id"],
              "emp_code": element["emp_code"],
              "gender": element["gender"],
              "occupation_id": element["occupation_id"],
              "working_time": element["working_time"],
              "work_nature": element["work_nature"],
              "training": element["training"],
              "ojt_apprentice": element["ojt_apprentice"],
              "work_exp1": element["work_exp1"],
              "work_exp2": element["work_exp2"],
              "edu_qua_general": element["edu_qua_general"],
              "edu_qua_tvet": element["edu_qua_tvet"],
            });
          }

          var answerModel = AnswerHiveObject()
            ..questionId = questionId
            ..fieldValue = " "
            ..questionType = questionType
            ..extraData = {"answers": technicalList};

          /// key of each object is question id|surveyId|pivotId
          box.put("$questionId${dataList[0]}${dataList[1]}", answerModel);
        } else if (questionType == "external_table" &&
            questionNumber == "6.b" &&
            listOfAnswer.isNotEmpty) {
          List<List<String?>> list = [];
          for (var element in listOfAnswer) {
            List<String?> temps = [
              element["working_number"].toString(),
              element["required_number"].toString(),
              element["for_two_years"].toString(),
              element["for_five_years"].toString(),
            ];
            list.add(temps);
          }

          var answerModel = AnswerHiveObject()
            ..questionId = questionId
            ..fieldValue = " "
            ..questionType = questionType
            ..extraData = {"answer": list};

          /// key of each object is question id|surveyId|pivotId
          box.put("$questionId${dataList[0]}${dataList[1]}", answerModel);
        } else if (questionType == "checkbox" && listOfAnswer.isNotEmpty) {
          String rawValues = listOfAnswer.first["answer"];
          List listOfValues = rawValues.split(",");
          List<int> intValues = listOfValues.map((e) => int.parse(e)).toList();

          var answerModel = AnswerHiveObject()
            ..questionId = questionId
            ..fieldValue = listOfAnswer.first["other_answer"] ?? " "
            ..questionType = questionType
            ..extraData = {"answer": intValues};

          /// key of each object is question id|surveyId|pivotId
          box.put("$questionId${dataList[0]}${dataList[1]}", answerModel);
        } else if (questionType == "services" && listOfAnswer.isNotEmpty) {
          String rawValues = listOfAnswer.first["answer"];
          List listOfValues = rawValues.split(",");
          List<int> intValues = listOfValues.map((e) => int.parse(e)).toList();

          var answerModel = AnswerHiveObject()
            ..questionId = questionId
            ..fieldValue = listOfAnswer.first["other_answer"] ?? " "
            ..questionType = questionType
            ..extraData = {"answer": intValues};

          /// key of each object is question id|surveyId|pivotId
          box.put("$questionId${dataList[0]}${dataList[1]}", answerModel);
        } else if (questionType == "radio" && listOfAnswer.isNotEmpty) {
          var answerModel = AnswerHiveObject()
            ..questionId = questionId
            ..fieldValue = listOfAnswer.first["other_answer"]
            ..questionType = questionType
            ..extraData = {"answer": listOfAnswer.first["qsn_opt_id"]};

          /// key of each object is question id|surveyId|pivotId
          box.put("$questionId${dataList[0]}${dataList[1]}", answerModel);
        } else if (questionType == "sub_qsn") {
          bool checker = false;

          List subAnswers = element["sub_questions"];

          for (var element in subAnswers) {
            List subSubAnswer = element["answer"];
            if (subSubAnswer.isNotEmpty) {
              checker = true;
            }
          }

          if (checker == true) {
            List<List<String?>> values = [];

            for (var element in subAnswers) {
              List<String?> tempValue = [];
              List subQuestionAnswer = element["answer"];
              if (subQuestionAnswer.isNotEmpty) {
                Map mapValues = subQuestionAnswer.first["answer"];
                mapValues.forEach((key, value) {
                  tempValue.add(value ?? "");
                });
              } else {
                tempValue.add("");
                tempValue.add("");
              }
              values.add(tempValue);
            }

            /// save answer in hive
            var answerModel = AnswerHiveObject()
              ..questionId = questionId
              ..fieldValue = " "
              ..questionType = questionType
              ..extraData = {"answer": values};

            /// key of each object is question id|surveyId|pivotId
            box.put("$questionId${dataList[0]}${dataList[1]}", answerModel);
          }
        } else if (questionType == "external_table" &&
            questionNumber == "13" &&
            listOfAnswer.isNotEmpty) {
          List<String> values = [];
          late String communicationAnswerT,
              communicationAnswerUT,
              punctualityAnswerT,
              punctualityAnswerUT,
              teamWorkAnswerT,
              teamWorkAnswerUT,
              leaderShipAnswerT,
              leaderShipAnswerUT,
              interpersonalAnswerT,
              interpersonalAnswerUT;

          for (var element in listOfAnswer) {
            for (var element in listOfAnswer) {
              if (element["skill"] == "communication") {
                communicationAnswerT = element["formally_trained"].toString();
                communicationAnswerUT =
                    element["formally_untrained"].toString();
              } else if (element["skill"] == "punctuality") {
                punctualityAnswerT = element["formally_trained"].toString();
                punctualityAnswerUT = element["formally_untrained"].toString();
              } else if (element["skill"] == "team_work") {
                teamWorkAnswerT = element["formally_trained"].toString();
                teamWorkAnswerUT = element["formally_untrained"].toString();
              } else if (element["skill"] == "leadership") {
                leaderShipAnswerT = element["formally_trained"].toString();
                leaderShipAnswerUT = element["formally_untrained"].toString();
              } else if (element["skill"] == "interpersonal") {
                interpersonalAnswerT = element["formally_trained"].toString();
                interpersonalAnswerUT =
                    element["formally_untrained"].toString();
              }
            }
          }

          values.addAll([
            communicationAnswerT,
            communicationAnswerUT,
            punctualityAnswerT,
            punctualityAnswerUT,
            teamWorkAnswerT,
            teamWorkAnswerUT,
            leaderShipAnswerT,
            leaderShipAnswerUT,
            interpersonalAnswerT,
            interpersonalAnswerUT
          ]);

          /// save object in hive

          var answerModel = AnswerHiveObject()
            ..questionId = questionId
            ..fieldValue = " "
            ..questionType = questionType
            ..extraData = {"answers": values};

          /// key of each object is question id|surveyId|pivotId
          box.put("$questionId${dataList[0]}${dataList[1]}", answerModel);
        } else if (questionType == "multiple_input" &&
            listOfAnswer.isNotEmpty) {
          List answerStrings = [];
          Map data = listOfAnswer.first["answer"];
          data.forEach((key, value) {
            answerStrings.add(value);
          });

          var answerModel = AnswerHiveObject()
            ..questionId = questionId
            ..fieldValue = " "
            ..questionType = questionType
            ..extraData = {"answers": answerStrings};

          /// key of each object is question id|surveyId|pivotId
          box.put("$questionId${dataList[0]}${dataList[1]}", answerModel);
        } else if (questionType == "sector" && listOfAnswer.isNotEmpty) {
          List subSectors = element["sub_sectors"];
          String fieldValue = "";
          for (var element in subSectors) {
            if (element["id"] == int.parse(listOfAnswer.first["answer"])) {
              fieldValue = element["sector_name"];
            }
          }

          var answerModel = AnswerHiveObject()
            ..questionId = questionId
            ..fieldValue = fieldValue
            ..questionType = questionType
            ..extraData = {
              "subSectorId": int.parse(listOfAnswer.first["answer"])
            };

          _storage.saveSubSecId(int.parse(listOfAnswer.first["answer"]));

          /// key of each object is question id|surveyId|pivotId
          box.put("$questionId${dataList[0]}${dataList[1]}", answerModel);
        } else if (questionType == "external_table" &&
            questionNumber == "5.1" &&
            listOfAnswer.isNotEmpty) {
          /// save object in hive
          var answerModel = AnswerHiveObject()
            ..questionId = questionId
            ..fieldValue = " "
            ..questionType = questionType
            ..extraData = {
              "answer": getArrayOfAnswersForQuestion5(element),
            };

          /// key of each object is question id|surveyId|pivotId
          box.put("$questionId${dataList[0]}${dataList[1]}", answerModel);
        } else if (questionType == "external_table" &&
            questionNumber == "5.2" &&
            listOfAnswer.isNotEmpty) {
          /// save object in hive
          var answerModel = AnswerHiveObject()
            ..questionId = questionId
            ..fieldValue = " "
            ..questionType = questionType
            ..extraData = {
              "answer": getArrayOfAnswersForQuestion5(element),
            };

          /// key of each object is question id|surveyId|pivotId
          box.put("$questionId${dataList[0]}${dataList[1]}", answerModel);
        } else if (questionType == "external_table" &&
            questionNumber == "5.3" &&
            listOfAnswer.isNotEmpty) {
          /// save object in hive
          var answerModel = AnswerHiveObject()
            ..questionId = questionId
            ..fieldValue = " "
            ..questionType = questionType
            ..extraData = {
              "answer": getArrayOfAnswersForQuestion5(element),
            };

          /// key of each object is question id|surveyId|pivotId
          box.put("$questionId${dataList[0]}${dataList[1]}", answerModel);
        } else if (questionType == "cond_radio" &&
            questionNumber == "9" &&
            listOfAnswer.isNotEmpty) {
          List conditionalAnswer = listOfAnswer.first["conditional_answer"];
          String? otherAnswer;

          if (conditionalAnswer.isNotEmpty) {
            otherAnswer = conditionalAnswer.first["answer"];
          }

          Map formData = {
            "pivot_id": dataList[1],
            "question_id": questionId,
            "answer_id": " ",
            "answer": listOfAnswer.first["qsn_opt_id"],
            "optionalAnswer": {"22": otherAnswer}
          };

          /// save object in hive
          var answerModel = AnswerHiveObject()
            ..questionId = questionId
            ..fieldValue = otherAnswer
            ..questionType = questionType
            ..extraData = {
              "answers": {
                "radioValue": listOfAnswer.first["qsn_opt_id"],
                "question17Answers": formData,
              }
            };

          /// key of each object is question id|surveyId|pivotId
          box.put("$questionId${dataList[0]}${dataList[1]}", answerModel);
        } else if (questionType == "cond_radio" &&
            questionNumber == "8" &&
            listOfAnswer.isNotEmpty) {
          List<dynamic> question8AnswerList = [];

          List temp = listOfAnswer.first["other_occup"];
          for (var element in temp) {
            question8AnswerList.add(
              {
                "id": element["id"],
                "occupation_id": element["occupation_id"],
                "present_demand": element["present_demand"],
                "demand_two_year": element["demand_two_year"],
                "demand_five_year": element["demand_five_year"]
              },
            );
          }

          /// save object in hive
          var answerModel = AnswerHiveObject()
            ..questionId = questionId
            ..fieldValue = " "
            ..questionType = questionType
            ..extraData = {
              "answers": {
                "radioValue": listOfAnswer.first["qsn_opt_id"],
                "question8Answers": question8AnswerList,
              }
            };

          /// key of each object is question id|surveyId|pivotId
          box.put("$questionId${dataList[0]}${dataList[1]}", answerModel);
        } else if (questionType == "cond_radio" &&
            questionNumber == "17" &&
            listOfAnswer.isNotEmpty) {
          Map tempAnswer = listOfAnswer.first;
          late Map tempSubAnswer;
          List tempSubAnswerList = tempAnswer["conditional_answer"];
          if (tempSubAnswerList.isNotEmpty) {
            tempSubAnswer = tempSubAnswerList.first;
          }

          var formData = {
            "pivot_id": dataList[1],
            "question_id": questionId,
            "answer_id": tempAnswer["id"],
            "answer": tempAnswer["qsn_opt_id"],
            "technology": {
              "id": tempSubAnswer["id"],
              "sector_id": tempSubAnswer["sector"]["parent_id"],
              "sub_sector_id": tempSubAnswer["sub_sector_id"],
              "technology": tempSubAnswer["technology"],
            }
          };

          /// save object in hive
          var answerModel = AnswerHiveObject()
            ..questionId = questionId
            ..fieldValue = " "
            ..questionType = questionType
            ..extraData = {
              "answers": {
                "radioValue": tempAnswer["qsn_opt_id"],
                "question17Answers": formData,
              }
            };

          /// key of each object is question id|surveyId|pivotId
          box.put("$questionId${dataList[0]}${dataList[1]}", answerModel);
        } else if (questionType == "cond_radio" &&
            questionNumber == "18" &&
            listOfAnswer.isNotEmpty) {
          Map tempAnswer = listOfAnswer.first;
          List<dynamic> question18AnswerList = [];
          List tempSubAnswerList = tempAnswer["conditional_answer"];

          for (var element in tempSubAnswerList) {
            question18AnswerList.add(
              {
                "id": element["id"],
                "sector_id": element["sector_id"],
                "occupation_id": element["occupation_id"],
                "level": element["level"],
                "required_number": element["required_number"],
                "incorporate_possible": element["incorporate_possible"],
              },
            );
          }

          /// save object in hive
          var answerModel = AnswerHiveObject()
            ..questionId = questionId
            ..fieldValue = " "
            ..questionType = questionType
            ..extraData = {
              "answers": {
                "radioValue": tempAnswer["qsn_opt_id"],
                "question18Answers": question18AnswerList,
              }
            };

          /// key of each object is question id|surveyId|pivotId
          box.put("$questionId${dataList[0]}${dataList[1]}", answerModel);
        }
      }
    } catch (e, s) {
      print(e);
      print(s);
    }
  }

  getArrayOfAnswersForQuestion5(questionData) {
    Map question5Data = questionData;
    List questionAnswer = question5Data["answer"];

    List<List<int>> countersListForSave = List<List<int>>.generate(
        4, (item) => List<int>.generate(6, (item) => 0)).toList();

    for (var element in questionAnswer) {
      switch (element["resource_type"]) {
        case "employer":
          switch (element["working_type"]) {
            case "managerial":
              countersListForSave[0][0] = element["male_count"];
              countersListForSave[0][1] = element["female_count"];
              countersListForSave[0][2] = element["minority_count"];
              countersListForSave[0][3] = element["nepali_count"];
              countersListForSave[0][4] = element["neighboring_count"];
              countersListForSave[0][5] = element["foreigner_count"];
              break;
            case "technical":
              countersListForSave[1][0] = element["male_count"];
              countersListForSave[1][1] = element["female_count"];
              countersListForSave[1][2] = element["minority_count"];
              countersListForSave[1][3] = element["nepali_count"];
              countersListForSave[1][4] = element["neighboring_count"];
              countersListForSave[1][5] = element["foreigner_count"];
              break;
            case "administrative":
              countersListForSave[2][0] = element["male_count"];
              countersListForSave[2][1] = element["female_count"];
              countersListForSave[2][2] = element["minority_count"];
              countersListForSave[2][3] = element["nepali_count"];
              countersListForSave[2][4] = element["neighboring_count"];
              countersListForSave[2][5] = element["foreigner_count"];
              break;
            case "assisting":
              countersListForSave[3][0] = element["male_count"];
              countersListForSave[3][1] = element["female_count"];
              countersListForSave[3][2] = element["minority_count"];
              countersListForSave[3][3] = element["nepali_count"];
              countersListForSave[3][4] = element["neighboring_count"];
              countersListForSave[3][5] = element["foreigner_count"];
              break;
          }
          break;
        case "family_member":
          switch (element["working_type"]) {
            case "managerial":
              countersListForSave[0][0] = element["male_count"];
              countersListForSave[0][1] = element["female_count"];
              countersListForSave[0][2] = element["minority_count"];
              countersListForSave[0][3] = element["nepali_count"];
              countersListForSave[0][4] = element["neighboring_count"];
              countersListForSave[0][5] = element["foreigner_count"];
              break;
            case "technical":
              countersListForSave[1][0] = element["male_count"];
              countersListForSave[1][1] = element["female_count"];
              countersListForSave[1][2] = element["minority_count"];
              countersListForSave[1][3] = element["nepali_count"];
              countersListForSave[1][4] = element["neighboring_count"];
              countersListForSave[1][5] = element["foreigner_count"];
              break;
            case "administrative":
              countersListForSave[2][0] = element["male_count"];
              countersListForSave[2][1] = element["female_count"];
              countersListForSave[2][2] = element["minority_count"];
              countersListForSave[2][3] = element["nepali_count"];
              countersListForSave[2][4] = element["neighboring_count"];
              countersListForSave[2][5] = element["foreigner_count"];
              break;
            case "assisting":
              countersListForSave[3][0] = element["male_count"];
              countersListForSave[3][1] = element["female_count"];
              countersListForSave[3][2] = element["minority_count"];
              countersListForSave[3][3] = element["nepali_count"];
              countersListForSave[3][4] = element["neighboring_count"];
              countersListForSave[3][5] = element["foreigner_count"];
              break;
          }
          break;
        case "employees":
          switch (element["working_type"]) {
            case "managerial":
              countersListForSave[0][0] = element["male_count"];
              countersListForSave[0][1] = element["female_count"];
              countersListForSave[0][2] = element["minority_count"];
              countersListForSave[0][3] = element["nepali_count"];
              countersListForSave[0][4] = element["neighboring_count"];
              countersListForSave[0][5] = element["foreigner_count"];
              break;
            case "technical":
              countersListForSave[1][0] = element["male_count"];
              countersListForSave[1][1] = element["female_count"];
              countersListForSave[1][2] = element["minority_count"];
              countersListForSave[1][3] = element["nepali_count"];
              countersListForSave[1][4] = element["neighboring_count"];
              countersListForSave[1][5] = element["foreigner_count"];
              break;
            case "administrative":
              countersListForSave[2][0] = element["male_count"];
              countersListForSave[2][1] = element["female_count"];
              countersListForSave[2][2] = element["minority_count"];
              countersListForSave[2][3] = element["nepali_count"];
              countersListForSave[2][4] = element["neighboring_count"];
              countersListForSave[2][5] = element["foreigner_count"];
              break;
            case "assisting":
              countersListForSave[3][0] = element["male_count"];
              countersListForSave[3][1] = element["female_count"];
              countersListForSave[3][2] = element["minority_count"];
              countersListForSave[3][3] = element["nepali_count"];
              countersListForSave[3][4] = element["neighboring_count"];
              countersListForSave[3][5] = element["foreigner_count"];
              break;
          }
          break;
      }
    }

    return countersListForSave;
  }
}
