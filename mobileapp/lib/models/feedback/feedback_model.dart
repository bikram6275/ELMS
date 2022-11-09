class FeedbackModel {
  FeedbackModel({
    required this.data,
  });

  late final List<FeedbackItemModel> data;

  FeedbackModel.fromJson(json) {
    data = List.from(json['data'])
        .map((e) => FeedbackItemModel.fromJson(e))
        .toList();
  }

  Map<String, dynamic> toJson() {
    final _data = <String, dynamic>{};
    _data['data'] = data.map((e) => e.toJson()).toList();
    return _data;
  }
}

class FeedbackItemModel {
  FeedbackItemModel({
    required this.id,
    required this.status,
    required this.remarks,
  });

  late final int id;
  late final String status;
  late final String remarks;

  FeedbackItemModel.fromJson(json) {
    id = json['id'];
    status = json['status'];
    remarks = json['remarks'];
  }

  Map<String, dynamic> toJson() {
    final _data = <String, dynamic>{};
    _data['id'] = id;
    _data['status'] = status;
    _data['remarks'] = remarks;
    return _data;
  }
}
