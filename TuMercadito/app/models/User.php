<?php
class User {
    private $db;

    public function __construct(){
        $this->db = new Database;
    }

    public function register($data){
        $this->db->query('INSERT INTO usuarios (nombre, email, password_hash) VALUES(:nombre, :email, :password)');
        $this->db->bind(':nombre', $data['nombre']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':password', $data['password']);

        if($this->db->execute()){
            return true;
        } else {
            return false;
        }
    }

    public function login($email, $password){
        $this->db->query('SELECT * FROM usuarios WHERE email = :email');
        $this->db->bind(':email', $email);

        $row = $this->db->single();

        if($row){
            $hashed_password = $row->password_hash;
            if(password_verify($password, $hashed_password)){
                return $row;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function findUserByEmail($email){
        $this->db->query('SELECT * FROM usuarios WHERE email = :email');
        $this->db->bind(':email', $email);

        $row = $this->db->single();

        if($this->db->rowCount() > 0){
            return true;
        } else {
            return false;
        }
    }

    public function getUserById($id){
        $this->db->query("SELECT id_usuario, nombre, email, rol, fecha_registro FROM usuarios WHERE id_usuario = :id");
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    public function changePassword($userId, $newPassword){
        $hashed_password = password_hash($newPassword, PASSWORD_DEFAULT);
        $this->db->query("UPDATE usuarios SET password_hash = :password WHERE id_usuario = :id");
        $this->db->bind(':password', $hashed_password);
        $this->db->bind(':id', $userId);
        
        return $this->db->execute();
    }
}
