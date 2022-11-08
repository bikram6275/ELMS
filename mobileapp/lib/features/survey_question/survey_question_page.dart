import 'package:elms/constant/app_colors.dart';
import 'package:elms/constant/app_dimens.dart';
import 'package:elms/constant/app_strings.dart';
import 'package:elms/features/survey_question/components/check_box_question/check_box_question.dart';
import 'package:elms/features/survey_question/components/check_box_question/check_box_question_controller.dart';
import 'package:elms/features/survey_question/components/input_questions/input_question.dart';
import 'package:elms/features/survey_question/components/input_questions/input_question_controller.dart';
import 'package:elms/features/survey_question/components/question_13/question_13.dart';
import 'package:elms/features/survey_question/components/question_5/question_5.dart';
import 'package:elms/features/survey_question/components/question_6a/question_6a.dart';
import 'package:elms/features/survey_question/components/question_6b/question_6b.dart';
import 'package:elms/features/survey_question/components/question_6b/question_6b_controller.dart';
import 'package:elms/features/survey_question/components/radio_question/radio_question.dart';
import 'package:elms/features/survey_question/components/radio_question/radio_question_controller.dart';
import 'package:elms/features/survey_question/components/sub_questions/sub_question_controller.dart';
import 'package:elms/features/survey_question/survey_question_controller.dart';
import 'package:elms/global_widgets/counter_badge/counter_badge.dart';
import 'package:elms/global_widgets/custom_button/custom_button.dart';
import 'package:elms/global_widgets/custom_indicator/custom_indicator.dart';
import 'package:elms/utils/custom_text/custom_text.dart';
import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:scrollable_positioned_list/scrollable_positioned_list.dart';

import 'components/condition_radio_question/condition_radio_question.dart';
import 'components/condition_radio_question/condition_radio_question_controller.dart';
import 'components/multiple_input_question/multiple_input_question.dart';
import 'components/multiple_input_question/multiple_input_question_controller.dart';
import 'components/sector_question/sector_question.dart';
import 'components/service_question/service_question.dart';
import 'components/sub_questions/sub_question.dart';

class SurveyQuestionPage extends GetResponsiveView {
  SurveyQuestionPage({
    Key? key,
    required this.values,
  }) : super(key: key);

  final List<int> values;

  final AppStrings _strings = Get.find();
  final AppColors _colors = Get.find();
  final AppDimens _dimens = Get.find();

  final SurveyQuestionController _surveyQuestionController = Get.find();
  final CheckBoxQuestionController _checkBoxQuestionController = Get.find();
  final ConditionRadioQuestionController _conditionRadioQuestionController =
      Get.find();
  final RadioQuestionController _radioQuestionController = Get.find();
  final InputQuestionController _inputQuestionController = Get.find();
  final MultipleInputQuestionController _multipleInputQuestionController =
      Get.find();

  final SubQuestionController _subQuestionController = Get.find();
  final Question6bController _question6bController = Get.find();

  @override
  Widget? builder() {
    BuildContext context = Get.context!;
    return GestureDetector(
      onTap: () {
        FocusScopeNode currentFocus = FocusScope.of(context);
        if (!currentFocus.hasPrimaryFocus &&
            currentFocus.focusedChild != null) {
          FocusManager.instance.primaryFocus?.unfocus();
        }
      },
      child: Obx(
        () {
          var answerLoading = (_surveyQuestionController
                  .answerQuestionLoading.value ||
              _surveyQuestionController.sendRemainingQuestionLoading.value ||
              _surveyQuestionController.finishSurveyLoading.value);

          return Stack(
            children: [
              Scaffold(
                appBar: AppBar(
                  title: Text(_strings.surveyQuestion),
                  centerTitle: true,
                  actions: [
                    Stack(
                      children: [
                        CounterBadge(),
                        IconButton(
                          onPressed: () {
                            _surveyQuestionController
                                .sendRemainingQuestionToServer();
                          },
                          icon: const Icon(
                            Icons.upload,
                          ),
                        ),
                      ],
                    )
                  ],
                ),
                body: ui(),
              ),
              if (answerLoading)
                Container(
                  width: screen.width,
                  height: screen.height,
                  color: Colors.black.withOpacity(.8),
                  child: Center(
                    child: Container(
                      decoration: BoxDecoration(
                        color: _colors.scaffoldBackgroundColor.withOpacity(.2),
                        borderRadius: BorderRadius.circular(10),
                      ),
                      child: Padding(
                        padding: EdgeInsets.all(_dimens.padding),
                        child: CustomIndicator(
                          color: _colors.lightIndicator,
                        ),
                      ),
                    ),
                  ),
                ),
            ],
          );
        },
      ),
    );
  }

