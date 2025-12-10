import 'package:flutter/material.dart';
import '../services/api_service.dart';
import '../models/market.dart';
import '../theme/app_colors.dart';

class MarketsScreen extends StatefulWidget {
  @override
  _MarketsScreenState createState() => _MarketsScreenState();
}

class _MarketsScreenState extends State<MarketsScreen> {
  final ApiService _api = ApiService();
  List<Market> markets = [];
  bool isLoading = true;

  @override
  void initState() {
    super.initState();
    _loadMarkets();
  }

  void _loadMarkets() async {
    try {
      final list = await _api.getAllMarkets();
      setState(() {
        markets = list;
        isLoading = false;
      });
    } catch (e) {
      setState(() => isLoading = false);
      ScaffoldMessenger.of(
        context,
      ).showSnackBar(SnackBar(content: Text("Error cargando mercados")));
    }
  }

  void _toggleFavorite(int index) {
    // Simulación visual (En una app real, llamarías a la API aquí)
    setState(() {
      markets[index].isFavorite = !markets[index].isFavorite;
    });

    ScaffoldMessenger.of(context).showSnackBar(
      SnackBar(
        content: Text(
          markets[index].isFavorite
              ? "Añadido a favoritos"
              : "Eliminado de favoritos",
        ),
        duration: Duration(seconds: 1),
      ),
    );
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: AppColors.background,
      appBar: AppBar(
        title: Text(
          "Mercados",
          style: TextStyle(
            color: AppColors.petroleum,
            fontWeight: FontWeight.bold,
          ),
        ),
        backgroundColor: Colors.white,
        elevation: 0,
        iconTheme: IconThemeData(color: AppColors.petroleum),
      ),
      body: isLoading
          ? Center(child: CircularProgressIndicator(color: AppColors.primary))
          : markets.isEmpty
          ? Center(child: Text("No hay mercados disponibles"))
          : GridView.builder(
              padding: EdgeInsets.all(20),
              gridDelegate: SliverGridDelegateWithFixedCrossAxisCount(
                crossAxisCount: 2, // 2 Columnas
                crossAxisSpacing: 15,
                mainAxisSpacing: 15,
                childAspectRatio: 0.75, // Altura de las tarjetas
              ),
              itemCount: markets.length,
              itemBuilder: (context, index) {
                final market = markets[index];
                return _buildMarketCard(market, index);
              },
            ),
    );
  }

  Widget _buildMarketCard(Market market, int index) {
    return Container(
      decoration: BoxDecoration(
        color: Colors.white,
        borderRadius: BorderRadius.circular(20),
        boxShadow: [
          BoxShadow(color: Colors.black.withOpacity(0.05), blurRadius: 10),
        ],
      ),
      child: Padding(
        padding: const EdgeInsets.all(15.0),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            // Icono y Estrella
            Row(
              mainAxisAlignment: MainAxisAlignment.spaceBetween,
              children: [
                Container(
                  width: 40,
                  height: 40,
                  decoration: BoxDecoration(
                    color: AppColors.petroleum.withOpacity(0.1),
                    shape: BoxShape.circle,
                  ),
                  child: Icon(
                    Icons.store,
                    color: AppColors.petroleum,
                    size: 20,
                  ),
                ),
                if (market.isFavorite)
                  Icon(Icons.star, color: Colors.amber, size: 20),
              ],
            ),

            SizedBox(height: 15),

            // Textos
            Text(
              market.nombre,
              style: TextStyle(
                fontWeight: FontWeight.bold,
                fontSize: 16,
                color: AppColors.petroleumDark,
              ),
              maxLines: 2,
              overflow: TextOverflow.ellipsis,
            ),
            SizedBox(height: 5),
            Text(
              market.distrito ?? "Distrito no especificado",
              style: TextStyle(fontSize: 11, color: Colors.grey),
            ),

            Spacer(),

            // Dirección
            Row(
              children: [
                Icon(
                  Icons.location_on,
                  size: 12,
                  color: Colors.red.withOpacity(0.7),
                ),
                SizedBox(width: 4),
                Expanded(
                  child: Text(
                    market.direccion ?? "Sin dirección",
                    style: TextStyle(fontSize: 10, color: Colors.grey),
                    maxLines: 1,
                    overflow: TextOverflow.ellipsis,
                  ),
                ),
              ],
            ),

            SizedBox(height: 10),

            // Botón Favorito
            SizedBox(
              width: double.infinity,
              height: 35,
              child: OutlinedButton(
                onPressed: () => _toggleFavorite(index),
                style: OutlinedButton.styleFrom(
                  side: BorderSide(
                    color: market.isFavorite
                        ? Colors.amber
                        : Colors.grey.shade300,
                  ),
                  shape: RoundedRectangleBorder(
                    borderRadius: BorderRadius.circular(10),
                  ),
                  foregroundColor: market.isFavorite
                      ? Colors.amber[800]
                      : Colors.grey,
                ),
                child: Text(
                  market.isFavorite ? "Favorito" : "Añadir",
                  style: TextStyle(fontSize: 12, fontWeight: FontWeight.bold),
                ),
              ),
            ),
          ],
        ),
      ),
    );
  }
}
