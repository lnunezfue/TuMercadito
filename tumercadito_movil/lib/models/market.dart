class Market {
  final int id;
  final String nombre;
  final String? distrito; // Puede ser null
  final String? direccion; // Puede ser null
  bool isFavorite; // Mutable para cambiarlo en la app

  Market({
    required this.id,
    required this.nombre,
    this.distrito,
    this.direccion,
    this.isFavorite = false,
  });

  factory Market.fromJson(Map<String, dynamic> json) {
    return Market(
      id: int.parse(json['id_mercado'].toString()),
      nombre: json['nombre'],
      distrito: json['distrito'], // Asegúrate que tu BD tenga esta columna
      direccion: json['direccion'], // Asegúrate que tu BD tenga esta columna
      // Si la API manda 'is_favorite', lo usamos. Si no, false.
      isFavorite: json['is_favorite'] == true || json['is_favorite'] == 1,
    );
  }
}
