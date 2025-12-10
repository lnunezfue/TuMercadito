import 'package:flutter/material.dart';
import '../../services/api_service.dart';
import '../../models/product.dart';
import '../../theme/app_colors.dart';

class ProductFormScreen extends StatefulWidget {
  final Product?
  product; // Si es null, estamos CREANDO. Si tiene datos, estamos EDITANDO.

  const ProductFormScreen({Key? key, this.product}) : super(key: key);

  @override
  _ProductFormScreenState createState() => _ProductFormScreenState();
}

class _ProductFormScreenState extends State<ProductFormScreen> {
  final _formKey = GlobalKey<FormState>();
  final ApiService _api = ApiService();

  late TextEditingController nameCtrl;
  late TextEditingController unitCtrl;
  late TextEditingController catCtrl;
  bool isSaving = false;

  @override
  void initState() {
    super.initState();
    // Pre-llenamos si estamos editando
    nameCtrl = TextEditingController(text: widget.product?.nombre ?? '');
    unitCtrl = TextEditingController(text: widget.product?.unidad ?? '');
    catCtrl = TextEditingController(text: widget.product?.categoria ?? '');
  }

  void _save() async {
    if (!_formKey.currentState!.validate()) return;

    setState(() => isSaving = true);

    try {
      bool success;
      if (widget.product == null) {
        // CREAR
        success = await _api.addProduct(
          nameCtrl.text,
          unitCtrl.text,
          catCtrl.text,
        );
      } else {
        // EDITAR
        success = await _api.editProduct(
          widget.product!.id,
          nameCtrl.text,
          unitCtrl.text,
          catCtrl.text,
        );
      }

      if (success) {
        ScaffoldMessenger.of(context).showSnackBar(
          SnackBar(
            content: Text("Guardado correctamente"),
            backgroundColor: Colors.green,
          ),
        );
        Navigator.pop(context, true); // Volver y recargar lista
      }
    } catch (e) {
      ScaffoldMessenger.of(context).showSnackBar(
        SnackBar(
          content: Text("Error al guardar"),
          backgroundColor: Colors.red,
        ),
      );
    } finally {
      setState(() => isSaving = false);
    }
  }

  @override
  Widget build(BuildContext context) {
    bool isEdit = widget.product != null;

    return Scaffold(
      appBar: AppBar(
        title: Text(isEdit ? "Editar Producto" : "Nuevo Producto"),
        backgroundColor: AppColors.background,
      ),
      body: Padding(
        padding: const EdgeInsets.all(20.0),
        child: Form(
          key: _formKey,
          child: ListView(
            children: [
              TextFormField(
                controller: nameCtrl,
                decoration: InputDecoration(
                  labelText: "Nombre del Producto",
                  border: OutlineInputBorder(),
                ),
                validator: (v) => v!.isEmpty ? "Campo requerido" : null,
              ),
              SizedBox(height: 15),
              TextFormField(
                controller: unitCtrl,
                decoration: InputDecoration(
                  labelText: "Unidad (Ej: Kg, Litro, Unidad)",
                  border: OutlineInputBorder(),
                ),
              ),
              SizedBox(height: 15),
              TextFormField(
                controller: catCtrl,
                decoration: InputDecoration(
                  labelText: "Categoría",
                  border: OutlineInputBorder(),
                ),
              ),
              SizedBox(height: 30),
              SizedBox(
                height: 50,
                child: ElevatedButton.icon(
                  onPressed: isSaving ? null : _save,
                  icon: isSaving ? Container() : Icon(Icons.save),
                  label: Text(isSaving ? "Guardando..." : "Guardar Producto"),
                  style: ElevatedButton.styleFrom(
                    backgroundColor: AppColors.primary,
                    foregroundColor: Colors.white,
                  ),
                ),
              ),
            ],
          ),
        ),
      ),
    );
  }
}
