import 'package:flutter/material.dart';
import '../theme/app_colors.dart';
import '../widgets/side_menu.dart';
import 'dashboard_screen.dart';

class HomeLayout extends StatefulWidget {
  // 1. CAMBIO: Agregamos la variable para recibir los datos del Login
  final Map<String, dynamic> userData;

  // 2. CAMBIO: Actualizamos el constructor para exigirlos
  const HomeLayout({Key? key, required this.userData}) : super(key: key);

  @override
  _HomeLayoutState createState() => _HomeLayoutState();
}

class _HomeLayoutState extends State<HomeLayout> {
  String tituloPagina = "Panel de Control";

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: AppColors.background,

      // --- HEADER ---
      appBar: AppBar(
        backgroundColor: AppColors.background,
        elevation: 0,
        iconTheme: IconThemeData(color: AppColors.petroleum),

        title: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            Text(
              tituloPagina,
              style: TextStyle(
                color: AppColors.petroleum,
                fontWeight: FontWeight.bold,
                fontSize: 18,
              ),
            ),
            Text(
              "Gestiona tus compras inteligentemente",
              style: TextStyle(color: Colors.grey, fontSize: 10),
            ),
          ],
        ),

        actions: [
          Padding(
            padding: const EdgeInsets.only(right: 15.0),
            child: CircleAvatar(
              backgroundColor: Colors.white,
              // 3. CAMBIO: Ahora mostramos la inicial real del usuario
              child: Text(
                widget.userData['nombre'][0].toUpperCase(),
                style: TextStyle(
                  color: AppColors.primary,
                  fontWeight: FontWeight.bold,
                ),
              ),
            ),
          ),
        ],
      ),

      // --- SIDEBAR ---
      // En HomeLayout...
      drawer: SideMenu(
        userData: widget.userData,
      ), // <--- Pasamos los datos aquí
      // --- MAIN CONTENT ---
      body: Padding(
        padding: const EdgeInsets.all(20.0),
        // 4. CAMBIO IMPORTANTE: Aquí pasamos los datos al hijo
        child: DashboardScreen(usuario: widget.userData),
      ),
    );
  }
}
