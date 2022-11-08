// ignore_for_file: avoid_print

import 'package:elms/constant/app_colors.dart';
import 'package:elms/constant/app_dimens.dart';
import 'package:elms/constant/app_strings.dart';
import 'package:elms/features/survey_question/components/check_box_question/check_box_question_controller.dart';
import 'package:elms/features/survey_question/components/condition_radio_question/condition_radio_question_controller.dart';
import 'package:elms/features/survey_question/components/custom_size_box.dart';
import 'package:elms/features/survey_question/components/input_questions/input_question_controller.dart';
import 'package:elms/features/survey_question/components/multiple_input_question/multiple_input_question_controller.dart';
import 'package:elms/features/survey_question/components/question_13/question_13_controller.dart';
import 'package:elms/features/survey_question/components/question_5/question_5_controller.dart';
import 'package:elms/features/survey_question/components/question_6a/question_6a_controller.dart';
import 'package:elms/features/survey_question/components/question_6b/question_6b_controller.dart';
import 'package:elms/features/survey_question/components/radio_question/radio_question_controller.dart';
import 'package:elms/features/survey_question/components/sector_question/sector_quetion_controller.dart';
import 'package:elms/features/survey_question/components/service_question/service_question_controller.dart';
import 'package:elms/features/survey_question/components/sub_questions/sub_question_controller.dart';
import 'package:elms/features/survey_question/survey_question_controller.dart';
import 'package:elms/features/view_survey/view_survey_controllers.dart';
import 'package:elms/global_widgets/custom_button/custom_button.dart';
import 'package:elms/global_widgets/custom_indicator/custom_indicator.dart';
import 'package:elms/utils/custom_text/custom_text.dart';
import 'package:flutter/material.dart';
import 'package:get/get.dart';

class ViewSurveyPage extends GetResponsiveView {
  ViewSurveyPage({Key? key, required this.values}) : super(key: key);

  final AppStrings _strings = Get.find();
  final AppColors _colors = Get.find();
  final AppDimens _dimens = Get.find();
  final SurveyQuestionController _surveyQuestionController = Get.find();
  final ViewSurveyController _viewSurveyController = Get.find();
  final InputQuestionController _inputQuestionController = Get.find();
  final CheckBoxQuestionController _checkBoxQuestionController = Get.find();
  final RadioQuestionController _radioQuestionController = Get.find();
  final SubQuestionController _subQuestionController = Get.find();
  final MultipleInputQuestionController _multipleInputQuestionController =
      Get.find();
  final Question13Controller _question13controller = Get.find();
  final ConditionRadioQuestionController _conditionRadioQuestionController =
      Get.find();
  final ServiceQuestionController _serviceQuestionController = Get.find();
  final SectorQuestionController _sectorQuestionController = Get.find();

  final Question6aController _question6aController = Get.find();
  final Question6bController _question6bController = Get.find();
  final Question5Controller _question5controller = Get.find();

  final List<int> values;

  @override
  Widget? builder() {
    return Scaffold(
      appBar: AppBar(
        title: Text(_strings.viewSurveyPage),
        centerTitle: true,
      ),
      body: ui(),
    );
  }

  ui() => Obx(
        () {
          return _viewSurveyController.getQeustionsLoading.value
              ? Center(
                  child: CustomIndicator(
                  color: _colors.primaryColor,
                ))
              : _viewSurveyController.getQuesstionsError.value
                  ? Center(
                      child: CustomButton(
                        width: screen.width * .5,
                        child: CustomText(
                          _strings.tryAgainBtn,
                          colorOption: TextColorOptions.light,
                        ),
                        color: _colors.buttonColor,
                        onPressed: () {
                          _viewSurveyController.onInit();
                        },
                      ),
                    )
                  : SingleChildScrollView(
                      child: Padding(
                        padding: const EdgeInsets.all(8.0),
                        child: Column(
                          children: [
                            sizedBox(),
                            for (var item in _viewSurveyController.questionList)
                              Column(
                                children: [
                                  CustomText(
                                    item["qsn_number"].toString() +
                                        " : " +
                                        (item["qsn_name"] as String)
                                            .replaceAll("\n", ""),
                                    maxLine: 10,
                                    textAlign: TextAlign.left,
                                    sizeOption: TextSizeOptions.body,
                                    fontWeight: FontWeight.bold,
                                  ),
                                  sizedBox(),
                                  answerWidget(
                                      item["qsn_number"], item["ans_type"]),
                                  Divider(
                                    color: _colors.primaryColor,
                                  ),
                                ],
                              ),
                          ],
                        ),
                      ),
                    );
        },
      );

