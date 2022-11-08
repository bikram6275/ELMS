import 'package:elms/constant/app_colors.dart';
import 'package:elms/constant/app_dimens.dart';
import 'package:elms/constant/app_routes.dart';
import 'package:elms/constant/app_strings.dart';
import 'package:elms/features/dashboard/dashboard_controller.dart';
import 'package:elms/features/survey_question/components/custom_size_box.dart';
import 'package:elms/global_widgets/custom_button/custom_button.dart';
import 'package:elms/global_widgets/custom_drawer/custom_drawer.dart';
import 'package:elms/global_widgets/custom_indicator/custom_indicator.dart';
import 'package:elms/infrastructure/custom_storage/custom_storage.dart';
import 'package:elms/models/survey/survey_model.dart';
import 'package:elms/utils/custom_text/custom_text.dart';
import 'package:flutter/material.dart';
import 'package:get/get.dart';

class DashboardPage extends GetResponsiveView {
  DashboardPage({Key? key}) : super(key: key);

  final AppStrings _strings = Get.find();
  final AppRoutes _routes = Get.find();
  final AppColors _colors = Get.find();
  final AppDimens _dimens = Get.find();
  final CustomStorage _storage = Get.find();

  final GlobalKey<ScaffoldState> _key = GlobalKey();

  final DashboardController _dashboardController = Get.find();

  @override
  Widget? builder() {
    return Scaffold(
      key: _key,
      appBar: AppBar(
        title: Text(
          _strings.dashboardTitle,
        ),
        centerTitle: true,
        actions: [
          IconButton(
              onPressed: () => _dashboardController.onInit(),
              icon: const Icon(Icons.refresh)),
        ],
      ),
      drawer: Drawer(
        child: CustomDrawer(
          drawerKey: _key,
        ),
      ),
      body: ui(),
    );
  }

  bottomBar() => Container(
        width: screen.width,
        height: 80,
        color: _colors.primaryColor,
        child: Padding(
          padding: EdgeInsets.all(_dimens.padding * 2),
          child: Row(
            mainAxisAlignment: MainAxisAlignment.spaceBetween,
            children: [
              CustomButton(
                child: Text(_strings.backBtn),
                color: _colors.buttonColor,
                onPressed: () {},
              ),
              CustomButton(
                child: Text(_strings.nextBtn),
                color: _colors.buttonColor,
                onPressed: () {},
              ),
            ],
          ),
        ),
      );

  ui() => Obx(() {
        bool loading = (_dashboardController.getRecentSurveyLoading.value ||
            _dashboardController.getProductsLoading.value ||
            _dashboardController.getSectorLoading.value ||
            _dashboardController.getOccupationLoading.value ||
            _dashboardController.getAboutInfoLoading.value);

        bool error = (_dashboardController.getRecentSurveyError.value ||
            _dashboardController.getProductsError.value ||
            _dashboardController.getSectorError.value ||
            _dashboardController.getOccupationError.value ||
            _dashboardController.getAboutInfoError.value);

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
                : surveyWidget();
      });

  customSizedBox() => const SizedBox(
        height: 10,
      );

  surveyWidget() {
    List<SurveyModel> list = _dashboardController.recentSurveyList;
    return Padding(
      padding: EdgeInsets.all(_dimens.padding),
      child: Column(
        children: [
          Card(
            elevation: 0,
            color: _colors.cardBackground.withOpacity(.9),
            shape: RoundedRectangleBorder(
              borderRadius: BorderRadius.circular(_dimens.borderRadius),
            ),
            child: Padding(
              padding: EdgeInsets.symmetric(vertical: _dimens.padding * 5),
              child: Row(
                children: [
                  Expanded(
                    child: Column(
                      children: [
                        CustomText(
                          "Welcome",
                          sizeOption: TextSizeOptions.title,
                          fontWeight: FontWeight.w300,
                        ),
                        CustomText(
                          _storage.readName() + " !",
                          sizeOption: TextSizeOptions.body,
                          fontWeight: FontWeight.bold,
                        ),
                      ],
                    ),
                  ),
                  Expanded(
                    child: Icon(
                      Icons.account_circle,
                      size: 100,
                      color: _colors.button2Color,
                    ),
                  ),
                ],
              ),
            ),
          ),
          sizedBox(),
          CustomText(
            "Recent Survey :",
            textAlign: TextAlign.left,
          ),
          sizedBox(),
          Expanded(
            child: list.isEmpty
                ? CustomText("There is no survey.")
                : ListView.builder(
                    itemCount: list.length,
                    itemBuilder: (context, index) {
                      return InkWell(
                        onTap: () {
                          Get.toNamed(_routes.organization,
                              arguments: list[index].id);
                        },
                        child: Card(
                          elevation: 0,
                          color: _colors.cardBackground.withOpacity(.9),
                          shape: RoundedRectangleBorder(
                            borderRadius:
                                BorderRadius.circular(_dimens.borderRadius),
                          ),
                          child: Padding(
                            padding: EdgeInsets.all(_dimens.padding * 2),
                            child: Column(
                              children: [
                                CustomText(
                                  list[index].surveyName,
                                  maxLine: 3,
                                  textAlign: TextAlign.left,
                                  sizeOption: TextSizeOptions.underline,
                                  fontWeight: FontWeight.bold,
                                ),
                                const SizedBox(
                                  height: 10,
                                ),
                                Row(
                                  children: [
                                    Expanded(
                                      child: CustomText(
                                        getYearOfDate(list[index].startDate),
                                        customColor: Colors.green,
                                        sizeOption: TextSizeOptions.caption,
                                      ),
                                    ),
                                    const Text(" | "),
                                    Expanded(
                                      child: CustomText(
                                        getYearOfDate(list[index].endDate),
                                        customColor: Colors.red,
                                        sizeOption: TextSizeOptions.caption,
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
                        ),
                      );
                    },
                  ),
          ),
        ],
      ),
    );
  }

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
