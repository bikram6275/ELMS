import 'package:elms/constant/app_colors.dart';
import 'package:elms/constant/app_strings.dart';
import 'package:elms/features/forget_password/forget_password_controller.dart';
import 'package:elms/global_widgets/custom_button/custom_button.dart';
import 'package:elms/global_widgets/custom_from_field/custom_form_fields.dart';
import 'package:elms/global_widgets/custom_indicator/custom_indicator.dart';
import 'package:elms/utils/custom_text/custom_text.dart';
import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:get/get_state_manager/get_state_manager.dart';

class ForgetPasswordPage extends GetResponsiveView {
  ForgetPasswordPage({Key? key}) : super(key: key, alwaysUseBuilder: true);

  final AppStrings _strings = Get.find();
  final AppColors _colors = Get.find();

  final ForgetPasswordController _forgetPasswordController = Get.find();

  @override
  Widget? builder() {
    return Scaffold(
      appBar: AppBar(
        title: Text(_strings.forgetPasswordTitle),
      ),
      body: Padding(
        padding: const EdgeInsets.all(8.0),
        child: Column(
          mainAxisAlignment: MainAxisAlignment.center,
          children: [
            CustomFormField(
              editController: _forgetPasswordController.emailController,
              hint: _strings.emailHint,
              validatorsType: 'email',
            ),
            const SizedBox(
              height: 30,
            ),
            CustomButton(
                height: 60,
                child: Obx(() =>
                    _forgetPasswordController.submitForgetPassLoading.value
                        ? Center(
                            child: CustomIndicator(
                              color: _colors.lightIndicator,
                            ),
                          )
                        : CustomText(
                            _strings.submitBtn,
                            colorOption: TextColorOptions.light,
                          )),
                color: _colors.buttonColor,
                onPressed: () {
                  _forgetPasswordController.forgetPassword();
                }),
          ],
        ),
      ),
    );
  }
}
