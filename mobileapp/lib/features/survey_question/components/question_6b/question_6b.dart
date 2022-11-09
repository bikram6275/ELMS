import 'package:elms/constant/app_colors.dart';
import 'package:elms/constant/app_dimens.dart';
import 'package:elms/constant/app_strings.dart';
import 'package:elms/features/survey_question/components/question_6b/question_6b_controller.dart';
import 'package:elms/global_widgets/custom_divider/custom_divider.dart';
import 'package:elms/global_widgets/custom_from_field/custom_form_fields.dart';
import 'package:elms/utils/custom_text/custom_text.dart';
import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:get/get_state_manager/get_state_manager.dart';

import '../../survey_question_controller.dart';
import '../button_group.dart';
import '../custom_size_box.dart';

class Question6B extends GetResponsiveView {
  Question6B({
    Key? key,
    required this.questionData,
  }) : super(key: key);

  final Map questionData;

  final AppDimens _dimens = Get.find();
  final AppStrings _strings = Get.find();

  final SurveyQuestionController _surveyQuestionController = Get.find();
  final Question6bController _question6bController = Get.find();

  @override
  Widget? builder() {
    int questionId = questionData["id"];
    String questionType = questionData["ans_type"];
    String questionTitle = questionData["qsn_name"];
    String questionNumber = questionData["qsn_number"];
    String occupationStatus = questionData["sector"]["sector_name"];
    bool previousState = (questionNumber != "1.1");
    List<dynamic> occupationsList = questionData["occupations"];

    return Padding(
      padding: EdgeInsets.all(_dimens.padding),
      child: SingleChildScrollView(
        child: Column(
          mainAxisAlignment: MainAxisAlignment.center,
          children: [
            const SizedBox(
              height: 10,
            ),
            CustomText(
              _strings.questionTitle + questionNumber,
              textAlign: TextAlign.left,
              fontWeight: FontWeight.bold,
            ),
            const SizedBox(
              height: 10,
            ),
            CustomText(
              questionTitle,
              sizeOption: TextSizeOptions.body,
              maxLine: 10,
              textAlign: TextAlign.justify,
            ),
            // sizedBox(size: 40),
            // CustomText(
            //   "Sector : " + occupationStatus,
            //   textAlign: TextAlign.left,
            // ),
            sizedBox(),
            customDivider(),
            sizedBox(),
            for (var i = 0; i < occupationsList.length; i++)
              Column(
                children: [
                  CustomText(
                      "Occupation : ${occupationsList[i]["occupation_name"]}",
                      textAlign: TextAlign.left),
                  sizedBox(),
                  CustomFormField(
                    editController: _question6bController.q6bControllersList[i]
                        [0],
                    hint: "Currently working numbers",
                    justNumber: true,
                    textInputType: TextInputType.number,
                  ),
                  sizedBox(),
                  CustomFormField(
                    editController: _question6bController.q6bControllersList[i]
                        [1],
                    hint: "Currently Required Number",
                    justNumber: true,
                    textInputType: TextInputType.number,
                  ),
                  sizedBox(),
                  CustomFormField(
                    editController: _question6bController.q6bControllersList[i]
                        [2],
                    hint: "Estimated Required For next two Years",
                    justNumber: true,
                    textInputType: TextInputType.number,
                  ),
                  sizedBox(),
                  CustomFormField(
                    editController: _question6bController.q6bControllersList[i]
                        [3],
                    hint: "Estimated Required For next five Years",
                    justNumber: true,
                    textInputType: TextInputType.number,
                  ),
                  sizedBox(),
                ],
              ),
            sizedBox(),
            ButtonGroup(
                previousState: previousState,
                onPressed: () {
                  _question6bController.answerQuestion6b(
                      questionId, questionType, questionNumber);
                }),
          ],
        ),
      ),
    );
  }
}
