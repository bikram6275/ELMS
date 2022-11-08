import 'package:elms/constant/app_colors.dart';
import 'package:elms/constant/app_dimens.dart';
import 'package:elms/constant/app_strings.dart';
import 'package:elms/features/survey_question/components/input_questions/input_question_controller.dart';
import 'package:elms/global_widgets/custom_divider/custom_divider.dart';
import 'package:elms/global_widgets/custom_from_field/custom_form_fields.dart';
import 'package:elms/main.dart';
import 'package:elms/utils/custom_text/custom_text.dart';
import 'package:flutter/material.dart';
import 'package:get/get.dart';
import '../../../../global_widgets/custom_indicator/custom_indicator.dart';
import '../../survey_question_controller.dart';
import '../button_group.dart';
import '../custom_size_box.dart';

class InputQuestion extends GetResponsiveView {
  InputQuestion({
    Key? key,
    required this.questionData,
  }) : super(key: key);

  final Map questionData;

  final AppStrings _strings = Get.find();
  final AppColors _colors = Get.find();
  final AppDimens _dimens = Get.find();

  final SurveyQuestionController _surveyQuestionController = Get.find();
  final InputQuestionController _inputQuestionController = Get.find();

  @override
  Widget? builder() {
    String questionTitle = questionData["qsn_name"];
    String questionNumber = questionData["qsn_number"];
    String questionType = questionData["ans_type"];
    bool previousState = (questionNumber != "1.1");
    bool finalState = (questionNumber == "22");
    return Padding(
      padding: EdgeInsets.all(_dimens.padding),
      child: Obx(
        () => _inputQuestionController.getInputQuestionsLoading.value
            ? CustomIndicator(
                color: _colors.primaryColor,
              )
            : Column(
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
                  CustomFormField(
                    editController: _inputQuestionController
                        .getControllerOfQuestionInputQuestion(questionNumber),
                    textInputType: _surveyQuestionController
                        .parseDynamicInputFields(questionData["input_type"]),
                    onChanged: (value) {},
                    justNumber: (questionData["input_type"] == "number"),
                  ),
                  sizedBox(),
                  ButtonGroup(
                      previousState: previousState,
                      finalBtn: finalState,
                      onPressed: () {
                        _inputQuestionController.answerInputQuestion(
                          questionData["id"],
                          _inputQuestionController
                              .getControllerOfQuestionInputQuestion(
                                  questionNumber),
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
