import 'package:flutter/material.dart';
import 'package:tumercadito_movil/screens/comparador_screen.dart';
import 'package:tumercadito_movil/screens/markets_screen.dart';
import '../theme/app_colors.dart';
import 'chart_screen.dart'; // Importamos la pantalla de gráficos para el botón
import 'ranking_screen.dart';

class DashboardScreen extends StatelessWidget {
  // 1. Variable para recibir los datos del usuario logueado
  final Map<String, dynamic> usuario;

  // 2. Constructor actualizado para exigir los datos
  const DashboardScreen({Key? key, required this.usuario}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return SingleChildScrollView(
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          // --- 1. BIENVENIDA DINÁMICA ---
          Text(
            "Hola, ${usuario['nombre']} 👋", // <--- AQUÍ SE MUESTRA EL NOMBRE REAL
            style: TextStyle(
              fontSize: 28,
              fontWeight: FontWeight.bold,
              color: AppColors.petroleumDark,
            ),
          ),
          Text(
            "Bienvenido a tu panel personal de ahorro.",
            style: TextStyle(fontSize: 16, color: Colors.grey[600]),
          ),

          SizedBox(height: 30),

          // --- 2. BLOQUE DESTACADO (Hero Card) ---
          _HeroCard(),

          SizedBox(height: 30),

          // --- 3. ACCESOS RÁPIDOS (Grid) ---
          GridView.count(
            crossAxisCount: 2,
            shrinkWrap: true,
            physics: NeverScrollableScrollPhysics(),
            crossAxisSpacing: 15,
            mainAxisSpacing: 15,
            childAspectRatio: 0.85,
            children: [
              _ActionCard(
                title: "Ver Gráficos",
                subtitle: "Tendencia histórica",
                icon: Icons.show_chart,
                color: Colors.blue,
                onTap: () {
                  // Navegamos a la pantalla de gráficos que creamos antes
                  Navigator.push(
                    context,
                    MaterialPageRoute(builder: (context) => ChartScreen()),
                  );
                },
              ),
              _ActionCard(
                title: "Ranking",
                subtitle: "¿Dónde es más barato?",
                icon: Icons.emoji_events,
                color: Colors.orange,
                onTap: () {
                  Navigator.push(
                    context,
                    MaterialPageRoute(builder: (context) => RankingScreen()),
                  );
                },
              ),
              _ActionCard(
                title: "Mercados",
                subtitle: "Tus lugares favoritos",
                icon: Icons.store,
                color: AppColors.petroleum,
                onTap: () {
                  Navigator.push(
                    context,
                    MaterialPageRoute(builder: (context) => MarketsScreen()),
                  );
                },
              ),
            ],
          ),

          SizedBox(height: 20),
        ],
      ),
    );
  }
}

// ==========================================
// WIDGETS INTERNOS (Sin cambios)
// ==========================================

class _HeroCard extends StatelessWidget {
  @override
  Widget build(BuildContext context) {
    return Container(
      width: double.infinity,
      padding: EdgeInsets.all(25),
      decoration: BoxDecoration(
        color: Colors.white,
        borderRadius: BorderRadius.circular(25),
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
          Container(
            padding: EdgeInsets.symmetric(horizontal: 12, vertical: 6),
            decoration: BoxDecoration(
              color: AppColors.primary.withOpacity(0.1),
              borderRadius: BorderRadius.circular(20),
            ),
            child: Text(
              "Herramienta Principal",
              style: TextStyle(
                color: AppColors.primary,
                fontWeight: FontWeight.bold,
                fontSize: 12,
              ),
            ),
          ),
          SizedBox(height: 15),

          Text(
            "Comparador Inteligente",
            style: TextStyle(
              fontSize: 22,
              fontWeight: FontWeight.bold,
              color: AppColors.petroleumDark,
              height: 1.1,
            ),
          ),
          SizedBox(height: 10),

          Text(
            "Crea tu lista y descubre dónde gastarás menos hoy.",
            style: TextStyle(color: Colors.grey[600], fontSize: 14),
          ),
          SizedBox(height: 20),

          SizedBox(
            width: double.infinity,
            child: ElevatedButton.icon(
              onPressed: () {
                Navigator.push(
                  context,
                  MaterialPageRoute(builder: (context) => ComparadorScreen()),
                );
              },
              icon: Icon(Icons.search, color: Colors.white),
              label: Text(
                "Ir al Comparador",
                style: TextStyle(
                  color: Colors.white,
                  fontWeight: FontWeight.bold,
                ),
              ),
              style: ElevatedButton.styleFrom(
                backgroundColor: AppColors.primary,
                padding: EdgeInsets.symmetric(vertical: 15),
                shape: RoundedRectangleBorder(
                  borderRadius: BorderRadius.circular(15),
                ),
                elevation: 0,
              ),
            ),
          ),
        ],
      ),
    );
  }
}

class _ActionCard extends StatelessWidget {
  final String title;
  final String subtitle;
  final IconData icon;
  final Color color;
  final VoidCallback onTap;

  const _ActionCard({
    required this.title,
    required this.subtitle,
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
              color: Colors.black.withOpacity(0.04),
              blurRadius: 10,
              offset: Offset(0, 4),
            ),
          ],
        ),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          mainAxisAlignment: MainAxisAlignment.center,
          children: [
            Container(
              width: 50,
              height: 50,
              decoration: BoxDecoration(
                color: color.withOpacity(0.1),
                shape: BoxShape.circle,
              ),
              child: Icon(icon, color: color, size: 24),
            ),
            Spacer(),
            Text(
              title,
              style: TextStyle(
                fontWeight: FontWeight.bold,
                fontSize: 16,
                color: AppColors.petroleumDark,
              ),
            ),
            SizedBox(height: 4),
            Text(
              subtitle,
              style: TextStyle(fontSize: 11, color: Colors.grey),
              maxLines: 2,
              overflow: TextOverflow.ellipsis,
            ),
          ],
        ),
      ),
    );
  }
}
