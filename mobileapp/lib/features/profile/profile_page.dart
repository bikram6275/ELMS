import 'package:elms/features/survey_question/components/custom_size_box.dart';
import 'package:elms/global_widgets/custom_button/custom_button.dart';
import 'package:elms/infrastructure/global_controller/global_controller.dart';
import 'package:elms/utils/custom_text/custom_text.dart';
import 'package:flutter/material.dart';
import 'package:get/get.dart';

import '../../../../constant/app_colors.dart';
import '../../../../constant/app_dimens.dart';
import '../../../../constant/app_routes.dart';
import '../../../../constant/app_strings.dart';
import '../../../../infrastructure/custom_storage/custom_storage.dart';
import 'profile_controller.dart';

class ProfilePage extends StatefulWidget {
  const ProfilePage({Key? key}) : super(key: key);

  @override
  _ProfilePageState createState() => _ProfilePageState();
}

class _ProfilePageState extends State<ProfilePage> {
  final AppStrings _strings = Get.find();
  final AppRoutes _routes = Get.find();
  final AppColors _colors = Get.find();
  final AppDimens _dimens = Get.find();
  final CustomStorage _storage = Get.find();

  final ProfileController _profileController = Get.find();
  final GlobalController _globalController = Get.find();

  @override
  Widget build(BuildContext context) {
    final _width = MediaQuery.of(context).size.width;
    final _height = MediaQuery.of(context).size.height;

    return Scaffold(
      body: Stack(
        children: <Widget>[
          Container(
            height: _height * .5,
            decoration: BoxDecoration(
              gradient: LinearGradient(
                colors: [
                  _colors.primaryColor,
                  _colors.button2Color,
                ],
                begin: Alignment.topCenter,
                end: Alignment.center,
              ),
            ),
          ),
          Scaffold(
            appBar: AppBar(
              backgroundColor: Colors.transparent,
              elevation: 0,
            ),
            backgroundColor: Colors.transparent,
            body: SingleChildScrollView(
              child: Stack(
                children: <Widget>[
                  Align(
                    alignment: Alignment.center,
                    child: Padding(
                      padding: EdgeInsets.all(_height / 15),
                      child: Column(
                        crossAxisAlignment: CrossAxisAlignment.center,
                        children: <Widget>[
                          CircleAvatar(
                            backgroundImage:
                                const AssetImage('assets/images/man.png'),
                            radius: _height / 10,
                          ),
                        ],
                      ),
                    ),
                  ),
                  Padding(
                    padding: EdgeInsets.only(
                        top: _height / 2.8,
                        left: _width / 20,
                        right: _width / 20),
                    child: Column(
                      children: <Widget>[
                        Container(
                          width: _width * .9,
                          decoration: BoxDecoration(
                              borderRadius:
                                  const BorderRadius.all(Radius.circular(20)),
                              color: _colors.lightIndicator,
                              // (_storage.readUserStatus() == "active"
                              //     ? Colors.green
                              //     : Colors.red)[100],
                              boxShadow: const [
                                BoxShadow(
                                    color: Colors.black45,
                                    blurRadius: 2.0,
                                    offset: Offset(0.0, 2.0))
                              ]),
                          child: Padding(
                            padding: EdgeInsets.symmetric(
                              horizontal: _width / 20,
                              vertical: _width / 20,
                            ),
                            child: Column(
                              children: [
                                Center(
                                  child: Row(
                                    children: [
                                      const Text(
                                        "Name : ",
                                        style: TextStyle(
                                            fontSize: 18.0,
                                            fontWeight: FontWeight.bold),
                                      ),
                                      Text(
                                        _storage.readName().toString(),
                                        style: const TextStyle(
                                            fontSize: 18.0,
                                            fontWeight: FontWeight.bold),
                                      ),
                                    ],
                                  ),
                                ),
                                sizedBox(),
                                Center(
                                  child: Row(
                                    children: [
                                      const Text(
                                        "Address : ",
                                        style: TextStyle(
                                            fontSize: 18.0,
                                            fontWeight: FontWeight.bold),
                                      ),
                                      Text(
                                        _storage.readPradeshName().toString() +
                                                ", " +
                                                _storage
                                                    .readEnglishName()
                                                    .toString() ??
                                            "...",
                                        style: const TextStyle(
                                            fontSize: 18.0,
                                            fontWeight: FontWeight.bold),
                                      ),
                                    ],
                                  ),
                                ),
                                sizedBox(),
                                Center(
                                  child: Row(
                                    children: [
                                      const Text(
                                        "User Status : ",
                                        style: TextStyle(
                                            fontSize: 18.0,
                                            fontWeight: FontWeight.bold),
                                      ),
                                      Container(
                                        padding: EdgeInsets.symmetric(
                                            horizontal: _dimens.padding * 2,
                                            vertical: 2),
                                        decoration: BoxDecoration(
                                            color: (_storage.readUserStatus() ==
                                                    "active"
                                                ? Colors.green
                                                : Colors.red)[500],
                                            borderRadius:
                                                BorderRadius.circular(20)),
                                        child: Text(
                                          _storage.readUserStatus().toString(),
                                          style: const TextStyle(
                                              fontSize: 18.0,
                                              fontWeight: FontWeight.bold),
                                        ),
                                      ),
                                    ],
                                  ),
                                ),
                              ],
                            ),
                          ),
                        ),
                        sizedBox(),
                        Container(
                          decoration: BoxDecoration(
                              borderRadius:
                                  const BorderRadius.all(Radius.circular(20)),
                              color: _colors.lightIndicator,
                              // (_storage.readUserStatus() == "active"
                              //     ? Colors.green
                              //     : Colors.red)[100],
                              boxShadow: const [
                                BoxShadow(
                                    color: Colors.black45,
                                    blurRadius: 2.0,
                                    offset: Offset(0.0, 2.0))
                              ]),
                          child: Padding(
                            padding: EdgeInsets.symmetric(
                              horizontal: _width / 20,
                              vertical: _width / 20,
                            ),
                            child: Column(
                              children: <Widget>[
                                infoChild(_width, Icons.email,
                                    _storage.readEmail().toString()),
                                sizedBox(size: 6),
                                infoChild(_width, Icons.call,
                                    _storage.readPhone().toString()),
                              ],
                            ),
                          ),
                        ),
                        sizedBox(size: 20),
                        TextButton(
                            onPressed: () {
                              Get.toNamed(_routes.forgetPassword);
                            },
                            child: CustomText(
                              _strings.changePassTitle,
                              customColor: Colors.blueAccent,
                            )),
                        sizedBox(size: 20),
                        CustomButton(
                            height: 55,
                            child: CustomText("Logout",
                                customColor: _colors.lightTxtColor),
                            color: Colors.red,
                            onPressed: () {
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
                  )
                ],
              ),
            ),
          ),
        ],
      ),
    );
  }

  Widget infoChild(double width, IconData icon, data) => Row(
        children: <Widget>[
          Icon(
            icon,
            color: _colors.primaryColor,
            size: 36.0,
          ),
          SizedBox(
            width: width / 20,
          ),
          Text(data)
        ],
      );
}
