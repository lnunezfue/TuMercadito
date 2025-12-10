import 'dart:convert';
import 'package:http/http.dart' as http;
import 'package:tumercadito_movil/models/user.dart';
import '../models/price_history.dart';
import '../models/product.dart';
import '../models/ranking_item.dart';
import '../models/market.dart'; // Asegúrate de haber creado este modelo en el paso anterior

class ApiService {
  // ⚠️ CONFIGURACIÓN DE URL
  // Si usas Emulador Android: '10.0.2.2'
  // Si usas Celular Físico (USB): La IP de tu PC (ej: 192.168.1.XX)
  final String baseUrl =
      "https://reinaldo-unfoaming-cozeningly.ngrok-free.dev/TuMercadito/Api";

  // ==========================================
  // 1. AUTENTICACIÓN
  // ==========================================

  // Login
  Future<Map<String, dynamic>> login(String email, String password) async {
    final url = Uri.parse('$baseUrl/login');

    try {
      final response = await http.post(
        url,
        headers: {"Content-Type": "application/json"},
        body: jsonEncode({"email": email, "password": password}),
      );

      if (response.statusCode == 200) {
        return jsonDecode(response.body);
      } else {
        final errorData = jsonDecode(response.body);
        throw Exception(errorData['error'] ?? 'Error desconocido');
      }
    } catch (e) {
      throw Exception('Error de conexión: $e');
    }
  }

  // Registro
  Future<bool> register(
    String nombre,
    String email,
    String password,
    String confirmPassword,
  ) async {
    final url = Uri.parse('$baseUrl/register');

    try {
      final response = await http.post(
        url,
        headers: {"Content-Type": "application/json"},
        body: jsonEncode({
          "nombre": nombre,
          "email": email,
          "password": password,
          "confirm_password": confirmPassword,
        }),
      );

      if (response.statusCode == 200) {
        return true;
      } else {
        final errorData = jsonDecode(response.body);
        throw Exception(errorData['error'] ?? 'Error al registrar');
      }
    } catch (e) {
      throw Exception('Error de conexión: $e');
    }
  }

  // ==========================================
  // 2. GRÁFICOS E HISTORIAL
  // ==========================================

  // Obtener historial de precios (con predicción)
  Future<PriceHistory> getHistory(int productId, int marketId) async {
    final url = Uri.parse('$baseUrl/priceHistory/$productId/$marketId');

    try {
      final response = await http.get(url);

      if (response.statusCode == 200) {
        final jsonData = jsonDecode(response.body);
        return PriceHistory.fromJson(jsonData);
      } else {
        throw Exception('Error al cargar historial: ${response.body}');
      }
    } catch (e) {
      throw Exception('Error de conexión: $e');
    }
  }

  // ==========================================
  // 3. COMPARADOR Y LISTAS
  // ==========================================

  // Obtener lista de productos (Dropdown)
  Future<List<Product>> getProducts() async {
    final url = Uri.parse('$baseUrl/getProducts');

    try {
      final response = await http.get(url);

      if (response.statusCode == 200) {
        final List<dynamic> data = jsonDecode(response.body);
        return data.map((json) => Product.fromJson(json)).toList();
      } else {
        throw Exception('Error cargando productos');
      }
    } catch (e) {
      throw Exception('Error conexión: $e');
    }
  }

  // Obtener lista de mercados (Dropdown)
  Future<List<Market>> getMarkets() async {
    final url = Uri.parse('$baseUrl/getMarkets');

    try {
      final response = await http.get(url);

      if (response.statusCode == 200) {
        final List<dynamic> data = jsonDecode(response.body);
        return data.map((json) => Market.fromJson(json)).toList();
      } else {
        throw Exception('Error cargando mercados');
      }
    } catch (e) {
      throw Exception('Error conexión: $e');
    }
  }
  // ... resto del código ...

  // D. Obtener listado completo de mercados (con detalles)
  Future<List<Market>> getAllMarkets() async {
    final url = Uri.parse('$baseUrl/getAllMarkets');

    try {
      final response = await http.get(url);

      if (response.statusCode == 200) {
        final List<dynamic> data = jsonDecode(response.body);
        return data.map((json) => Market.fromJson(json)).toList();
      } else {
        throw Exception('Error cargando mercados');
      }
    } catch (e) {
      throw Exception('Error conexión: $e');
    }
  }

  // Enviar lista para comparar precios
  Future<Map<String, dynamic>> comparePrices(
    List<Map<String, dynamic>> items,
  ) async {
    final url = Uri.parse('$baseUrl/compare');

    try {
      final response = await http.post(
        url,
        headers: {"Content-Type": "application/json"},
        body: jsonEncode({"items": items}),
      );

      if (response.statusCode == 200) {
        return jsonDecode(response.body);
      } else {
        throw Exception('Error al comparar: ${response.body}');
      }
    } catch (e) {
      throw Exception('Error de conexión: $e');
    }
  }

  // ==========================================
  // 4. RANKING
  // ==========================================
  Future<List<RankingItem>> getRanking(int productId) async {
    final url = Uri.parse('$baseUrl/getRanking/$productId');

    try {
      final response = await http.get(url);

      if (response.statusCode == 200) {
        final List<dynamic> data = jsonDecode(response.body);
        return data.map((json) => RankingItem.fromJson(json)).toList();
      } else {
        if (response.statusCode == 404) return [];
        throw Exception('Error al cargar ranking');
      }
    } catch (e) {
      throw Exception('Error de conexión: $e');
    }
  }
  // ... resto del código ...

