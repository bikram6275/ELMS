class OrganizationsIncludeFeedbackModel {
  OrganizationsIncludeFeedbackModel({
    required this.data,
  });

  late final List<OrganizationsIncludeFeedbackItemModel> data;

  OrganizationsIncludeFeedbackModel.fromJson(json) {
    data = List.from(json['data'])
        .map((e) => OrganizationsIncludeFeedbackItemModel.fromJson(e))
        .toList();
  }

  Map<String, dynamic> toJson() {
    final _data = <String, dynamic>{};
    _data['data'] = data.map((e) => e.toJson()).toList();
    return _data;
  }
}

class OrganizationsIncludeFeedbackItemModel {
  OrganizationsIncludeFeedbackItemModel({
    required this.id,
    required this.orgName,
    required this.phoneNo,
    required this.establishDate,
    required this.pivotId,
    required this.districtName,
    required this.sector,
    required this.status,
    required this.surveyStatus,
  });

  late final int id;
  late final String orgName;
  late final String phoneNo;
  late final String establishDate;
  late final int pivotId;
  late final String districtName;
  late final String sector;
  late final String status;
  late final String surveyStatus;

  OrganizationsIncludeFeedbackItemModel.fromJson(json) {
    id = json['id'];
    orgName = json['org_name'];
    phoneNo = json['phone_no'];
    establishDate = json['establish_date'];
    pivotId = json['pivot_id'];
    districtName = json['district_name'];
    sector = json['sector'];
    status = json['status'];
    surveyStatus = json['survey_status'];
  }

  Map<String, dynamic> toJson() {
    final _data = <String, dynamic>{};
    _data['id'] = id;
    _data['org_name'] = orgName;
    _data['phone_no'] = phoneNo;
    _data['establish_date'] = establishDate;
    _data['pivot_id'] = pivotId;
    _data['district_name'] = districtName;
    _data['sector'] = sector;
    _data['status'] = status;
    _data['survey_status'] = surveyStatus;
    return _data;
  }
}
