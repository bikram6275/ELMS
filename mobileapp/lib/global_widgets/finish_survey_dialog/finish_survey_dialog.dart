import 'package:elms/global_widgets/custom_button/custom_button.dart';
import 'package:elms/utils/custom_text/custom_text.dart';
import 'package:flutter/material.dart';
import 'package:get/get.dart';

class FinishSurveyDialog extends GetResponsiveView {
  FinishSurveyDialog({Key? key}) : super(key: key);

  @override
  Widget? builder() {
    return Scaffold(
      body: Column(
        children: [
          TextField(),
          CustomButton(
              child: CustomText("submit"), color: Colors.blue, onPressed: () {})
        ],
      ),
    );
  }
}
