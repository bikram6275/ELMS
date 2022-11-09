import 'package:elms/constant/app_colors.dart';
import 'package:elms/constant/app_dimens.dart';
import 'package:elms/constant/app_routes.dart';
import 'package:elms/constant/app_strings.dart';
import 'package:elms/features/feedback/organization_include_feedback_controller.dart';
import 'package:elms/features/survey_question/components/custom_size_box.dart';
import 'package:elms/global_widgets/custom_indicator/custom_indicator.dart';
import 'package:elms/utils/custom_text/custom_text.dart';
import 'package:flutter/material.dart';
import 'package:get/get.dart';

import '../../global_widgets/custom_button/custom_button.dart';
import '../../global_widgets/information_row/information_row.dart';

class OrganizationsIncludeFeedbackPage extends StatelessWidget {
  OrganizationsIncludeFeedbackPage({Key? key}) : super(key: key);

  final OrganizationsIncludeFeedbackController
      _organizationsIncludeFeedbackController = Get.find();
  final AppStrings _strings = Get.find();
  final AppRoutes _routes = Get.find();
  final AppColors _colors = Get.find();
  final AppDimens _dimens = Get.find();

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text("Organizations"),
        actions: [
          IconButton(
            onPressed: () {
              _organizationsIncludeFeedbackController.onInit();
            },
            icon: const Icon(Icons.refresh),
          ),
        ],
      ),
      body: Obx(() {
        if (_organizationsIncludeFeedbackController
            .getOrganizationsLoading.value) {
          return Center(
              child: CustomIndicator(
            color: _colors.primaryColor,
          ));
        }

        if (_organizationsIncludeFeedbackController
            .getOrganizationsError.value) {
          return Center(
            child: CustomButton(
                width: MediaQuery.of(context).size.width * .5,
                child: CustomText(
                  _strings.tryAgainBtn,
                  colorOption: TextColorOptions.light,
                ),
                color: _colors.buttonColor,
                onPressed: () {
                  _organizationsIncludeFeedbackController.onInit();
                }),
          );
        }

        if (_organizationsIncludeFeedbackController.organizations.isEmpty &&
            _organizationsIncludeFeedbackController
                    .getOrganizationsLoading.value ==
                false) {
          return Center(
            child: Column(
              mainAxisAlignment: MainAxisAlignment.center,
              children: [
                CustomText("There is no feedback please try again"),
                sizedBox(),
                CustomButton(
                    width: MediaQuery.of(context).size.width * .5,
                    child: CustomText(
                      _strings.tryAgainBtn,
                      colorOption: TextColorOptions.light,
                    ),
                    color: _colors.buttonColor,
                    onPressed: () {
                      _organizationsIncludeFeedbackController.onInit();
                    }),
              ],
            ),
          );
        }

        return ListView.builder(
          itemCount:
              _organizationsIncludeFeedbackController.organizations.length,
          itemBuilder: (context, index) => Padding(
            padding: EdgeInsets.all(_dimens.padding),
            child: Card(
              elevation: 10,
              child: Column(
                children: [
                  InformationRow(
                      title: "District :",
                      data: _organizationsIncludeFeedbackController
                          .organizations[index].districtName),
                  InformationRow(
                      title: "Organization :",
                      data: _organizationsIncludeFeedbackController
                          .organizations[index].orgName),
                  InformationRow(
                      title: "Sector :",
                      data: _organizationsIncludeFeedbackController
                          .organizations[index].sector),
                  InformationRow(
                    title: "Phone number :",
                    data: _organizationsIncludeFeedbackController
                            .organizations[index].phoneNo ??
                        "-",
                    maxLine: 1,
                  ),
                  Padding(
                    padding: EdgeInsets.all(_dimens.padding),
                    child: CustomButton(
                      child: CustomText(
                        "Feedbacks",
                        colorOption: TextColorOptions.light,
                      ),
                      color: _colors.primaryColor,
                      onPressed: () {
                        Get.toNamed(
                          _routes.feedback,
                          arguments: _organizationsIncludeFeedbackController
                              .organizations[index].pivotId
                              .toString(),
                        );
                      },
                    ),
                  )
                ],
              ),
            ),
          ),
        );
      }),
    );
  }
}
