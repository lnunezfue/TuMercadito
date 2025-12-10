import 'package:flutter/material.dart';
import '../../services/api_service.dart';
import '../../models/product.dart';
import '../../models/market.dart';
import '../../theme/app_colors.dart';

class UpdatePriceScreen extends StatefulWidget {
  @override
  _UpdatePriceScreenState createState() => _UpdatePriceScreenState();
}

class _UpdatePriceScreenState extends State<UpdatePriceScreen> {
  final ApiService _api = ApiService();

  // Listas
  List<Product> products = [];
  List<Market> markets = [];

  // Selecciones
  Product? selectedProduct;
  Market? selectedMarket;
  final TextEditingController priceCtrl = TextEditingController();

  bool isLoadingData = true;
  bool isSaving = false;

  @override
  void initState() {
    super.initState();
    _loadData();
  }

  void _loadData() async {
    try {
      final results = await Future.wait([
        _api.getProducts(),
        _api.getMarkets(),
      ]);
      setState(() {
        products = results[0] as List<Product>;
        markets = results[1] as List<Market>;
        isLoadingData = false;
      });
    } catch (e) {
      setState(() => isLoadingData = false);
      ScaffoldMessenger.of(
        context,
      ).showSnackBar(SnackBar(content: Text("Error cargando listas")));
    }
  }

