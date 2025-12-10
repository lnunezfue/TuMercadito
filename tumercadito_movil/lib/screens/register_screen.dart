import 'package:flutter/material.dart';
import '../services/api_service.dart';
import '../theme/app_colors.dart';
import 'login_screen.dart'; // Para redirigir tras el registro

class RegisterScreen extends StatefulWidget {
  @override
  _RegisterScreenState createState() => _RegisterScreenState();
}

class _RegisterScreenState extends State<RegisterScreen> {
  // Controladores de texto
  final TextEditingController nameCtrl = TextEditingController();
  final TextEditingController emailCtrl = TextEditingController();
  final TextEditingController passCtrl = TextEditingController();
  final TextEditingController confirmCtrl = TextEditingController();

  final ApiService apiService = ApiService();
  bool cargando = false;
  bool _obscurePass = true; // Para ocultar contraseña 1
  bool _obscureConfirm = true; // Para ocultar contraseña 2

  void _register() async {
    // 1. Validaciones Locales
    if (nameCtrl.text.isEmpty ||
        emailCtrl.text.isEmpty ||
        passCtrl.text.isEmpty) {
      ScaffoldMessenger.of(context).showSnackBar(
        SnackBar(
          content: Text("Todos los campos son obligatorios"),
          backgroundColor: Colors.orange,
        ),
      );
      return;
    }

    if (passCtrl.text != confirmCtrl.text) {
      ScaffoldMessenger.of(context).showSnackBar(
        SnackBar(
          content: Text("Las contraseñas no coinciden"),
          backgroundColor: Colors.red,
        ),
      );
      return;
    }

    setState(() {
      cargando = true;
    });

    try {
      // 2. Llamada a la API
      await apiService.register(
        nameCtrl.text.trim(),
        emailCtrl.text.trim(),
        passCtrl.text.trim(),
        confirmCtrl.text.trim(),
      );

      if (!mounted) return;

      // 3. Éxito
      ScaffoldMessenger.of(context).showSnackBar(
        SnackBar(
          content: Text("¡Cuenta creada! Inicia sesión."),
          backgroundColor: AppColors.primary,
        ),
      );

      // Redirigir al Login
      Navigator.pushReplacement(
        context,
        MaterialPageRoute(builder: (context) => LoginScreen()),
      );
    } catch (e) {
      // Error
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
      backgroundColor: AppColors.background,
      appBar: AppBar(
        backgroundColor: Colors.transparent,
        elevation: 0,
        leading: IconButton(
          icon: Icon(Icons.arrow_back, color: AppColors.petroleum),
          onPressed: () => Navigator.pop(context),
        ),
      ),
      body: Center(
        child: SingleChildScrollView(
          padding: EdgeInsets.all(30),
          child: Column(
            mainAxisAlignment: MainAxisAlignment.center,
            children: [
              // --- ENCABEZADO ---
              Text(
                "Crear Cuenta",
                style: TextStyle(
                  fontSize: 28,
                  fontWeight: FontWeight.bold,
                  color: AppColors.petroleum,
                ),
              ),
              SizedBox(height: 10),
              Text(
                "Únete y empieza a ahorrar.",
                style: TextStyle(color: Colors.grey, fontSize: 14),
              ),
              SizedBox(height: 30),

              // --- TARJETA BLANCA ---
              Container(
                padding: EdgeInsets.all(25),
                decoration: BoxDecoration(
                  color: Colors.white,
                  borderRadius: BorderRadius.circular(30), // rounded-4
                  boxShadow: [
                    BoxShadow(
                      color: Colors.black.withOpacity(0.05),
                      blurRadius: 20,
                      offset: Offset(0, 10),
                    ),
                  ],
                ),
                child: Column(
                  crossAxisAlignment: CrossAxisAlignment.start,
                  children: [
                    // Nombre
                    _buildLabel("Nombre Completo"),
                    SizedBox(height: 8),
                    TextField(
                      controller: nameCtrl,
                      decoration: _inputDecoration(
                        Icons.person_outline,
                        "Tu nombre",
                      ),
                    ),
                    SizedBox(height: 20),

                    // Email
                    _buildLabel("Correo Electrónico"),
                    SizedBox(height: 8),
                    TextField(
                      controller: emailCtrl,
                      keyboardType: TextInputType.emailAddress,
                      decoration: _inputDecoration(
                        Icons.email_outlined,
                        "tucorreo@ejemplo.com",
                      ),
                    ),
                    SizedBox(height: 20),

                    // Contraseña
                    _buildLabel("Contraseña"),
                    SizedBox(height: 8),
                    TextField(
                      controller: passCtrl,
                      obscureText: _obscurePass,
                      decoration: _inputDecoration(Icons.lock_outline, "••••••")
                          .copyWith(
                            suffixIcon: IconButton(
                              icon: Icon(
                                _obscurePass
                                    ? Icons.visibility_off
                                    : Icons.visibility,
                                color: Colors.grey,
                              ),
                              onPressed: () =>
                                  setState(() => _obscurePass = !_obscurePass),
                            ),
                          ),
                    ),
                    SizedBox(height: 20),

                    // Confirmar Contraseña
                    _buildLabel("Confirmar"),
                    SizedBox(height: 8),
                    TextField(
                      controller: confirmCtrl,
                      obscureText: _obscureConfirm,
                      decoration: _inputDecoration(Icons.lock_reset, "••••••")
                          .copyWith(
                            suffixIcon: IconButton(
                              icon: Icon(
                                _obscureConfirm
                                    ? Icons.visibility_off
                                    : Icons.visibility,
                                color: Colors.grey,
                              ),
                              onPressed: () => setState(
                                () => _obscureConfirm = !_obscureConfirm,
                              ),
                            ),
                          ),
                    ),
                    SizedBox(height: 30),

                    // BOTÓN REGISTRARSE
                    SizedBox(
                      width: double.infinity,
                      height: 55,
                      child: ElevatedButton(
                        onPressed: cargando ? null : _register,
                        style: ElevatedButton.styleFrom(
                          backgroundColor: AppColors.primary,
                          shape: StadiumBorder(),
                          elevation: 5,
                        ),
                        child: cargando
                            ? CircularProgressIndicator(color: Colors.white)
                            : Text(
                                "Registrarse",
                                style: TextStyle(
                                  fontSize: 18,
                                  fontWeight: FontWeight.bold,
                                  color: Colors.white,
                                ),
                              ),
                      ),
                    ),
                  ],
                ),
              ),

              SizedBox(height: 20),

              // --- FOOTER ---
              Row(
                mainAxisAlignment: MainAxisAlignment.center,
                children: [
                  Text(
                    "¿Ya tienes una cuenta?",
                    style: TextStyle(color: Colors.grey),
                  ),
                  TextButton(
                    onPressed: () {
                      // Ir al Login
                      Navigator.pushReplacement(
                        context,
                        MaterialPageRoute(builder: (context) => LoginScreen()),
                      );
                    },
                    child: Text(
                      "Inicia Sesión",
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
      ),
    );
  }

  // Estilos reutilizables (Igual que en Login)
  InputDecoration _inputDecoration(IconData icon, String hint) {
    return InputDecoration(
      filled: true,
      fillColor: Color(0xFFF8F9FA), // bg-light
      hintText: hint,
      prefixIcon: Icon(icon, color: Colors.grey),
      border: OutlineInputBorder(
        borderRadius: BorderRadius.circular(15),
        borderSide: BorderSide.none,
      ),
      contentPadding: EdgeInsets.symmetric(vertical: 18),
    );
  }

  Widget _buildLabel(String text) {
    return Text(
      text.toUpperCase(),
      style: TextStyle(
        fontSize: 11,
        fontWeight: FontWeight.bold,
        color: Colors.grey[600],
      ),
    );
  }
}
