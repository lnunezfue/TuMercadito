import 'package:flutter/material.dart';
import 'package:fl_chart/fl_chart.dart';
import '../services/api_service.dart';
import '../models/price_history.dart';
import '../models/product.dart';
import '../models/market.dart';
import '../theme/app_colors.dart';

class ChartScreen extends StatefulWidget {
  @override
  _ChartScreenState createState() => _ChartScreenState();
}

class _ChartScreenState extends State<ChartScreen> {
  final ApiService _api = ApiService();

  List<Product> products = [];
  List<Market> markets = [];
  Product? selectedProduct;
  Market? selectedMarket;

  bool isLoadingDropdowns = true;
  bool isLoadingChart = false;
  PriceHistory? historyData;
  String errorMessage = "";

  @override
  void initState() {
    super.initState();
    _loadDropdowns();
  }

  void _loadDropdowns() async {
    try {
      final results = await Future.wait([
        _api.getProducts(),
        _api.getMarkets(),
      ]);

      setState(() {
        products = results[0] as List<Product>;
        markets = results[1] as List<Market>;
        isLoadingDropdowns = false;
      });
    } catch (e) {
      setState(() => isLoadingDropdowns = false);
    }
  }

  void _loadChart() async {
    if (selectedProduct == null || selectedMarket == null) {
      ScaffoldMessenger.of(
        context,
      ).showSnackBar(SnackBar(content: Text("Selecciona producto y mercado")));
      return;
    }

    setState(() {
      isLoadingChart = true;
      errorMessage = "";
    });

    try {
      final data = await _api.getHistory(
        selectedProduct!.id,
        selectedMarket!.id,
      );
      setState(() {
        historyData = data;
        isLoadingChart = false;
      });
    } catch (e) {
      setState(() {
        errorMessage = e.toString(); // Mostramos el error real para debug
        isLoadingChart = false;
        historyData = null;
      });
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: AppColors.background,
      appBar: AppBar(
        title: Text(
          "Tendencia de Precios",
          style: TextStyle(
            color: AppColors.petroleum,
            fontWeight: FontWeight.bold,
          ),
        ),
        backgroundColor: Colors.white,
        elevation: 0,
        iconTheme: IconThemeData(color: AppColors.petroleum),
      ),
      body: SingleChildScrollView(
        padding: EdgeInsets.all(20),
        child: Column(
          children: [
            _buildControlPanel(),
            SizedBox(height: 30),

            if (isLoadingChart)
              SizedBox(
                height: 200,
                child: Center(
                  child: CircularProgressIndicator(color: AppColors.primary),
                ),
              )
            else if (errorMessage.isNotEmpty)
              _buildErrorState()
            else if (historyData != null && historyData!.prices.isNotEmpty)
              _buildChartCard()
            else
              _buildPlaceholder(),
          ],
        ),
      ),
    );
  }

