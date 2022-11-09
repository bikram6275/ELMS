import 'package:elms/constant/app_colors.dart';
import 'package:elms/constant/app_dimens.dart';
import 'package:elms/constant/app_strings.dart';
import 'package:elms/features/survey_question/components/multiple_input_question/multiple_input_question_controller.dart';
import 'package:elms/global_widgets/custom_divider/custom_divider.dart';
import 'package:elms/global_widgets/custom_from_field/custom_form_fields.dart';
import 'package:elms/utils/custom_text/custom_text.dart';
import 'package:flutter/material.dart';
import 'package:flutter/services.dart';
import 'package:get/get.dart';

import '../button_group.dart';
import '../custom_size_box.dart';

class MultipleInputQuestion extends GetResponsiveView {
  MultipleInputQuestion({
    Key? key,
    required this.questionData,
    required this.controllersList,
  }) : super(key: key);

  final Map questionData;
  final RxList<TextEditingController> controllersList;

  final AppStrings _strings = Get.find();
  final AppColors _colors = Get.find();
  final AppDimens _dimens = Get.find();

  final MultipleInputQuestionController _multipleInputQuestionController =
      Get.find();

  @override
  Widget? builder() {
    int questionId = questionData["id"];
    String questionType = questionData["ans_type"];
    String questionTitle = questionData["qsn_name"];
    String questionNumber = questionData["qsn_number"];
    List<dynamic> quesitonOptions = questionData["question_options"];
    bool previousState = (questionNumber != "1.1");

    return Padding(
      padding: EdgeInsets.all(_dimens.padding),
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
          for (var i = 0; i < quesitonOptions.length; i++)
            Obx(() => Column(
                  children: [
                    CustomFormField(
                      editController: controllersList[i],
                      hint: quesitonOptions[i]["option_name"],
                      onChanged: (value) {},
                      formatter: (questionNumber == "12")
                          ? [
                              FilteringTextInputFormatter.allow(
                                  RegExp(r'[1-4]')),
                            ]
                          : (questionNumber == "20")
                              ? [
                                  FilteringTextInputFormatter.allow(
                                      RegExp(r'[1-6]')),
                                ]
                              : null,
                      maxLength:
                          (questionNumber == "12" || questionNumber == "20")
                              ? 1
                              : null,
                      textInputType: TextInputType.number,
                    ),
                    sizedBox(),
                  ],
                )),
          ButtonGroup(
              previousState: previousState,
              onPressed: () {
                _multipleInputQuestionController.answerMultipleInputQuestion(
                    questionId, controllersList, questionType, questionNumber);
              }),
        ],
      ),
    );
  }
}
