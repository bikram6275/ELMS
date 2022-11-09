import 'package:elms/constant/app_colors.dart';
import 'package:elms/constant/app_dimens.dart';
import 'package:elms/constant/app_strings.dart';
import 'package:elms/features/survey_question/components/radio_question/radio_question_controller.dart';
import 'package:elms/global_widgets/custom_divider/custom_divider.dart';
import 'package:elms/global_widgets/custom_from_field/custom_form_fields.dart';
import 'package:elms/models/radio_questions/radio_questions_model.dart';
import 'package:elms/utils/custom_text/custom_text.dart';
import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:get/get_state_manager/get_state_manager.dart';

import '../../survey_question_controller.dart';
import '../button_group.dart';
import '../custom_size_box.dart';

class RadioQuestion extends GetResponsiveView {
  RadioQuestion(
      {Key? key, required this.questionData, required this.radioValue})
      : super(key: key);

  final Map questionData;
  final RxInt radioValue;

  final AppDimens _dimens = Get.find();
  final AppStrings _strings = Get.find();
  final AppColors _colors = Get.find();

  final SurveyQuestionController _surveyQuestionController = Get.find();
  final RadioQuestionController _radioQuestionController = Get.find();

  @override
  Widget? builder() {
    int questionId = questionData["id"];
    String questionType = questionData["ans_type"];
    String questionTitle = questionData["qsn_name"];
    String questionNumber = questionData["qsn_number"];
    List<dynamic> radioOptions = questionData["question_options"];
    List<RadioQuestionModel> radioQuestionsList = radioOptions
        .map<RadioQuestionModel>(
            (e) => RadioQuestionModel(id: e["id"], name: e["option_name"]))
        .toList();
    bool previousState = (questionNumber != "1.1");

    return Padding(
      padding: EdgeInsets.all(_dimens.padding),
      child: Obx(() => Column(
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
              for (var item in radioQuestionsList)
                Container(
                  padding: EdgeInsets.symmetric(vertical: _dimens.padding),
                  decoration: BoxDecoration(
                    color: (item.id == radioValue.value)
                        ? _colors.primaryColor.withOpacity(.1)
                        : Colors.transparent,
                    border: Border.all(
                      color: Colors.grey.withOpacity(.15),
                    ),
                  ),
                  child: InkWell(
                    onTap: () {
                      radioValue(item.id);
                      print(item.id);
                    },
                    child: Row(
                      children: [
                        Radio<int>(
                          value: radioValue.value,
                          onChanged: (value) {
                            radioValue(item.id);
                          },
                          groupValue: item.id,
                          fillColor: MaterialStateProperty.all(
                            _colors.primaryColor.withOpacity(.7),
                          ),
                        ),
                        Expanded(
                          child: CustomText(
                            item.name,
                            textAlign: TextAlign.left,
                            maxLine: 3,
                          ),
                        ),
                      ],
                    ),
                  ),
                ),
              sizedBox(),
              if (questionNumber == "21" && radioValue.value == 85)
                CustomFormField(
                  editController: _radioQuestionController.q21_OtherAnswer,
                ),
              if (questionNumber == "10" && radioValue.value == 49)
                CustomFormField(
                  editController: _radioQuestionController.q10_OtherAnswer,
                ),
              sizedBox(),
              ButtonGroup(
                  previousState: previousState,
                  onPressed: () {
                    _radioQuestionController.answerRadioQuestion(
                      questionId,
                      radioValue.value,
                      questionType,
                      questionNumber,
                    );
                  }),
            ],
          )),
    );
  }
}
