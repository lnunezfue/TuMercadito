import 'package:flutter/material.dart';
import '../services/api_service.dart';
import '../models/product.dart';
import '../models/ranking_item.dart';
import '../theme/app_colors.dart';

class RankingScreen extends StatefulWidget {
  @override
  _RankingScreenState createState() => _RankingScreenState();
}

class _RankingScreenState extends State<RankingScreen> {
  final ApiService _api = ApiService();

  // Datos para el dropdown
  List<Product> products = [];
  Product? selectedProduct;
  bool isLoadingProducts = true;

  // Datos para la lista de resultados
  List<RankingItem> rankingList = [];
  bool isLoadingRanking = false;
  bool hasSearched =
      false; // Para saber si mostrar "No hay resultados" o "Busca algo"

  @override
  void initState() {
    super.initState();
    _loadProducts();
  }

  void _loadProducts() async {
    try {
      final list = await _api.getProducts();
      setState(() {
        products = list;
        isLoadingProducts = false;
      });
    } catch (e) {
      // Manejo de error simple
      setState(() => isLoadingProducts = false);
    }
  }

  void _searchRanking() async {
    if (selectedProduct == null) return;

    setState(() {
      isLoadingRanking = true;
      hasSearched = true;
    });

    try {
      final results = await _api.getRanking(selectedProduct!.id);
      setState(() {
        rankingList = results;
        isLoadingRanking = false;
      });
    } catch (e) {
      setState(() {
        rankingList = [];
        isLoadingRanking = false;
      });
      ScaffoldMessenger.of(
        context,
      ).showSnackBar(SnackBar(content: Text("Error al buscar ranking")));
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: AppColors.background,
      appBar: AppBar(
        title: Text(
          "Ranking de Precios",
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
            // --- HEADER TITULO ---
            Icon(
              Icons.emoji_events,
              size: 60,
              color: Colors.amber,
            ), // Trofeo dorado
            SizedBox(height: 10),
            Text(
              "Descubre dónde comprar mejor",
              style: TextStyle(color: Colors.grey[600]),
            ),
            SizedBox(height: 30),

            // --- TARJETA DE BÚSQUEDA ---
            Container(
              padding: EdgeInsets.all(20),
              decoration: BoxDecoration(
                color: Colors.white,
                borderRadius: BorderRadius.circular(20),
                boxShadow: [
                  BoxShadow(
                    color: Colors.black.withOpacity(0.05),
                    blurRadius: 10,
                  ),
                ],
              ),
              child: Column(
                children: [
                  // Dropdown
                  Container(
                    padding: EdgeInsets.symmetric(horizontal: 15),
                    decoration: BoxDecoration(
                      color: Color(0xFFF8F9FA),
                      borderRadius: BorderRadius.circular(10),
                    ),
                    child: DropdownButtonHideUnderline(
                      child: DropdownButton<Product>(
                        hint: Text("Buscar producto..."),
                        value: selectedProduct,
                        isExpanded: true,
                        items: products.map((Product p) {
                          return DropdownMenuItem<Product>(
                            value: p,
                            child: Text(p.nombre),
                          );
                        }).toList(),
                        onChanged: (val) {
                          setState(() => selectedProduct = val);
                        },
                      ),
                    ),
                  ),
                  SizedBox(height: 15),

                  // Botón Buscar (Amarillo/Dorado como en tu web)
                  SizedBox(
                    width: double.infinity,
                    height: 50,
                    child: ElevatedButton.icon(
                      onPressed: selectedProduct == null
                          ? null
                          : _searchRanking,
                      icon: Icon(Icons.search, color: Colors.white),
                      label: Text(
                        "BUSCAR",
                        style: TextStyle(
                          fontWeight: FontWeight.bold,
                          color: Colors.white,
                        ),
                      ),
                      style: ElevatedButton.styleFrom(
                        backgroundColor: Colors
                            .amber[700], // btn-warning más oscuro para contraste
                        shape: RoundedRectangleBorder(
                          borderRadius: BorderRadius.circular(10),
                        ),
                        elevation: 0,
                      ),
                    ),
                  ),
                ],
              ),
            ),

            SizedBox(height: 30),

            // --- RESULTADOS ---
            if (isLoadingRanking)
              CircularProgressIndicator(color: Colors.amber)
            else if (hasSearched && rankingList.isEmpty)
              _buildEmptyState()
            else if (hasSearched)
              _buildRankingList(),
          ],
        ),
      ),
    );
  }

  Widget _buildRankingList() {
    return Column(
      crossAxisAlignment: CrossAxisAlignment.start,
      children: [
        Text(
          "Top Precios: ${selectedProduct?.nombre}",
          style: TextStyle(
            fontSize: 18,
            fontWeight: FontWeight.bold,
            color: AppColors.petroleum,
          ),
        ),
        SizedBox(height: 15),

        ListView.builder(
          shrinkWrap: true,
          physics: NeverScrollableScrollPhysics(),
          itemCount: rankingList.length,
          itemBuilder: (context, index) {
            final item = rankingList[index];
            final rank = index + 1;
            final isFirst = rank == 1;

            return Container(
              margin: EdgeInsets.only(bottom: 10),
              padding: EdgeInsets.all(15),
              decoration: BoxDecoration(
                color: Colors.white,
                borderRadius: BorderRadius.circular(15),
                border: isFirst
                    ? Border.all(color: Colors.amber.withOpacity(0.5), width: 2)
                    : null,
                boxShadow: [
                  BoxShadow(
                    color: Colors.black.withOpacity(0.03),
                    blurRadius: 5,
                  ),
                ],
              ),
              child: Row(
                children: [
                  // Círculo del Rank (#1, #2...)
                  Container(
                    width: 40,
                    height: 40,
                    decoration: BoxDecoration(
                      color: isFirst ? Colors.amber : Colors.grey[200],
                      shape: BoxShape.circle,
                    ),
                    child: Center(
                      child: Text(
                        "$rank",
                        style: TextStyle(
                          fontWeight: FontWeight.bold,
                          color: isFirst ? Colors.white : Colors.grey[600],
                        ),
                      ),
                    ),
                  ),
                  SizedBox(width: 15),

                  // Nombre del Mercado
                  Expanded(
                    child: Column(
                      crossAxisAlignment: CrossAxisAlignment.start,
                      children: [
                        Text(
                          item.mercado,
                          style: TextStyle(
                            fontWeight: FontWeight.bold,
                            fontSize: 16,
                            color: AppColors.petroleumDark,
                          ),
                        ),
                        Text(
                          "Precio por Unidad/Kg",
                          style: TextStyle(fontSize: 10, color: Colors.grey),
                        ),
                      ],
                    ),
                  ),

                  // Precio
                  Container(
                    padding: EdgeInsets.symmetric(horizontal: 12, vertical: 6),
                    decoration: BoxDecoration(
                      color: AppColors.primary.withOpacity(0.1),
                      borderRadius: BorderRadius.circular(20),
                    ),
                    child: Text(
                      "S/ ${item.precio.toStringAsFixed(2)}",
                      style: TextStyle(
                        color: AppColors.primary,
                        fontWeight: FontWeight.bold,
                      ),
                    ),
                  ),
                ],
              ),
            );
          },
        ),
      ],
    );
  }

  Widget _buildEmptyState() {
    return Container(
      padding: EdgeInsets.all(20),
      decoration: BoxDecoration(
        color: Colors.orange.withOpacity(0.1),
        borderRadius: BorderRadius.circular(15),
      ),
      child: Row(
        children: [
          Icon(Icons.warning_amber_rounded, color: Colors.orange),
          SizedBox(width: 10),
          Expanded(
            child: Text(
              "No se encontraron precios registrados para este producto.",
            ),
          ),
        ],
      ),
    );
  }
}
