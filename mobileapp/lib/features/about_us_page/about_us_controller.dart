import 'package:elms/constant/api_path.dart';
import 'package:elms/infrastructure/api_service/api_service.dart';
import 'package:elms/infrastructure/hive_database/hive_keys.dart';
import 'package:elms/models/about_us/about_us_model.dart';
import 'package:elms/utils/connection_status/connection_status.dart';
import 'package:elms/utils/debugger/debugger.dart';
import 'package:dio/dio.dart' as D;
import 'package:get/get.dart';
import 'package:hive_flutter/hive_flutter.dart';

class AboutUsController extends GetxController {
  RxBool getAboutInfoLoading = false.obs;
  RxBool getAboutInfoError = false.obs;
  RxList<AboutUsModel> aboutUsList = <AboutUsModel>[].obs;
  late Box box;

  final ApiService _apiService = Get.find();
  final ApiPath _path = Get.find();

  @override
  void onInit() async {
    box = await Hive.openBox("db");

    getAboutUsInformation();
    super.onInit();
  }

  getAboutUsInformation() async {
    bool interetStatus = await ConnectionStatus.checkConnection();
    if (interetStatus) {
      try {
        getAboutInfoLoading(true);
        getAboutInfoError(false);

        D.Response? response = await _apiService.get(
          needToken: true,
          path: _path.about,
        );

        if (response != null && response.statusCode == 200) {
          List list = response.data["data"];
          for (var element in list) {
            aboutUsList.add(AboutUsModel.fromJson(element));
          }
        }

        getAboutInfoLoading(false);
      } catch (e, s) {
        getAboutInfoLoading(false);
        getAboutInfoError(true);

        debugger(error: e, stacktrace: s);
      }
    } else {
      getAboutInfoLoading(true);

      List data = box.get(HiveKeys.aboutUsKey);
      for (var element in data) {
        aboutUsList.add(AboutUsModel.fromJson(element));
      }

      getAboutInfoLoading(false);
    }
  }
}
