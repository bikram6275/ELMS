// To parse this JSON data, do
//
//     final organizationModel = organizationModelFromJson(jsonString);

import 'dart:convert';

List<OrganizationModel> organizationModelFromJson(List str) =>
    List<OrganizationModel>.from(str.map((x) => OrganizationModel.fromJson(x)));

String organizationModelToJson(List<OrganizationModel> data) =>
    json.encode(List<dynamic>.from(data.map((x) => x.toJson())));

class OrganizationModel {
  OrganizationModel({
    required this.id,
    required this.orgName,
    required this.phoneNo,
    required this.establishDate,
    required this.pivotId,
    required this.status,
    required this.sector,
    required this.districtName,
  });

  final int id;
  final String orgName;
  final String? phoneNo;
  final String? establishDate;
  final int pivotId;
  String status;
  final String sector;
  final String districtName;

  factory OrganizationModel.fromJson(json) => OrganizationModel(
        id: json["id"],
        orgName: json["org_name"],
        phoneNo: json["phone_no"],
        establishDate: json["establish_date"],
        pivotId: json["pivot_id"],
        status: json["status"] ?? "Not Started",
        sector: json["sector"],
        districtName: json["district_name"],
      );

  Map<String, dynamic> toJson() => {
        "id": id,
        "org_name": orgName,
        "phone_no": phoneNo,
        "establish_date": establishDate,
        "pivot_id": pivotId,
        "status": status,
        "sector": sector,
        "district_name": districtName,
      };
}
