import 'package:flutter/material.dart';
import '../services/api_service.dart';
import '../models/product.dart';
import '../theme/app_colors.dart';

class ComparadorScreen extends StatefulWidget {
  @override
  _ComparadorScreenState createState() => _ComparadorScreenState();
}

class _ComparadorScreenState extends State<ComparadorScreen> {
  final ApiService _api = ApiService();

  // Estado
  List<Product> availableProducts = [];
  bool isLoadingProducts = true;
  bool isComparing = false;

  // Lista de selección del usuario (Filas del formulario)
  // Cada elemento es un mapa: {'product': ProductObjeto, 'qty': TextEditingController}
  List<Map<String, dynamic>> formRows = [];

  // Resultados (null si no se ha comparado aún)
  Map<String, dynamic>? comparisonResults;

  @override
  void initState() {
    super.initState();
    _loadProducts();
    _addNewRow(); // Agregamos la primera fila vacía al iniciar
  }

  void _loadProducts() async {
    try {
      // NOTA: Para probar sin backend, descomenta la linea de abajo y comenta la llamada a API
      // availableProducts = [Product(id: 1, nombre: "Arroz"), Product(id: 2, nombre: "Azúcar")];
      availableProducts = await _api.getProducts();
    } catch (e) {
      print(e); // Manejar error
    } finally {
      if (mounted) setState(() => isLoadingProducts = false);
    }
  }

  void _addNewRow() {
    setState(() {
      formRows.add({
        'product': null, // Ningún producto seleccionado aún
        'qty': TextEditingController(text: '1'), // Cantidad 1 por defecto
      });
    });
  }

  void _removeRow(int index) {
    if (formRows.length > 1) {
      setState(() {
        formRows.removeAt(index);
      });
    }
  }

