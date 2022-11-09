import 'package:elms/constant/app_colors.dart';
import 'package:elms/constant/app_dimens.dart';
import 'package:elms/constant/app_routes.dart';
import 'package:elms/constant/app_strings.dart';
import 'package:elms/features/feedback/feedback_controller.dart';
import 'package:flutter/material.dart';
import 'package:get/get.dart';

import '../../global_widgets/custom_button/custom_button.dart';
import '../../global_widgets/custom_indicator/custom_indicator.dart';
import '../../utils/custom_text/custom_text.dart';
import '../survey_question/components/custom_size_box.dart';

class FeedbackPage extends StatelessWidget {
  FeedbackPage({Key? key, required this.pivotId}) : super(key: key);

  final String pivotId;

  final AppStrings _strings = Get.find();
  final AppRoutes _routes = Get.find();
  final AppColors _colors = Get.find();
  final AppDimens _dimens = Get.find();

  final FeedbackController _feedbackController = Get.find();

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      // floatingActionButton: FloatingActionButton.extended(
      //   backgroundColor: _colors.primaryColor,
      //   onPressed: () {
      //     Get.offAllNamed(_routes.dashboard);
      //   },
      //   label: const Text("Back to dashboard"),
      //   isExtended: true,
      // ),
      appBar: AppBar(
        title: const Text("Feedbacks"),
        actions: [
          IconButton(
            onPressed: () {
              _feedbackController.onInit();
            },
            icon: const Icon(Icons.refresh),
          ),
        ],
      ),
      body: Obx(() {
        if (_feedbackController.getFeedbacksLoading.value) {
          return Center(
              child: CustomIndicator(
            color: _colors.primaryColor,
          ));
        }

        if (_feedbackController.getFeedbacksError.value) {
          return Center(
            child: CustomButton(
                width: MediaQuery.of(context).size.width * .5,
                child: CustomText(
                  _strings.tryAgainBtn,
                  colorOption: TextColorOptions.light,
                ),
                color: _colors.buttonColor,
                onPressed: () {
                  _feedbackController.onInit();
                }),
          );
        }

        if (_feedbackController.feedbacks.isEmpty &&
            _feedbackController.getFeedbacksLoading.value == false) {
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
                      _feedbackController.onInit();
                    }),
              ],
            ),
          );
        }
        return ListView.builder(
          itemCount: _feedbackController.feedbacks.length,
          itemBuilder: (context, index) => Padding(
            padding: const EdgeInsets.all(20),
            child: Container(
              decoration: BoxDecoration(
                border: Border(
                  left: BorderSide(
                    color: _colors.primaryColor,
                    width: 4,
                  ),
                ),
              ),
              child: Padding(
                padding: EdgeInsets.all(_dimens.padding),
                child: Column(
                  crossAxisAlignment: CrossAxisAlignment.start,
                  children: [
                    Container(
                      padding: const EdgeInsets.symmetric(
                          vertical: 8, horizontal: 12),
                      decoration: BoxDecoration(
                        color: Colors.green,
                        borderRadius: BorderRadius.all(
                          Radius.circular(_dimens.borderRadius),
                        ),
                      ),
                      child: Text(
                        _feedbackController.feedbacks[index].status,
                        textAlign: TextAlign.start,
                        style: TextStyle(color: _colors.lightTxtColor),
                      ),
                    ),
                    sizedBox(),
                    Row(
                      crossAxisAlignment: CrossAxisAlignment.start,
                      children: [
                        const Icon(
                          Icons.flag_outlined,
                          color: Colors.green,
                          size: 30,
                        ),
                        const SizedBox(
                          width: 10,
                        ),
                        Expanded(
                          child: CustomText(
                            _feedbackController.feedbacks[index].remarks,
                            maxLine: 10,
                            textAlign: TextAlign.start,
                          ),
                        ),
                      ],
                    ),
                  ],
                ),
              ),
            ),
          ),
        );
      }),
    );
  }
}
