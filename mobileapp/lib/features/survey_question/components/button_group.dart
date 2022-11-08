import 'package:elms/constant/app_colors.dart';
import 'package:elms/constant/app_strings.dart';
import 'package:elms/features/survey_question/survey_question_controller.dart';
import 'package:elms/global_widgets/custom_button/custom_button.dart';
import 'package:elms/utils/custom_text/custom_text.dart';
import 'package:flutter/material.dart';
import 'package:get/get.dart';

class ButtonGroup extends GetResponsiveView {
  ButtonGroup({
    Key? key,
    required this.previousState,
    required this.onPressed,
    this.finalBtn = false,
  }) : super(key: key);

  final bool previousState;
  final VoidCallback onPressed;
  final bool finalBtn;

  final AppStrings _strings = Get.find();
  final AppColors _colors = Get.find();

  final SurveyQuestionController _surveyQuestionController = Get.find();

  @override
  Widget? builder() {
    return Row(
      children: [
        Visibility(
          visible: previousState,
          child: Expanded(
            child: CustomButton(
                radius: 20,
                height: 50,
                child: CustomText(
                  _strings.previousBtn,
                  colorOption: TextColorOptions.light,
                ),
                color: _colors.button2Color,
                onPressed: () {
                  _surveyQuestionController.goToPreviousQuestion();
                }),
          ),
        ),
        const SizedBox(
          width: 10,
        ),
        Expanded(
          child: CustomButton(
            radius: 20,
            height: 50,
            child: CustomText(
              finalBtn ? _strings.submitBtn : _strings.nextBtn,
              colorOption: TextColorOptions.light,
            ),
            color: _colors.primaryColor,
            onPressed: onPressed,
          ),
        ),
      ],
    );
  }
}
