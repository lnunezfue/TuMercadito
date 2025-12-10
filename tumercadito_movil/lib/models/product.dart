class Product {
  final int id;
  final String nombre;
  final String? unidad; // Nuevo
  final String? categoria; // Nuevo

  Product({
    required this.id,
    required this.nombre,
    this.unidad,
    this.categoria,
  });

  factory Product.fromJson(Map<String, dynamic> json) {
    return Product(
      id: int.parse(json['id_producto'].toString()),
      nombre: json['nombre'],
      unidad: json['unidad_medida'], // Asegúrate que coincida con tu BD
      categoria: json['categoria'],
    );
  }
}
