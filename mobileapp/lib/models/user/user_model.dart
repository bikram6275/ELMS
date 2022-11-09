import 'dart:convert';

UserModel userModelFromJson(String str) => UserModel.fromJson(json.decode(str));

String userModelToJson(UserModel data) => json.encode(data.toJson());

class UserModel {
  UserModel({
    required this.user,
    required this.token,
    required this.expiresIn,
  });

  final User user;
  final String token;
  final String expiresIn;

  factory UserModel.fromJson(Map<String, dynamic> json) => UserModel(
        user: User.fromJson(json["user"]),
        token: json["token"],
        expiresIn: json["expires_in"],
      );

  Map<String, dynamic> toJson() => {
        "user": user.toJson(),
        "token": token,
        "expires_in": expiresIn,
      };
}

class User {
  User({
    required this.id,
    required this.name,
    required this.email,
    required this.userStatus,
    required this.phoneNo,
    required this.pradesh,
    required this.district,
    required this.createdAt,
    required this.updatedAt,
    required this.pradeshId,
    required this.districtId,
    required this.muniId,
    required this.wardNo,
  });

  final int id;
  final String? name;
  final String? email;
  final String? userStatus;
  final String? phoneNo;
  final DateTime createdAt;
  final DateTime updatedAt;
  final Map pradesh;
  final Map district;
  final int? pradeshId;
  final int? districtId;
  final int? muniId;
  final int? wardNo;

  factory User.fromJson(Map<String, dynamic> json) => User(
        id: json["id"],
        name: json["name"] ?? "-",
        email: json["email"] ?? "-",
        district: json["district"],
        pradesh: json["pradesh"],
        userStatus: json["user_status"] ?? "-",
        phoneNo: json["phone_no"] ?? "-",
        createdAt: DateTime.parse(json["created_at"]),
        updatedAt: DateTime.parse(json["updated_at"]),
        pradeshId: json["pradesh_id"] ?? 0,
        districtId: json["district_id"] ?? 0,
        muniId: json["muni_id"] ?? 0,
        wardNo: json["ward_no"] ?? 0,
      );

  Map<String, dynamic> toJson() => {
        "id": id,
        "name": name,
        "email": email,
        "user_status": userStatus,
        "phone_no": phoneNo,
        "created_at": createdAt.toIso8601String(),
        "updated_at": updatedAt.toIso8601String(),
        "pradesh_id": pradeshId,
        "district_id": districtId,
        "muni_id": muniId,
        "ward_no": wardNo,
      };
}
