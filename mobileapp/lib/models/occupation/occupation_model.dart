// To parse this JSON data, do
//
//     final occupationModel = occupationModelFromJson(jsonString);

import 'dart:convert';

OccupationModel occupationModelFromJson(String str) =>
    OccupationModel.fromJson(json.decode(str));

String occupationModelToJson(OccupationModel data) =>
    json.encode(data.toJson());

class OccupationModel {
  OccupationModel({
    required this.id,
    required this.occupationName,
    required this.sectorId,
  });

  final int id;
  final String occupationName;
  final int? sectorId;

  factory OccupationModel.fromJson(json) => OccupationModel(
        id: json["id"],
        occupationName: json["occupation_name"],
        sectorId: json["sector_id"],
      );

  Map<String, dynamic> toJson() => {
        "id": id,
        "occupation_name": occupationName,
        "sector_id": sectorId,
      };
}
