class User {
  final int id;
  final String nombre;
  final String email;
  String rol; // Mutable para poder cambiarlo en la UI
  final String? fechaRegistro;

  User({
    required this.id,
    required this.nombre,
    required this.email,
    required this.rol,
    this.fechaRegistro,
  });

  factory User.fromJson(Map<String, dynamic> json) {
    return User(
      id: int.parse(json['id_usuario'].toString()),
      nombre: json['nombre'],
      email: json['email'],
      rol: json['rol'],
      fechaRegistro: json['fecha_registro'],
    );
  }
}
