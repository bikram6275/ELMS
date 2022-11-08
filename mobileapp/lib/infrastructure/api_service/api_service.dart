// ignore_for_file: avoid_print, library_prefixes

import 'package:dio/dio.dart' as D;
import 'package:elms/constant/app_strings.dart';
import 'package:elms/infrastructure/custom_storage/custom_storage.dart';
import 'package:get/get.dart';

import '../../utils/snackbar/snackbar.dart';

class ApiService {
  final D.Dio _dio = Get.find();
  final AppStrings _appStrings = Get.find();
  final CustomStorage _storage = Get.find();

  handleErrors(D.Response response) {
    switch (response.statusCode) {
      case 422:
        snackBar(_appStrings.failedTitle, response.data["message"],
            error: true);
        break;
      case 404:
        snackBar(_appStrings.failedTitle, response.data["message"],
            error: true);
        break;
      case 400:
        snackBar(_appStrings.failedTitle, "Problem occuerd please try again!",
            error: true);
        break;
      case 403:
        snackBar(_appStrings.failedTitle, response.data["message"],
            error: true);
        break;
      case 409:
        snackBar(_appStrings.failedTitle, "Please check network and try again!",
            error: true);
        break;
      case 429:
        snackBar(_appStrings.failedTitle, "Too many request! please try later.",
            error: true);
        break;
    }
  }

  Future? get({
    required String path,
    Map<String, dynamic>? parameters,
    required bool needToken,
  }) async {
    try {
      D.Response response = await _dio.get(
        path,
        queryParameters: parameters ?? {},
        options: D.Options(
            headers: needToken
                ? {
                    "Content-Type": "application/json",
                    "Accept": "application/json",
                    "Authorization": "Bearer ${_storage.readToken()}",
                  }
                : {
                    "Content-Type": "application/json",
                    "Accept": "application/json",
                  }),
      );

      if (response.statusCode == 200) {
        return response;
      } else {
        handleErrors(response);
      }
    } catch (e, s) {
      print(e);
      print(s);
    }
  }

  Future? post({
    required String path,
    formData,
    Map<String, dynamic>? parameters,
    required bool needToken,
  }) async {
    try {
      D.Response response = await _dio.post(
        path,
        queryParameters: parameters ?? {},
        data: formData ?? {},
        options: D.Options(
            headers: needToken
                ? {
                    "Content-Type": "application/json",
                    "Accept": "application/json",
                    "Authorization": "Bearer ${_storage.readToken()}",
                  }
                : {
                    "Content-Type": "application/json",
                    "Accept": "application/json",
                  }),
      );

      if (response.statusCode == 200) {
        return response;
      } else {
        handleErrors(response);
      }
    } catch (e, s) {
      print(e);
      print(s);
    }
  }

  Future? put({
    required String path,
    Map<String, dynamic>? formData,
    Map<String, dynamic>? parameters,
    required bool needToken,
  }) async {
    try {
      D.Response response = await _dio.put(
        path,
        queryParameters: parameters ?? {},
        data: formData ?? {},
        options: D.Options(
            headers: needToken
                ? {
                    "Content-Type": "application/json",
                    "Accept": "application/json",
                    "Authorization": "Bearer ${_storage.readToken()}",
                  }
                : {
                    "Content-Type": "application/json",
                    "Accept": "application/json",
                  }),
      );

      if (response.statusCode == 200) {
        return response;
      } else {
        handleErrors(response);
      }
    } catch (e, s) {
      print(e);
      print(s);
    }
  }

  Future? delete({
    required String path,
    Map<String, dynamic>? formData,
    Map<String, dynamic>? parameters,
    required bool needToken,
  }) async {
    try {
      D.Response response = await _dio.delete(
        path,
        queryParameters: parameters ?? {},
        data: formData ?? {},
        options: D.Options(
            headers: needToken
                ? {
                    "Content-Type": "application/json",
                    "Accept": "application/json",
                    "Authorization": "Bearer ${_storage.readToken()}",
                  }
                : {
                    "Content-Type": "application/json",
                    "Accept": "application/json",
                  }),
      );

      if (response.statusCode == 200) {
        return response;
      } else {
        handleErrors(response);
      }
    } catch (e, s) {
      print(e);
      print(s);
    }
  }
}
