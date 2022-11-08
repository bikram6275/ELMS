import 'package:elms/constant/app_dimens.dart';
import 'package:elms/constant/app_strings.dart';
import 'package:elms/features/survey_question/components/sub_questions/sub_question_controller.dart';
import 'package:elms/features/survey_question/survey_question_controller.dart';
import 'package:elms/global_widgets/custom_divider/custom_divider.dart';
import 'package:elms/global_widgets/custom_drop_down/custom_drop_down.dart';
import 'package:elms/utils/custom_text/custom_text.dart';
import 'package:flutter/material.dart';
import 'package:get/get.dart';

import '../button_group.dart';
import '../custom_size_box.dart';

class SubQuestion extends GetResponsiveView {
  SubQuestion({
    Key? key,
    required this.questionData,
  }) : super(key: key);

  final Map questionData;

  final AppStrings _strings = Get.find();
  final AppDimens _dimens = Get.find();

  final SubQuestionController _subQuestionController = Get.find();
  final SurveyQuestionController _surveyQuestionController = Get.find();

  @override
  Widget? builder() {
    int questionId = questionData["id"];
    String questionType = questionData["ans_type"];
    String questionTitle = questionData["qsn_name"];
    String questionNumber = questionData["qsn_number"];
    List<dynamic> subQuestions = questionData["sub_questions"];
    bool previousState = (questionNumber != "1.1");

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
            for (var i = 0; i < subQuestions.length; i++)
              Obx(
                () {
                  print(_surveyQuestionController.q2ControllersList.length);
                  return Column(
                    children: [
                      const SizedBox(
                        height: 4,
                      ),
                      CustomText(
                        subQuestions[i]["qsn_number"] +
                            " " +
                            subQuestions[i]["qsn_name"],
                        sizeOption: TextSizeOptions.body,
                        textAlign: TextAlign.left,
                      ),
                      const SizedBox(
                        height: 4,
                      ),
                      CustomDropDown(
                        list: _subQuestionController.yearDropDownList,
                        hint: (_surveyQuestionController
                                    .q2ControllersList[i][0].text ==
                                "")
                            ? "Year"
                            : _surveyQuestionController
                                .q2ControllersList[i][0].text,
                        onChange: (value) {
                          if (value.id == 1001) {
                            _surveyQuestionController.q2ControllersList[i][0]
                                .clear();
                          } else {
                            _surveyQuestionController
                                .q2ControllersList[i][0].text = value.name;
                          }
                        },
                      ),
                      const SizedBox(
                        height: 4,
                      ),
                      // CustomDropDown(
                      //   list: _subQuestionController.monthDropDownList,
                      //   hint: (_surveyQuestionController
                      //               .q2ControllersList[i][1].text ==
                      //           "")
                      //       ? "Month"
                      //       : _surveyQuestionController
                      //           .q2ControllersList[i][1].text,
                      //   onChange: (value) {
                      //     if (value.id == 1001) {
                      //       _surveyQuestionController.q2ControllersList[i][1]
                      //           .clear();
                      //     } else {
                      //       _surveyQuestionController
                      //           .q2ControllersList[i][1].text = value.name;
                      //     }
                      //   },
                      // ),
                      // CustomFormField(
                      //   editController:
                      //       _surveyQuestionController.q2ControllersList[i][0],
                      //   hint: _strings.yearTitle,
                      // ),
                      // const SizedBox(
                      //   height: 4,
                      // ),
                      // CustomFormField(
                      //   editController:
                      //       _surveyQuestionController.q2ControllersList[i][1],
                      //   hint: _strings.monthTitle,
                      // ),
                    ],
                  );
                },
              ),
            sizedBox(),
            ButtonGroup(
                previousState: previousState,
                onPressed: () {
                  _subQuestionController.answerSubQuestion(
                    questionId,
                    _surveyQuestionController.q2ControllersList,
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