  void _savePrice() async {
    if (selectedProduct == null ||
        selectedMarket == null ||
        priceCtrl.text.isEmpty) {
      ScaffoldMessenger.of(
        context,
      ).showSnackBar(SnackBar(content: Text("Completa todos los campos")));
      return;
    }

    double? price = double.tryParse(priceCtrl.text);
    if (price == null || price <= 0) {
      ScaffoldMessenger.of(
        context,
      ).showSnackBar(SnackBar(content: Text("Precio inválido")));
      return;
    }

    setState(() => isSaving = true);

    try {
      await _api.updatePrice(selectedProduct!.id, selectedMarket!.id, price);

      ScaffoldMessenger.of(context).showSnackBar(
        SnackBar(
          content: Text("¡Precio actualizado con éxito!"),
          backgroundColor: Colors.green,
        ),
      );

      // Limpiar campo precio (opcional)
      priceCtrl.clear();
    } catch (e) {
      ScaffoldMessenger.of(context).showSnackBar(
        SnackBar(
          content: Text(e.toString().replaceAll("Exception: ", "")),
          backgroundColor: Colors.red,
        ),
      );
    } finally {
      setState(() => isSaving = false);
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: AppColors.background, // #F5F6F7
      appBar: AppBar(
        title: Text(
          "Actualizar Precio",
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
        padding: EdgeInsets.all(25),
        child: Column(
          children: [
            // --- HEADER ICONO AMARILLO ---
            Container(
              width: 70,
              height: 70,
              decoration: BoxDecoration(
                color: Colors.amber.withOpacity(0.15), // bg-yellow-soft
                shape: BoxShape.circle,
              ),
              child: Icon(
                Icons.local_offer,
                color: Colors.amber[700],
                size: 30,
              ),
            ),
            SizedBox(height: 15),
            Text(
              "Establecer nuevo precio",
              style: TextStyle(color: Colors.grey[600]),
            ),
            SizedBox(height: 30),

            // --- TARJETA FORMULARIO ---
            Container(
              padding: EdgeInsets.all(30),
              decoration: BoxDecoration(
                color: Colors.white,
                borderRadius: BorderRadius.circular(20),
                boxShadow: [
                  BoxShadow(
                    color: Colors.black.withOpacity(0.05),
                    blurRadius: 15,
                  ),
                ],
              ),
              child: isLoadingData
                  ? Center(
                      child: CircularProgressIndicator(color: Colors.amber),
                    )
                  : Column(
                      crossAxisAlignment: CrossAxisAlignment.start,
                      children: [
                        // Selector Producto
                        _buildLabel("Producto"),
                        _buildDropdown<Product>(
                          hint: "Seleccionar producto...",
                          value: selectedProduct,
                          items: products
                              .map(
                                (p) => DropdownMenuItem(
                                  value: p,
                                  child: Text(p.nombre),
                                ),
                              )
                              .toList(),
                          onChanged: (val) =>
                              setState(() => selectedProduct = val),
                        ),

                        SizedBox(height: 20),

                        // Selector Mercado
                        _buildLabel("Mercado"),
                        _buildDropdown<Market>(
                          hint: "Seleccionar mercado...",
                          value: selectedMarket,
                          items: markets
                              .map(
                                (m) => DropdownMenuItem(
                                  value: m,
                                  child: Text(m.nombre),
                                ),
                              )
                              .toList(),
                          onChanged: (val) =>
                              setState(() => selectedMarket = val),
                        ),

                        SizedBox(height: 30),

                        // Input Precio Gigante
                        _buildLabel("Nuevo Precio (S/)"),
                        Container(
                          decoration: BoxDecoration(
                            color: Colors.white,
                            borderRadius: BorderRadius.circular(15),
                            boxShadow: [
                              BoxShadow(
                                color: Colors.black.withOpacity(0.05),
                                blurRadius: 5,
                              ),
                            ],
                          ),
                          child: Row(
                            children: [
                              Container(
                                padding: EdgeInsets.symmetric(
                                  horizontal: 20,
                                  vertical: 15,
                                ),
                                decoration: BoxDecoration(
                                  color: Colors.amber, // bg-warning
                                  borderRadius: BorderRadius.horizontal(
                                    left: Radius.circular(15),
                                  ),
                                ),
                                child: Text(
                                  "S/",
                                  style: TextStyle(
                                    color: Colors.white,
                                    fontWeight: FontWeight.bold,
                                    fontSize: 18,
                                  ),
                                ),
                              ),
                              Expanded(
                                child: TextField(
                                  controller: priceCtrl,
                                  keyboardType: TextInputType.numberWithOptions(
                                    decimal: true,
                                  ),
                                  textAlign: TextAlign.end,
                                  style: TextStyle(
                                    fontSize: 24,
                                    fontWeight: FontWeight.bold,
                                    color: AppColors.petroleum,
                                  ),
                                  decoration: InputDecoration(
                                    border: InputBorder.none,
                                    hintText: "0.00",
                                    contentPadding: EdgeInsets.symmetric(
                                      horizontal: 20,
                                    ),
                                  ),
                                ),
                              ),
                            ],
                          ),
                        ),

                        SizedBox(height: 40),

                        // Botón Guardar
                        SizedBox(
                          width: double.infinity,
                          height: 55,
                          child: ElevatedButton.icon(
                            onPressed: isSaving ? null : _savePrice,
                            style: ElevatedButton.styleFrom(
                              backgroundColor: Colors.amber, // btn-warning
                              shape: RoundedRectangleBorder(
                                borderRadius: BorderRadius.circular(10),
                              ),
                              elevation: 5,
                            ),
                            icon: isSaving
                                ? SizedBox(
                                    width: 20,
                                    height: 20,
                                    child: CircularProgressIndicator(
                                      color: Colors.white,
                                      strokeWidth: 2,
                                    ),
                                  )
                                : Icon(Icons.save, color: Colors.white),
                            label: Text(
                              isSaving ? " Guardando..." : "Actualizar Precio",
                              style: TextStyle(
                                color: Colors.white,
                                fontWeight: FontWeight.bold,
                                fontSize: 16,
                              ),
                            ),
                          ),
                        ),
                      ],
                    ),
            ),
          ],
        ),
      ),
    );
  }

  Widget _buildLabel(String text) {
    return Padding(
      padding: const EdgeInsets.only(bottom: 8.0),
      child: Text(
        text,
        style: TextStyle(
          fontWeight: FontWeight.bold,
          color: AppColors.petroleum,
        ),
      ),
    );
  }

  Widget _buildDropdown<T>({
    required String hint,
    required T? value,
    required List<DropdownMenuItem<T>> items,
    required ValueChanged<T?> onChanged,
  }) {
    return Container(
      padding: EdgeInsets.symmetric(horizontal: 15),
      decoration: BoxDecoration(
        color: Color(0xFFF8F9FA), // bg-light
        borderRadius: BorderRadius.circular(12),
      ),
      child: DropdownButtonHideUnderline(
        child: DropdownButton<T>(
          hint: Text(hint, style: TextStyle(fontSize: 14)),
          value: value,
          isExpanded: true,
          items: items,
          onChanged: onChanged,
        ),
      ),
    );
  }
}
