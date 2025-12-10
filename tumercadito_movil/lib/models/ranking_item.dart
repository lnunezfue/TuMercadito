class RankingItem {
  final String mercado;
  final double precio;

  RankingItem({required this.mercado, required this.precio});

  factory RankingItem.fromJson(Map<String, dynamic> json) {
    return RankingItem(
      mercado: json['nombre_mercado'],
      // Convertimos a double asegurando que no falle si viene string o int
      precio: double.parse(json['precio'].toString()),
    );
  }
}
