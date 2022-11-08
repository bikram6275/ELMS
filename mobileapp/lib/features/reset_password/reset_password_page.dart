import 'package:elms/constant/app_colors.dart';
import 'package:elms/constant/app_dimens.dart';
import 'package:elms/constant/app_strings.dart';
import 'package:elms/features/reset_password/reset_password_controller.dart';
import 'package:elms/global_widgets/custom_button/custom_button.dart';
import 'package:elms/global_widgets/custom_from_field/custom_form_fields.dart';
import 'package:elms/utils/custom_text/custom_text.dart';
import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:get/get_state_manager/get_state_manager.dart';

class ResetPasswordPage extends GetResponsiveView {
  ResetPasswordPage({Key? key}) : super(key: key);

  final AppStrings _strings = Get.find();
  final AppDimens _dimens = Get.find();
  final AppColors _colors = Get.find();
  final ResetPasswordController _resetPasswordController = Get.find();

  customSizedBox() => const SizedBox(
        height: 20,
      );

  @override
  Widget? builder() {
    return Scaffold(
      appBar: AppBar(
        title: Text(
          _strings.changePassTitle,
        ),
      ),
      body: Padding(
        padding: EdgeInsets.all(_dimens.padding * 2),
        child: Column(
          mainAxisAlignment: MainAxisAlignment.center,
          children: [
            CustomFormField(
              editController: _resetPasswordController.currentPassController,
              hint: _strings.oldPassTitle,
            ),
            customSizedBox(),
            CustomFormField(
              editController: _resetPasswordController.newPassController,
              hint: _strings.newPassTitle,
            ),
            customSizedBox(),
            CustomFormField(
              editController: _resetPasswordController.confirmPassController,
              hint: _strings.confirmPassTitle,
            ),
            customSizedBox(),
            CustomButton(
              child: CustomText(
                _strings.submitBtn,
                colorOption: TextColorOptions.light,
                sizeOption: TextSizeOptions.button,
              ),
              color: _colors.buttonColor,
              onPressed: () {},
              height: 50,
            ),
          ],
        ),
      ),
    );
  }
}
