import 'package:elms/constant/app_colors.dart';
import 'package:elms/constant/app_dimens.dart';
import 'package:elms/constant/app_routes.dart';
import 'package:elms/constant/app_strings.dart';
import 'package:elms/features/dashboard/dashboard_controller.dart';
import 'package:elms/global_widgets/custom_button/custom_button.dart';
import 'package:elms/global_widgets/custom_drawer/custom_drawer.dart';
import 'package:elms/infrastructure/custom_storage/custom_storage.dart';
import 'package:elms/models/survey/survey_model.dart';
import 'package:elms/utils/custom_text/custom_text.dart';
import 'package:flutter/material.dart';
import 'package:get/get.dart';

import '../../global_widgets/custom_indicator/custom_indicator.dart';
import '../survey_question/components/custom_size_box.dart';

class DashboardPage extends GetResponsiveView {
  DashboardPage({Key? key}) : super(key: key);

  final AppStrings _strings = Get.find();
  final AppRoutes _routes = Get.find();
  final AppColors _colors = Get.find();
  final AppDimens _dimens = Get.find();
  final CustomStorage _storage = Get.find();

  final DashboardController _dashboardController = Get.find();

  @override
  Widget? builder() {
    return Scaffold(
      key: _dashboardController.scaffoldStateKey,
      drawer: Drawer(
        child: CustomDrawer(
          drawerKey: _dashboardController.scaffoldStateKey,
        ),
      ),
      body: BodyUI(),
    );
  }
}

class RowSource extends DataTableSource {
  final DashboardController _dashboardController = Get.find();

  @override
  DataRow? getRow(int index) {
    List<SurveyModel> list = _dashboardController.recentSurveyList;
    if (index < list.length) {
      return DataRow(cells: <DataCell>[
        DataCell(Text(list[index].id.toString())),
        DataCell(Text(list[index].surveyName)),
        DataCell(Text(list[index].startDate)),
        DataCell(Text(list[index].endDate))
      ]);
    } else {
      return null;
    }
  }

  @override
  bool get isRowCountApproximate => true;

  @override
  int get rowCount => _dashboardController.recentSurveyList.length;

  @override
  int get selectedRowCount => 0;
}

class BodyUI extends GetResponsiveView {
  BodyUI({Key? key}) : super(key: key);

  final AppStrings _strings = Get.find();
  final AppRoutes _routes = Get.find();
  final AppColors _colors = Get.find();
  final AppDimens _dimens = Get.find();
  final CustomStorage _storage = Get.find();

  final DashboardController _dashboardController = Get.find();

  @override
  bool get alwaysUseBuilder => true;

