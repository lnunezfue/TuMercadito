import 'package:flutter/material.dart';
import '../../services/api_service.dart';
import '../../models/user.dart';
import '../../theme/app_colors.dart';

class UsersListScreen extends StatefulWidget {
  @override
  _UsersListScreenState createState() => _UsersListScreenState();
}

class _UsersListScreenState extends State<UsersListScreen> {
  final ApiService _api = ApiService();
  List<User> users = [];
  bool isLoading = true;

  @override
  void initState() {
    super.initState();
    _loadUsers();
  }

  void _loadUsers() async {
    setState(() => isLoading = true);
    try {
      final list = await _api.getUsers();
      setState(() {
        users = list;
        isLoading = false;
      });
    } catch (e) {
      setState(() => isLoading = false);
      ScaffoldMessenger.of(
        context,
      ).showSnackBar(SnackBar(content: Text("Error cargando usuarios")));
    }
  }

  void _showRoleDialog(User user) {
    showDialog(
      context: context,
      builder: (context) => AlertDialog(
        title: Text("Cambiar Rol"),
        content: Column(
          mainAxisSize: MainAxisSize.min,
          children: [
            Text("Selecciona el nuevo rol para ${user.nombre}:"),
            SizedBox(height: 20),
            ListTile(
              title: Text("Administrador"),
              leading: Icon(Icons.security, color: Colors.orange),
              onTap: () => _updateRole(user, 'admin'),
            ),
            ListTile(
              title: Text("Usuario"),
              leading: Icon(Icons.person, color: Colors.blue),
              onTap: () => _updateRole(user, 'usuario'),
            ),
          ],
        ),
      ),
    );
  }

  void _updateRole(User user, String newRole) async {
    Navigator.pop(context); // Cerrar diálogo

    if (user.rol == newRole) return; // No hacer nada si es el mismo

    try {
      bool success = await _api.changeRole(user.id, newRole);
      if (success) {
        setState(() {
          user.rol = newRole; // Actualizar UI localmente
        });
        ScaffoldMessenger.of(context).showSnackBar(
          SnackBar(
            content: Text("Rol actualizado"),
            backgroundColor: Colors.green,
          ),
        );
      }
    } catch (e) {
      ScaffoldMessenger.of(context).showSnackBar(
        SnackBar(
          content: Text("Error al cambiar rol"),
          backgroundColor: Colors.red,
        ),
      );
    }
  }

  void _delete(int id) async {
    bool confirm =
        await showDialog(
          context: context,
          builder: (context) => AlertDialog(
            title: Text("¿Eliminar usuario?"),
            content: Text("Esta acción es irreversible."),
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
      await _api.deleteUser(id);
      _loadUsers();
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: AppColors.background,
      appBar: AppBar(
        title: Text(
          "Gestionar Usuarios",
          style: TextStyle(
            color: AppColors.petroleum,
            fontWeight: FontWeight.bold,
          ),
        ),
        backgroundColor: Colors.white,
        iconTheme: IconThemeData(color: AppColors.petroleum),
      ),
      body: isLoading
          ? Center(child: CircularProgressIndicator())
          : ListView.builder(
              padding: EdgeInsets.all(15),
              itemCount: users.length,
              itemBuilder: (context, index) {
                final u = users[index];
                bool isAdmin = u.rol == 'admin';

                return Card(
                  elevation: 0,
                  margin: EdgeInsets.only(bottom: 10),
                  shape: RoundedRectangleBorder(
                    borderRadius: BorderRadius.circular(15),
                  ),
                  child: ListTile(
                    leading: CircleAvatar(
                      backgroundColor: isAdmin
                          ? Colors.orange.withOpacity(0.1)
                          : Colors.blue.withOpacity(0.1),
                      child: Icon(
                        isAdmin ? Icons.security : Icons.person,
                        color: isAdmin ? Colors.orange : Colors.blue,
                      ),
                    ),
                    title: Text(
                      u.nombre,
                      style: TextStyle(
                        fontWeight: FontWeight.bold,
                        color: AppColors.petroleumDark,
                      ),
                    ),
                    subtitle: Text(u.email),
                    trailing: Row(
                      mainAxisSize: MainAxisSize.min,
                      children: [
                        // Badge del Rol
                        Container(
                          padding: EdgeInsets.symmetric(
                            horizontal: 8,
                            vertical: 4,
                          ),
                          decoration: BoxDecoration(
                            color: isAdmin ? Colors.orange : Colors.grey[200],
                            borderRadius: BorderRadius.circular(10),
                          ),
                          child: Text(
                            isAdmin ? "ADMIN" : "USER",
                            style: TextStyle(
                              fontSize: 10,
                              fontWeight: FontWeight.bold,
                              color: isAdmin ? Colors.white : Colors.grey[600],
                            ),
                          ),
                        ),
                        SizedBox(width: 10),

                        // Botón Editar Rol (Solo si queremos gestión rápida)
                        IconButton(
                          icon: Icon(Icons.edit, color: Colors.grey, size: 20),
                          onPressed: () => _showRoleDialog(u),
                        ),

                        // Botón Eliminar
                        IconButton(
                          icon: Icon(
                            Icons.delete,
                            color: Colors.red[300],
                            size: 20,
                          ),
                          onPressed: () => _delete(u.id),
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