  answerWidget(questionNumber, questionType) {
    if (questionType == "input") {
      return inputAnswer(_inputQuestionController
          .getControllerOfQuestionInputQuestion(questionNumber)
          .text);
    } else {
      switch (questionNumber) {
        case "1.3":
          return checkBoxQuestion1_3Widget();
        case "1.4":
          return CustomText(
            "- " +
                _viewSurveyController.getRadioValue(
                  _radioQuestionController.q1_4RadioValue.value,
                ),
            textAlign: TextAlign.left,
          );
        case "2":
          return question2Widget();

        case "2.1":
          return CustomText(
            "- " +
                _viewSurveyController.getRadioValue(
                  _radioQuestionController.q1_6RadioValue.value,
                ),
            textAlign: TextAlign.left,
            maxLine: 2,
          );
        case "2.2":
          return CustomText(
            "- " +
                _viewSurveyController.getRadioValue(
                  _radioQuestionController.q1_7RadioValue.value,
                ),
            textAlign: TextAlign.left,
            maxLine: 2,
          );
        case "2.3":
          return CustomText(
            "- " +
                _viewSurveyController.getRadioValue(
                  _radioQuestionController.q1_8RadioValue.value,
                ),
            textAlign: TextAlign.left,
            maxLine: 2,
          );
        case "3":
          return question3Widget();
        case "4":
          return question4Widget();
        case "5":
          return checkBoxQuestion5Widget();
        case "5.1":
          return question5widget("5.1");
        case "5.2":
          return question5widget("5.2");
        case "5.3":
          return question5widget("5.3");
        case "6.a":
          return question6aWidget();
        case "6.b":
          return question6bWidget();
        case "7":
          return CustomText(
            "- " +
                _viewSurveyController.getRadioValue(
                  _radioQuestionController.q7RadioValue.value,
                ),
            textAlign: TextAlign.left,
            maxLine: 2,
          );
        case "8":
          return question8Widget();
        case "9":
          return question9Widget();
        case "10":
          return Column(
            children: [
              CustomText(
                "- " +
                    _viewSurveyController.getRadioValue(
                      _radioQuestionController.q10RadioValue.value,
                    ),
                textAlign: TextAlign.left,
                maxLine: 2,
              ),
              if (_radioQuestionController.q10RadioValue.value == 49)
                CustomText(
                  "- Conditional Answer : " +
                      _radioQuestionController.q10_OtherAnswer.text,
                  textAlign: TextAlign.left,
                  maxLine: 2,
                ),
            ],
          );
        case "11":
          return CustomText(
            "- " +
                _viewSurveyController.getRadioValue(
                  _radioQuestionController.q11RadioValue.value,
                ),
            textAlign: TextAlign.left,
            maxLine: 2,
          );
        case "12":
          return question12Widget();
        case "13":
          return question13Widget();
        case "14":
          return CustomText(
            "- " +
                _viewSurveyController.getRadioValue(
                  _radioQuestionController.q14RadioValue.value,
                ),
            textAlign: TextAlign.left,
            maxLine: 2,
          );
        case "15":
          return CustomText(
            "- " +
                _viewSurveyController.getRadioValue(
                  _radioQuestionController.q15RadioValue.value,
                ),
            textAlign: TextAlign.left,
            maxLine: 2,
          );
        case "16":
          return CustomText(
            "- " +
                _viewSurveyController.getRadioValue(
                  _radioQuestionController.q16RadioValue.value,
                ),
            textAlign: TextAlign.left,
            maxLine: 2,
          );
        case "17":
          return question17Widget();
        case "18":
          return question18Widget();
        case "19":
          return checkBoxQuestion19Widget();
        case "20":
          return question20Widget();
        case "21":
          return Column(
            children: [
              CustomText(
                "- " +
                    _viewSurveyController.getRadioValue(
                      _radioQuestionController.q21RadioValue.value,
                    ),
                textAlign: TextAlign.left,
              ),
              CustomText(
                "- " + _radioQuestionController.q21_OtherAnswer.text,
                textAlign: TextAlign.left,
              ),
            ],
          );

        default:
          return Container();
      }
    }
  }