  void _compare() async {
    // Validar que haya productos seleccionados
    List<Map<String, dynamic>> itemsToSend = [];

    for (var row in formRows) {
      if (row['product'] != null) {
        itemsToSend.add({
          "id": (row['product'] as Product).id,
          "qty": int.tryParse((row['qty'] as TextEditingController).text) ?? 1,
        });
      }
    }

    if (itemsToSend.isEmpty) {
      ScaffoldMessenger.of(context).showSnackBar(
        SnackBar(content: Text("Selecciona al menos un producto")),
      );
      return;
    }

    setState(() => isComparing = true);

    try {
      final results = await _api.comparePrices(itemsToSend);
      setState(() {
        comparisonResults = results;
        isComparing = false;
      });
    } catch (e) {
      setState(() => isComparing = false);
      ScaffoldMessenger.of(
        context,
      ).showSnackBar(SnackBar(content: Text("Error al comparar precios")));
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: AppColors.background,
      appBar: AppBar(
        title: Text(
          "Comparador",
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
            // --- SECCIÓN 1: FORMULARIO (MI LISTA) ---
            _buildFormCard(),

            SizedBox(height: 30),

            // --- SECCIÓN 2: RESULTADOS ---
            if (isComparing)
              CircularProgressIndicator(color: AppColors.primary)
            else if (comparisonResults != null)
              _buildResultsSection()
            else
              _buildEmptyState(),
          ],
        ),
      ),
    );
  }

  // Tarjeta Blanca del Formulario
  Widget _buildFormCard() {
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
          Row(
            children: [
              Icon(Icons.shopping_basket, color: AppColors.primary),
              SizedBox(width: 10),
              Text(
                "Mi Lista",
                style: TextStyle(
                  fontSize: 18,
                  fontWeight: FontWeight.bold,
                  color: AppColors.petroleum,
                ),
              ),
            ],
          ),
          Divider(height: 30),

          // Lista de Filas Dinámicas
          isLoadingProducts
              ? Center(child: CircularProgressIndicator())
              : ListView.builder(
                  shrinkWrap: true, // Importante dentro de Column
                  physics: NeverScrollableScrollPhysics(),
                  itemCount: formRows.length,
                  itemBuilder: (context, index) {
                    return _buildInputRow(index);
                  },
                ),

          SizedBox(height: 15),

          // Botón Agregar Otro
          OutlinedButton.icon(
            onPressed: _addNewRow,
            icon: Icon(Icons.add_circle, size: 18),
            label: Text("Agregar Otro"),
            style: OutlinedButton.styleFrom(
              foregroundColor: Colors.grey,
              side: BorderSide(
                color: Colors.grey.shade300,
                style: BorderStyle.solid,
              ), // Dashed es difícil en flutter nativo
              minimumSize: Size(double.infinity, 45),
            ),
          ),

          SizedBox(height: 15),

          // Botón Comparar (Verde)
          ElevatedButton.icon(
            onPressed: isComparing ? null : _compare,
            icon: Icon(Icons.search, color: Colors.white),
            label: Text(
              "Comparar Precios",
              style: TextStyle(
                color: Colors.white,
                fontWeight: FontWeight.bold,
              ),
            ),
            style: ElevatedButton.styleFrom(
              backgroundColor: AppColors.primary,
              minimumSize: Size(double.infinity, 50),
              shape: RoundedRectangleBorder(
                borderRadius: BorderRadius.circular(10),
              ),
            ),
          ),
        ],
      ),
    );
  }

  // Una fila individual (Dropdown + Cantidad + Eliminar)
  Widget _buildInputRow(int index) {
    return Padding(
      padding: const EdgeInsets.only(bottom: 10.0),
      child: Row(
        children: [
          // Dropdown de Productos
          Expanded(
            flex: 3,
            child: Container(
              padding: EdgeInsets.symmetric(horizontal: 10),
              decoration: BoxDecoration(
                color: Color(0xFFF8F9FA),
                borderRadius: BorderRadius.circular(10),
              ),
              child: DropdownButtonHideUnderline(
                child: DropdownButton<Product>(
                  hint: Text("Producto..."),
                  value: formRows[index]['product'],
                  isExpanded: true,
                  items: availableProducts.map((Product p) {
                    return DropdownMenuItem<Product>(
                      value: p,
                      child: Text(p.nombre),
                    );
                  }).toList(),
                  onChanged: (Product? value) {
                    setState(() {
                      formRows[index]['product'] = value;
                    });
                  },
                ),
              ),
            ),
          ),
          SizedBox(width: 10),

          // Input Cantidad
          Expanded(
            flex: 1,
            child: Container(
              decoration: BoxDecoration(
                color: Color(0xFFF8F9FA),
                borderRadius: BorderRadius.circular(10),
              ),
              child: TextField(
                controller: formRows[index]['qty'],
                keyboardType: TextInputType.number,
                textAlign: TextAlign.center,
                decoration: InputDecoration(
                  border: InputBorder.none,
                  hintText: "Cant.",
                  contentPadding: EdgeInsets.symmetric(vertical: 14),
                ),
              ),
            ),
          ),

          // Botón Eliminar (Solo si hay más de 1 fila)
          if (formRows.length > 1)
            IconButton(
              icon: Icon(Icons.close, color: Colors.red.shade300),
              onPressed: () => _removeRow(index),
            ),
        ],
      ),
    );
  }

  // --- RESULTADOS ---

  Widget _buildResultsSection() {
    // Extraemos datos del JSON de respuesta
    final rec = comparisonResults!['recommendation'];
    // NOTA: La tabla es compleja, aquí hacemos una versión simplificada de la "Mejor Opción"

    return Column(
      children: [
        // Tarjeta Ganadora (Verde Oscuro)
        Container(
          width: double.infinity,
          padding: EdgeInsets.all(25),
          decoration: BoxDecoration(
            color: AppColors.petroleum,
            borderRadius: BorderRadius.circular(20),
            boxShadow: [
              BoxShadow(
                color: AppColors.petroleum.withOpacity(0.4),
                blurRadius: 15,
                offset: Offset(0, 5),
              ),
            ],
          ),
          child: Stack(
            children: [
              Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  Text(
                    "MEJOR OPCIÓN DE COMPRA",
                    style: TextStyle(
                      color: AppColors.primary,
                      fontWeight: FontWeight.bold,
                      fontSize: 12,
                    ),
                  ),
                  SizedBox(height: 10),
                  Text(
                    rec['market'],
                    style: TextStyle(
                      color: Colors.white,
                      fontSize: 24,
                      fontWeight: FontWeight.bold,
                    ),
                  ),
                  Text(
                    "S/ ${rec['total']}",
                    style: TextStyle(
                      color: AppColors.primary,
                      fontSize: 40,
                      fontWeight: FontWeight.bold,
                    ),
                  ),
                  SizedBox(height: 5),
                  Text(
                    "Es el mercado más económico para tu lista.",
                    style: TextStyle(color: Colors.white54),
                  ),
                ],
              ),
              Positioned(
                right: -20,
                bottom: -20,
                child: Icon(
                  Icons.emoji_events,
                  size: 100,
                  color: Colors.white.withOpacity(0.1),
                ),
              ),
            ],
          ),
        ),

        SizedBox(height: 20),

        // Aquí iría la tabla detallada.
        // Como es compleja de renderizar dinámicamente en móvil (muchas columnas),
        // sugerencia: Mostrar solo un resumen o usar un widget de tabla horizontal.
        Text(
          "Detalles disponibles en la versión web",
          style: TextStyle(color: Colors.grey, fontStyle: FontStyle.italic),
        ),
      ],
    );
  }

  Widget _buildEmptyState() {
    return Padding(
      padding: const EdgeInsets.only(top: 40.0),
      child: Column(
        children: [
          Icon(
            Icons.shopping_cart_outlined,
            size: 80,
            color: Colors.grey.withOpacity(0.3),
          ),
          SizedBox(height: 10),
          Text(
            "Añade productos para comparar",
            style: TextStyle(color: Colors.grey),
          ),
        ],
      ),
    );
  }
}
