import 'package:flutter/material.dart';
import '../../services/api_service.dart';
import '../../models/market.dart';
import '../../theme/app_colors.dart';
import 'market_form_screen.dart';

class MarketsListScreen extends StatefulWidget {
  @override
  _MarketsListScreenState createState() => _MarketsListScreenState();
}

class _MarketsListScreenState extends State<MarketsListScreen> {
  final ApiService _api = ApiService();
  List<Market> markets = [];
  bool isLoading = true;

  @override
  void initState() {
    super.initState();
    _loadMarkets();
  }

  void _loadMarkets() async {
    setState(() => isLoading = true);
    try {
      final list = await _api
          .getAllMarkets(); // Reutilizamos getAllMarkets que ya devuelve todo
      setState(() {
        markets = list;
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
            title: Text("¿Eliminar mercado?"),
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
      await _api.deleteMarket(id);
      _loadMarkets();
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: AppColors.background,
      appBar: AppBar(
        title: Text(
          "Gestionar Mercados",
          style: TextStyle(
            color: AppColors.petroleum,
            fontWeight: FontWeight.bold,
          ),
        ),
        backgroundColor: Colors.white,
        iconTheme: IconThemeData(color: AppColors.petroleum),
      ),
      floatingActionButton: FloatingActionButton(
        backgroundColor: AppColors.primary,
        child: Icon(Icons.add, color: Colors.white),
        onPressed: () async {
          bool? result = await Navigator.push(
            context,
            MaterialPageRoute(builder: (context) => MarketFormScreen()),
          );
          if (result == true) _loadMarkets();
        },
      ),
      body: isLoading
          ? Center(child: CircularProgressIndicator())
          : ListView.builder(
              padding: EdgeInsets.all(15),
              itemCount: markets.length,
              itemBuilder: (context, index) {
                final m = markets[index];
                return Card(
                  elevation: 0,
                  margin: EdgeInsets.only(bottom: 10),
                  shape: RoundedRectangleBorder(
                    borderRadius: BorderRadius.circular(15),
                  ),
                  child: ListTile(
                    leading: CircleAvatar(
                      backgroundColor: AppColors.petroleum.withOpacity(0.1),
                      child: Icon(Icons.store, color: AppColors.petroleum),
                    ),
                    title: Text(
                      m.nombre,
                      style: TextStyle(
                        fontWeight: FontWeight.bold,
                        color: AppColors.petroleumDark,
                      ),
                    ),
                    subtitle: Text("${m.distrito} • ${m.direccion ?? ''}"),
                    trailing: Row(
                      mainAxisSize: MainAxisSize.min,
                      children: [
                        IconButton(
                          icon: Icon(Icons.edit, color: Colors.blue),
                          onPressed: () async {
                            bool? result = await Navigator.push(
                              context,
                              MaterialPageRoute(
                                builder: (context) =>
                                    MarketFormScreen(market: m),
                              ),
                            );
                            if (result == true) _loadMarkets();
                          },
                        ),
                        IconButton(
                          icon: Icon(Icons.delete, color: Colors.red),
                          onPressed: () => _delete(m.id),
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
