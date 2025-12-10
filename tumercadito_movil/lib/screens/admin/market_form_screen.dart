import 'package:flutter/material.dart';
import '../../services/api_service.dart';
import '../../models/market.dart';
import '../../theme/app_colors.dart';

class MarketFormScreen extends StatefulWidget {
  final Market? market; // Si es null = Crear, Si tiene datos = Editar

  const MarketFormScreen({Key? key, this.market}) : super(key: key);

  @override
  _MarketFormScreenState createState() => _MarketFormScreenState();
}

class _MarketFormScreenState extends State<MarketFormScreen> {
  final _formKey = GlobalKey<FormState>();
  final ApiService _api = ApiService();

  late TextEditingController nameCtrl;
  late TextEditingController distCtrl;
  late TextEditingController dirCtrl;
  bool isSaving = false;

  @override
  void initState() {
    super.initState();
    nameCtrl = TextEditingController(text: widget.market?.nombre ?? '');
    distCtrl = TextEditingController(text: widget.market?.distrito ?? '');
    dirCtrl = TextEditingController(text: widget.market?.direccion ?? '');
  }

  void _save() async {
    if (!_formKey.currentState!.validate()) return;

    setState(() => isSaving = true);

    try {
      bool success;
      if (widget.market == null) {
        // CREAR
        success = await _api.addMarket(
          nameCtrl.text,
          distCtrl.text,
          dirCtrl.text,
        );
      } else {
        // EDITAR
        success = await _api.editMarket(
          widget.market!.id,
          nameCtrl.text,
          distCtrl.text,
          dirCtrl.text,
        );
      }

      if (success) {
        ScaffoldMessenger.of(context).showSnackBar(
          SnackBar(
            content: Text("Guardado correctamente"),
            backgroundColor: Colors.green,
          ),
        );
        Navigator.pop(context, true); // Volver y recargar
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
    bool isEdit = widget.market != null;

    return Scaffold(
      appBar: AppBar(
        title: Text(isEdit ? "Editar Mercado" : "Nuevo Mercado"),
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
                  labelText: "Nombre del Mercado",
                  border: OutlineInputBorder(),
                  prefixIcon: Icon(Icons.store),
                ),
                validator: (v) => v!.isEmpty ? "Campo requerido" : null,
              ),
              SizedBox(height: 15),
              TextFormField(
                controller: distCtrl,
                decoration: InputDecoration(
                  labelText: "Distrito",
                  border: OutlineInputBorder(),
                  prefixIcon: Icon(Icons.map),
                ),
                validator: (v) => v!.isEmpty ? "Campo requerido" : null,
              ),
              SizedBox(height: 15),
              TextFormField(
                controller: dirCtrl,
                decoration: InputDecoration(
                  labelText: "Dirección Exacta",
                  border: OutlineInputBorder(),
                  prefixIcon: Icon(Icons.location_on),
                ),
              ),
              SizedBox(height: 30),
              SizedBox(
                height: 50,
                child: ElevatedButton.icon(
                  onPressed: isSaving ? null : _save,
                  icon: isSaving ? Container() : Icon(Icons.save),
                  label: Text(isSaving ? "Guardando..." : "Guardar Mercado"),
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
