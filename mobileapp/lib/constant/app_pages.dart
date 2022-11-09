import 'package:elms/features/about_us_page/about_us_page.dart';
import 'package:elms/features/dashboard/dashboard_page.dart';
import 'package:elms/features/feedback/feedback_page.dart';
import 'package:elms/features/feedback/organizations_include_feedback_page.dart';
import 'package:elms/features/forget_password/forget_password_page.dart';
import 'package:elms/features/login/login_page.dart';
import 'package:elms/features/organization/organization_page.dart';
import 'package:elms/features/reset_password/reset_password_page.dart';
import 'package:elms/features/survey_question/components/question_6a/components/edit_added_item_page.dart';
import 'package:elms/features/survey_question/survey_question_page.dart';
import 'package:elms/features/view_survey/view_survey_page.dart';
import 'package:get/get.dart';

import '../features/profile/profile_page.dart';
import 'app_routes.dart';

class AppPages {
  static AppRoutes routes = Get.find();

  final pages = [
    GetPage(
      name: routes.surveyQuestion,
      page: () => SurveyQuestionPage(
        values: Get.arguments,
      ),
    ),
    GetPage(
      name: routes.editItem,
      page: () => EditAddedItemPage(data: Get.arguments),
    ),
    GetPage(
      name: routes.feedback,
      page: () => FeedbackPage(pivotId: Get.arguments),
    ),
    GetPage(
      name: routes.organizationsIncludeFeedback,
      page: () => OrganizationsIncludeFeedbackPage(),
    ),
    GetPage(
      name: routes.dashboard,
      page: () => DashboardPage(),
    ),
    GetPage(
      name: routes.profile,
      page: () => const ProfilePage(),
    ),
    GetPage(
      name: routes.login,
      page: () => LoginPage(),
    ),
    GetPage(
      name: routes.forgetPassword,
      page: () => ForgetPasswordPage(),
    ),
    GetPage(
      name: routes.resetPassword,
      page: () => ResetPasswordPage(),
    ),
    GetPage(
      name: routes.viewSurvey,
      page: () => ViewSurveyPage(
        values: Get.arguments,
      ),
    ),
    GetPage(
      name: routes.organization,
      page: () => OrganizationPage(
        surveyId: Get.arguments,
      ),
    ),
    GetPage(
      name: routes.about,
      page: () => AboutUsPage(),
    ),
  ];
}
