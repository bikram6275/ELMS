import 'package:dio/dio.dart' as D;
import 'package:elms/infrastructure/hive_database/hive_keys.dart';
import 'package:elms/models/feedback/organizations_include_feedback_model.dart';
import 'package:get/get.dart';
import 'package:hive/hive.dart';

import '../../constant/api_path.dart';
import '../../constant/app_routes.dart';
import '../../constant/app_strings.dart';
import '../../infrastructure/api_service/api_service.dart';
import '../../infrastructure/custom_storage/custom_storage.dart';
import '../../utils/connection_status/connection_status.dart';

class OrganizationsIncludeFeedbackController extends GetxController {
  final ApiService _apiService = Get.find();
  final ApiPath _path = Get.find();
  final AppStrings _strings = Get.find();
  final AppRoutes _routes = Get.find();
  final CustomStorage _storage = Get.find();

  late Box box;

  RxList<OrganizationsIncludeFeedbackItemModel> organizations =
      <OrganizationsIncludeFeedbackItemModel>[].obs;

  RxBool getOrganizationsLoading = false.obs;
  RxBool getOrganizationsError = false.obs;

  RxBool getOrganizationFeedbackLoading = false.obs;
  RxBool getOrganizationFeedbackError = false.obs;

  @override
  void onInit() async {
    box = await Hive.openBox("db");

    checkAndOnInit();
    super.onInit();
  }

  checkAndOnInit() async {
    bool internetStatus = await ConnectionStatus.checkConnection();
    if (internetStatus) {
      getOrganizationsIncludeFeedback();
    } else {
      getOrganizationsIncludeFeedbackOffline();
    }
  }

  getOrganizationsIncludeFeedbackOffline() {
    getOrganizationsLoading(true);
    organizations.clear();
    var data = box.get(HiveKeys.organizationsIncludeFeedback);

    OrganizationsIncludeFeedbackModel items =
        OrganizationsIncludeFeedbackModel.fromJson(data);

    organizations.addAll(items.data);

    getOrganizationsLoading(false);
  }

  getOrganizationsIncludeFeedback() async {
    try {
      getOrganizationsLoading(true);
      getOrganizationsError(false);
      organizations.clear();

      D.Response? response = await _apiService.get(
        path: _path.organizationsIncludeFeedback,
        needToken: true,
      );

      if (response != null) {
        getOrganizationsLoading(false);

        OrganizationsIncludeFeedbackModel items =
            OrganizationsIncludeFeedbackModel.fromJson(response.data);

        organizations.addAll(items.data);

        // save organizations in the hive
        box.put(HiveKeys.organizationsIncludeFeedback, response.data);
      } else {
        getOrganizationsError(true);
      }
    } catch (e) {
      getOrganizationsLoading(false);
      getOrganizationsError(true);
    }
  }

  getFeedbacks() async {
    try {} catch (e) {}
  }
}
