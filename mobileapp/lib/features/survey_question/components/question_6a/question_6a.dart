import 'package:elms/constant/app_colors.dart';
import 'package:elms/constant/app_dimens.dart';
import 'package:elms/constant/app_strings.dart';
import 'package:elms/features/survey_question/components/question_6a/question_6a_controller.dart';
import 'package:elms/global_widgets/custom_button/custom_button.dart';
import 'package:elms/global_widgets/custom_divider/custom_divider.dart';
import 'package:elms/global_widgets/custom_drop_down/custom_drop_down.dart';
import 'package:elms/global_widgets/custom_from_field/custom_form_fields.dart';
import 'package:elms/models/answer/drop_down_model.dart';
import 'package:elms/models/question_6a_answer/question_6a_answer_model.dart';
import 'package:elms/utils/custom_text/custom_text.dart';
import 'package:flutter/material.dart';
import 'package:get/get.dart';

import '../../survey_question_controller.dart';
import '../button_group.dart';
import '../custom_size_box.dart';

class Question6A extends GetResponsiveView {
  Question6A({
    Key? key,
    required this.questionData,
  }) : super(key: key);

  final Map questionData;

  final AppStrings _strings = Get.find();
  final AppColors _colors = Get.find();
  final AppDimens _dimens = Get.find();

  final SurveyQuestionController _surveyQuestionController = Get.find();
  final Question6aController _question6aController = Get.find();

  getEnumOfValues(value) {
    switch (value) {
      case "Full time(40 hours and +)":
        return "full";
      case "Part time(less than 40 hours)":
        return "part";
      case "Regular":
        return "regular";
      case "Seasonal":
        return "seasonal";
      case "Trained":
        return "trained";
      case "Untrained":
        return "untrained";
      case "General":
        return "general";
      case "Tvet":
        return "tvet";
      case "Male":
        return "male";
      case "Female":
        return "female";
      case "Sexual Minority":
        return "sexual_minority";
    }
  }

  checkNullStrings(str) {
    if (str == null) {
      return ' - ';
    } else {
      return str;
    }
  }