  @override
  Widget? builder() {
    List<SurveyModel> list = _dashboardController.recentSurveyList;

    return Obx(() {
      bool loading = (_dashboardController.getRecentSurveyLoading.value ||
          _dashboardController.getProductsLoading.value ||
          _dashboardController.getSectorLoading.value ||
          _dashboardController.getOccupationLoading.value ||
          _dashboardController.getAboutInfoLoading.value ||
          _dashboardController.getSurveyStatusLoading.value);

      bool error = (_dashboardController.getRecentSurveyError.value ||
          _dashboardController.getProductsError.value ||
          _dashboardController.getSectorError.value ||
          _dashboardController.getOccupationError.value ||
          _dashboardController.getAboutInfoError.value ||
          _dashboardController.getSurveyStatusError.value);

      return loading
          ? Center(
              child: CustomIndicator(
                color: _colors.darkIndicator,
              ),
            )
          : error
              ? Center(
                  child: CustomButton(
                      width: screen.width * .5,
                      child: CustomText(
                        _strings.tryAgainBtn,
                        colorOption: TextColorOptions.light,
                      ),
                      color: _colors.buttonColor,
                      onPressed: () {
                        _dashboardController.onInit();
                      }),
                )
              : SingleChildScrollView(
                  child: Column(
                    children: [
                      SizedBox(
                        width: screen.width,
                        height: screen.height * .43,
                        child: Stack(
                          children: [
                            Container(
                              width: screen.width,
                              height: screen.height * .3,
                              color: _colors.primaryColor,
                              child: SafeArea(
                                child: Padding(
                                  padding: EdgeInsets.all(_dimens.padding * 2),
                                  child: Row(
                                    mainAxisAlignment: MainAxisAlignment.end,
                                    crossAxisAlignment:
                                        CrossAxisAlignment.start,
                                    children: [
                                      SizedBox(
                                        width: 60,
                                        height: 60,
                                        child: IconButton(
                                          onPressed: () {
                                            _dashboardController
                                                .scaffoldStateKey.currentState
                                                ?.openDrawer();
                                          },
                                          icon: Image.asset(
                                            "assets/images/man.png",
                                          ),
                                        ),
                                      ),
                                      const Expanded(
                                        child: SizedBox(
                                          width: 1,
                                        ),
                                      ),
                                      IconButton(
                                        onPressed: () {
                                          _dashboardController.onInit();
                                        },
                                        icon: Icon(
                                          Icons.refresh,
                                          size: 30,
                                          color: _colors.lightTxtColor,
                                        ),
                                      ),
                                    ],
                                  ),
                                ),
                              ),
                            ),
                            Align(
                              alignment: Alignment.bottomCenter,
                              child: SizedBox(
                                width: screen.width * .8,
                                height: screen.height * .25,
                                child: Stack(
                                  children: [
                                    SizedBox(
                                      width: screen.width * .8,
                                      height: screen.height * .22,
                                      child: Card(
                                        color: _colors.cardBackground,
                                        elevation: 3,
                                        shape: RoundedRectangleBorder(
                                          borderRadius:
                                              BorderRadius.circular(30),
                                        ),
                                        child: Column(
                                          mainAxisAlignment:
                                              MainAxisAlignment.center,
                                          children: [
                                            CustomText(_strings.welcomeTitle),
                                            sizedBox(size: 10),
                                            CustomText(
                                              _storage.readName() ?? "...",
                                              customColor: _colors.primaryColor,
                                              fontWeight: FontWeight.bold,
                                              sizeOption:
                                                  TextSizeOptions.appBar,
                                            ),
                                            sizedBox(size: 10),
                                            SizedBox(
                                              width: screen.width * .7,
                                              child: Row(
                                                mainAxisAlignment:
                                                    MainAxisAlignment
                                                        .spaceEvenly,
                                                mainAxisSize: MainAxisSize.max,
                                                children: [
                                                  Expanded(
                                                    child: Row(
                                                      children: [
                                                        const Icon(Icons
                                                            .location_history),
                                                        const SizedBox(
                                                            width: 2),
                                                        Expanded(
                                                          child: CustomText(
                                                            _storage
                                                                        .readPradeshName()
                                                                        .toString() +
                                                                    ", " +
                                                                    _storage
                                                                        .readEnglishName()
                                                                        .toString() ??
                                                                "...",
                                                            maxLine: 2,
                                                            sizeOption:
                                                                TextSizeOptions
                                                                    .caption,
                                                            textAlign:
                                                                TextAlign.start,
                                                          ),
                                                        ),
                                                      ],
                                                    ),
                                                  ),
                                                  Expanded(
                                                    child: Row(
                                                      children: [
                                                        const Icon(Icons
                                                            .mobile_friendly),
                                                        const SizedBox(
                                                            width: 2),
                                                        Expanded(
                                                          child: CustomText(
                                                            _storage.readPhone() ??
                                                                "...",
                                                            sizeOption:
                                                                TextSizeOptions
                                                                    .caption,
                                                            textAlign:
                                                                TextAlign.start,
                                                          ),
                                                        ),
                                                      ],
                                                    ),
                                                  ),
                                                ],
                                              ),
                                            ),
                                            sizedBox(size: 10),
                                          ],
                                        ),
                                      ),
                                    ),
                                    Align(
                                      alignment: Alignment.bottomCenter,
                                      child: CustomButton(
                                        height: screen.height * .06,
                                        width: screen.width * .4,
                                        color: _colors.primaryColor,
                                        onPressed: () {
                                          Get.toNamed(_routes
                                              .organizationsIncludeFeedback);
                                        },
                                        child: Text(_strings.feedbackBtnTitle),
                                      ),
                                    )
                                  ],
                                ),
                              ),
                            ),
                          ],
                        ),
                      ),
                      sizedBox(),
                      Padding(
                        padding:
                            EdgeInsets.symmetric(horizontal: _dimens.padding),
                        child: CustomText(
                          "Survey Status",
                          textAlign: TextAlign.left,
                          fontWeight: FontWeight.bold,
                        ),
                      ),
                      sizedBox(),
                      Row(
                        mainAxisAlignment: MainAxisAlignment.spaceEvenly,
                        children: [
                          SurveyStatusWidget(
                              iconData: Icons.stop_screen_share,
                              title: "Assigned",
                              iconColor: Colors.red,
                              count: _dashboardController
                                  .surveyStatusModel?.assigned),
                          SurveyStatusWidget(
                              iconData: Icons.start,
                              title: "Started",
                              iconColor: Colors.cyan,
                              count: _dashboardController
                                  .surveyStatusModel?.started),
                          SurveyStatusWidget(
                              iconData: Icons.bookmark_added_sharp,
                              title: "Completed",
                              iconColor: Colors.green,
                              count: _dashboardController
                                  .surveyStatusModel?.completed),
                        ],
                      ),
                      sizedBox(),
                      Padding(
                        padding:
                            EdgeInsets.symmetric(horizontal: _dimens.padding),
                        child: CustomText(
                          "Recent Survey",
                          textAlign: TextAlign.left,
                          fontWeight: FontWeight.bold,
                        ),
                      ),
                      Padding(
                        padding:
                            EdgeInsets.symmetric(horizontal: _dimens.padding),
                        child: list.isEmpty
                            ? CustomText("There is no survey.")
                            : SizedBox(
                                height: screen.height * .5,
                                child: ListView.builder(
                                  padding:
                                      const EdgeInsets.symmetric(vertical: 10),
                                  itemCount: list.length,
                                  itemBuilder: (context, index) {
                                    return InkWell(
                                      onTap: () {
                                        Get.toNamed(_routes.organization,
                                            arguments: list[index].id);
                                      },
                                      child: Card(
                                        elevation: 0,
                                        color:
                                            Colors.blueAccent.withOpacity(.2),
                                        shape: RoundedRectangleBorder(
                                          borderRadius: BorderRadius.circular(
                                              _dimens.borderRadius),
                                        ),
                                        child: Padding(
                                          padding: EdgeInsets.all(
                                              _dimens.padding * 2.5),
                                          child: Row(
                                            children: [
                                              Expanded(
                                                child: Column(
                                                  children: [
                                                    CustomText(
                                                      list[index].surveyName,
                                                      maxLine: 3,
                                                      textAlign: TextAlign.left,
                                                      sizeOption:
                                                          TextSizeOptions
                                                              .underline,
                                                      fontWeight:
                                                          FontWeight.bold,
                                                    ),
                                                    const SizedBox(
                                                      height: 10,
                                                    ),
                                                    Row(
                                                      children: [
                                                        Expanded(
                                                          child: CustomText(
                                                            getYearOfDate(
                                                                list[index]
                                                                    .startDate),
                                                            customColor:
                                                                Colors.green,
                                                            sizeOption:
                                                                TextSizeOptions
                                                                    .caption,
                                                          ),
                                                        ),
                                                        const Text(" | "),
                                                        Expanded(
                                                          child: CustomText(
                                                            getYearOfDate(
                                                                list[index]
                                                                    .endDate),
                                                            customColor:
                                                                Colors.red,
                                                            sizeOption:
                                                                TextSizeOptions
                                                                    .caption,
                                                          ),
                                                        ),
                                                        const Expanded(
                                                            flex: 2,
                                                            child: SizedBox(
                                                              width: 1,
                                                            )),
                                                      ],
                                                    ),
                                                  ],
                                                ),
                                              ),
                                              IconButton(
                                                  onPressed: () {
                                                    Get.toNamed(
                                                        _routes.organization,
                                                        arguments:
                                                            list[index].id);
                                                  },
                                                  icon: Icon(
                                                    Icons.arrow_circle_right,
                                                    size: 30,
                                                    color: _colors.primaryColor,
                                                  ))
                                            ],
                                          ),
                                        ),
                                      ),
                                    );
                                  },
                                ),
                              ),
                      ),
                    ],
                  ),
                );
    });
  }

