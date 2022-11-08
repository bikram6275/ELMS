import 'package:elms/constant/app_colors.dart';
import 'package:elms/features/survey_question/survey_question_controller.dart';
import 'package:elms/utils/custom_text/custom_text.dart';
import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:get/get_state_manager/get_state_manager.dart';

class CounterBadge extends GetResponsiveView {
  CounterBadge({Key? key}) : super(key: key);

  final AppColors _colors = Get.find();

  final SurveyQuestionController _surveyQuestionController = Get.find();

  @override
  Widget? builder() {
    return Container(
      width: 20,
      height: 20,
      decoration: BoxDecoration(
        color: _colors.buttonColor,
        borderRadius: BorderRadius.circular(
          100,
        ),
      ),
      child: Obx(() => CustomText(
            _surveyQuestionController.updateRequiredQuestionList.length
                .toString(),
            colorOption: TextColorOptions.light,
            sizeOption: TextSizeOptions.small,
          )),
    );
  }
}