  @override
  Widget? builder() {
    int questionId = questionData["id"];
    String questionType = questionData["ans_type"];
    String questionTitle = questionData["qsn_name"];
    String questionNumber = questionData["qsn_number"];
    bool previousState = (questionNumber != "1.1");
    List edu1List = questionData["educational_qualification_general"];
    List edu2List = questionData["educational_qualification_tvet"];
    List<DropDownModel> genderDropDownList = const [
      DropDownModel("Male", 1),
      DropDownModel("Female", 2),
      DropDownModel("Sexual Minority", 3),
    ];
    List<DropDownModel> ojtDropDownList = const [
      DropDownModel("OJT", 1),
      DropDownModel("Apprentice", 2),
      DropDownModel("None", 3),
    ];

    List<DropDownModel> workingTimeList = questionData["working_hour"]
        .map<DropDownModel>((item) => DropDownModel(item, 0))
        .toList();
    List<DropDownModel> natureOfWorkList = questionData["nature_of_work"]
        .map<DropDownModel>((item) => DropDownModel(item, 0))
        .toList();
    List<DropDownModel> trainingList = questionData["training"]
        .map<DropDownModel>((item) => DropDownModel(item, 0))
        .toList();
    List<DropDownModel> educationalQualificationGeneralList =
        questionData["educational_qualification_general"]
            .map<DropDownModel>(
                (item) => DropDownModel(item["name"], item["id"]))
            .toList();
    List<DropDownModel> educationalQualificationTvetList =
        questionData["educational_qualification_tvet"]
            .map<DropDownModel>(
                (item) => DropDownModel(item["name"], item["id"]))
            .toList();

    return Padding(
      padding: EdgeInsets.all(_dimens.padding),
      child: Obx(
        () => Column(
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
              editController: _question6aController.empNameController,
              hint: "Employee name",
            ),
            sizedBox(),
            customDivider(),
            sizedBox(),
            Obx(
              () => Column(
                mainAxisAlignment: MainAxisAlignment.spaceBetween,
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  SizedBox(
                      width: screen.width * .4,
                      child: CustomText(
                        "Gender",
                        textAlign: TextAlign.start,
                      )),
                  sizedBox(),
                  for (var item in genderDropDownList)
                    InkWell(
                      onTap: () {
                        _question6aController.gender(item.name);
                      },
                      child: Row(
                        children: [
                          Radio<String>(
                            value: _question6aController.gender.value,
                            onChanged: (value) {
                              _question6aController.gender(value!);
                              _question6aController.gender(item.name);
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
                    )
                ],
              ),
            ),
            customDivider(),
            sizedBox(),
            Obx(
              () {
                List<DropDownModel> occupationDropDownList =
                    _question6aController.occupationList
                        .map<DropDownModel>((item) =>
                            DropDownModel(item["occupation_name"], item["id"]))
                        .toList();
                return Column(
                  mainAxisAlignment: MainAxisAlignment.spaceBetween,
                  children: [
                    CustomText(
                      "Occupations",
                      textAlign: TextAlign.start,
                    ),
                    CustomDropDown(
                      list: occupationDropDownList,
                      onChange: (value) {
                        _question6aController.occupations(value.id.toString());
                        if (value.name == "Others") {
                          _question6aController.showOtherOccupationField(true);
                        } else {
                          _question6aController.showOtherOccupationField(false);
                        }
                      },
                    ),
                  ],
                );
              },
            ),
            customDivider(),
            sizedBox(),
            Obx(
              () => _question6aController.showOtherOccupationField.value
                  ? Column(
                      children: [
                        CustomFormField(
                          editController: _question6aController
                              .otherOccupationValueController,
                          hint: "Other occupation",
                        ),
                        sizedBox(),
                        customDivider(),
                      ],
                    )
                  : Container(),
            ),
            Obx(
              () => Column(
                mainAxisAlignment: MainAxisAlignment.spaceBetween,
                children: [
                  CustomText(
                    "Working Hours",
                    textAlign: TextAlign.start,
                  ),
                  sizedBox(),
                  for (var item in workingTimeList)
                    InkWell(
                      onTap: () {
                        _question6aController.workingHours(item.name);
                      },
                      child: Row(
                        children: [
                          Radio<String>(
                            value: _question6aController.workingHours.value,
                            onChanged: (value) {
                              _question6aController.workingHours(value!);
                              _question6aController.workingHours(item.name);
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
                ],
              ),
            ),
            customDivider(),
            Obx(
              () => Column(
                mainAxisAlignment: MainAxisAlignment.spaceBetween,
                children: [
                  CustomText(
                    "Nature of Work",
                    textAlign: TextAlign.start,
                  ),
                  sizedBox(),
                  for (var item in natureOfWorkList)
                    InkWell(
                      onTap: () {
                        _question6aController.nature(item.name);
                      },
                      child: Row(
                        children: [
                          Radio<String>(
                            value: _question6aController.nature.value,
                            onChanged: (value) {
                              _question6aController.nature(value!);
                              _question6aController.nature(item.name);
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
                ],
              ),
            ),
            customDivider(),
            Obx(() => Column(
                  mainAxisAlignment: MainAxisAlignment.spaceBetween,
                  crossAxisAlignment: CrossAxisAlignment.start,
                  children: [
                    SizedBox(
                        width: screen.width * .4,
                        child: CustomText(
                          "Training",
                          textAlign: TextAlign.start,
                        )),
                    sizedBox(),
                    for (var item in trainingList)
                      InkWell(
                        onTap: () {
                          _question6aController.training(item.name);
                        },
                        child: Row(
                          children: [
                            Radio<String>(
                              value: _question6aController.training.value,
                              onChanged: (value) {
                                _question6aController.training(value!);
                                _question6aController.training(item.name);
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
                      )
                  ],
                )),
            customDivider(),
            Column(
              mainAxisAlignment: MainAxisAlignment.spaceBetween,
              children: [
                sizedBox(),
                CustomText(
                  "Educational Qualification General",
                  textAlign: TextAlign.start,
                  maxLine: 2,
                ),
                CustomDropDown(
                  list: educationalQualificationGeneralList,
                  onChange: (value) {
                    _question6aController
                        .educationalQualificationGeneral(value.id);
                  },
                ),
              ],
            ),
            Column(
              mainAxisAlignment: MainAxisAlignment.spaceBetween,
              children: [
                sizedBox(),
                CustomText(
                  "Educational Qualification Tvet",
                  textAlign: TextAlign.start,
                  maxLine: 2,
                ),
                CustomDropDown(
                    list: educationalQualificationTvetList,
                    onChange: (value) {
                      _question6aController
                          .educationalQualificationTvet(value.id);
                    }),
              ],
            ),
            customDivider(),
            Column(
              mainAxisAlignment: MainAxisAlignment.spaceBetween,
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                SizedBox(
                    width: screen.width * .4,
                    child: CustomText(
                      "OJT/Apprentice",
                      textAlign: TextAlign.start,
                    )),
                sizedBox(),
                for (var item in ojtDropDownList)
                  InkWell(
                    onTap: () {
                      _question6aController.q6aOjt(item.name);
                    },
                    child: Row(
                      children: [
                        Radio<String>(
                          value: _question6aController.q6aOjt.value,
                          onChanged: (value) {
                            _question6aController.q6aOjt(value!);
                            _question6aController.q6aOjt(item.name);
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
                  )
              ],
            ),
            customDivider(),
            CustomText("Work Experience(In Years)", textAlign: TextAlign.left),
            sizedBox(),
            CustomFormField(
              editController: _question6aController.q6aWorkExperiencePosition,
              hint: "In present position",
              justNumber: true,
            ),
            sizedBox(),
            CustomFormField(
              editController: _question6aController.q6aWorkExperienceOccupation,
              hint: "In this Occupation",
              justNumber: true,
            ),
            Divider(
              color: _colors.primaryColor,
              height: 30,
            ),
            SizedBox(
              height: screen.height * .4,
              child: Obx(() => Card(
                    elevation: 4,
                    child: _question6aController.q6aAnswersList.isEmpty
                        ? CustomText("There is no employee")
                        : ListView.builder(
                            itemCount:
                                _question6aController.q6aAnswersList.length,
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
                                        "Employee Name : " +
                                            _question6aController
                                                .q6aAnswersList[index].empName,
                                        textAlign: TextAlign.left,
                                      ),
                                      CustomText(
                                        "Gender : " +
                                            _question6aController
                                                .q6aAnswersList[index].gender,
                                        textAlign: TextAlign.left,
                                      ),
                                      Obx(
                                        () {
                                          return CustomText(
                                            "Occupation : " +
                                                _question6aController
                                                    .getOccupationTitleFromList(
                                                  _question6aController
                                                      .q6aAnswersList[index]
                                                      .occupationId,
                                                  _question6aController
                                                      .occupationList,
                                                ),
                                            textAlign: TextAlign.left,
                                            maxLine: 2,
                                          );
                                        },
                                      ),
                                      CustomText(
                                        "Other Occupation : " +
                                            checkNullStrings(
                                                _question6aController
                                                    .q6aAnswersList[index]
                                                    .otherOccupationValue),
                                        textAlign: TextAlign.left,
                                        maxLine: 2,
                                      ),
                                      CustomText(
                                        "WorkingTime : " +
                                            _question6aController
                                                .q6aAnswersList[index]
                                                .workingTime,
                                        textAlign: TextAlign.left,
                                      ),
                                      CustomText(
                                        "WorkNature : " +
                                            _question6aController
                                                .q6aAnswersList[index]
                                                .workNature,
                                        textAlign: TextAlign.left,
                                      ),
                                      CustomText(
                                        "Training : " +
                                            _question6aController
                                                .q6aAnswersList[index].training,
                                        textAlign: TextAlign.left,
                                      ),
                                      CustomText(
                                        "Educational qualification general : " +
                                            _question6aController
                                                .getEduTitleFromList(
                                              _question6aController
                                                  .q6aAnswersList[index]
                                                  .eduQuaGeneralId,
                                              edu1List,
                                              edu2List,
                                            ),
                                        textAlign: TextAlign.left,
                                        maxLine: 2,
                                      ),
                                      CustomText(
                                        "Educational qualification tvet : " +
                                            _question6aController
                                                .getEduTitleFromList(
                                              _question6aController
                                                  .q6aAnswersList[index]
                                                  .eduQuaTvetId,
                                              edu1List,
                                              edu2List,
                                            ),
                                        textAlign: TextAlign.left,
                                        maxLine: 2,
                                      ),
                                      CustomText(
                                        "OjtApprentice : " +
                                            _question6aController
                                                .q6aAnswersList[index]
                                                .ojtApprentice,
                                        textAlign: TextAlign.left,
                                      ),
                                      CustomText(
                                        "Present position : " +
                                            _question6aController
                                                .q6aAnswersList[index].workExp1,
                                        textAlign: TextAlign.left,
                                      ),
                                      CustomText(
                                        "Occupation position : " +
                                            _question6aController
                                                .q6aAnswersList[index].workExp2,
                                        textAlign: TextAlign.left,
                                      ),
                                      sizedBox(),
                                      CustomButton(
                                          width: screen.width * .4,
                                          height: 50,
                                          child: const Icon(Icons.delete),
                                          color: _colors.buttonColor,
                                          onPressed: () {
                                            _question6aController.q6aAnswersList
                                                .removeAt(index);
                                          }),
                                      sizedBox(),
                                    ],
                                  ),
                                ),
                              ],
                            ),
                          ),
                  )),
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
                if (_question6aController.checkVariables() &&
                    _question6aController.checkQ6Controllers()) {
                  _question6aController.q6aAnswersList.add(
                    Question6AAnswerModel(
                        id: null,
                        otherOccupationValue: _question6aController
                            .otherOccupationValueController.text,
                        empName: _question6aController.empNameController.text,
                        gender:
                            getEnumOfValues(_question6aController.gender.value),
                        workingTime: getEnumOfValues(
                            _question6aController.workingHours.value),
                        workNature:
                            getEnumOfValues(_question6aController.nature.value),
                        training: getEnumOfValues(
                            _question6aController.training.value),
                        ojtApprentice: _question6aController.q6aOjt.value,
                        workExp1: _question6aController
                            .q6aWorkExperiencePosition.text,
                        workExp2: _question6aController
                            .q6aWorkExperienceOccupation.text,
                        occupationId:
                            int.parse(_question6aController.occupations.value),
                        eduQuaGeneralId: _question6aController
                            .educationalQualificationGeneral.value,
                        eduQuaTvetId: _question6aController
                            .educationalQualificationTvet.value),
                  );
                  _question6aController.q6aWorkExperiencePosition.clear();
                  _question6aController.q6aWorkExperienceOccupation.clear();
                  _question6aController.empNameController.clear();
                  _question6aController.otherOccupationValueController.clear();
                }
              },
            ),
            sizedBox(),
            ButtonGroup(
                previousState: previousState,
                onPressed: () {
                  _question6aController.answerQuestion6a(
                    questionId,
                    questionType,
                    _question6aController.q6aAnswersList,
                    questionNumber,
                  );
                }),
          ],
        ),
      ),
    );
  }
}