  ui() => Obx(() {
        var getQuestionError =
            _surveyQuestionController.getQuestionsError.value;
        var getQuestionLoading =
            _surveyQuestionController.getQuestionsLoading.value;
        return getQuestionLoading
            ? Center(
                child: CustomIndicator(
                  color: _colors.darkIndicator,
                ),
              )
            : getQuestionError
                ? Center(
                    child: CustomButton(
                      width: screen.width * .5,
                      child: CustomText(
                        _strings.tryAgainBtn,
                        colorOption: TextColorOptions.light,
                      ),
                      color: _colors.buttonColor,
                      onPressed: () {
                        _surveyQuestionController.onInit();
                      },
                    ),
                  )
                : Obx(() {
                    return SingleChildScrollView(
                      child: Column(
                        children: [
                          questionsCounterIndicators(),
                          if (_surveyQuestionController.questionList.isNotEmpty)
                            questionUi(
                              _surveyQuestionController.filteredQuestionList[
                                  _surveyQuestionController
                                      .selectedQuestion.value],
                            ),
                        ],
                      ),
                    );
                  });
      });

  getQuestionByQuestionNumber(qsnNumber) {
    for (var element in _surveyQuestionController.questionList) {
      if (element["qsn_number"] == qsnNumber) {
        return element;
      }
    }
  }

  /// filter and set constion on all questions in this method
  getAllQuestionList() {
    List finalList = [];
    _surveyQuestionController.filteredQuestionList.clear();
    for (var element in _surveyQuestionController.questionList) {
      bool question2_1Condition = (_surveyQuestionController
              .q2ControllersList[0][0].text.isNotEmpty ||
          _surveyQuestionController.q2ControllersList[1][0].text.isNotEmpty ||
          _surveyQuestionController.q2ControllersList[2][0].text.isNotEmpty);
      bool question2_2Condition =
          (_surveyQuestionController.q2ControllersList[3][0].text.isNotEmpty);
      bool question2_3Condition =
          (_surveyQuestionController.q2ControllersList[4][0].text.isNotEmpty);

      bool question5_1Condition =
          (_checkBoxQuestionController.q5checkbox.contains(99));

      bool question5_2Condition =
          (_checkBoxQuestionController.q5checkbox.contains(100));

      bool question5_3Condition =
          (_checkBoxQuestionController.q5checkbox.contains(101));

      if (element["qsn_number"] == "2.1") {
        if (question2_1Condition) {
          finalList.add(element);
        }
      } else if (element["qsn_number"] == "2.2") {
        if (question2_2Condition) {
          finalList.add(element);
        }
      } else if (element["qsn_number"] == "2.3") {
        if (question2_3Condition) {
          finalList.add(element);
        }
      } else if (element["qsn_number"] == "1.5") {
        if (_radioQuestionController.checkQuestion1_5Condition(
            _surveyQuestionController
                .getSpecificQuestoinMapByQuestionNumber("1.4"))) {
          finalList.add(element);
        }
      } else if (element["qsn_number"] == "5.1") {
        if (question5_1Condition) {
          finalList.add(element);
        }
      } else if (element["qsn_number"] == "5.2") {
        if (question5_2Condition) {
          finalList.add(element);
        }
      } else if (element["qsn_number"] == "5.3") {
        if (question5_3Condition) {
          finalList.add(element);
        }
      } else if (element["qsn_number"] == "17") {
        Map question16Data = _surveyQuestionController
            .getSpecificQuestoinMapByQuestionNumber("16");
        var option = _radioQuestionController.getQuestion16OptionName(
            questionData: question16Data);
        if (option != "e") {
          finalList.add(element);
        }
      } else if (element["qsn_number"] == "18") {
        Map question16Data = _surveyQuestionController
            .getSpecificQuestoinMapByQuestionNumber("16");
        var option = _radioQuestionController.getQuestion16OptionName(
            questionData: question16Data);
        if (option == "c" || option == "d") {
          finalList.add(element);
        }
      } else {
        finalList.add(element);
      }
    }

    _surveyQuestionController.filteredQuestionList.addAll(finalList);

    return finalList;
  }

