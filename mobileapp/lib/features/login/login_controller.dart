import 'package:dio/dio.dart' as D;
import 'package:elms/constant/api_path.dart';
import 'package:elms/constant/app_routes.dart';
import 'package:elms/constant/app_strings.dart';
import 'package:elms/infrastructure/api_service/api_service.dart';
import 'package:elms/infrastructure/custom_storage/custom_storage.dart';
import 'package:elms/models/user/user_model.dart';
import 'package:elms/utils/debugger/debugger.dart';
import 'package:flutter/material.dart';
import 'package:get/get.dart';

import '../../utils/snackbar/snackbar.dart';

class LoginController extends GetxController {
  RxBool loginLoading = false.obs;
  TextEditingController emailController = TextEditingController();
  TextEditingController passwordController = TextEditingController();

  final ApiService _apiService = Get.find();
  final ApiPath _apiPath = Get.find();
  final AppStrings _appStrings = Get.find();
  final CustomStorage _storage = Get.find();
  final AppRoutes _routes = Get.find();

  @override
  void onClose() {
    emailController.dispose();
    passwordController.dispose();
    super.onClose();
  }

  // @override
  // void onInit() {
  //   super.onInit();
  // }

  saveUserInformation(
      {expTime, name, phone, userId, userStatus, token, pName, eName, email}) {
    _storage.saveExpTokenTime(expTime);
    _storage.saveName(name);
    _storage.savePhone(phone);
    _storage.saveToken(token);
    _storage.saveUserId(userId);
    _storage.saveUserStatus(userStatus);
    _storage.saveEnglishName(eName);
    _storage.savePradeshName(pName);
    _storage.saveEmail(email);
  }

  checkFields() {
    if (emailController.text.isNotEmpty && passwordController.text.isNotEmpty) {
      return true;
    } else {
      snackBar(_appStrings.failedTitle, _appStrings.fieldError, error: true);
      return false;
    }
  }

  loginUser(email, password) async {
    try {
      if (checkFields()) {
        loginLoading(true);

        D.Response? response = await _apiService.post(
            path: _apiPath.login,
            formData: {
              "email": email,
              "password": password,
            },
            needToken: false);

        if (response != null) {
          if (response.statusCode == 200) {
            UserModel userData = UserModel.fromJson(response.data["data"]);

            saveUserInformation(
              expTime: userData.expiresIn,
              name: userData.user.name,
              phone: userData.user.phoneNo,
              token: userData.token,
              userId: userData.user.id,
              userStatus: userData.user.userStatus,
              eName: userData.user.district["english_name"],
              pName: userData.user.pradesh["pradesh_name"],
              email: userData.user.email,
            );

            Get.offNamed(_routes.dashboard);
          }
        }
        loginLoading(false);
      }
    } catch (e, s) {
      loginLoading(false);
      debugger(error: e, stacktrace: s);
      snackBar(_appStrings.failedTitle, "Problem occurred please try again !",
          error: true);
    }
  }
}
