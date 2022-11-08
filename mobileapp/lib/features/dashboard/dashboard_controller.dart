import 'package:elms/constant/api_path.dart';
import 'package:elms/infrastructure/api_service/api_service.dart';
import 'package:elms/infrastructure/global_controller/global_controller.dart';
import 'package:elms/infrastructure/hive_database/hive_keys.dart';
import 'package:elms/models/survey/survey_model.dart';
import 'package:elms/utils/connection_status/connection_status.dart';
import 'package:elms/utils/debugger/debugger.dart';
import 'package:dio/dio.dart' as D;
import 'package:get/get.dart';
import 'package:hive/hive.dart';

class DashboardController extends GetxController {
  RxList<SurveyModel> recentSurveyList = <SurveyModel>[].obs;

  RxBool getRecentSurveyLoading = false.obs;
  RxBool getRecentSurveyError = false.obs;
  RxBool getSectorLoading = false.obs;
  RxBool getSectorError = false.obs;
  RxBool getProductsLoading = false.obs;
  RxBool getProductsError = false.obs;
  RxBool getOccupationLoading = false.obs;
  RxBool getOccupationError = false.obs;
  RxBool getAboutInfoLoading = false.obs;
  RxBool getAboutInfoError = false.obs;

  final GlobalController _globalController = Get.find();

  final ApiService _apiService = Get.find();
  final ApiPath _apiPath = Get.find();
  final ApiPath _path = Get.find();
  late Box box;

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
      getRecentSurvey();
      getProductAndServices();
      getSectors();
      getOccupation();
      getAboutUsInformation();
      getNepaliMonth();
      getNepaliYear();
    } else {
      getDataInOfflineMode();
    }
  }

  getNepaliYear() async {
    try {
      getRecentSurveyLoading(true);
      getRecentSurveyError(false);
      D.Response? response = await _apiService.get(
        path: _path.nepaliYears,
        needToken: true,
      );
      if (response != null) {
        box.put(HiveKeys.nYearKey, response.data["data"]);
      }
      getRecentSurveyLoading(false);
    } catch (e, s) {
      getRecentSurveyError(true);
      getRecentSurveyLoading(false);
      debugger(error: e, stacktrace: s);
    }
  }

  getNepaliMonth() async {
    try {
      getRecentSurveyLoading(true);
      getRecentSurveyError(false);
      D.Response? response = await _apiService.get(
        path: _path.nepaliMonth,
        needToken: true,
      );

      if (response != null) {
        box.put(HiveKeys.nMonthKey, response.data["data"]);
      }
      getRecentSurveyLoading(false);
    } catch (e, s) {
      getRecentSurveyError(true);
      getRecentSurveyLoading(false);
      debugger(error: e, stacktrace: s);
    }
  }

  getAboutUsInformation() async {
    try {
      getAboutInfoLoading(true);
      getAboutInfoError(false);

      D.Response? response = await _apiService.get(
        needToken: true,
        path: _path.about,
      );

      if (response != null && response.statusCode == 200) {
        box.put(HiveKeys.aboutUsKey, response.data["data"]);
      }

      getAboutInfoLoading(false);
    } catch (e, s) {
      getAboutInfoLoading(false);
      getAboutInfoError(true);

      debugger(error: e, stacktrace: s);
    }
  }

  getDataInOfflineMode() async {
    getRecentSurveyLoading(true);
    getRecentSurveyError(false);

    List surveys = box.get(HiveKeys.surveysKey);
    recentSurveyList.clear();

    for (var element in surveys) {
      recentSurveyList.add(SurveyModel.fromJson(element));
    }
    getRecentSurveyLoading(false);
    getRecentSurveyError(false);
  }

  getProductAndServices() async {
    try {
      getProductsLoading(true);
      getProductsError(false);
      D.Response response = await _apiService.get(
        path: _path.productAndService,
        needToken: true,
      );

      if (response.statusCode == 200) {
        box.put(HiveKeys.productsServicesKey, response.data);
      } else {
        getProductsError(true);
      }

      getProductsLoading(false);
    } catch (e, s) {
      getProductsLoading(false);
      getProductsError(true);
      debugger(stacktrace: s, error: e);
    }
  }

  getSectors() async {
    try {
      getSectorLoading(true);
      getSectorError(false);
      D.Response response = await _apiService.get(
        path: _path.subSectors,
        needToken: true,
      );

      if (response.statusCode == 200) {
        box.put(HiveKeys.subSectorKey, response.data);
      } else {
        getSectorError(true);
      }

      getSectorLoading(false);
    } catch (e, s) {
      getSectorLoading(false);
      getSectorError(true);
      debugger(stacktrace: s, error: e);
    }
  }

  getOccupation() async {
    try {
      getOccupationLoading(true);
      getOccupationError(false);

      D.Response? response = await _apiService.get(
        path: _path.occupation,
        needToken: true,
      );

      if (response != null) {
        box.put(HiveKeys.occupationKey, response.data["data"]);
      } else {
        getOccupationError(true);
      }
      getOccupationLoading(false);
    } catch (e, s) {
      getOccupationError(true);
      getOccupationLoading(false);
      debugger(error: e, stacktrace: s);
    }
  }

  getRecentSurvey() async {
    try {
      getRecentSurveyLoading(true);
      getRecentSurveyError(false);
      recentSurveyList.clear();

      D.Response? response = await _apiService.get(
        path: _apiPath.recentSurvey,
        needToken: true,
      );

      if (response != null) {
        recentSurveyList(surveyModelFromJson(response.data["data"]));
        box.put(HiveKeys.surveysKey, response.data["data"]);
      } else {
        getRecentSurveyError(true);
      }

      getRecentSurveyLoading(false);
    } catch (e, s) {
      getRecentSurveyLoading(false);
      debugger(error: e, stacktrace: s);
    }
  }
}
