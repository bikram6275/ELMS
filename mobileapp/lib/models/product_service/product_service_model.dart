class ProductAndService {
  ProductAndService({
    required this.id,
    required this.productAndServicesName,
    required this.subSectorId,
  });

  final int id;
  final String productAndServicesName;
  final int subSectorId;

  factory ProductAndService.fromJson(json) => ProductAndService(
        id: json["id"],
        productAndServicesName: json["product_and_services_name"],
        subSectorId: json["sub_sector_id"],
      );

  Map<String, dynamic> toJson() => {
        "id": id,
        "product_and_services_name": productAndServicesName,
        "sub_sector_id": subSectorId,
      };
}
