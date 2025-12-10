import 'package:flutter/material.dart';
import 'package:tumercadito_movil/screens/admin/markets_list_screen.dart';
import 'package:tumercadito_movil/screens/admin/products_list_screen.dart';
import 'package:tumercadito_movil/screens/admin/update_price_screen.dart';
import 'package:tumercadito_movil/screens/admin/users_list_screen.dart';
import '../../theme/app_colors.dart';

class AdminDashboardScreen extends StatelessWidget {
  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: AppColors.background,
      appBar: AppBar(
        title: Text(
          "Panel de Control",
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
        padding: EdgeInsets.all(20.0),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            // --- 1. BANNER DE BIENVENIDA ---
            Container(
              width: double.infinity,
              padding: EdgeInsets.all(25),
              decoration: BoxDecoration(
                gradient: LinearGradient(
                  colors: [AppColors.petroleum, Color(0xFF2C3E50)],
                  begin: Alignment.topLeft,
                  end: Alignment.bottomRight,
                ),
                borderRadius: BorderRadius.circular(20),
                boxShadow: [
                  BoxShadow(
                    color: AppColors.petroleum.withOpacity(0.4),
                    blurRadius: 15,
                    offset: Offset(0, 8),
                  ),
                ],
              ),
              child: Row(
                children: [
                  Expanded(
                    child: Column(
                      crossAxisAlignment: CrossAxisAlignment.start,
                      children: [
                        Text(
                          "Panel de Control",
                          style: TextStyle(
                            color: Colors.white,
                            fontSize: 24,
                            fontWeight: FontWeight.bold,
                          ),
                        ),
                        SizedBox(height: 8),
                        Text(
                          "Bienvenido, gestiona todo tu mercado desde un solo lugar.",
                          style: TextStyle(color: Colors.white70, fontSize: 14),
                        ),
                      ],
                    ),
                  ),
                  // Icono decorativo (Pie Chart)
                  Icon(
                    Icons.pie_chart,
                    color: Colors.white.withOpacity(0.2),
                    size: 60,
                  ),
                ],
              ),
            ),

            SizedBox(height: 30),

            // --- 2. GRID DE GESTIÓN ---
            GridView.count(
              shrinkWrap: true,
              physics: NeverScrollableScrollPhysics(),
              crossAxisCount: 2, // 2 Columnas
              crossAxisSpacing: 15,
              mainAxisSpacing: 15,
              childAspectRatio: 0.75, // Ajusta la altura de las tarjetas
              children: [
                // Tarjeta PRECIOS (Amarillo)
                _AdminCard(
                  title: "Gestionar Precios",
                  description: "Actualiza costos y variaciones.",
                  icon: Icons.price_check, // fa-tags
                  color: Colors.orange, // text-warning
                  onTap: () {
                    Navigator.push(
                      context,
                      MaterialPageRoute(
                        builder: (context) => UpdatePriceScreen(),
                      ),
                    );
                  },
                ),

                // Tarjeta PRODUCTOS (Verde)
                _AdminCard(
                  title: "Gestionar Productos",
                  description: "Inventario y categorías.",
                  icon: Icons.inventory_2, // fa-box-open
                  color: AppColors.primary, // text-success
                  onTap: () {
                    Navigator.push(
                      context,
                      MaterialPageRoute(
                        builder: (context) => ProductsListScreen(),
                      ),
                    );
                  },
                ),

                // Tarjeta MERCADOS (Petróleo)
                _AdminCard(
                  title: "Gestionar Mercados",
                  description: "Sucursales y ubicaciones.",
                  icon: Icons.store, // fa-store
                  color: AppColors.petroleum, // text-petroleum
                  onTap: () {
                    Navigator.push(
                      context,
                      MaterialPageRoute(
                        builder: (context) => MarketsListScreen(),
                      ),
                    );
                  },
                ),

                // Tarjeta USUARIOS (Info/Cyan)
                _AdminCard(
                  title: "Gestionar Usuarios",
                  description: "Control de acceso y roles.",
                  icon: Icons.group, // fa-users
                  color: Colors.cyan, // text-info
                  onTap: () {
                    Navigator.push(
                      context,
                      MaterialPageRoute(
                        builder: (context) => UsersListScreen(),
                      ),
                    );
                  },
                ),
              ],
            ),
          ],
        ),
      ),
    );
  }
}

// ==========================================
// WIDGET REUTILIZABLE DE TARJETA ADMIN
// ==========================================
class _AdminCard extends StatelessWidget {
  final String title;
  final String description;
  final IconData icon;
  final Color color;
  final VoidCallback onTap;

  const _AdminCard({
    required this.title,
    required this.description,
    required this.icon,
    required this.color,
    required this.onTap,
  });

  @override
  Widget build(BuildContext context) {
    return GestureDetector(
      onTap: onTap,
      child: Container(
        padding: EdgeInsets.all(20),
        decoration: BoxDecoration(
          color: Colors.white,
          borderRadius: BorderRadius.circular(20),
          boxShadow: [
            BoxShadow(
              color: Colors.black.withOpacity(0.05),
              blurRadius: 10,
              offset: Offset(0, 4),
            ),
          ],
        ),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            // Icon Box
            Container(
              padding: EdgeInsets.all(12),
              decoration: BoxDecoration(
                color: color.withOpacity(
                  0.1,
                ), // Fondo suave del color principal
                borderRadius: BorderRadius.circular(15),
              ),
              child: Icon(icon, color: color, size: 28),
            ),

            SizedBox(height: 15),

            // Título
            Text(
              title,
              style: TextStyle(
                fontWeight: FontWeight.bold,
                fontSize: 16,
                color: AppColors.petroleumDark,
                height: 1.2,
              ),
            ),

            SizedBox(height: 8),

            // Descripción
            Expanded(
              child: Text(
                description,
                style: TextStyle(fontSize: 11, color: Colors.grey),
                maxLines: 3,
                overflow: TextOverflow.ellipsis,
              ),
            ),

            // Link "Acceder"
            Row(
              children: [
                Text(
                  "Acceder",
                  style: TextStyle(
                    color: color,
                    fontWeight: FontWeight.bold,
                    fontSize: 12,
                  ),
                ),
                SizedBox(width: 5),
                Icon(Icons.chevron_right, color: color, size: 16),
              ],
            ),
          ],
        ),
      ),
    );
  }
}
