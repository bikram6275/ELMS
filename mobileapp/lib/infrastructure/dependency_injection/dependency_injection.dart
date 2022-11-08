import 'package:dio/dio.dart';
import 'package:dio_logging_interceptor/dio_logging_interceptor.dart';
import 'package:elms/constant/api_path.dart';
import 'package:elms/constant/app_colors.dart';
import 'package:elms/constant/app_dimens.dart';
import 'package:elms/constant/app_pages.dart';
import 'package:elms/constant/app_routes.dart';
import 'package:elms/constant/app_strings.dart';
import 'package:elms/constant/app_theme.dart';
import 'package:elms/features/about_us_page/about_us_controller.dart';
import 'package:elms/features/dashboard/dashboard_controller.dart';
import 'package:elms/features/forget_password/forget_password_controller.dart';
import 'package:elms/features/login/login_controller.dart';
import 'package:elms/features/organization/organization_controller.dart';
import 'package:elms/features/reset_password/reset_password_controller.dart';
import 'package:elms/features/survey_question/components/check_box_question/check_box_question_controller.dart';
import 'package:elms/features/survey_question/components/condition_radio_question/condition_radio_question_controller.dart';
import 'package:elms/features/survey_question/components/input_questions/input_question_controller.dart';
import 'package:elms/features/survey_question/components/multiple_input_question/multiple_input_question_controller.dart';
import 'package:elms/features/survey_question/components/question_13/question_13_controller.dart';
import 'package:elms/features/survey_question/components/question_5/question_5_controller.dart';
import 'package:elms/features/survey_question/components/question_6a/question_6a_controller.dart';
import 'package:elms/features/survey_question/components/question_6b/question_6b_controller.dart';
import 'package:elms/features/survey_question/components/radio_question/radio_question_controller.dart';
import 'package:elms/features/survey_question/components/sector_question/sector_quetion_controller.dart';
import 'package:elms/features/survey_question/components/service_question/service_question_controller.dart';
import 'package:elms/features/survey_question/components/sub_questions/sub_question_controller.dart';
import 'package:elms/features/survey_question/survey_question_controller.dart';
import 'package:elms/features/view_survey/view_survey_controllers.dart';
import 'package:elms/infrastructure/api_service/api_service.dart';
import 'package:elms/infrastructure/custom_storage/custom_storage.dart';
import 'package:elms/infrastructure/global_controller/global_controller.dart';
import 'package:elms/infrastructure/hive_database/answer_hive_object.dart';
import 'package:get/get.dart';
import 'package:get_storage/get_storage.dart';
import 'package:hive_flutter/hive_flutter.dart';

class DependencyInjection {
  static Future injectDependencies() async {
    await Hive.initFlutter();
    Hive.registerAdapter(AnswerHiveObjectAdapter());
    // inject storage
    Get.put(GetStorage());
    Get.put(CustomStorage());

    // injdect constant class
    Get.put(ApiPath());
    Get.put(AppColors());
    Get.put(AppRoutes());
    Get.put(AppStrings());
    Get.put(AppPages());
    Get.put(AppDimens());
    Get.put(AppTheme());

    // inject dio
    ApiPath path = Get.find();
    Dio dio;
    BaseOptions baseOptions = BaseOptions(
      baseUrl: path.baseUrl,
      receiveTimeout: 7000,
      connectTimeout: 7000,
      sendTimeout: 5000,
      validateStatus: (status) {
        return status! < 500;
      },
    );
    dio = Dio(baseOptions);
    dio.interceptors.add(
      DioLoggingInterceptor(
        level: Level.body,
        compact: false,
      ),
    );
    Get.put(dio);

    // inject api service
    Get.put(ApiService());

    // inject controllers
    Get.put(GlobalController());
    Get.lazyPut(() => LoginController(), fenix: true);
    Get.lazyPut(() => ViewSurveyController(), fenix: true);
    Get.lazyPut(() => DashboardController(), fenix: true);
    Get.lazyPut(() => ForgetPasswordController(), fenix: true);
    Get.lazyPut(() => ResetPasswordController(), fenix: true);
    Get.lazyPut(() => SurveyQuestionController(), fenix: true);
    Get.lazyPut(() => OrganizationController(), fenix: true);
    Get.lazyPut(() => ConditionRadioQuestionController(), fenix: true);
    Get.lazyPut(() => RadioQuestionController(), fenix: true);
    Get.lazyPut(() => Question13Controller(), fenix: true);
    Get.lazyPut(() => Question5Controller(), fenix: true);
    Get.lazyPut(() => InputQuestionController(), fenix: true);
    Get.lazyPut(() => SubQuestionController(), fenix: true);
    Get.lazyPut(() => CheckBoxQuestionController(), fenix: true);
    Get.lazyPut(() => MultipleInputQuestionController(), fenix: true);
    Get.lazyPut(() => Question6aController(), fenix: true);
    Get.lazyPut(() => Question6bController(), fenix: true);
    Get.lazyPut(() => SectorQuestionController(), fenix: true);
    Get.lazyPut(() => ServiceQuestionController(), fenix: true);
    Get.lazyPut(() => AboutUsController(), fenix: true);
  }
}
