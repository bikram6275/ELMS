import 'package:elms/constant/app_colors.dart';
import 'package:elms/constant/app_routes.dart';
import 'package:elms/constant/app_strings.dart';
import 'package:elms/global_widgets/custom_button/custom_button.dart';
import 'package:elms/infrastructure/custom_storage/custom_storage.dart';
import 'package:elms/infrastructure/global_controller/global_controller.dart';
import 'package:elms/utils/custom_text/custom_text.dart';
import 'package:flutter/material.dart';
import 'package:get/get.dart';

class CustomDrawer extends GetResponsiveView {
  CustomDrawer({Key? key, required this.drawerKey})
      : super(key: key, alwaysUseBuilder: true);

  final CustomStorage _storage = Get.find();
  final GlobalController _globalController = Get.find();
  final GlobalKey<ScaffoldState> drawerKey;

  final AppStrings _strings = Get.find();
  final AppRoutes _routes = Get.find();
  final AppColors _colors = Get.find();

  userName() {
    return _storage.readName();
  }

  customDivider() => const Divider(
        color: Colors.grey,
      );

  customSizedBox() => const SizedBox(
        height: 20,
      );

  item(String title, onPressed) => InkWell(
        onTap: onPressed,
        child: Container(
          padding: const EdgeInsets.all(20),
          child: CustomText(
            title,
            textAlign: TextAlign.start,
          ),
        ),
      );

  @override
  Widget? builder() {
    return SizedBox(
      width: screen.width * .7,
      height: screen.height,
      child: SafeArea(
        child: SingleChildScrollView(
          child: Column(
            children: [
              customSizedBox(),
              Image.asset(
                "assets/images/ELMS_Logo.png",
                width: 200,
              ),
              customSizedBox(),
              customDivider(),
              CustomText("Welcome ${userName()}"),
              customDivider(),
              item("Profile", () {
                Get.toNamed(_routes.profile);
              }),
              item(_strings.surveyTitle, () {
                drawerKey.currentState!.openEndDrawer();
              }),
              item(_strings.aboutTitle, () {
                Get.toNamed(_routes.about);
              }),
              item(_strings.changePassTitle, () {
                Get.toNamed(_routes.forgetPassword);
              }),
              item(_strings.logoutTitle, () {
                Get.defaultDialog(
                  middleText: _strings.logoutDesc,
                  confirm: CustomButton(
                      child: Text(_strings.confitmBtn),
                      color: _colors.buttonColor,
                      onPressed: () {
                        _globalController.logoutUser();
                      }),
                  cancel: CustomButton(
                      child: Text(_strings.cancleBtn),
                      color: _colors.buttonColor,
                      onPressed: () {
                        Get.back();
                      }),
                );
              }),
            ],
          ),
        ),
      ),
    );
  }
}
