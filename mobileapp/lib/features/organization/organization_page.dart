import 'package:elms/constant/app_colors.dart';
import 'package:elms/constant/app_dimens.dart';
import 'package:elms/constant/app_routes.dart';
import 'package:elms/constant/app_strings.dart';
import 'package:elms/features/organization/organization_controller.dart';
import 'package:elms/global_widgets/custom_button/custom_button.dart';
import 'package:elms/global_widgets/custom_indicator/custom_indicator.dart';
import 'package:elms/global_widgets/information_row/information_row.dart';
import 'package:elms/models/organozation/organization_model.dart';
import 'package:elms/utils/custom_text/custom_text.dart';
import 'package:flutter/material.dart';
import 'package:get/get.dart';

class OrganizationPage extends GetResponsiveView {
  OrganizationPage({Key? key, required this.surveyId}) : super(key: key);

  final int surveyId;

  final AppStrings _strings = Get.find();

  final AppRoutes _routes = Get.find();
  final AppColors _colors = Get.find();
  final AppDimens _dimens = Get.find();

  final OrganizationController _organizationController = Get.find();

  getColorOfStatus(String status) {
    if (status == "Completed") {
      return Colors.green;
    } else if (status == "Not Started") {
      return Colors.grey;
    } else if (status == "In Progress") {
      return Colors.blue;
    } else {
      return null;
    }
  }

  @override
  Widget? builder() {
    return Scaffold(
      appBar: AppBar(
        title: Text(_strings.organiztionTitle),
        centerTitle: true,
        actions: [
          Obx(
            () => _organizationController.getOrganizationLoading.value
                ? Container()
                : IconButton(
                    onPressed: () {
                      _organizationController.onInit();
                    },
                    icon: const Icon(Icons.refresh),
                  ),
          ),
        ],
      ),
      body: ui(),
    );
  }

  ui() => Obx(() => _organizationController.getOrganizationLoading.value ||
          _organizationController.getAllQuestionsLoading.value
      ? Center(
          child: CustomIndicator(
            color: _colors.darkIndicator,
          ),
        )
      : _organizationController.getOrganizationError.value ||
              _organizationController.getAllQuestionsError.value
          ? Center(
              child: CustomButton(
                  width: screen.width * .5,
                  child: CustomText(
                    _strings.tryAgainBtn,
                    colorOption: TextColorOptions.light,
                  ),
                  color: _colors.buttonColor,
                  onPressed: () {
                    _organizationController.getOrganization();
                  }),
            )
          : organizationWidget());

  getYearOfDate(date) {
    List months = [
      'jan',
      'feb',
      'mar',
      'apr',
      'may',
      'jun',
      'jul',
      'aug',
      'sep',
      'oct',
      'nov',
      'dec'
    ];
    DateTime dt = DateTime.parse(date);
    return dt.year.toString() +
        " " +
        months[dt.month - 1] +
        " " +
        dt.day.toString();
  }

  organizationWidget() {
    List<OrganizationModel> list = _organizationController.organizationList;
    return ListView.builder(
      itemCount: list.length,
      itemBuilder: (context, index) {
        return Padding(
          padding: EdgeInsets.all(_dimens.padding),
          child: Card(
            elevation: 3,
            child: Column(
              children: [
                // InformationRow(title: "S.N :", data: list[index].id.toString()),
                InformationRow(
                    title: "District :", data: list[index].districtName),
                InformationRow(
                    title: "Organization :", data: list[index].orgName),
                InformationRow(title: "Sector :", data: list[index].sector),

                // InformationRow(
                //   title: "Establish date :",
                //   data: getYearOfDate(list[index].establishDate),
                // ),
                InformationRow(
                  title: "Phone number :",
                  data: list[index].phoneNo ?? "-",
                  maxLine: 1,
                ),
                InformationRow(
                  title: "Status :",
                  data: list[index].status,
                  color: getColorOfStatus(list[index].status),
                  maxLine: 1,
                ),
                Row(
                  children: [
                    Expanded(
                      child: Padding(
                        padding: EdgeInsets.symmetric(
                            horizontal: _dimens.padding * 2),
                        child: CustomButton(
                          radius: 20,
                          height: 40,
                          child: Obx(() =>
                              _organizationController.viewSurveyLoading.value
                                  ? Center(
                                      child: CustomIndicator(
                                        color: _colors.lightIndicator,
                                        size: 15,
                                      ),
                                    )
                                  : Text(_strings.viewBtn)),
                          color: _colors.button2Color,
                          onPressed: () {
                            _organizationController.clickedIndex(index);
                            _organizationController.viewSurvey(
                                surveyId: surveyId,
                                pivotId: list[index].pivotId);
                          },
                        ),
                      ),
                    ),
                    Expanded(
                      child: Padding(
                        padding: EdgeInsets.symmetric(
                            horizontal: _dimens.padding * 2),
                        child: CustomButton(
                          radius: 20,
                          height: 40,
                          child: Obx(() => _organizationController
                                      .startSurveyLoading.value &&
                                  _organizationController.clickedIndex.value ==
                                      index
                              ? Center(
                                  child: CustomIndicator(
                                    color: _colors.lightIndicator,
                                    size: 15,
                                  ),
                                )
                              : Text(_strings.startBtn)),
                          color: _colors.buttonColor,
                          onPressed: () {
                            _organizationController.clickedIndex(index);
                            _organizationController.startSurvey(
                                surveyId: surveyId,
                                pivotId: list[index].pivotId);
                          },
                        ),
                      ),
                    )
                  ],
                ),
                const SizedBox(
                  height: 10,
                ),
              ],
            ),
          ),
        );
      },
    );
  }
}
