import 'package:elms/constant/api_path.dart';
import 'package:elms/constant/app_strings.dart';
import 'package:elms/infrastructure/api_service/api_service.dart';
import 'package:elms/utils/debugger/debugger.dart';
import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:dio/dio.dart' as D;

import '../../utils/snackbar/snackbar.dart';

class ForgetPasswordController extends GetxController {
  RxBool submitForgetPassLoading = false.obs;

  TextEditingController emailController = TextEditingController();
  final AppStrings _strings = Get.find();
  final ApiService _service = Get.find();
  final ApiPath _path = Get.find();

  @override
  void onClose() {
    emailController.dispose();
    super.onClose();
  }

  checkField() {
    if (emailController.text.isNotEmpty) {
      return true;
    } else {
      snackBar(_strings.failedTitle, _strings.fieldError, error: true);
      return false;
    }
  }

  forgetPassword() async {
    try {
      if (checkField()) {
        submitForgetPassLoading(true);

        D.Response? response = await _service
            .post(path: _path.forgetPassword, needToken: false, formData: {
          "email": emailController.text,
        });

        if (response != null && response.statusCode == 200) {
          snackBar(_strings.successTitle, response.data["status"],
              error: false);
        }
        submitForgetPassLoading(false);
      }
    } catch (e, s) {
      submitForgetPassLoading(false);

      debugger(error: e, stacktrace: s);
    }
  }
}