  customSizedBox() => const SizedBox(
        height: 10,
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
        " , " +
        dt.day.toString();
  }
}

class SurveyStatusWidget extends StatelessWidget {
  const SurveyStatusWidget(
      {Key? key,
      required this.iconData,
      required this.title,
      required this.iconColor,
      required this.count})
      : super(key: key);

  final IconData iconData;
  final String title;
  final int? count;
  final Color iconColor;

  @override
  Widget build(BuildContext context) {
    return Column(
      children: [
        Card(
            elevation: 6,
            shape:
                RoundedRectangleBorder(borderRadius: BorderRadius.circular(20)),
            child: Padding(
              padding:
                  const EdgeInsets.symmetric(horizontal: 40.0, vertical: 12),
              child: Column(
                mainAxisAlignment: MainAxisAlignment.spaceEvenly,
                children: [
                  Icon(
                    iconData,
                    color: iconColor,
                  ),
                  sizedBox(size: 5),
                  Text(
                    count == null ? "0" : count.toString(),
                    style: TextStyle(
                      fontSize: 23,
                      fontWeight: FontWeight.bold,
                    ),
                  ),
                ],
              ),
            )),
        sizedBox(size: 12),
        Text(
          title,
          style: TextStyle(
            fontSize: 19,
          ),
        )
      ],
    );
  }
}
