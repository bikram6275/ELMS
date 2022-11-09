import 'package:elms/constant/app_colors.dart';
import 'package:elms/constant/app_dimens.dart';
import 'package:elms/constant/app_strings.dart';
import 'package:elms/features/survey_question/survey_question_controller.dart';
import 'package:elms/global_widgets/custom_button/custom_button.dart';
import 'package:elms/global_widgets/custom_divider/custom_divider.dart';
import 'package:elms/global_widgets/custom_drop_down/custom_drop_down.dart';
import 'package:elms/global_widgets/custom_from_field/custom_form_fields.dart';
import 'package:elms/models/answer/drop_down_model.dart';
import 'package:elms/models/occupation/occupation_model.dart';
import 'package:elms/models/question18_answer/question18_answer_model.dart';
import 'package:elms/models/question8_answer/question8_answer_model.dart';
import 'package:elms/models/radio_questions/radio_questions_model.dart';
import 'package:elms/models/sub_sector/sub_sector_model.dart';
import 'package:elms/utils/custom_text/custom_text.dart';
import 'package:flutter/material.dart';
import 'package:get/get.dart';

import '../button_group.dart';
import '../custom_size_box.dart';
import 'condition_radio_question_controller.dart';

class ConditionRadioQuestion extends GetResponsiveView {
  ConditionRadioQuestion(
      {Key? key, required this.questionData, required this.radioValue})
      : super(key: key);

  final Map questionData;
  final RxInt radioValue;

  final AppStrings _strings = Get.find();
  final AppColors _colors = Get.find();
  final AppDimens _dimens = Get.find();

  final ConditionRadioQuestionController _conditionRadioQuestionController =
      Get.find();
  final SurveyQuestionController _surveyQuestionController = Get.find();

