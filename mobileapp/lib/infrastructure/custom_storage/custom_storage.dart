import 'package:get/get.dart';
import 'package:get_storage/get_storage.dart';

class CustomStorage {
  final token = "/token";
  final userStatus = "/userStatus";
  final phoneNum = "/phoneNum";
  final expTokenTime = "/expTokenTime";
  final email = "/email";
  final name = "/name";
  final userId = "/id";
  final subSecId = "/subSecId";
  final syncOnline = "/syncOnline";
  final pradeshName = "/pradesh_name";
  final englishName = "/english_name";

  final GetStorage _storage = Get.find();

  saveEmail(e) {
    _storage.write(email, e);
  }

  readEmail() {
    return _storage.read(email);
  }

  savePradeshName(name) {
    _storage.write(pradeshName, name);
  }

  readPradeshName() {
    return _storage.read(pradeshName);
  }

  removePradeshName() {
    _storage.remove(pradeshName);
  }

  saveEnglishName(name) {
    _storage.write(englishName, name);
  }

  readEnglishName() {
    return _storage.read(englishName);
  }

  removeEnglishName() {
    _storage.remove(englishName);
  }

  saveSyncOnline() {
    _storage.write(syncOnline, true);
  }

  readSyncOnline() {
    return _storage.read(syncOnline);
  }

  removeSyncOnline() {
    _storage.remove(syncOnline);
  }

  saveSubSecId(value) {
    _storage.write(subSecId, value);
  }

  readSubSecId() {
    return _storage.read(subSecId);
  }

  removeSubSecId() {
    _storage.remove(subSecId);
  }

  saveUserId(id) {
    _storage.write(userId, id);
  }

  readUserId() {
    return _storage.read(userId);
  }

  removeUserId() {
    _storage.remove(userId);
  }

  saveName(data) {
    _storage.write(name, data);
  }

  readName() {
    return _storage.read(name);
  }

  removeName() {
    _storage.remove(name);
  }

  saveExpTokenTime(time) {
    _storage.write(expTokenTime, time);
  }

  readExpTokenTime() {
    return _storage.read(expTokenTime);
  }

  removeExpTokenTime() {
    _storage.remove(expTokenTime);
  }

  savePhone(phone) {
    _storage.write(phoneNum, phone);
  }

  readPhone() {
    return _storage.read(phoneNum);
  }

  removePhone() {
    _storage.remove(phoneNum);
  }

  saveUserStatus(status) {
    _storage.write(userStatus, status);
  }

  readUserStatus() {
    return _storage.read(userStatus);
  }

  removeUserStatus() {
    _storage.remove(userStatus);
  }

  saveToken(data) {
    _storage.write(token, data);
  }

  readToken() {
    return _storage.read(token);
  }

  removeToken() {
    _storage.remove(token);
  }
}