  Widget _buildControlPanel() {
    return Container(
      padding: EdgeInsets.all(20),
      decoration: BoxDecoration(
        color: Colors.white,
        borderRadius: BorderRadius.circular(20),
        boxShadow: [
          BoxShadow(color: Colors.black.withOpacity(0.05), blurRadius: 10),
        ],
      ),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          Text(
            "PRODUCTO",
            style: TextStyle(
              fontSize: 10,
              fontWeight: FontWeight.bold,
              color: Colors.grey,
            ),
          ),
          SizedBox(height: 5),
          Container(
            padding: EdgeInsets.symmetric(horizontal: 10),
            decoration: BoxDecoration(
              color: Color(0xFFF8F9FA),
              borderRadius: BorderRadius.circular(10),
            ),
            child: DropdownButtonHideUnderline(
              child: DropdownButton<Product>(
                hint: Text("Seleccionar..."),
                value: selectedProduct,
                isExpanded: true,
                items: products
                    .map(
                      (p) => DropdownMenuItem(value: p, child: Text(p.nombre)),
                    )
                    .toList(),
                onChanged: (val) => setState(() => selectedProduct = val),
              ),
            ),
          ),
          SizedBox(height: 15),
          Text(
            "MERCADO",
            style: TextStyle(
              fontSize: 10,
              fontWeight: FontWeight.bold,
              color: Colors.grey,
            ),
          ),
          SizedBox(height: 5),
          Container(
            padding: EdgeInsets.symmetric(horizontal: 10),
            decoration: BoxDecoration(
              color: Color(0xFFF8F9FA),
              borderRadius: BorderRadius.circular(10),
            ),
            child: DropdownButtonHideUnderline(
              child: DropdownButton<Market>(
                hint: Text("Seleccionar..."),
                value: selectedMarket,
                isExpanded: true,
                items: markets
                    .map(
                      (m) => DropdownMenuItem(value: m, child: Text(m.nombre)),
                    )
                    .toList(),
                onChanged: (val) => setState(() => selectedMarket = val),
              ),
            ),
          ),
          SizedBox(height: 20),
          SizedBox(
            width: double.infinity,
            height: 50,
            child: ElevatedButton.icon(
              onPressed: (isLoadingDropdowns) ? null : _loadChart,
              icon: Icon(Icons.play_arrow, color: Colors.white),
              label: Text(
                "VER GRÁFICO",
                style: TextStyle(
                  color: Colors.white,
                  fontWeight: FontWeight.bold,
                ),
              ),
              style: ElevatedButton.styleFrom(
                backgroundColor: Colors.blue,
                shape: RoundedRectangleBorder(
                  borderRadius: BorderRadius.circular(10),
                ),
              ),
            ),
          ),
        ],
      ),
    );
  }

  Widget _buildChartCard() {
    // 1. Datos históricos
    List<FlSpot> historySpots = historyData!.prices.asMap().entries.map((e) {
      return FlSpot(e.key.toDouble(), e.value);
    }).toList();

    // 2. Datos de predicción
    List<FlSpot> predictionSpots = [];

    // ✅ CORRECCIÓN AQUÍ: Usamos predictionPrice en lugar de prediction
    if (historyData!.predictionPrice != null && historySpots.isNotEmpty) {
      predictionSpots.add(historySpots.last);
      predictionSpots.add(
        FlSpot(historySpots.length.toDouble(), historyData!.predictionPrice!),
      );
    }

    return Container(
      height: 350, // Le damos altura fija al contenedor del gráfico
      padding: EdgeInsets.all(20),
      decoration: BoxDecoration(
        color: Colors.white,
        borderRadius: BorderRadius.circular(20),
        boxShadow: [
          BoxShadow(color: Colors.black.withOpacity(0.05), blurRadius: 10),
        ],
      ),
      child: Column(
        children: [
          Row(
            mainAxisAlignment: MainAxisAlignment.spaceBetween,
            children: [
              Expanded(
                child: Text(
                  "${selectedProduct?.nombre} en ${selectedMarket?.nombre}",
                  style: TextStyle(
                    fontWeight: FontWeight.bold,
                    color: AppColors.petroleumDark,
                  ),
                ),
              ),
              if (historyData!.predictionPrice != null)
                Container(
                  padding: EdgeInsets.symmetric(horizontal: 8, vertical: 4),
                  decoration: BoxDecoration(
                    color: Colors.blue.withOpacity(0.1),
                    borderRadius: BorderRadius.circular(5),
                  ),
                  child: Text(
                    "IA Activa",
                    style: TextStyle(
                      color: Colors.blue,
                      fontSize: 10,
                      fontWeight: FontWeight.bold,
                    ),
                  ),
                ),
            ],
          ),
          SizedBox(height: 30),
          Expanded(
            child: LineChart(
              LineChartData(
                gridData: FlGridData(show: true, drawVerticalLine: false),
                titlesData: FlTitlesData(
                  leftTitles: AxisTitles(
                    sideTitles: SideTitles(
                      showTitles: true,
                      reservedSize: 40,
                      getTitlesWidget: (val, meta) => Text(
                        "S/${val.toInt()}",
                        style: TextStyle(fontSize: 10),
                      ),
                    ),
                  ),
                  bottomTitles: AxisTitles(
                    sideTitles: SideTitles(
                      showTitles: true, // ✅ Activamos las fechas abajo
                      interval: 1, // Muestra todas (o ajusta si son muchas)
                      getTitlesWidget: (value, meta) {
                        int index = value.toInt();
                        // Mostramos fechas históricas (dates)
                        if (index >= 0 && index < historyData!.dates.length) {
                          return Padding(
                            padding: const EdgeInsets.only(top: 8.0),
                            child: Text(
                              historyData!.dates[index],
                              style: TextStyle(fontSize: 10),
                            ),
                          );
                        }
                        // Mostramos fecha de predicción si es el último punto
                        if (index == historyData!.dates.length &&
                            historyData!.predictionDate != null) {
                          return Padding(
                            padding: const EdgeInsets.only(top: 8.0),
                            child: Text(
                              historyData!.predictionDate!,
                              style: TextStyle(
                                fontSize: 10,
                                color: Colors.green,
                                fontWeight: FontWeight.bold,
                              ),
                            ),
                          );
                        }
                        return Text("");
                      },
                    ),
                  ),
                  rightTitles: AxisTitles(
                    sideTitles: SideTitles(showTitles: false),
                  ),
                  topTitles: AxisTitles(
                    sideTitles: SideTitles(showTitles: false),
                  ),
                ),
                borderData: FlBorderData(show: false),
                lineBarsData: [
                  // LÍNEA SÓLIDA
                  LineChartBarData(
                    spots: historySpots,
                    isCurved: true,
                    color: AppColors.petroleum,
                    barWidth: 3,
                    dotData: FlDotData(show: false),
                    belowBarData: BarAreaData(
                      show: true,
                      color: AppColors.petroleum.withOpacity(0.1),
                    ),
                  ),
                  // LÍNEA PUNTEADA
                  if (predictionSpots.isNotEmpty)
                    LineChartBarData(
                      spots: predictionSpots,
                      isCurved: false,
                      color: AppColors.primary,
                      barWidth: 3,
                      isStrokeCapRound: true,
                      dotData: FlDotData(show: true),
                      dashArray: [5, 5],
                    ),
                ],
              ),
            ),
          ),
          SizedBox(height: 20),
          Row(
            mainAxisAlignment: MainAxisAlignment.center,
            children: [
              Icon(Icons.circle, size: 10, color: AppColors.petroleum),
              SizedBox(width: 5),
              Text("Histórico", style: TextStyle(fontSize: 12)),
              SizedBox(width: 20),
              Icon(Icons.circle, size: 10, color: AppColors.primary),
              SizedBox(width: 5),
              Text("Predicción", style: TextStyle(fontSize: 12)),
            ],
          ),
        ],
      ),
    );
  }

  Widget _buildPlaceholder() {
    return Padding(
      padding: const EdgeInsets.only(top: 40),
      child: Column(
        children: [
          Icon(Icons.bar_chart, size: 80, color: Colors.grey.withOpacity(0.3)),
          SizedBox(height: 10),
          Text(
            "Selecciona datos para graficar",
            style: TextStyle(color: Colors.grey),
          ),
        ],
      ),
    );
  }

  Widget _buildErrorState() {
    return Container(
      padding: EdgeInsets.all(20),
      decoration: BoxDecoration(
        color: Colors.red.withOpacity(0.1),
        borderRadius: BorderRadius.circular(15),
      ),
      child: Row(
        children: [
          Icon(Icons.error_outline, color: Colors.red),
          SizedBox(width: 10),
          Expanded(
            child: Text(errorMessage, style: TextStyle(color: Colors.red[800])),
          ),
        ],
      ),
    );
  }
}
