import 'package:flutter/material.dart';
import '../theme/app_colors.dart';

// --- IMPORTAMOS TODAS LAS PANTALLAS ---
import '../screens/landing_screen.dart';
import '../screens/comparador_screen.dart';
import '../screens/ranking_screen.dart';
import '../screens/chart_screen.dart';
import '../screens/markets_screen.dart';
import '../screens/profile_screen.dart';
import '../screens/admin/admin_dashboard_screen.dart'; // <--- ESTE IMPORT ES VITAL

class SideMenu extends StatelessWidget {
  final Map<String, dynamic>? userData;

  const SideMenu({Key? key, this.userData}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    // Verificamos si el usuario es admin
    // Asegúrate de que en tu Base de Datos el rol esté escrito exactamente como 'admin'
    bool isAdmin = userData != null && userData!['rol'] == 'admin';

    return Drawer(
      backgroundColor: Colors.white,
      child: ListView(
        padding: EdgeInsets.zero,
        children: [
          // --- LOGO ---
          DrawerHeader(
            decoration: BoxDecoration(
              border: Border(bottom: BorderSide(color: Colors.grey.shade200)),
            ),
            child: Row(
              children: [
                Icon(Icons.shopping_basket, color: AppColors.primary, size: 30),
                SizedBox(width: 10),
                Expanded(
                  child: Text(
                    "TuMercadito",
                    style: TextStyle(
                      color: AppColors.petroleumDark,
                      fontSize: 24,
                      fontWeight: FontWeight.bold,
                    ),
                  ),
                ),
              ],
            ),
          ),

          // --- SECCIÓN: PRINCIPAL ---
          _buildMenuLabel("Principal"),
          _buildMenuItem(Icons.home, "Inicio", () {
            Navigator.pop(context);
          }),

          // --- SECCIÓN: HERRAMIENTAS ---
          _buildMenuLabel("Herramientas"),

          _buildMenuItem(Icons.balance, "Comparador", () {
            Navigator.pop(context);
            Navigator.push(
              context,
              MaterialPageRoute(builder: (context) => ComparadorScreen()),
            );
          }),

          _buildMenuItem(Icons.emoji_events, "Ranking", () {
            Navigator.pop(context);
            Navigator.push(
              context,
              MaterialPageRoute(builder: (context) => RankingScreen()),
            );
          }),

          _buildMenuItem(Icons.show_chart, "Gráficos", () {
            Navigator.pop(context);
            Navigator.push(
              context,
              MaterialPageRoute(builder: (context) => ChartScreen()),
            );
          }),

          _buildMenuItem(Icons.store, "Mercados", () {
            Navigator.pop(context);
            Navigator.push(
              context,
              MaterialPageRoute(builder: (context) => MarketsScreen()),
            );
          }),

          // --- SECCIÓN: ADMIN (SOLO VISIBLE SI ES ADMIN) ---
          if (isAdmin) ...[
            Divider(),
            _buildMenuLabel("ADMINISTRACIÓN", color: Colors.orange),
            _buildMenuItem(Icons.admin_panel_settings, "Panel de Control", () {
              Navigator.pop(context);
              // --- AQUI ESTABA EL CAMBIO ---
              // Antes solo mostraba un mensaje, ahora navega:
              Navigator.push(
                context,
                MaterialPageRoute(builder: (context) => AdminDashboardScreen()),
              );
            }, highlight: true),
          ],

          Divider(),

          // --- SECCIÓN: MI CUENTA ---
          _buildMenuLabel("Mi Cuenta"),

          _buildMenuItem(Icons.person, "Mi Perfil", () {
            Navigator.pop(context);
            if (userData != null) {
              Navigator.push(
                context,
                MaterialPageRoute(
                  builder: (context) => ProfileScreen(user: userData!),
                ),
              );
            } else {
              ScaffoldMessenger.of(context).showSnackBar(
                SnackBar(content: Text("Error: Datos de usuario no cargados")),
              );
            }
          }),

          _buildMenuItem(Icons.logout, "Cerrar Sesión", () {
            Navigator.pushAndRemoveUntil(
              context,
              MaterialPageRoute(builder: (context) => LandingScreen()),
              (Route<dynamic> route) => false,
            );
          }, isDanger: true),
        ],
      ),
    );
  }

  // Helper para etiquetas
  Widget _buildMenuLabel(String text, {Color? color}) {
    return Padding(
      padding: const EdgeInsets.fromLTRB(20, 20, 20, 10),
      child: Text(
        text.toUpperCase(),
        style: TextStyle(
          color: color ?? Colors.grey,
          fontSize: 11,
          fontWeight: FontWeight.bold,
          letterSpacing: 1.2,
        ),
      ),
    );
  }

  // Helper para items
  Widget _buildMenuItem(
    IconData icon,
    String title,
    VoidCallback onTap, {
    bool isDanger = false,
    bool highlight = false, // Nuevo parámetro para resaltar el admin
  }) {
    return ListTile(
      leading: Icon(
        icon,
        color: isDanger
            ? Colors.red
            : (highlight ? Colors.orange : Color(0xFF7F8C8D)),
      ),
      title: Text(
        title,
        style: TextStyle(
          color: isDanger
              ? Colors.red
              : (highlight ? Colors.orange[800] : AppColors.petroleum),
          fontWeight: highlight ? FontWeight.bold : FontWeight.w500,
        ),
      ),
      onTap: onTap,
    );
  }
}
