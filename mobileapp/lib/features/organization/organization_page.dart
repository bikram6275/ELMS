import 'package:elms/constant/app_colors.dart';
import 'package:elms/constant/app_dimens.dart';
import 'package:elms/constant/app_routes.dart';
import 'package:elms/constant/app_strings.dart';
import 'package:elms/features/organization/organization_controller.dart';
import 'package:elms/features/survey_question/components/custom_size_box.dart';
import 'package:elms/global_widgets/custom_button/custom_button.dart';
import 'package:elms/global_widgets/custom_indicator/custom_indicator.dart';
import 'package:elms/global_widgets/information_row/information_row.dart';
import 'package:elms/models/filter/filter_model.dart';
import 'package:elms/models/organozation/organization_model.dart';
import 'package:elms/utils/custom_text/custom_text.dart';
import 'package:elms/utils/snackbar/snackbar.dart';
import 'package:flutter/material.dart';
import 'package:get/get.dart';

import '../../infrastructure/custom_storage/custom_storage.dart';
import '../../utils/connection_status/connection_status.dart';

class FilterDialog extends StatelessWidget {
  FilterDialog({Key? key}) : super(key: key);

  final OrganizationController _organizationController = Get.find();
  final AppStrings _strings = Get.find();
  final AppRoutes _routes = Get.find();
  final AppColors _colors = Get.find();
  final AppDimens _dimens = Get.find();
  final CustomStorage _storage = Get.find();

  @override
  Widget build(BuildContext context) {
    return Dialog(
      shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(12.0)),
      child: SizedBox(
        height: 350.0,
        width: MediaQuery.of(context).size.width * .9,
        child: Padding(
          padding: const EdgeInsets.symmetric(horizontal: 20),
          child: Column(
            mainAxisAlignment: MainAxisAlignment.center,
            children: <Widget>[
              const Expanded(
                  child: SizedBox(
                height: 1,
              )),
              Obx(
                () => DropdownButton<String>(
                  isExpanded: true,
                  hint: Text(_organizationController.getPradeshTitle()),
                  items: _organizationController.pradeshList
                      .map((element) => DropdownMenuItem(
                          value: (element as PradeshModel).id.toString(),
                          child: Text(element.pradeshName)))
                      .toList(),
                  onChanged: (value) {
                    _organizationController.pradeshId(value);
                    _organizationController.getFilterDistrict(value);
                  },
                ),
              ),
              sizedBox(),
              Obx(
                () => DropdownButton<String>(
                  isExpanded: true,
                  hint: Text(_organizationController.getDistrictTitle()),
                  items: _organizationController.districtList
                      .map((element) => DropdownMenuItem(
                          value: (element as DistrictModel).id.toString(),
                          child: Text(element.englishName +
                              " | " +
                              element.nepaliName)))
                      .toList(),
                  onChanged: (value) {
                    _organizationController.districtId(value);
                  },
                ),
              ),
              sizedBox(),
              Obx(
                () => DropdownButton<String>(
                  isExpanded: true,
                  hint: Text(_organizationController.getSectorTitle()),
                  items: _organizationController.sectorList
                      .map((element) => DropdownMenuItem(
                          value: element.id.toString(),
                          child: Text(element.sectorName)))
                      .toList(),
                  onChanged: (value) {
                    _organizationController.sectorId(value);
                  },
                ),
              ),
              const Expanded(
                  child: SizedBox(
                height: 1,
              )),
              Row(
                mainAxisAlignment: MainAxisAlignment.spaceEvenly,
                children: [
                  CustomButton(
                    height: 50,
                    width: 120,
                    child: const Text("Clear Filter"),
                    color: _colors.primaryColor,
                    onPressed: () {
                      _organizationController.clearAllFilters();
                      _organizationController.onInit();
                      Get.back();
                    },
                  ),
                  CustomButton(
                    height: 50,
                    width: 120,
                    child: const Text("Filter"),
                    color: _colors.primaryColor,
                    onPressed: () {
                      Get.back();
                      _organizationController.getFilteredOrganizations();
                    },
                  ),
                ],
              ),
              sizedBox(),
            ],
          ),
        ),
      ),
    );
  }
}

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
      floatingActionButton: Obx(
        () => _organizationController.getOrganizationLoading.value ||
                _organizationController.getAllQuestionsLoading.value
            ? Container()
            : SizedBox(
                width: 60,
                height: 60,
                child: FloatingActionButton.large(
                  tooltip: "Filter",
                  onPressed: () async {
                    bool internetStatus =
                        await ConnectionStatus.checkConnection();

                    if (internetStatus) {
                      showDialog(
                          context: Get.context!,
                          builder: (BuildContext context) => FilterDialog());
                    } else {
                      snackBar(
                        "Error",
                        "Filter feature just available in online mode",
                        error: true,
                      );
                    }
                  },
                  child: const Icon(Icons.filter_alt),
                  backgroundColor: _colors.primaryColor,
                ),
              ),
      ),
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

  ui() => Obx(
        () => _organizationController.getOrganizationLoading.value ||
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
                : organizationWidget(_organizationController.organizationList),
      );

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

  organizationWidget(List<OrganizationModel> list) {
    return list.isEmpty
        ? Center(
            child: CustomText("There is no organization"),
          )
        : ListView.builder(
            padding: const EdgeInsets.only(bottom: 110),
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
                      InformationRow(
                          title: "Sector :", data: list[index].sector),

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
                                child: Obx(() => _organizationController
                                        .viewSurveyLoading.value
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
                                        _organizationController
                                                .clickedIndex.value ==
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