  question3Widget() {
    return CustomText(
      "- " + _sectorQuestionController.subSectorName.value,
      textAlign: TextAlign.left,
    );
  }

  question4Widget() {
    List<String> listOfTitle =
        _viewSurveyController.getCheckedCheckBoxNamesQuestion4(
            _serviceQuestionController.q4checkbox);
    return Column(
      children: [
        for (var i = 0; i < listOfTitle.length; i++)
          CustomText(
            "- " + listOfTitle[i],
            textAlign: TextAlign.left,
            maxLine: 2,
          ),
      ],
    );
  }

  getConditionStatus(String hr, String workers) {
    if (hr == "Employer" && workers == "Assisting") {
      return false;
    } else if (hr == "Family Member" && workers == "Assisting") {
      return false;
    } else {
      return true;
    }
  }

  question5widget(questionNumber) {
    List<dynamic> hrList = (questionNumber == "5.1")
        ? [
            "Employer",
          ]
        : (questionNumber == "5.2")
            ? [
                "Family Member",
              ]
            : [
                "Employees",
              ];
    List<dynamic> workerList = _viewSurveyController
        .getQuestionObjectWithQuestionNumber(questionNumber)["workers"];

    var list = (questionNumber == "5.1")
        ? _question5controller.q5_1CountersList
        : (questionNumber == "5.2")
            ? _question5controller.q5_2CountersList
            : _question5controller.q5_3CountersList;

    return Column(
      children: [
        for (var j = 0; j < hrList.length; j++)
          Column(
            children: [
              CustomText(
                hrList[j],
                textAlign: TextAlign.left,
                sizeOption: TextSizeOptions.title,
              ),
              for (var i = 0; i < workerList.length; i++)
                if (_question5controller.getConditionStatus(
                    hrList[j], workerList[i]))
                  question5SubWidget(item: workerList[i], list: list[i])
            ],
          ),
      ],
    );
  }

  question5SubWidget({item, list}) {
    return Card(
      child: Padding(
        padding: EdgeInsets.all(_dimens.padding),
        child: Column(
          children: [
            CustomText(
              item,
              textAlign: TextAlign.left,
            ),
            const SizedBox(
              height: 10,
            ),
            Row(
              children: [
                Expanded(
                  child: CustomText(
                    "Male : ${list[0].text}",
                    textAlign: TextAlign.left,
                  ),
                ),
              ],
            ),
            const SizedBox(
              height: 10,
            ),
            Row(
              children: [
                Expanded(
                  child: CustomText(
                    "Female : ${list[1].text}",
                    textAlign: TextAlign.left,
                  ),
                ),
              ],
            ),
            const SizedBox(
              height: 10,
            ),
            Row(
              children: [
                Expanded(
                  child: CustomText(
                    "Sexual Minority : ${list[2].text}",
                    textAlign: TextAlign.left,
                  ),
                ),
              ],
            ),
            const SizedBox(
              height: 10,
            ),
            Row(
              children: [
                Expanded(
                  child: CustomText(
                    "Nepali : ${list[3].text}",
                    textAlign: TextAlign.left,
                  ),
                ),
              ],
            ),
            const SizedBox(
              height: 10,
            ),
            Row(
              children: [
                Expanded(
                  child: CustomText(
                    "Neighboring Countries : ${list[4].text}",
                    textAlign: TextAlign.left,
                  ),
                ),
              ],
            ),
            const SizedBox(
              height: 10,
            ),
            Row(
              children: [
                Expanded(
                    child: CustomText(
                  "Foreigner : ${list[5].text}",
                  textAlign: TextAlign.left,
                )),
              ],
            ),
          ],
        ),
      ),
    );
  }

  checkNullStrings(str) {
    if (str == null) {
      return ' - ';
    } else {
      return str;
    }
  }

