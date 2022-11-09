class DistrictModel {
  DistrictModel({
    required this.id,
    required this.pradeshId,
    required this.englishName,
    required this.nepaliName,
  });

  late final int id;
  late final int pradeshId;
  late final String englishName;
  late final String nepaliName;

  DistrictModel.fromJson(json) {
    id = json['id'];
    pradeshId = json['pradesh_id'];
    englishName = json['english_name'];
    nepaliName = json['nepali_name'];
  }

  Map<String, dynamic> toJson() {
    final _data = <String, dynamic>{};
    _data['id'] = id;
    _data['pradesh_id'] = pradeshId;
    _data['english_name'] = englishName;
    _data['nepali_name'] = nepaliName;
    return _data;
  }
}

class PradeshModel {
  PradeshModel({
    required this.id,
    required this.pradeshName,
  });

  late final int id;
  late final String pradeshName;

  PradeshModel.fromJson(Map<String, dynamic> json) {
    id = json['id'];
    pradeshName = json['pradesh_name'];
  }

  Map<String, dynamic> toJson() {
    final _data = <String, dynamic>{};
    _data['id'] = id;
    _data['pradesh_name'] = pradeshName;
    return _data;
  }
}

class SectorModel {
  SectorModel({
    required this.id,
    required this.sectorName,
  });

  late final int id;
  late final String sectorName;

  SectorModel.fromJson(Map<String, dynamic> json) {
    id = json['id'];
    sectorName = json['sector_name'];
  }

  Map<String, dynamic> toJson() {
    final _data = <String, dynamic>{};
    _data['id'] = id;
    _data['sector_name'] = sectorName;
    return _data;
  }
}
