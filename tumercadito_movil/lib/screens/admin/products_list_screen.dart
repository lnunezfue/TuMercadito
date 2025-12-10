import 'package:flutter/material.dart';
import '../../services/api_service.dart';
import '../../models/product.dart';
import '../../theme/app_colors.dart';
import 'product_form_screen.dart'; // Importamos el formulario

class ProductsListScreen extends StatefulWidget {
  @override
  _ProductsListScreenState createState() => _ProductsListScreenState();
}

class _ProductsListScreenState extends State<ProductsListScreen> {
  final ApiService _api = ApiService();
  List<Product> products = [];
  bool isLoading = true;

  @override
  void initState() {
    super.initState();
    _loadProducts();
  }

  void _loadProducts() async {
    setState(() => isLoading = true);
    try {
      final list = await _api.getProducts();
      setState(() {
        products = list;
        isLoading = false;
      });
    } catch (e) {
      setState(() => isLoading = false);
    }
  }

  void _delete(int id) async {
    bool confirm =
        await showDialog(
          context: context,
          builder: (context) => AlertDialog(
            title: Text("¿Eliminar producto?"),
            content: Text("Esta acción no se puede deshacer."),
            actions: [
              TextButton(
                onPressed: () => Navigator.pop(context, false),
                child: Text("Cancelar"),
              ),
              TextButton(
                onPressed: () => Navigator.pop(context, true),
                child: Text("Eliminar", style: TextStyle(color: Colors.red)),
              ),
            ],
          ),
        ) ??
        false;

    if (confirm) {
      await _api.deleteProduct(id);
      _loadProducts(); // Recargar lista
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: AppColors.background,
      appBar: AppBar(
        title: Text(
          "Gestionar Productos",
          style: TextStyle(
            color: AppColors.petroleum,
            fontWeight: FontWeight.bold,
          ),
        ),
        backgroundColor: Colors.white,
        iconTheme: IconThemeData(color: AppColors.petroleum),
      ),
      floatingActionButton: FloatingActionButton(
        backgroundColor: AppColors.primary, // Verde
        child: Icon(Icons.add, color: Colors.white),
        onPressed: () async {
          // Ir al formulario en modo CREAR
          bool? result = await Navigator.push(
            context,
            MaterialPageRoute(builder: (context) => ProductFormScreen()),
          );
          if (result == true) _loadProducts(); // Recargar si se guardó algo
        },
      ),
      body: isLoading
          ? Center(child: CircularProgressIndicator())
          : ListView.builder(
              padding: EdgeInsets.all(15),
              itemCount: products.length,
              itemBuilder: (context, index) {
                final p = products[index];
                return Card(
                  elevation: 0,
                  margin: EdgeInsets.only(bottom: 10),
                  shape: RoundedRectangleBorder(
                    borderRadius: BorderRadius.circular(15),
                  ),
                  child: ListTile(
                    leading: CircleAvatar(
                      backgroundColor: AppColors.primary.withOpacity(0.1),
                      child: Icon(Icons.inventory_2, color: AppColors.primary),
                    ),
                    title: Text(
                      p.nombre,
                      style: TextStyle(
                        fontWeight: FontWeight.bold,
                        color: AppColors.petroleumDark,
                      ),
                    ),
                    subtitle: Text(
                      "${p.categoria ?? 'Sin cat.'} • ${p.unidad ?? ''}",
                    ),
                    trailing: Row(
                      mainAxisSize: MainAxisSize.min,
                      children: [
                        IconButton(
                          icon: Icon(Icons.edit, color: Colors.blue),
                          onPressed: () async {
                            // Ir al formulario en modo EDITAR (pasamos el producto)
                            bool? result = await Navigator.push(
                              context,
                              MaterialPageRoute(
                                builder: (context) =>
                                    ProductFormScreen(product: p),
                              ),
                            );
                            if (result == true) _loadProducts();
                          },
                        ),
                        IconButton(
                          icon: Icon(Icons.delete, color: Colors.red),
                          onPressed: () => _delete(p.id),
                        ),
                      ],
                    ),
                  ),
                );
              },
            ),
    );
  }
}
