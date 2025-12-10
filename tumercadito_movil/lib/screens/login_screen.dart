import 'package:flutter/material.dart';
import '../services/api_service.dart';
import '../theme/app_colors.dart';
import 'home_layout.dart'; // Para ir al Dashboard si el login es correcto
import 'register_screen.dart'; // <--- No olvides esto al principio del archivo

class LoginScreen extends StatefulWidget {
  @override
  _LoginScreenState createState() => _LoginScreenState();
}

class _LoginScreenState extends State<LoginScreen> {
  final TextEditingController emailController = TextEditingController();
  final TextEditingController passwordController = TextEditingController();
  final ApiService apiService = ApiService();

  bool cargando = false;
  bool _isObscure = true; // Para el ojito de la contraseña

  void _login() async {
    if (emailController.text.isEmpty || passwordController.text.isEmpty) {
      ScaffoldMessenger.of(context).showSnackBar(
        SnackBar(
          content: Text("Por favor llena todos los campos"),
          backgroundColor: Colors.orange,
        ),
      );
      return;
    }

    setState(() {
      cargando = true;
    });

    try {
      // 1. Llamamos a la API
      final respuesta = await apiService.login(
        emailController.text.trim(),
        passwordController.text.trim(),
      );

      if (!mounted) return;

      // 2. Mensaje de éxito
      ScaffoldMessenger.of(context).showSnackBar(
        SnackBar(
          content: Text(
            "¡Bienvenido de nuevo, ${respuesta['user']['nombre']}!",
          ),
          backgroundColor: AppColors.primary,
        ),
      );

      // 3. Navegamos al Dashboard (HomeLayout)
      // Usamos pushReplacement para que no pueda volver al login con el botón "Atrás"
      Navigator.pushReplacement(
        context,
        MaterialPageRoute(
          builder: (context) => HomeLayout(
            userData: respuesta['user'],
          ), // <--- AQUÍ ENVIAMOS EL TICKET
        ),
      );
    } catch (e) {
      if (!mounted) return;
      ScaffoldMessenger.of(context).showSnackBar(
        SnackBar(
          content: Text(e.toString().replaceAll("Exception: ", "")),
          backgroundColor: Colors.red,
        ),
      );
    } finally {
      if (mounted)
        setState(() {
          cargando = false;
        });
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: AppColors.background, // Tu color gris clarito de fondo
      body: Center(
        child: SingleChildScrollView(
          padding: EdgeInsets.all(30),
          child: Column(
            mainAxisAlignment: MainAxisAlignment.center,
            children: [
              // --- 1. ENCABEZADO (Icono y Textos) ---
              Container(
                width: 80,
                height: 80,
                decoration: BoxDecoration(
                  color: AppColors.primary.withOpacity(0.1), // bg-success-soft
                  shape: BoxShape.circle,
                ),
                child: Icon(
                  Icons.lock_person,
                  color: AppColors.primary,
                  size: 40,
                ),
              ),
              SizedBox(height: 20),

              Text(
                "Bienvenido de nuevo",
                style: TextStyle(
                  fontSize: 26,
                  fontWeight: FontWeight.bold,
                  color: AppColors.petroleum, // text-petroleum
                ),
              ),
              SizedBox(height: 10),
              Text(
                "Ingresa tus credenciales para acceder.",
                style: TextStyle(color: Colors.grey, fontSize: 14),
              ),
              SizedBox(height: 40),

              // --- 2. TARJETA BLANCA (Formulario) ---
              Container(
                padding: EdgeInsets.all(30), // p-4 p-sm-5
                decoration: BoxDecoration(
                  color: Colors.white,
                  borderRadius: BorderRadius.circular(30), // rounded-4
                  boxShadow: [
                    BoxShadow(
                      color: Colors.black.withOpacity(
                        0.05,
                      ), // shadow-lg (suavizado)
                      blurRadius: 20,
                      offset: Offset(0, 10),
                    ),
                  ],
                ),
                child: Column(
                  crossAxisAlignment: CrossAxisAlignment.start,
                  children: [
                    // Label Email
                    _buildLabel("Correo Electrónico"),
                    SizedBox(height: 8),
                    TextField(
                      controller: emailController,
                      keyboardType: TextInputType.emailAddress,
                      decoration: _inputDecoration(
                        Icons.email_outlined,
                        "ejemplo@correo.com",
                      ),
                    ),

                    SizedBox(height: 25),

                    // Label Password
                    _buildLabel("Contraseña"),
                    SizedBox(height: 8),
                    TextField(
                      controller: passwordController,
                      obscureText: _isObscure,
                      decoration:
                          _inputDecoration(
                            Icons.vpn_key_outlined,
                            "••••••••",
                          ).copyWith(
                            suffixIcon: IconButton(
                              icon: Icon(
                                _isObscure
                                    ? Icons.visibility_off
                                    : Icons.visibility,
                                color: Colors.grey,
                              ),
                              onPressed: () {
                                setState(() {
                                  _isObscure = !_isObscure;
                                });
                              },
                            ),
                          ),
                    ),

                    SizedBox(height: 40),

                    // BOTÓN INICIAR SESIÓN
                    SizedBox(
                      width: double.infinity,
                      height: 55,
                      child: ElevatedButton(
                        onPressed: cargando ? null : _login,
                        style: ElevatedButton.styleFrom(
                          backgroundColor: AppColors.primary, // btn-success
                          shape: StadiumBorder(), // rounded-pill
                          elevation: 5,
                          shadowColor: AppColors.primary.withOpacity(0.4),
                        ),
                        child: cargando
                            ? CircularProgressIndicator(color: Colors.white)
                            : Text(
                                "Iniciar Sesión",
                                style: TextStyle(
                                  fontSize: 18,
                                  fontWeight: FontWeight.bold,
                                  color: Colors.white,
                                ),
                              ),
                      ),
                    ),

                    SizedBox(height: 20),

                    // Link Registro
                    Row(
                      mainAxisAlignment: MainAxisAlignment.center,
                      children: [
                        Text(
                          "¿Aún no tienes cuenta?",
                          style: TextStyle(color: Colors.grey, fontSize: 13),
                        ),
                        TextButton(
                          onPressed: () {
                            Navigator.push(
                              context,
                              MaterialPageRoute(
                                builder: (context) => RegisterScreen(),
                              ),
                            );
                          },
                          child: Text(
                            "Regístrate gratis",
                            style: TextStyle(
                              fontWeight: FontWeight.bold,
                              color: AppColors.primary,
                            ),
                          ),
                        ),
                      ],
                    ),
                  ],
                ),
              ),

              SizedBox(height: 30),

              // --- 3. VOLVER AL INICIO ---
              TextButton.icon(
                onPressed: () {
                  Navigator.pop(context); // Vuelve atrás (al Landing)
                },
                icon: Icon(Icons.arrow_back, size: 16, color: Colors.grey),
                label: Text(
                  "Volver al inicio",
                  style: TextStyle(color: Colors.grey),
                ),
              ),
            ],
          ),
        ),
      ),
    );
  }

  // Helper para el estilo de los Inputs (bg-light border-0)
  InputDecoration _inputDecoration(IconData icon, String hint) {
    return InputDecoration(
      filled: true,
      fillColor: Color(0xFFF8F9FA), // bg-light de Bootstrap
      hintText: hint,
      hintStyle: TextStyle(color: Colors.grey[400]),
      prefixIcon: Icon(icon, color: Colors.grey),
      border: OutlineInputBorder(
        borderRadius: BorderRadius.circular(15),
        borderSide: BorderSide.none, // Sin borde
      ),
      focusedBorder: OutlineInputBorder(
        borderRadius: BorderRadius.circular(15),
        borderSide: BorderSide(
          color: AppColors.primary,
          width: 1.5,
        ), // Borde verde al enfocar
      ),
      contentPadding: EdgeInsets.symmetric(vertical: 20),
    );
  }

  // Helper para los Labels (TEXT-UPPERCASE SMALL)
  Widget _buildLabel(String text) {
    return Text(
      text.toUpperCase(),
      style: TextStyle(
        fontSize: 11,
        fontWeight: FontWeight.bold,
        color: Colors.grey[600],
        letterSpacing: 0.5,
      ),
    );
  }
}