  questionsCounterIndicators() {
    List data = getAllQuestionList();

    return SizedBox(
        width: screen.width,
        height: 65,
        child: Obx(() {
          print(
              _surveyQuestionController.filteredQuestionList.length.toString());
          return ScrollablePositionedList.builder(
            itemScrollController: _surveyQuestionController.scrollController,
            scrollDirection: Axis.horizontal,
            itemCount: data.length,
            itemBuilder: (context, index) {
              return InkWell(
                onTap: () {
                  _surveyQuestionController.selectedQuestion(index);
                },
                child: questionIdWidget(
                  color: (_surveyQuestionController.selectedQuestion.value ==
                          index)
                      ? _colors.selectedQuestionIndicatorColor
                      : _surveyQuestionController.checkQuestionColorState(
                              "${data[index]["id"]}${values[0]}${values[1]}")
                          ? _colors.answeredQuestionIndicatorColor
                          : _colors.questionIndicatorColor,
                  questionNumber: data[index]["qsn_number"],
                ),
              );
            },
          );
        }));
  }

  questionIdWidget({required Color color, required questionNumber}) => Padding(
        padding: EdgeInsets.all(_dimens.padding),
        child: Container(
          width: 50,
          child: Center(
            child: CustomText(
              questionNumber,
              colorOption: TextColorOptions.light,
              fontWeight: FontWeight.bold,
            ),
          ),
          decoration: BoxDecoration(
            color: color,
            borderRadius: BorderRadius.circular(_dimens.borderRadius * 100),
          ),
        ),
      );

  questionUi(questionData) {
    String questionNumber = questionData["qsn_number"];
    String questionType = questionData["ans_type"];
    if (questionNumber == "6.a" && questionType == "external_table") {
      return Question6A(questionData: questionData);
    } else if (questionNumber == "6.b" && questionType == "external_table") {
      return Question6B(questionData: questionData);
    } else if ((questionNumber == "5.1" ||
            questionNumber == "5.2" ||
            questionNumber == "5.3") &&
        questionType == "external_table") {
      return Question5(questionData: questionData);
    } else if (questionNumber == "13" && questionType == "external_table") {
      return Question13(questionData: questionData);
    } else if (questionType == "input") {
      return InputQuestion(questionData: questionData);
    } else if (questionType == "checkbox") {
      return CheckBoxQuestion(
        questionData: questionData,
        editingController: _checkBoxQuestionController
            .getControllerOfQuestionInputQuestion(questionNumber),
      );
    } else if (questionType == "radio") {
      return RadioQuestion(
        questionData: questionData,
        radioValue:
            _radioQuestionController.getRadioButtonValue(questionNumber),
      );
    } else if (questionType == "sub_qsn") {
      return SubQuestion(
        questionData: questionData,
      );
    } else if (questionType == "sector") {
      return SectorQuestion(
        questionData: questionData,
      );
    } else if (questionType == "services") {
      return ServiceQuestion(questionData: questionData);
    } else if (questionType == "cond_radio") {
      return ConditionRadioQuestion(
        questionData: questionData,
        radioValue: _conditionRadioQuestionController
            .getRadioButtonValue(questionNumber),
      );
    } else if (questionType == "multiple_input") {
      return MultipleInputQuestion(
        questionData: questionData,
        controllersList: _multipleInputQuestionController
            .getMultipleInputControllers(questionNumber),
      );
    }
    return const Center(
      child: Text("Please select a question."),
    );
  }
}
