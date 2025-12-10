class PriceHistory {
  final List<String> dates; // Eje X (Fechas)
  final List<double> prices; // Eje Y (Precios históricos)

  // CAMBIOS IMPORTANTES AQUÍ:
  // Ya no es solo un double, ahora separamos precio y fecha futura
  final double? predictionPrice;
  final String? predictionDate;

  PriceHistory({
    required this.dates,
    required this.prices,
    this.predictionPrice,
    this.predictionDate,
  });

  factory PriceHistory.fromJson(Map<String, dynamic> json) {
    // 1. Procesar Fechas (Labels)
    List<String> parsedDates = [];
    if (json['labels'] != null) {
      parsedDates = List<String>.from(json['labels'].map((x) => x.toString()));
    }

    // 2. Procesar Precios (Data)
    // Usamos tryParse para ser ultra-seguros si PHP manda strings o números
    List<double> parsedPrices = [];
    if (json['data'] != null) {
      parsedPrices = List<double>.from(
        json['data'].map((x) => double.tryParse(x.toString()) ?? 0.0),
      );
    }

    // 3. Procesar Predicción (EL CAMBIO CLAVE)
    double? predPrice;
    String? predDate;

    if (json['prediction'] != null) {
      // Verificamos si es un Mapa (Objeto JSON) como lo manda el nuevo PHP
      if (json['prediction'] is Map) {
        predPrice = double.tryParse(json['prediction']['price'].toString());
        predDate = json['prediction']['date'].toString();
      }
      // Soporte retroactivo: Si por alguna razón llega solo un número
      else if (json['prediction'] is num) {
        predPrice = (json['prediction'] as num).toDouble();
      }
    }

    return PriceHistory(
      dates: parsedDates,
      prices: parsedPrices,
      predictionPrice: predPrice,
      predictionDate: predDate,
    );
  }
}
