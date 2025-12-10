class PriceHistory {
  final List<String> dates; // Las fechas (eje X)
  final List<double> prices; // Los precios (eje Y)
  final double? prediction; // La predicción futura (puede ser nulo)

  PriceHistory({required this.dates, required this.prices, this.prediction});

  // Esta "fábrica" convierte el JSON crudo en un objeto PriceHistory limpio
  factory PriceHistory.fromJson(Map<String, dynamic> json) {
    return PriceHistory(
      // Convertimos la lista de fechas a String
      dates: List<String>.from(json['labels']),

      // Convertimos la lista de precios a números decimales (double)
      // El .map(...) asegura que si PHP manda un entero (5), Dart lo lea como decimal (5.0)
      prices: List<double>.from(json['data'].map((x) => (x as num).toDouble())),

      // Si viene predicción, la guardamos. Si no, la dejamos nula.
      prediction: json['prediction'] != null
          ? (json['prediction'] as num).toDouble()
          : null,
    );
  }
}
