// ignore_for_file: avoid_print

import 'package:elms/constant/app_colors.dart';
import 'package:elms/constant/app_dimens.dart';
import 'package:elms/constant/app_strings.dart';
import 'package:elms/features/survey_question/components/question_5/question_5_controller.dart';
import 'package:elms/global_widgets/custom_divider/custom_divider.dart';
import 'package:elms/global_widgets/custom_from_field/custom_form_fields.dart';
import 'package:elms/utils/custom_text/custom_text.dart';
import 'package:flutter/material.dart';
import 'package:get/get.dart';

import '../../survey_question_controller.dart';
import '../button_group.dart';
import '../custom_size_box.dart';

class Question5 extends GetResponsiveView {
  Question5({
    Key? key,
    required this.questionData,
  }) : super(key: key);

  final Map questionData;

  final AppStrings _strings = Get.find();
  final AppColors _colors = Get.find();
  final AppDimens _dimens = Get.find();

  final SurveyQuestionController _surveyQuestionController = Get.find();
  final Question5Controller _question5controller = Get.find();

  @override
  Widget? builder() {
    int questionId = questionData["id"];
    String questionType = questionData["ans_type"];
    String questionTitle = questionData["qsn_name"];
    String questionNumber = questionData["qsn_number"];
    List<dynamic> workerList = questionData["workers"];
    bool previousState = (questionNumber != "1.1");
    _question5controller.getAnswerIdsFromQuestionResponse(
        questionData: questionData, questionNumber: questionNumber);

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
            conditionalWidgets(
                questionNumber: questionNumber, workerList: workerList),
            sizedBox(),
            ButtonGroup(
                previousState: previousState,
                onPressed: () {
                  if (_question5controller
                      .checkConditionsBeforeAnswerQuestion(questionNumber)) {
                    _question5controller.answerQuestion5(
                      questionId,
                      questionType,
                      questionNumber,
                    );
                  }
                }),
          ],
        ),
      ),
    );
  }

  conditionalWidgets({required questionNumber, required workerList}) {
    if (questionNumber == "5.1") {
      return Column(
        children: [
          CustomText(
            "Employer",
            textAlign: TextAlign.left,
            sizeOption: TextSizeOptions.body,
            fontWeight: FontWeight.bold,
          ),
          sizedBox(),
          for (var i = 0; i < workerList.length; i++)
            if (_question5controller.getConditionStatus(
                "Employer", workerList[i]))
              question5SubWidget(
                item: workerList[i],
                list: _question5controller.q5_1CountersList[i],
              )
        ],
      );
    } else if (questionNumber == "5.2") {
      return Column(
        children: [
          CustomText(
            "Family Member",
            textAlign: TextAlign.left,
            sizeOption: TextSizeOptions.body,
            fontWeight: FontWeight.bold,
          ),
          sizedBox(),
          for (var i = 0; i < workerList.length; i++)
            if (_question5controller.getConditionStatus(
                "Family Member", workerList[i]))
              question5SubWidget(
                item: workerList[i],
                list: _question5controller.q5_2CountersList[i],
              )
        ],
      );
    } else if (questionNumber == "5.3") {
      return Column(
        children: [
          CustomText(
            "Employees",
            textAlign: TextAlign.left,
            sizeOption: TextSizeOptions.body,
            fontWeight: FontWeight.bold,
          ),
          sizedBox(),
          for (var i = 0; i < workerList.length; i++)
            if (_question5controller.getConditionStatus(
                "Employees", workerList[i]))
              question5SubWidget(
                item: workerList[i],
                list: _question5controller.q5_3CountersList[i],
              )
        ],
      );
    }
  }

  question5SubWidget({
    required item,
    required list,
  }) {
    return Card(
      elevation: 5,
      child: Padding(
        padding: EdgeInsets.all(_dimens.padding),
        child: Column(
          children: [
            CustomText(
              item,
              textAlign: TextAlign.left,
              fontWeight: FontWeight.bold,
            ),
            const SizedBox(
              height: 10,
            ),
            CustomFormField(
              hint: "Male",
              editController: list[0],
              justNumber: true,
              textInputType: TextInputType.number,
              onChanged: (value) => _question5controller.totalCountUpdater(
                  !_question5controller.totalCountUpdater.value),
            ),
            const SizedBox(
              height: 10,
            ),
            CustomFormField(
              hint: "Female",
              editController: list[1],
              justNumber: true,
              textInputType: TextInputType.number,
              onChanged: (value) => _question5controller.totalCountUpdater(
                  !_question5controller.totalCountUpdater.value),
            ),
            const SizedBox(
              height: 10,
            ),
            CustomFormField(
              hint: "Sexual Minority",
              editController: list[2],
              justNumber: true,
              textInputType: TextInputType.number,
              onChanged: (value) => _question5controller.totalCountUpdater(
                  !_question5controller.totalCountUpdater.value),
            ),
            const SizedBox(
              height: 10,
            ),
            const Divider(),
            const SizedBox(
              height: 10,
            ),
            CustomFormField(
              hint: "Nepali",
              editController: list[3],
              justNumber: true,
              textInputType: TextInputType.number,
              onChanged: (value) => _question5controller.totalCountUpdater(
                  !_question5controller.totalCountUpdater.value),
            ),
            const SizedBox(
              height: 10,
            ),
            CustomFormField(
              hint: "Neighboring Countries",
              editController: list[4],
              justNumber: true,
              textInputType: TextInputType.number,
              onChanged: (value) => _question5controller.totalCountUpdater(
                  !_question5controller.totalCountUpdater.value),
            ),
            const SizedBox(
              height: 10,
            ),
            CustomFormField(
              hint: "Foreigner",
              editController: list[5],
              justNumber: true,
              textInputType: TextInputType.number,
              onChanged: (value) => _question5controller.totalCountUpdater(
                  !_question5controller.totalCountUpdater.value),
            ),
            const SizedBox(
              height: 10,
            ),
            Obx(() {
              print(_question5controller.totalCountUpdater.value);
              return CustomText(
                "Total : ${_question5controller.getTotalOfAnswers(list: list).toString()}",
                textAlign: TextAlign.center,
                sizeOption: TextSizeOptions.title,
              );
            }),
          ],
        ),
      ),
    );
  }
}
