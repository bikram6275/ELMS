import 'package:elms/constant/app_colors.dart';
import 'package:elms/constant/app_dimens.dart';
import 'package:elms/constant/app_strings.dart';
import 'package:elms/features/survey_question/components/check_box_question/check_box_question_controller.dart';
import 'package:elms/features/survey_question/survey_question_controller.dart';
import 'package:elms/global_widgets/custom_divider/custom_divider.dart';
import 'package:elms/global_widgets/custom_from_field/custom_form_fields.dart';
import 'package:elms/utils/custom_text/custom_text.dart';
import 'package:flutter/material.dart';
import 'package:get/get.dart';

import '../button_group.dart';
import '../custom_size_box.dart';

class CheckBoxQuestion extends GetResponsiveView {
  CheckBoxQuestion({
    Key? key,
    required this.questionData,
    this.editingController,
  }) : super(key: key);

  final Map questionData;
  final TextEditingController? editingController;

  final AppDimens _dimens = Get.find();
  final AppStrings _strings = Get.find();
  final AppColors _colors = Get.find();

  final SurveyQuestionController _surveyQuestionController = Get.find();
  final CheckBoxQuestionController _checkBoxQuestionController = Get.find();

  @override
  Widget? builder() {
    int questionId = questionData["id"];
    String questionType = questionData["ans_type"];
    String questionTitle = questionData["qsn_name"];
    String questionNumber = questionData["qsn_number"];
    List<dynamic> checkListQuestions = questionData["question_options"];
    bool previousState = (questionNumber != "1.1");
    List checkBoxValues =
        _checkBoxQuestionController.getCheckBoxValueOfQuestion(questionNumber);

    return Padding(
      padding: EdgeInsets.all(_dimens.padding),
      child: Obx(
        () {
          return Column(
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
              for (var i = 0; i < checkListQuestions.length; i++)
                Container(
                  padding: EdgeInsets.symmetric(vertical: _dimens.padding),
                  decoration: BoxDecoration(
                    color:
                        (checkBoxValues.contains(checkListQuestions[i]["id"]))
                            ? _colors.primaryColor.withOpacity(.1)
                            : Colors.transparent,
                    border: Border.all(
                      color: Colors.grey.withOpacity(.15),
                    ),
                  ),
                  child: CheckboxListTile(
                    controlAffinity: ListTileControlAffinity.leading,
                    title: CustomText(
                      checkListQuestions[i]["option_name"],
                      textAlign: TextAlign.start,
                      maxLine: 4,
                    ),
                    onChanged: (value) {
                      if (checkListQuestions[i]["id"] == 108 ||
                          checkListQuestions[i]["option_name"] ==
                              "None of the above") {
                        checkBoxValues.clear();
                        checkBoxValues.add(checkListQuestions[i]["id"]);
                      } else {
                        checkBoxValues.remove(108);
                        if (checkBoxValues
                            .contains(checkListQuestions[i]["id"])) {
                          checkBoxValues.remove(checkListQuestions[i]["id"]);
                        } else {
                          checkBoxValues.add(checkListQuestions[i]["id"]);
                        }
                      }
                    },
                    value:
                        (checkBoxValues.contains(checkListQuestions[i]["id"])),
                    activeColor: _colors.primaryColor.withOpacity(.7),
                  ),
                ),
              sizedBox(),
              if (checkBoxValues.contains(6) && questionNumber == "1.3")
                Column(
                  children: [
                    CustomFormField(editController: editingController),
                    sizedBox(),
                  ],
                ),
              ButtonGroup(
                  previousState: previousState,
                  onPressed: () {
                    _surveyQuestionController.answerCheckBoxQuestion(
                      questionId: questionId,
                      listOfValues: checkBoxValues,
                      otherController: editingController,
                      questionType: questionType,
                      questionNumber: questionNumber,
                    );
                  }),
            ],
          );
        },
      ),
    );
  }
}
