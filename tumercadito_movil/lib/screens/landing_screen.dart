import 'package:flutter/material.dart';
import '../theme/app_colors.dart';
import 'register_screen.dart';
import 'login_screen.dart'; // Importamos para poder navegar al Login

class LandingScreen extends StatelessWidget {
  @override
  Widget build(BuildContext context) {
    // Usamos Stack para poner la imagen de fondo y encima el contenido
    return Scaffold(
      body: Stack(
        children: [
          // CAPA 1: Imagen de Fondo (La misma de tu header CSS)
          Container(
            decoration: BoxDecoration(
              image: DecorationImage(
                image: NetworkImage(
                  'https://st3.depositphotos.com/1542745/14200/i/450/depositphotos_142004792-stock-photo-empty-wooden-table-with-blurred.jpg',
                ),
                fit: BoxFit.cover,
              ),
            ),
          ),

          // CAPA 2: El Gradiente Blanco/Gris (hero-section)
          // Esto hace que el texto sea legible
          Container(
            decoration: BoxDecoration(
              gradient: LinearGradient(
                begin: Alignment.topCenter,
                end: Alignment.bottomCenter,
                colors: [
                  Color(0xFFF5F6F7).withOpacity(0.9), // Arriba muy opaco
                  Color(
                    0xFFF5F6F7,
                  ).withOpacity(0.7), // Abajo un poco más transparente
                ],
              ),
            ),
          ),

          // CAPA 3: El Contenido Centrado
          Center(
            child: SingleChildScrollView(
              // Para pantallas pequeñas
              padding: EdgeInsets.all(30),
              child: Column(
                mainAxisAlignment: MainAxisAlignment.center,
                children: [
                  // --- ICONO ---
                  Container(
                    padding: EdgeInsets.all(20),
                    decoration: BoxDecoration(
                      color: Colors.white,
                      shape: BoxShape.circle,
                      boxShadow: [
                        BoxShadow(
                          color: AppColors.primary.withOpacity(0.2),
                          blurRadius: 20,
                          offset: Offset(0, 5),
                        ),
                      ],
                    ),
                    child: Icon(
                      Icons.shopping_basket,
                      size: 60, // Equivalente a fa-4x
                      color: AppColors.primary, // text-success
                    ),
                  ),

                  SizedBox(height: 30), // mb-3
                  // --- TÍTULO ---
                  Text(
                    "TuMercadito", // $data['title']
                    style: TextStyle(
                      fontSize: 40, // display-4
                      fontWeight: FontWeight.bold, // fw-bold
                      color: AppColors.petroleumDark, // text-petroleum
                      letterSpacing: -1,
                    ),
                  ),

                  SizedBox(height: 15), // mb-3
                  // --- DESCRIPCIÓN ---
                  Text(
                    "Comienza a planificar tus compras de manera eficiente y ahorra en cada visita al mercado.", // $data['description']
                    textAlign: TextAlign.center,
                    style: TextStyle(
                      fontSize: 16, // lead
                      color: Colors.grey[700], // text-muted
                      height: 1.5,
                    ),
                  ),

                  SizedBox(height: 50), // mb-5
                  // --- BOTONES ---
                  // Botón 1: Registrarse
                  SizedBox(
                    width: double.infinity,
                    height: 55,
                    child: ElevatedButton(
                      onPressed: () {
                        // Navegar a Registro (Aun no lo tenemos)
                        Navigator.push(
                          context,
                          MaterialPageRoute(
                            builder: (context) => RegisterScreen(),
                          ),
                        );
                      },
                      style: ElevatedButton.styleFrom(
                        backgroundColor: AppColors.primary, // btn-success
                        shape: StadiumBorder(), // rounded-pill
                        elevation: 5,
                        shadowColor: AppColors.primary.withOpacity(0.4),
                      ),
                      child: Text(
                        "Regístrate Gratis",
                        style: TextStyle(
                          fontSize: 18,
                          fontWeight: FontWeight.bold,
                          color: Colors.white,
                        ),
                      ),
                    ),
                  ),

                  SizedBox(height: 20), // gap-3
                  // Botón 2: Iniciar Sesión (Outline)
                  SizedBox(
                    width: double.infinity,
                    height: 55,
                    child: OutlinedButton(
                      onPressed: () {
                        // Navegar al Login
                        Navigator.push(
                          context,
                          MaterialPageRoute(
                            builder: (context) => LoginScreen(),
                          ),
                        );
                      },
                      style: OutlinedButton.styleFrom(
                        side: BorderSide(
                          color: Colors.grey,
                          width: 2,
                        ), // btn-outline-secondary
                        shape: StadiumBorder(), // rounded-pill
                      ),
                      child: Text(
                        "Inicia Sesión",
                        style: TextStyle(
                          fontSize: 18,
                          fontWeight: FontWeight.bold,
                          color: Colors.grey[700],
                        ),
                      ),
                    ),
                  ),

                  SizedBox(height: 20),
                  // Link pequeño por si acaso
                  TextButton(
                    onPressed: () {},
                    child: Text(
                      "¿Olvidaste tu contraseña?",
                      style: TextStyle(color: Colors.grey),
                    ),
                  ),
                ],
              ),
            ),
          ),
        ],
      ),
    );
  }
}
