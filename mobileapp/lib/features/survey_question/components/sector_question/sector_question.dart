import 'package:elms/constant/app_dimens.dart';
import 'package:elms/constant/app_strings.dart';
import 'package:elms/features/survey_question/components/sector_question/sector_quetion_controller.dart';
import 'package:elms/global_widgets/custom_divider/custom_divider.dart';
import 'package:elms/global_widgets/custom_drop_down/custom_drop_down.dart';
import 'package:elms/infrastructure/custom_storage/custom_storage.dart';
import 'package:elms/models/answer/drop_down_model.dart';
import 'package:elms/utils/custom_text/custom_text.dart';
import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:get/get_state_manager/get_state_manager.dart';

import '../../survey_question_controller.dart';
import '../button_group.dart';
import '../custom_size_box.dart';

class SectorQuestion extends GetResponsiveView {
  SectorQuestion({
    Key? key,
    required this.questionData,
  }) : super(key: key);

  final Map questionData;

  final AppDimens _dimens = Get.find();
  final CustomStorage _storage = Get.find();
  final AppStrings _strings = Get.find();

  final SurveyQuestionController _surveyQuestionController = Get.find();
  final SectorQuestionController _sectorQuestionController = Get.find();

  convertList(List subSectorlist) {
    List<DropDownModel> list = [];
    for (var element in subSectorlist) {
      list.add(
        DropDownModel(
          element["sector_name"],
          element["id"],
        ),
      );
    }
    return list;
  }

  @override
  Widget? builder() {
    int questionId = questionData["id"];
    String questionType = questionData["ans_type"];
    String questionTitle = questionData["qsn_name"];
    String questionNumber = questionData["qsn_number"];
    List<dynamic> subSectors = questionData["sub_sectors"];
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
            Obx(
              () => CustomDropDown(
                hint: _sectorQuestionController.subSectorName.value,
                list: convertList(subSectors),
                onChange: (value) {
                  _sectorQuestionController.subSectorName(value.name);
                  _sectorQuestionController.subSectorId(value.id);
                  _storage.saveSubSecId(value.id);
                },
              ),
            ),
            sizedBox(),
            ButtonGroup(
                previousState: previousState,
                onPressed: () {
                  _sectorQuestionController.answerSectorQuestion(
                      questionId,
                      _sectorQuestionController.subSectorName.value,
                      questionType,
                      _sectorQuestionController.subSectorId.value,
                      questionNumber);
                }),
          ],
        ),
      ),
    );
  }
}