  @override
  Widget? builder() {
    int questionId = questionData["id"];
    String questionType = questionData["ans_type"];
    String questionTitle = questionData["qsn_name"];
    String questionNumber = questionData["qsn_number"];
    List radioOptions = questionData["question_options"];
    List<RadioQuestionModel> radioQuestionsList = radioOptions
        .map<RadioQuestionModel>((item) =>
            RadioQuestionModel(id: item["id"], name: item["option_name"]))
        .toList();
    bool previousState = (questionNumber != "1.1");
    _conditionRadioQuestionController.getConditionValueFromQuestionResponse();
    return Padding(
      padding: EdgeInsets.all(_dimens.padding),
      child: Obx(() {
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
                          maxLine: 2,
                        ),
                      ),
                    ],
                  ),
                ),
              ),
            Obx(() => (_conditionRadioQuestionController.q9RadioValue.value !=
                        _conditionRadioQuestionController.q9ConditionId &&
                    questionNumber == "9" &&
                    _conditionRadioQuestionController.q9RadioValue.value != 0)
                ? question9ConditionalWidget()
                : (_conditionRadioQuestionController.q8RadioValue.value ==
                            _conditionRadioQuestionController.q8ConditionId &&
                        questionNumber == "8")
                    ? question8ConditionalWidget()
                    : (_conditionRadioQuestionController.q17RadioValue.value ==
                                _conditionRadioQuestionController
                                    .q17ConditionId &&
                            questionNumber == "17")
                        ? question17ConditionalWidget()
                        : (_conditionRadioQuestionController
                                        .q18RadioValue.value ==
                                    _conditionRadioQuestionController
                                        .q18ConditionId &&
                                questionNumber == "18")
                            ? question18ConditionalWidget()
                            : Container()),
            sizedBox(),
            ButtonGroup(
                previousState: previousState,
                onPressed: () {
                  _conditionRadioQuestionController.answerConditionalQuestion(
                    questionId,
                    questionType,
                    questionNumber,
                    radioValue.value,
                  );
                }),
          ],
        );
      }),
    );
  }

  question9ConditionalWidget() {
    return Column(
      children: [
        sizedBox(),
        CustomText(
          questionData["conditional_question"][0]["qsn_name"],
          maxLine: 3,
          textAlign: TextAlign.start,
        ),
        sizedBox(),
        CustomFormField(
          editController: _conditionRadioQuestionController.question9Controller,
        ),
      ],
    );
  }

  question8ConditionalWidget() {
    return Column(
      children: [
        sizedBox(),
        Obx(
          () {
            List<DropDownModel> occupationDropDownList =
                _conditionRadioQuestionController.occupationList
                    .map<DropDownModel>((item) =>
                        DropDownModel(item["occupation_name"], item["id"]))
                    .toList();
            return Column(
              children: [
                CustomText(
                  "Occupation",
                  textAlign: TextAlign.left,
                ),
                CustomDropDown(
                  list: occupationDropDownList,
                  onChange: (value) {
                    _conditionRadioQuestionController
                        .q8occupationName(value.name);
                    _conditionRadioQuestionController
                        .q18SelectedOccupationId(value.id);
                  },
                ),
              ],
            );
          },
        ),
        sizedBox(),
        CustomFormField(
          editController: _conditionRadioQuestionController.q8DemandController,
          hint: "Present demand",
          justNumber: true,
          textInputType: TextInputType.number,
        ),
        sizedBox(),
        CustomFormField(
          editController: _conditionRadioQuestionController
              .q8EstimateDemand2YearsController,
          hint: "Estimated demand for next two years",
          justNumber: true,
          textInputType: TextInputType.number,
        ),
        sizedBox(),
        CustomFormField(
          editController: _conditionRadioQuestionController
              .q8EstimateDemand5YearsController,
          hint: "Estimated demand for next five years",
          justNumber: true,
          textInputType: TextInputType.number,
        ),
        sizedBox(),
        if (_conditionRadioQuestionController.q8occupationName.value ==
            "Others")
          CustomFormField(
            editController:
                _conditionRadioQuestionController.q8OtherValueController,
            hint: "Other value",
          ),
        sizedBox(),
        SizedBox(
          height: screen.height * .36,
          child: Obx(
            () => Card(
              elevation: 4,
              child: _conditionRadioQuestionController.q8AnswerList.isEmpty
                  ? CustomText("There is no occupation")
                  : ListView.builder(
                      itemCount:
                          _conditionRadioQuestionController.q8AnswerList.length,
                      itemBuilder: (context, index) => ExpansionTile(
                        title: CustomText(
                          "Occupation ${index + 1}",
                          sizeOption: TextSizeOptions.body,
                          textAlign: TextAlign.left,
                        ),
                        children: [
                          Padding(
                            padding: EdgeInsets.all(_dimens.padding),
                            child: Column(
                              children: [
                                Obx(
                                  () => CustomText(
                                    "Occupation : " +
                                        _conditionRadioQuestionController
                                            .getOccupationTitleFromList(
                                          _conditionRadioQuestionController
                                              .q8AnswerList[index].occupationId,
                                          _conditionRadioQuestionController
                                              .occupationList,
                                        ),
                                    textAlign: TextAlign.left,
                                    maxLine: 3,
                                  ),
                                ),
                                CustomText(
                                  "Present demand : " +
                                      _conditionRadioQuestionController
                                          .q8AnswerList[index].presentDemand
                                          .toString(),
                                  textAlign: TextAlign.left,
                                ),
                                CustomText(
                                  "Estimated demand for two years : " +
                                      _conditionRadioQuestionController
                                          .q8AnswerList[index].demandTwoYear
                                          .toString(),
                                  textAlign: TextAlign.left,
                                ),
                                CustomText(
                                  "Estimated demand for five years : " +
                                      _conditionRadioQuestionController
                                          .q8AnswerList[index].demandFiveYear
                                          .toString(),
                                  textAlign: TextAlign.left,
                                ),
                                CustomText(
                                  "Other value : " +
                                      (_conditionRadioQuestionController
                                              .q8AnswerList[index].otherValue ??
                                          " -"),
                                  textAlign: TextAlign.left,
                                ),
                                sizedBox(),
                                CustomButton(
                                  width: screen.width * .4,
                                  height: 50,
                                  child: const Icon(Icons.delete),
                                  color: _colors.buttonColor,
                                  onPressed: () {
                                    _conditionRadioQuestionController
                                        .q8AnswerList
                                        .removeAt(index);
                                  },
                                ),
                                sizedBox(),
                              ],
                            ),
                          ),
                        ],
                      ),
                    ),
            ),
          ),
        ),
        sizedBox(),
        CustomButton(
            height: 50,
            radius: 20,
            child: CustomText(
              _strings.addBtn,
              colorOption: TextColorOptions.light,
            ),
            color: _colors.buttonColor,
            onPressed: () {
              if (_conditionRadioQuestionController
                  .question8AnswerValidation()) {
                _conditionRadioQuestionController.q8AnswerList.add(
                  Question8AnswerModel(
                    id: null,
                    occupationId: _conditionRadioQuestionController
                        .q18SelectedOccupationId.value,
                    presentDemand: _conditionRadioQuestionController
                        .q8DemandController.text,
                    demandTwoYear: _conditionRadioQuestionController
                        .q8EstimateDemand2YearsController.text,
                    demandFiveYear: _conditionRadioQuestionController
                        .q8EstimateDemand5YearsController.text,
                    otherValue: _conditionRadioQuestionController
                        .q8OtherValueController.text,
                  ),
                );
                _conditionRadioQuestionController.clearQuestion8Fields();
              }
            }),
      ],
    );
  }

  question18ConditionalWidget() {
    List<dynamic> sectorList = questionData["sector"];

    List<DropDownModel> sectorDropDownList = sectorList
        .map<DropDownModel>(
            (item) => DropDownModel(item["sector_name"], item["id"]))
        .toList();

    List<DropDownModel> greenSkillDropDownList = [
      const DropDownModel("Yes", 0),
      const DropDownModel("No", 1),
    ];

    List<OccupationModel> filteredOccupationList =
        _conditionRadioQuestionController.filterOccupationList(
            _conditionRadioQuestionController.q18SelectedSectorId.value);

    List<DropDownModel> occupationDropDownList = filteredOccupationList
        .map<DropDownModel>((e) => DropDownModel(e.occupationName, e.id))
        .toList();

    return Column(
      children: [
        sizedBox(),
        Column(
          children: [
            CustomText(
              "Sector",
              textAlign: TextAlign.left,
            ),
            CustomDropDown(
              list: sectorDropDownList,
              onChange: (value) {
                _conditionRadioQuestionController.q18SelectedSectorId(value.id);
              },
            ),
            CustomText(
              "Proposed Occupation",
              textAlign: TextAlign.left,
            ),
            Obx(() {
              print(_conditionRadioQuestionController
                  .q18SelectedOccupationId.value);
              return CustomDropDown(
                list: occupationDropDownList,
                onChange: (value) {
                  _conditionRadioQuestionController
                      .q18SelectedOccupationId(value.id);
                },
              );
            }),
          ],
        ),
        Obx(() =>
            _conditionRadioQuestionController.q18SelectedOccupationId.value ==
                    279
                ? Column(
                    children: [
                      sizedBox(),
                      CustomFormField(
                        editController: _conditionRadioQuestionController
                            .q18OtherValueController,
                        hint: "	Others",
                      ),
                    ],
                  )
                : Container()),
        sizedBox(),
        CustomFormField(
          editController:
              _conditionRadioQuestionController.q18SkillLevelController,
          hint: "	Skilled Level",
        ),
        sizedBox(),
        CustomFormField(
          editController:
              _conditionRadioQuestionController.q18RequiredNumberController,
          hint: "Required Number",
          justNumber: true,
        ),
        sizedBox(),
        // CustomFormField(
        //   editController: _conditionRadioQuestionController
        //       .q18incorporatePossibleGreenSkillsController,
        //   hint: "Possibility to incorporate green skills components",
        // ),
        CustomText(
          "Possibility to incorporate green skills components",
          textAlign: TextAlign.left,
        ),
        for (var item in greenSkillDropDownList)
          Obx(() {
            return Container(
              padding: EdgeInsets.symmetric(vertical: _dimens.padding),
              decoration: BoxDecoration(
                color: (item.name ==
                        _conditionRadioQuestionController
                            .q18incorporatePossibleGreenSkills.value)
                    ? _colors.primaryColor.withOpacity(.1)
                    : Colors.transparent,
                border: Border.all(
                  color: Colors.grey.withOpacity(.15),
                ),
              ),
              child: InkWell(
                onTap: () {
                  _conditionRadioQuestionController
                      .q18incorporatePossibleGreenSkills(item.name);
                },
                child: Row(
                  children: [
                    Radio<String>(
                      value: _conditionRadioQuestionController
                          .q18incorporatePossibleGreenSkills.value,
                      onChanged: (value) {
                        _conditionRadioQuestionController
                            .q18incorporatePossibleGreenSkills(item.name);
                      },
                      groupValue: item.name,
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
            );
          }),

        sizedBox(),
        Divider(
          height: 10,
          color: _colors.primaryColor,
        ),
        sizedBox(),
        SizedBox(
          height: screen.height * .4,
          child: Obx(
            () => Card(
              elevation: 4,
              child: _conditionRadioQuestionController.q18AnswerList.isEmpty
                  ? CustomText("There is no employee")
                  : ListView.builder(
                      itemCount: _conditionRadioQuestionController
                          .q18AnswerList.length,
                      itemBuilder: (context, index) => ExpansionTile(
                        title: CustomText(
                          "Occupation ${index + 1}",
                          sizeOption: TextSizeOptions.body,
                          textAlign: TextAlign.left,
                        ),
                        children: [
                          Padding(
                            padding: EdgeInsets.all(_dimens.padding),
                            child: Column(
                              children: [
                                CustomText(
                                  "occupation : " +
                                      _conditionRadioQuestionController
                                          .getOccupationTitleFromListQuestion18(
                                        _conditionRadioQuestionController
                                            .q18AnswerList[index].occupationId,
                                        _surveyQuestionController
                                            .occupationList,
                                      ),
                                  textAlign: TextAlign.left,
                                  maxLine: 2,
                                ),
                                CustomText(
                                  "sector : " +
                                      _conditionRadioQuestionController
                                          .getSectorTitleFromList(
                                              _conditionRadioQuestionController
                                                  .q18AnswerList[index]
                                                  .sectorId,
                                              sectorList),
                                  textAlign: TextAlign.left,
                                  maxLine: 2,
                                ),
                                CustomText(
                                  "level : " +
                                      _conditionRadioQuestionController
                                          .q18AnswerList[index].level,
                                  textAlign: TextAlign.left,
                                ),
                                CustomText(
                                  "required Number : " +
                                      _conditionRadioQuestionController
                                          .q18AnswerList[index].requiredNumber
                                          .toString(),
                                  textAlign: TextAlign.left,
                                ),
                                CustomText(
                                  "incorporate Possible : " +
                                      _conditionRadioQuestionController
                                          .q18AnswerList[index]
                                          .incorporatePossible,
                                  textAlign: TextAlign.left,
                                ),
                                CustomText(
                                  "Other occupation : " +
                                      (_conditionRadioQuestionController
                                              .q18AnswerList[index]
                                              .otherOccupationValue ??
                                          "-"),
                                  textAlign: TextAlign.left,
                                ),
                                sizedBox(),
                                CustomButton(
                                  width: screen.width * .4,
                                  height: 50,
                                  radius: 20,
                                  child: const Icon(Icons.delete),
                                  color: _colors.buttonColor,
                                  onPressed: () {
                                    _conditionRadioQuestionController
                                        .q18AnswerList
                                        .removeAt(index);
                                  },
                                ),
                                sizedBox(),
                              ],
                            ),
                          ),
                        ],
                      ),
                    ),
            ),
          ),
        ),
        sizedBox(),
        CustomButton(
          height: 50,
          radius: 20,
          child: CustomText(
            _strings.addBtn,
            colorOption: TextColorOptions.light,
          ),
          color: _colors.buttonColor,
          onPressed: () {
            if (_conditionRadioQuestionController
                .question18AnswerValidation()) {
              _conditionRadioQuestionController.q18AnswerList.add(
                Question18AnswerModel(
                  id: null,
                  sectorId: _conditionRadioQuestionController
                      .q18SelectedSectorId.value,
                  occupationId: _conditionRadioQuestionController
                      .q18SelectedOccupationId.value,
                  level: _conditionRadioQuestionController
                      .q18SkillLevelController.text,
                  requiredNumber: _conditionRadioQuestionController
                      .q18RequiredNumberController.text,
                  incorporatePossible: _conditionRadioQuestionController
                      .q18incorporatePossibleGreenSkills.value
                      .toLowerCase(),
                  otherOccupationValue: _conditionRadioQuestionController
                      .q18OtherValueController.text,
                ),
              );

              _conditionRadioQuestionController.clearQuestion18Fields();
            }
          },
        ),
      ],
    );
  }

  question17ConditionalWidget() {
    List<dynamic> sectorList = questionData["sector"];
    List<DropDownModel> sectorDropDownList = sectorList
        .map<DropDownModel>(
            (item) => DropDownModel(item["sector_name"], item["id"]))
        .toList();
    List<SectorModel> filteredSubSecList =
        _conditionRadioQuestionController.filterSubSectorList(
            _conditionRadioQuestionController.q17SelectedSectorId.value);
    List<DropDownModel> subSectorDropDownList = filteredSubSecList
        .map<DropDownModel>((e) => DropDownModel(e.subSectorName, e.id))
        .toList();
    List answers = questionData["answer"];
    if (answers.isNotEmpty) {
      List subAnswers = answers.first["conditional_answer"];
      if (subAnswers.isNotEmpty) {
        _conditionRadioQuestionController.q17oldAnswerId =
            subAnswers.first["id"];
      }
    }

    return Column(
      children: [
        sizedBox(),
        Column(
          children: [
            CustomText(
              "Sector",
              textAlign: TextAlign.left,
            ),
            Obx(() {
              print(
                  "enable reactive : ${_conditionRadioQuestionController.q17SelectedSectorId.value}");
              return CustomDropDown(
                hint: _conditionRadioQuestionController.getSectorTitle(
                    _conditionRadioQuestionController.q17SelectedSectorId.value,
                    "17"),
                list: sectorDropDownList,
                onChange: (value) {
                  _conditionRadioQuestionController
                      .q17SelectedSectorId(value.id);
                },
              );
            }),
          ],
        ),
        // sizedBox(),
        // Obx(() {
        //   print(_conditionRadioQuestionController.q17SelectedSectorId.value);
        //   return Column(
        //     children: [
        //       CustomText(
        //         "Sub-Sector",
        //         textAlign: TextAlign.left,
        //       ),
        //       CustomDropDown(
        //         hint: _conditionRadioQuestionController.getSubSectorTitle(
        //             _conditionRadioQuestionController
        //                 .q17SelectedSubSectorId.value),
        //         list: subSectorDropDownList,
        //         onChange: (value) {
        //           _conditionRadioQuestionController
        //               .q17SelectedSubSectorId(value.id);
        //         },
        //       ),
        //     ],
        //   );
        // }),
        sizedBox(),
        CustomFormField(
          editController: _conditionRadioQuestionController.q17TechController,
          hint: "Technology",
        ),
        sizedBox(),
      ],
    );
  }
}