  question6aWidget() {
    return SizedBox(
      height: screen.height * .4,
      child: Obx(() => Card(
            elevation: 4,
            child: _question6aController.q6aAnswersList.isEmpty
                ? CustomText("There is no employee")
                : ListView.builder(
                    itemCount: _question6aController.q6aAnswersList.length,
                    itemBuilder: (context, index) => ExpansionTile(
                      title: CustomText(
                        _strings.employeeId + " #${index + 1}",
                        sizeOption: TextSizeOptions.body,
                        textAlign: TextAlign.left,
                      ),
                      children: [
                        Padding(
                          padding: EdgeInsets.all(_dimens.padding),
                          child: Column(
                            children: [
                              CustomText(
                                "employer name : " +
                                    _question6aController
                                        .q6aAnswersList[index].empName,
                                textAlign: TextAlign.left,
                              ),
                              CustomText(
                                "gender : " +
                                    _question6aController
                                        .q6aAnswersList[index].gender,
                                textAlign: TextAlign.left,
                              ),
                              CustomText(
                                "occupation : " +
                                    _question6aController.getOccupationTitle(
                                        _question6aController
                                            .q6aAnswersList[index]
                                            .occupationId),
                                textAlign: TextAlign.left,
                                maxLine: 2,
                              ),
                              CustomText(
                                "Other occupation : " +
                                    checkNullStrings(_question6aController
                                        .q6aAnswersList[index]
                                        .otherOccupationValue),
                                textAlign: TextAlign.left,
                              ),
                              CustomText(
                                "workingTime : " +
                                    _question6aController
                                        .q6aAnswersList[index].workingTime,
                                textAlign: TextAlign.left,
                              ),
                              CustomText(
                                "workNature : " +
                                    _question6aController
                                        .q6aAnswersList[index].workNature,
                                textAlign: TextAlign.left,
                              ),
                              CustomText(
                                "training : " +
                                    _question6aController
                                        .q6aAnswersList[index].training,
                                textAlign: TextAlign.left,
                              ),
                              CustomText(
                                "edu general id : " +
                                    _question6aController.getEduTitle(
                                        id: _question6aController
                                            .q6aAnswersList[index]
                                            .eduQuaGeneralId,
                                        questionList: _surveyQuestionController
                                            .questionList),
                                textAlign: TextAlign.left,
                                maxLine: 2,
                              ),
                              CustomText(
                                "edu tvet id : " +
                                    _question6aController.getEduTitle(
                                        id: _question6aController
                                            .q6aAnswersList[index].eduQuaTvetId,
                                        questionList: _surveyQuestionController
                                            .questionList),
                                textAlign: TextAlign.left,
                                maxLine: 2,
                              ),
                              CustomText(
                                "ojtApprentice : " +
                                    _question6aController
                                        .q6aAnswersList[index].ojtApprentice,
                                textAlign: TextAlign.left,
                              ),
                              CustomText(
                                "present position : " +
                                    _question6aController
                                        .q6aAnswersList[index].workExp1,
                                textAlign: TextAlign.left,
                              ),
                              CustomText(
                                "occupation position : " +
                                    _question6aController
                                        .q6aAnswersList[index].workExp2,
                                textAlign: TextAlign.left,
                              ),
                            ],
                          ),
                        ),
                      ],
                    ),
                  ),
          )),
    );
  }

  question6bWidget() {
    List<dynamic> occupationsList = _viewSurveyController
        .getQuestionObjectWithQuestionNumber("6.b")["occupations"];

    return Obx(() {
      return Column(
        children: [
          for (var i = 0; i < occupationsList.length; i++)
            Column(
              children: [
                CustomText(
                  "- Occupation : ",
                  textAlign: TextAlign.left,
                  fontWeight: FontWeight.bold,
                ),
                sizedBox(),
                CustomText(
                  occupationsList[i]["occupation_name"],
                  fontWeight: FontWeight.bold,
                  textAlign: TextAlign.left,
                ),
                CustomText(
                  "- Currently working numbers : " +
                      _question6bController.q6bControllersList[i][0].text,
                  maxLine: 2,
                  textAlign: TextAlign.left,
                ),
                CustomText(
                  "- Currently Required Number : " +
                      _question6bController.q6bControllersList[i][1].text,
                  maxLine: 2,
                  textAlign: TextAlign.left,
                ),
                CustomText(
                  "- Estimated Required For next two Years : " +
                      _question6bController.q6bControllersList[i][2].text,
                  maxLine: 2,
                  textAlign: TextAlign.left,
                ),
                CustomText(
                  "- Estimated Required For next five Years : " +
                      _question6bController.q6bControllersList[i][3].text,
                  maxLine: 2,
                  textAlign: TextAlign.left,
                ),
                sizedBox(),
              ],
            ),
        ],
      );
    });
  }