  // E. Actualizar Contraseña
  Future<bool> updatePassword(
    int userId,
    String newPass,
    String confirmPass,
  ) async {
    final url = Uri.parse('$baseUrl/updatePassword');

    try {
      final response = await http.post(
        url,
        headers: {"Content-Type": "application/json"},
        body: jsonEncode({
          "user_id": userId,
          "new_password": newPass,
          "confirm_password": confirmPass,
        }),
      );

      if (response.statusCode == 200) {
        return true;
      } else {
        final errorData = jsonDecode(response.body);
        throw Exception(errorData['error'] ?? 'Error al actualizar');
      }
    } catch (e) {
      throw Exception('Error de conexión: $e');
    }
  }
  // ... resto del código ...

  // F. Actualizar Precio (Admin)
  Future<bool> updatePrice(int productId, int marketId, double newPrice) async {
    final url = Uri.parse('$baseUrl/updatePrice');

    try {
      final response = await http.post(
        url,
        headers: {"Content-Type": "application/json"},
        body: jsonEncode({
          "product_id": productId,
          "market_id": marketId,
          "new_price": newPrice,
        }),
      );

      if (response.statusCode == 200) {
        return true;
      } else {
        final errorData = jsonDecode(response.body);
        throw Exception(errorData['error'] ?? 'Error al actualizar precio');
      }
    } catch (e) {
      throw Exception('Error de conexión: $e');
    }
  }
  // ... resto del código ...

  // G. CRUD PRODUCTOS
  Future<bool> addProduct(
    String nombre,
    String unidad,
    String categoria,
  ) async {
    final url = Uri.parse('$baseUrl/addProduct');
    try {
      final response = await http.post(
        url,
        headers: {"Content-Type": "application/json"},
        body: jsonEncode({
          "nombre": nombre,
          "unidad": unidad,
          "categoria": categoria,
        }),
      );
      return response.statusCode == 200;
    } catch (e) {
      throw Exception('Error al agregar');
    }
  }

  Future<bool> editProduct(
    int id,
    String nombre,
    String unidad,
    String categoria,
  ) async {
    final url = Uri.parse('$baseUrl/editProduct');
    try {
      final response = await http.post(
        url,
        headers: {"Content-Type": "application/json"},
        body: jsonEncode({
          "id": id,
          "nombre": nombre,
          "unidad": unidad,
          "categoria": categoria,
        }),
      );
      return response.statusCode == 200;
    } catch (e) {
      throw Exception('Error al editar');
    }
  }

  Future<bool> deleteProduct(int id) async {
    final url = Uri.parse(
      '$baseUrl/deleteProduct/$id',
    ); // Asegúrate que tu router soporte esto o usa POST
    try {
      // Si tu router no soporta /id en la url, cambia a POST y envía el ID en el body
      final response = await http.post(url);
      return response.statusCode == 200;
    } catch (e) {
      throw Exception('Error al eliminar');
    }
  }
  // ... resto del código ...

  // H. CRUD MERCADOS
  Future<bool> addMarket(
    String nombre,
    String distrito,
    String direccion,
  ) async {
    final url = Uri.parse('$baseUrl/addMarket');
    try {
      final response = await http.post(
        url,
        headers: {"Content-Type": "application/json"},
        body: jsonEncode({
          "nombre": nombre,
          "distrito": distrito,
          "direccion": direccion,
        }),
      );
      return response.statusCode == 200;
    } catch (e) {
      throw Exception('Error al agregar');
    }
  }

  Future<bool> editMarket(
    int id,
    String nombre,
    String distrito,
    String direccion,
  ) async {
    final url = Uri.parse('$baseUrl/editMarket');
    try {
      final response = await http.post(
        url,
        headers: {"Content-Type": "application/json"},
        body: jsonEncode({
          "id": id,
          "nombre": nombre,
          "distrito": distrito,
          "direccion": direccion,
        }),
      );
      return response.statusCode == 200;
    } catch (e) {
      throw Exception('Error al editar');
    }
  }

  Future<bool> deleteMarket(int id) async {
    final url = Uri.parse('$baseUrl/deleteMarket/$id');
    try {
      final response = await http.post(url);
      return response.statusCode == 200;
    } catch (e) {
      throw Exception('Error al eliminar');
    }
  }

  // I. GESTIÓN DE USUARIOS
  Future<List<User>> getUsers() async {
    final url = Uri.parse('$baseUrl/getUsers');
    try {
      final response = await http.get(url);
      if (response.statusCode == 200) {
        final List<dynamic> data = jsonDecode(response.body);
        return data.map((json) => User.fromJson(json)).toList();
      } else {
        throw Exception('Error cargando usuarios');
      }
    } catch (e) {
      throw Exception('Error conexión: $e');
    }
  }

  Future<bool> changeRole(int userId, String newRole) async {
    final url = Uri.parse('$baseUrl/changeRole');
    try {
      final response = await http.post(
        url,
        headers: {"Content-Type": "application/json"},
        body: jsonEncode({"user_id": userId, "rol": newRole}),
      );
      return response.statusCode == 200;
    } catch (e) {
      throw Exception('Error al cambiar rol');
    }
  }

  Future<bool> deleteUser(int id) async {
    final url = Uri.parse('$baseUrl/deleteUser/$id');
    try {
      final response = await http.post(url);
      return response.statusCode == 200;
    } catch (e) {
      throw Exception('Error al eliminar');
    }
  }
}
