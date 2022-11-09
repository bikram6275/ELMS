import 'package:dio/dio.dart' as D;
import 'package:elms/models/feedback/feedback_model.dart';
import 'package:get/get.dart';
import 'package:hive/hive.dart';

import '../../constant/api_path.dart';
import '../../constant/app_routes.dart';
import '../../constant/app_strings.dart';
import '../../infrastructure/api_service/api_service.dart';
import '../../infrastructure/custom_storage/custom_storage.dart';
import '../../infrastructure/hive_database/hive_keys.dart';
import '../../utils/connection_status/connection_status.dart';

class FeedbackController extends GetxController {
  final ApiService _apiService = Get.find();
  final ApiPath _path = Get.find();
  final AppStrings _strings = Get.find();
  final AppRoutes _routes = Get.find();
  final CustomStorage _storage = Get.find();

  late Box box;
  String? pivotId = Get.arguments;
  RxList<FeedbackItemModel> feedbacks = <FeedbackItemModel>[].obs;

  RxBool getFeedbacksLoading = false.obs;
  RxBool getFeedbacksError = false.obs;

  @override
  void onInit() async {
    box = await Hive.openBox("db");

    checkAndOnInit();
    super.onInit();
  }

  checkAndOnInit() async {
    bool internetStatus = await ConnectionStatus.checkConnection();
    if (internetStatus) {
      getFeedbacks();
    } else {
      getFeedbacksOffline();
    }
  }

  getFeedbacks() async {
    try {
      getFeedbacksLoading(true);
      getFeedbacksError(false);
      feedbacks.clear();

      D.Response? response = await _apiService.get(
        path: _path.feedbacks.replaceAll("{{pivot_id}}", pivotId.toString()),
        needToken: true,
      );

      if (response != null) {
        getFeedbacksLoading(false);

        FeedbackModel items = FeedbackModel.fromJson(response.data);

        feedbacks.addAll(items.data);

        // save organizations in the hive
        box.put(HiveKeys.feedbacks + pivotId.toString(), response.data);
      } else {
        getFeedbacksError(true);
      }
    } catch (e) {
      getFeedbacksLoading(false);
      getFeedbacksError(true);
    }
  }

  getFeedbacksOffline() {
    getFeedbacksLoading(true);
    feedbacks.clear();
    var data = box.get(HiveKeys.feedbacks + pivotId.toString());

    FeedbackModel items = FeedbackModel.fromJson(data);

    feedbacks.addAll(items.data);

    getFeedbacksLoading(false);
  }
}