  question8Widget() {
    return Column(
      children: [
        CustomText(
          "- " +
              _viewSurveyController.getConditionRadioValue(
                  _conditionRadioQuestionController.q8RadioValue.value),
          textAlign: TextAlign.left,
        ),
        SizedBox(
          height: screen.height * .4,
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
                                CustomText(
                                  "Occupation : " +
                                      _conditionRadioQuestionController
                                          .getOccupationTitle(
                                              _conditionRadioQuestionController
                                                  .q8AnswerList[index]
                                                  .occupationId),
                                  textAlign: TextAlign.left,
                                  maxLine: 2,
                                ),
                                CustomText(
                                  "Present demand : " +
                                      _conditionRadioQuestionController
                                          .q8AnswerList[index].presentDemand,
                                  textAlign: TextAlign.left,
                                  maxLine: 2,
                                ),
                                CustomText(
                                  "Estimated demand for two years : " +
                                      _conditionRadioQuestionController
                                          .q8AnswerList[index].demandTwoYear,
                                  textAlign: TextAlign.left,
                                  maxLine: 2,
                                ),
                                CustomText(
                                  "Estimated demand for five years : " +
                                      _conditionRadioQuestionController
                                          .q8AnswerList[index].demandFiveYear,
                                  textAlign: TextAlign.left,
                                  maxLine: 2,
                                ),
                              ],
                            ),
                          ),
                        ],
                      ),
                    ),
            ),
          ),
        ),
      ],
    );
  }

  question9Widget() {
    return Column(
      children: [
        CustomText(
          "- " +
              _viewSurveyController.getConditionRadioValue(
                  _conditionRadioQuestionController.q9RadioValue.value),
          textAlign: TextAlign.left,
        ),
        CustomText(
          "- " + _conditionRadioQuestionController.question9Controller.text,
          textAlign: TextAlign.left,
        ),
      ],
    );
  }

  question12Widget() {
    List<String> list =
        _viewSurveyController.getMultipleQuestionTitleList("12");
    return Column(
      children: [
        for (var i = 0; i < list.length; i++)
          CustomText(
            "- " +
                list[i] +
                " = " +
                _multipleInputQuestionController
                    .q12TextEditingController[i].text,
            textAlign: TextAlign.left,
            maxLine: 2,
          ),
      ],
    );
  }

  question13Widget() {
    List workerList = _viewSurveyController.getQuestion13WorkerList();
    return Column(
      children: [
        for (var i = 0; i < workerList.length; i++)
          Column(
            children: [
              CustomText(
                "- " + workerList[i],
                textAlign: TextAlign.left,
              ),
              CustomText(
                "- Formally Trained: " +
                    _question13controller.q13ControllersList[i][0].text,
                textAlign: TextAlign.left,
                sizeOption: TextSizeOptions.underline,
              ),
              CustomText(
                "- Formally Untrained: " +
                    _question13controller.q13ControllersList[i][1].text,
                textAlign: TextAlign.left,
                sizeOption: TextSizeOptions.underline,
              )
            ],
          ),
      ],
    );
  }

  question17Widget() {
    return Column(
      children: [
        CustomText(
          "- " +
              _viewSurveyController.getConditionRadioValue(
                  _conditionRadioQuestionController.q17RadioValue.value),
          textAlign: TextAlign.left,
        ),
        if (_conditionRadioQuestionController.q17RadioValue.value != 74)
          Column(
            children: [
              CustomText(
                "- Sector : " +
                    _conditionRadioQuestionController.getSectorTitle(
                        _conditionRadioQuestionController
                            .q17SelectedSectorId.value,
                        "17"),
                textAlign: TextAlign.left,
              ),
              // CustomText(
              //   "- Sub Sector : " +
              //       _conditionRadioQuestoinController.getSubSectorTitle(
              //           _conditionRadioQuestoinController
              //               .q17SelectedSubSectorId.value),
              //   textAlign: TextAlign.left,
              // ),
              CustomText(
                "- Technology : " +
                    _conditionRadioQuestionController.q17TechController.text,
                textAlign: TextAlign.left,
              ),
            ],
          ),
      ],
    );
  }

  question18Widget() {
    return Column(
      children: [
        CustomText(
          "- " +
              _viewSurveyController.getConditionRadioValue(
                  _conditionRadioQuestionController.q18RadioValue.value),
          textAlign: TextAlign.left,
        ),
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
                                  "occupation Id : " +
                                      _conditionRadioQuestionController
                                          .getOccupationTitle(
                                              _conditionRadioQuestionController
                                                  .q18AnswerList[index]
                                                  .occupationId),
                                  textAlign: TextAlign.left,
                                  maxLine: 2,
                                ),
                                CustomText(
                                  "sector : " +
                                      _conditionRadioQuestionController
                                          .getSectorTitle(
                                              _conditionRadioQuestionController
                                                  .q18AnswerList[index]
                                                  .sectorId,
                                              "18"),
                                  textAlign: TextAlign.left,
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
                                          .q18AnswerList[index].requiredNumber,
                                  textAlign: TextAlign.left,
                                ),
                                CustomText(
                                  "incorporate Possible : " +
                                      _conditionRadioQuestionController
                                          .q18AnswerList[index]
                                          .incorporatePossible,
                                  textAlign: TextAlign.left,
                                ),
                              ],
                            ),
                          ),
                        ],
                      ),
                    ),
            ),
          ),
        ),
      ],
    );
  }

  question20Widget() {
    List<String> list =
        _viewSurveyController.getMultipleQuestionTitleList("20");
    return Column(
      children: [
        for (var i = 0; i < list.length; i++)
          CustomText(
            "- " +
                list[i] +
                " = " +
                _multipleInputQuestionController
                    .q20TextEditingController[i].text,
            textAlign: TextAlign.left,
            maxLine: 2,
          ),
      ],
    );
  }

  question2Widget() {
    return (_surveyQuestionController.q2ControllersList.isNotEmpty)
        ? Column(
            children: [
              for (int i = 0; i < _subQuestionController.titles.length; i++)
                Column(
                  children: [
                    CustomText(
                      "- ${_subQuestionController.titles[i]} Year : " +
                          _surveyQuestionController
                              .q2ControllersList[i][0].text,
                      textAlign: TextAlign.left,
                    ),
                    // CustomText(
                    //   "- ${_subQuestionController.titles[i]} Month :" +
                    //       _surveyQuestionController
                    //           .q2ControllersList[i][1].text,
                    //   textAlign: TextAlign.left,
                    // ),
                    sizedBox(),
                  ],
                ),
            ],
          )
        : Container();
  }

  inputAnswer(str) {
    return CustomText(
      "- " + str,
      maxLine: 5,
      textAlign: TextAlign.left,
    );
  }

  checkBoxQuestion19Widget() {
    List<String> listOfTitle = _viewSurveyController.getCheckedCheckBoxNames(
        checkedValue: _checkBoxQuestionController.q19checkbox,
        questionNumber: "19");
    return Column(
      children: [
        for (var i = 0; i < listOfTitle.length; i++)
          CustomText(
            "- " + listOfTitle[i],
            textAlign: TextAlign.left,
            maxLine: 2,
          ),
      ],
    );
  }

  checkBoxQuestion5Widget() {
    List<String> listOfTitle = _viewSurveyController.getCheckedCheckBoxNames(
        checkedValue: _checkBoxQuestionController.q5checkbox,
        questionNumber: "5");
    return Column(
      children: [
        for (var i = 0; i < listOfTitle.length; i++)
          CustomText(
            "- " + listOfTitle[i],
            textAlign: TextAlign.left,
            maxLine: 2,
          ),
      ],
    );
  }

  checkBoxQuestion1_3Widget() {
    return Column(
      children: [
        for (var item in _viewSurveyController.getCheckedCheckBoxNames(
            checkedValue: _checkBoxQuestionController.q1_3checkbox,
            questionNumber: "1.3"))
          CustomText(
            "- " + item,
            textAlign: TextAlign.left,
            maxLine: 3,
          ),
        CustomText(
          "- Other answer : " +
              _checkBoxQuestionController.q1_3OtherController.text,
          textAlign: TextAlign.left,
        )
      ],
    );
  }
}
