import 'package:elms/constant/app_dimens.dart';
import 'package:elms/utils/custom_text/custom_text.dart';
import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:get/get_state_manager/get_state_manager.dart';

class InformationRow extends GetResponsiveView {
  InformationRow(
      {required this.title,
      required this.data,
      Key? key,
      this.maxLine,
      this.color})
      : super(key: key);

  final String title, data;
  final int? maxLine;
  final Color? color;

  final AppDimens _dimens = Get.find();

  @override
  Widget? builder() {
    return Padding(
      padding: EdgeInsets.all(_dimens.padding),
      child: Row(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          SizedBox(
            width: screen.width * .4,
            child: CustomText(
              title,
              textAlign: TextAlign.left,
              fontWeight: FontWeight.bold,
              maxLine: 2,
            ),
          ),
          SizedBox(
            width: screen.width * .4,
            child: CustomText(
              data,
              customColor: color,
              textAlign: TextAlign.left,
              maxLine: maxLine ?? 3,
              // sizeOption: TextSizeOptions.caption,
            ),
          ),
        ],
      ),
    );
  }
}
