import 'package:elms/constant/app_colors.dart';
import 'package:elms/constant/app_dimens.dart';
import 'package:elms/constant/app_strings.dart';
import 'package:elms/features/about_us_page/about_us_controller.dart';
import 'package:elms/features/survey_question/components/custom_size_box.dart';
import 'package:elms/global_widgets/custom_button/custom_button.dart';
import 'package:elms/global_widgets/custom_indicator/custom_indicator.dart';
import 'package:elms/utils/custom_text/custom_text.dart';
import 'package:flutter/material.dart';
import 'package:get/get.dart';

class AboutUsPage extends GetResponsiveView {
  AboutUsPage({Key? key}) : super(key: key);

  final AppStrings _strings = Get.find();
  final AboutUsController _aboutUsController = Get.find();
  final AppColors _colors = Get.find();
  final AppDimens _dimens = Get.find();

  @override
  Widget? builder() {
    return Scaffold(
      appBar: AppBar(
        title: Text(
          _strings.aboutUsTitle,
        ),
      ),
      body: Obx(
        () => _aboutUsController.getAboutInfoLoading.value
            ? Center(
                child: CustomIndicator(
                  color: _colors.primaryColor,
                ),
              )
            : _aboutUsController.getAboutInfoError.value
                ? Center(
                    child: CustomButton(
                        width: screen.width * .5,
                        child: CustomText(
                          _strings.tryAgainBtn,
                          colorOption: TextColorOptions.light,
                        ),
                        color: _colors.buttonColor,
                        onPressed: () {
                          _aboutUsController.onInit();
                        }),
                  )
                : _aboutUsController.aboutUsList.isEmpty
                    ? Container()
                    : SingleChildScrollView(
                        child: SafeArea(
                          child: Padding(
                            padding: EdgeInsets.all(_dimens.padding),
                            child: Column(
                              children: [
                                CustomText(
                                  _aboutUsController.aboutUsList.first.title,
                                  maxLine: 3,
                                  textAlign: TextAlign.center,
                                  sizeOption: TextSizeOptions.title,
                                  fontWeight: FontWeight.bold,
                                ),
                                sizedBox(),
                                CustomText(
                                  _aboutUsController
                                      .aboutUsList.first.description,
                                  maxLine: 40,
                                  textAlign: TextAlign.left,
                                  sizeOption: TextSizeOptions.body,
                                ),
                              ],
                            ),
                          ),
                        ),
                      ),
      ),
    );
  }
}
