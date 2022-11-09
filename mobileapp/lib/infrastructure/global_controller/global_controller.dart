// ignore_for_file: avoid_print

import 'package:dio/dio.dart' as D;
import 'package:elms/constant/api_path.dart';
import 'package:elms/constant/app_routes.dart';
import 'package:elms/infrastructure/api_service/api_service.dart';
import 'package:elms/infrastructure/custom_storage/custom_storage.dart';
import 'package:elms/infrastructure/hive_database/hive_keys.dart';
import 'package:elms/utils/connection_status/connection_status.dart';
import 'package:elms/utils/debugger/debugger.dart';
import 'package:get/get.dart';
import 'package:get/get_state_manager/get_state_manager.dart';
import 'package:hive_flutter/hive_flutter.dart';

enum Auth {
  authenticated,
  unauthenticated,
}

class GlobalController extends GetxController {
  RxObjectMixin authState = Auth.unauthenticated.obs;

  final CustomStorage _storage = Get.find();
  final AppRoutes _routes = Get.find();
  final ApiPath _path = Get.find();
  final ApiService _apiService = Get.find();
  late Box box;

  @override
  onInit() {
    checkAuthentication();
    super.onInit();
  }

  checkAuthentication() {
    var token = _storage.readToken();
    if (token != null) {
      authState(Auth.authenticated);
    } else {
      authState(Auth.unauthenticated);
    }
  }

  logoutUser() {
    _storage.removeExpTokenTime();
    _storage.removeName();
    _storage.removePhone();
    _storage.removeToken();
    _storage.removeUserId();
    _storage.removeUserStatus();
    _storage.removePradeshName();
    _storage.removeEnglishName();
    Get.offAllNamed(_routes.login);
  }

  fetchFinishSurveys() async {
    try {
      box = await Hive.openBox("db");

      bool internetStatus = await ConnectionStatus.checkConnection();

      if (internetStatus) {
        List? items = box.get(HiveKeys.getFinishSurveyKey());
        List datas = [];

        if (items != null && items.isNotEmpty) {
          datas.addAll(items);

          for (var element in items) {
            print("recent survey finished because user is online");
            D.Response? response = await _apiService.post(
                path: _path.finishSurvey, needToken: true, formData: element);

            if (response != null && response.statusCode == 200) {
              datas.remove(element);
            }
          }
          box.put(HiveKeys.getFinishSurveyKey(), datas);
        } else {
          print("finish survey is empty");
        }
      }
    } catch (e, s) {
      debugger(error: e, stacktrace: s);
    }
  }

  fetchStartSurveys() async {
    try {
      box = await Hive.openBox("db");

      bool internetStatus = await ConnectionStatus.checkConnection();

      if (internetStatus) {
        List? items = box.get(HiveKeys.getStartSurveyKey());
        List datas = [];

        if (items != null && items.isNotEmpty) {
          datas.addAll(items);
          for (var element in items) {
            print("recent survey started because user is online");
            D.Response? response = await _apiService.post(
                path: _path.startSurvey, needToken: true, formData: element);

            if (response != null && response.statusCode == 200) {
              datas.remove(element);
            }
          }
          box.put(HiveKeys.getStartSurveyKey(), datas);
        } else {
          print("start survey is empty");
        }
      }
    } catch (e, s) {
      debugger(error: e, stacktrace: s);
    }
  }
}
