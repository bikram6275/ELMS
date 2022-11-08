import 'package:elms/constant/app_colors.dart';
import 'package:elms/constant/app_dimens.dart';
import 'package:elms/constant/app_strings.dart';
import 'package:elms/features/survey_question/components/service_question/service_question_controller.dart';
import 'package:elms/global_widgets/custom_divider/custom_divider.dart';
import 'package:elms/models/product_service/product_service_model.dart';
import 'package:elms/utils/custom_text/custom_text.dart';
import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:get/get_state_manager/get_state_manager.dart';

import '../../../../utils/snackbar/snackbar.dart';
import '../../survey_question_controller.dart';
import '../button_group.dart';
import '../custom_size_box.dart';

class ServiceQuestion extends GetResponsiveView {
  ServiceQuestion({
    Key? key,
    required this.questionData,
  }) : super(key: key);

  final Map questionData;

  final AppDimens _dimens = Get.find();
  final AppStrings _strings = Get.find();
  final AppColors _colors = Get.find();
  final SurveyQuestionController _surveyQuestionController = Get.find();
  final ServiceQuestionController _serviceQuestionController = Get.find();

  @override
  Widget? builder() {
    int questionId = questionData["id"];
    String questionType = questionData["ans_type"];
    String questionTitle = questionData["qsn_name"];
    String questionNumber = questionData["qsn_number"];
    bool previousState = (questionNumber != "1.1");
    List<ProductAndService> servicesList =
        _surveyQuestionController.filterProductAndServiceList();
    _serviceQuestionController.clearCheckBoxListFromUnUsableData(servicesList);
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
            servicesList.isEmpty
                ? Container()
                : Obx(() => Column(
                      children: [
                        for (var i = 0; i < servicesList.length; i++)
                          Container(
                            padding:
                                EdgeInsets.symmetric(vertical: _dimens.padding),
                            decoration: BoxDecoration(
                              color: (_serviceQuestionController.q4checkbox
                                      .contains(servicesList[i].id))
                                  ? _colors.primaryColor.withOpacity(.1)
                                  : Colors.transparent,
                              border: Border.all(
                                color: Colors.grey.withOpacity(.15),
                              ),
                            ),
                            child: CheckboxListTile(
                              controlAffinity: ListTileControlAffinity.leading,
                              value: (_serviceQuestionController.q4checkbox
                                  .contains(servicesList[i].id)),
                              activeColor: _colors.primaryColor.withOpacity(.7),
                              onChanged: (value) {
                                if (_serviceQuestionController.q4checkbox
                                    .contains(servicesList[i].id)) {
                                  _serviceQuestionController.q4checkbox
                                      .remove(servicesList[i].id);
                                } else {
                                  if (_serviceQuestionController
                                          .q4checkbox.length >
                                      3) {
                                    snackBar(_strings.failedTitle,
                                        "Max limit is 4 item!",
                                        error: true);
                                  } else {
                                    _serviceQuestionController.q4checkbox
                                        .add(servicesList[i].id);
                                  }
                                }
                              },
                              title: CustomText(
                                servicesList[i].productAndServicesName,
                                textAlign: TextAlign.start,
                                maxLine: 3,
                              ),
                            ),
                          ),
                      ],
                    )),
            sizedBox(),
            ButtonGroup(
                previousState: previousState,
                onPressed: () {
                  _surveyQuestionController.answerCheckBoxQuestion(
                    questionId: questionId,
                    questionType: questionType,
                    listOfValues: _serviceQuestionController.q4checkbox,
                    questionNumber: questionNumber,
                  );
                }),
          ],
        ));
  }
}
