import 'package:flutter/material.dart';
import 'package:get/get_state_manager/get_state_manager.dart';

class ResetPasswordController extends GetxController {
  TextEditingController currentPassController = TextEditingController();
  TextEditingController newPassController = TextEditingController();
  TextEditingController confirmPassController = TextEditingController();

  @override
  void onClose() {
    currentPassController.dispose();
    newPassController.dispose();
    confirmPassController.dispose();
    super.onClose();
  }
}
