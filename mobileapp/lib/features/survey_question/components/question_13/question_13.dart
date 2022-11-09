import 'package:elms/constant/app_colors.dart';
import 'package:elms/constant/app_dimens.dart';
import 'package:elms/constant/app_strings.dart';
import 'package:elms/features/survey_question/components/question_13/question_13_controller.dart';
import 'package:elms/global_widgets/custom_divider/custom_divider.dart';
import 'package:elms/global_widgets/custom_from_field/custom_form_fields.dart';
import 'package:elms/utils/custom_text/custom_text.dart';
import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:get/get_state_manager/get_state_manager.dart';

import '../../survey_question_controller.dart';
import '../button_group.dart';
import '../custom_size_box.dart';

class Question13 extends GetResponsiveView {
  Question13({
    Key? key,
    required this.questionData,
  }) : super(key: key);

  final Map questionData;

  final AppStrings _strings = Get.find();
  final AppColors _colors = Get.find();
  final AppDimens _dimens = Get.find();

  final SurveyQuestionController _surveyQuestionController = Get.find();
  final Question13Controller _question13controller = Get.find();

  generateList(Map data) {
    var list = [];
    data.forEach((k, v) => list.add(v));
    return list;
  }

  @override
  Widget? builder() {
    int questionId = questionData["id"];
    String questionType = questionData["ans_type"];
    String questionTitle = questionData["qsn_name"];
    String questionNumber = questionData["qsn_number"];
    var workerSkills = questionData["worker_skills"];
    List workerSkillsList = generateList(workerSkills);
    bool previousState = (questionNumber != "1.1");
    _question13controller.updateAnswerIds(questionData);

    return Padding(
      padding: EdgeInsets.all(_dimens.padding),
      child: SingleChildScrollView(
        child: Column(
          mainAxisAlignment: MainAxisAlignment.center,
          children: [
            sizedBox(),
            CustomText(
              _strings.questionTitle + questionNumber,
              textAlign: TextAlign.left,
              fontWeight: FontWeight.bold,
            ),
            sizedBox(),
            CustomText(
              questionTitle,
              sizeOption: TextSizeOptions.body,
              maxLine: 10,
              textAlign: TextAlign.justify,
            ),
            sizedBox(),
            customDivider(),
            sizedBox(),
            for (var i = 0; i < workerSkillsList.length; i++)
              Column(
                children: [
                  CustomText(workerSkillsList[i], textAlign: TextAlign.left),
                  sizedBox(),
                  CustomFormField(
                    editController: _question13controller.q13ControllersList[i]
                        [0],
                    hint: "Trained and Inexperienced",
                    textInputType: TextInputType.number,
                    isRating: true,
                    maxLength: 1,
                  ),
                  sizedBox(),
                  CustomFormField(
                    editController: _question13controller.q13ControllersList[i]
                        [1],
                    hint: "Untrained and Experienced",
                    isRating: true,
                    textInputType: TextInputType.number,
                    maxLength: 1,
                  ),
                  sizedBox(),
                ],
              ),
            ButtonGroup(
                previousState: previousState,
                onPressed: () {
                  _question13controller.answerQuestion13(
                    questionId,
                    questionType,
                    questionNumber,
                  );
                }),
          ],
        ),
      ),
    );
  }
}
