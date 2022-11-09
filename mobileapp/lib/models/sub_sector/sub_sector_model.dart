class SectorModel {
  SectorModel({
    required this.id,
    required this.subSectorName,
    required this.sectorId,
  });

  final int id;
  final String subSectorName;
  final int sectorId;

  factory SectorModel.fromJson(json) => SectorModel(
        id: json["id"],
        subSectorName: json["sub_sector_name"],
        sectorId: json["sector_id"],
      );

  Map<String, dynamic> toJson() => {
        "id": id,
        "sub_sector_name": subSectorName,
        "sector_id": sectorId,
      };
}
