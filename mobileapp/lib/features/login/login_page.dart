import 'package:elms/constant/app_colors.dart';
import 'package:elms/constant/app_dimens.dart';
import 'package:elms/constant/app_routes.dart';
import 'package:elms/constant/app_strings.dart';
import 'package:elms/features/login/login_controller.dart';
import 'package:elms/global_widgets/custom_button/custom_button.dart';
import 'package:elms/global_widgets/custom_from_field/custom_form_fields.dart';
import 'package:elms/global_widgets/custom_indicator/custom_indicator.dart';
import 'package:elms/utils/custom_text/custom_text.dart';
import 'package:flutter/material.dart';
import 'package:get/get.dart';

class LoginPage extends GetResponsiveView {
  LoginPage({Key? key}) : super(key: key, alwaysUseBuilder: true);

  final AppStrings _appStrings = Get.find();
  final AppColors _appColor = Get.find();
  final AppDimens _appDimens = Get.find();
  final AppRoutes _routes = Get.find();
  final LoginController _loginController = Get.find();

  @override
  Widget? builder() {
    return Scaffold(
      body: ui(),
    );
  }

  customExpanded(flex) => Expanded(
        flex: flex,
        child: const SizedBox(
          height: 1,
        ),
      );

  ui() => SafeArea(
        child: Padding(
          padding: EdgeInsets.all(_appDimens.padding * 2),
          child: SingleChildScrollView(
            child: Column(
              mainAxisAlignment: MainAxisAlignment.center,
              children: [
                SizedBox(
                  height: screen.height * .05,
                ),
                Image.asset(
                  "assets/images/ELMS_Logo.png",
                  width: 200,
                ),
                SizedBox(
                  height: screen.height * .2,
                ),
                Column(
                  children: [
                    CustomText(
                      _appStrings.loginTitle,
                      sizeOption: TextSizeOptions.body,
                      textAlign: TextAlign.start,
                      fontWeight: FontWeight.bold,
                      customColor: _appColor.buttonColor,
                    ),
                    SizedBox(
                      height: screen.height * .05,
                    ),
                    CustomFormField(
                      hint: _appStrings.emailHint,
                      editController: _loginController.emailController,
                      onChanged: (value) {},
                      textInputType: TextInputType.emailAddress,
                      validatorsType: "email",
                    ),
                    SizedBox(
                      height: screen.height * .02,
                    ),
                    CustomFormField(
                      hint: _appStrings.passHint,
                      isPasswordField: true,
                      editController: _loginController.passwordController,
                      onChanged: (value) {},
                      textInputType: TextInputType.visiblePassword,
                      validatorsType: "length",
                    ),
                  ],
                ),
                SizedBox(
                  height: screen.height * .02,
                ),
                InkWell(
                  onTap: () {
                    Get.toNamed(_routes.forgetPassword);
                  },
                  child: CustomText(
                    _appStrings.forgetPass,
                    customColor: _appColor.buttonColor,
                    textAlign: TextAlign.start,
                    sizeOption: TextSizeOptions.underline,
                  ),
                ),
                SizedBox(
                  height: screen.height * .06,
                ),
                CustomButton(
                  width: screen.width * .6,
                  height: 50,
                  child: Obx(
                    () => _loginController.loginLoading.value
                        ? CustomIndicator(
                            size: 30,
                            color: _appColor.lightIndicator,
                          )
                        : CustomText(
                            _appStrings.loginBtn,
                            colorOption: TextColorOptions.light,
                            sizeOption: TextSizeOptions.button,
                          ),
                  ),
                  color: _appColor.buttonColor,
                  onPressed: () {
                    _loginController.loginUser(
                      _loginController.emailController.text,
                      _loginController.passwordController.text,
                    );
                  },
                ),
                // SizedBox(
                //   height: screen.height * .06,
                // ),
                // imagesSection(),
              ],
            ),
          ),
        ),
      );

  imageDivider() => const SizedBox(
        width: 3,
      );

  imagesSection() => Column(
        mainAxisAlignment: MainAxisAlignment.center,
        crossAxisAlignment: CrossAxisAlignment.center,
        children: [
          Row(
            mainAxisAlignment: MainAxisAlignment.center,
            children: [
              Image.asset(
                'assets/images/dakchyata.jpeg',
                width: 50,
                height: 50,
              ),
              imageDivider(),
              Image.asset(
                'assets/images/EU.png',
                width: 50,
                height: 50,
              ),
              imageDivider(),
              Image.asset(
                'assets/images/British_council.png',
                width: 50,
                height: 50,
              ),
            ],
          ),
          Row(
            mainAxisAlignment: MainAxisAlignment.center,
            children: [
              Image.asset(
                'assets/images/fncci.png',
                width: 50,
                height: 50,
              ),
              imageDivider(),
              Image.asset(
                'assets/images/CNI.png',
                width: 50,
                height: 50,
              ),
              imageDivider(),
              Image.asset(
                'assets/images/fncsi.jpeg',
                width: 50,
                height: 50,
              ),
              imageDivider(),
              Image.asset(
                'assets/images/han.gif',
                width: 50,
                height: 50,
              ),
            ],
          ),
        ],
      );
}
