<?php
class Users extends Controller {
    public function __construct(){
        $this->userModel = $this->model('User');
    }

    public function register(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $data = [
                'nombre' => trim($_POST['nombre']),
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'confirm_password' => trim($_POST['confirm_password']),
                'nombre_err' => '',
                'email_err' => '',
                'password_err' => '',
                'confirm_password_err' => ''
            ];

            if(empty($data['email'])){
                $data['email_err'] = 'Por favor ingrese su email';
            } else {
                if($this->userModel->findUserByEmail($data['email'])){
                    $data['email_err'] = 'El email ya está registrado';
                }
            }
            if(empty($data['nombre'])){
                $data['nombre_err'] = 'Por favor ingrese su nombre';
            }
            if(empty($data['password'])){
                $data['password_err'] = 'Por favor ingrese una contraseña';
            } elseif(strlen($data['password']) < 6){
                $data['password_err'] = 'La contraseña debe tener al menos 6 caracteres';
            }
            if(empty($data['confirm_password'])){
                $data['confirm_password_err'] = 'Por favor confirme la contraseña';
            } else {
                if($data['password'] != $data['confirm_password']){
                    $data['confirm_password_err'] = 'Las contraseñas no coinciden';
                }
            }

            if(empty($data['email_err']) && empty($data['nombre_err']) && empty($data['password_err']) && empty($data['confirm_password_err'])){
                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
                if($this->userModel->register($data)){
                    flash('register_success', '¡Registro completado! Ya puedes iniciar sesión.');
                    header('Location: ' . URLROOT . '/users/login');
                } else {
                    die('Algo salió mal');
                }
            } else {
                $this->view('users/register', $data);
            }
        } else {
            $data = [
                'nombre' => '',
                'email' => '',
                'password' => '',
                'confirm_password' => '',
                'nombre_err' => '',
                'email_err' => '',
                'password_err' => '',
                'confirm_password_err' => ''
            ];
            $this->view('users/register', $data);
        }
    }

    public function login(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $data = [
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'email_err' => '',
                'password_err' => '',      
            ];

            if(empty($data['email'])){
                $data['email_err'] = 'Por favor ingrese su email';
            }
            if(empty($data['password'])){
                $data['password_err'] = 'Por favor ingrese su contraseña';
            }

            if($this->userModel->findUserByEmail($data['email'])){
                // Usuario encontrado
            } else {
                $data['email_err'] = 'Usuario no encontrado';
            }

            if(empty($data['email_err']) && empty($data['password_err'])){
                $loggedInUser = $this->userModel->login($data['email'], $data['password']);
                if($loggedInUser){
                    $this->createUserSession($loggedInUser);
                } else {
                    $data['password_err'] = 'Contraseña incorrecta';
                    $this->view('users/login', $data);
                }
            } else {
                $this->view('users/login', $data);
            }
        } else {
            $data = [
                'email' => '',
                'password' => '',
                'email_err' => '',
                'password_err' => '',
            ];
            $this->view('users/login', $data);
        }
    }

    public function createUserSession($user){
        $_SESSION['user_id'] = $user->id_usuario;
        $_SESSION['user_email'] = $user->email;
        $_SESSION['user_name'] = $user->nombre;
        $_SESSION['user_rol'] = $user->rol;
        header('Location: ' . URLROOT . '/pages/dashboard');
    }

    public function logout(){
        unset($_SESSION['user_id']);
        unset($_SESSION['user_email']);
        unset($_SESSION['user_name']);
        unset($_SESSION['user_rol']);
        session_destroy();
        header('Location: ' . URLROOT);
    }

    // Perfil de usuario
    public function profile(){
        if(!isLoggedIn()){
            header('Location: ' . URLROOT . '/users/login');
            exit();
        }

        $userId = $_SESSION['user_id'];

        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $newPassword = trim($_POST['new_password']);
            $confirmPassword = trim($_POST['confirm_password']);
            $password_err = '';

            if(empty($newPassword) || strlen($newPassword) < 6){
                $password_err = 'La nueva contraseña debe tener al menos 6 caracteres.';
            } elseif ($newPassword != $confirmPassword) {
                $password_err = 'Las contraseñas no coinciden.';
            }

            if(empty($password_err)){
                if($this->userModel->changePassword($userId, $newPassword)){
                    flash('profile_message', 'Contraseña actualizada correctamente.');
                } else {
                    flash('profile_message', 'Error al actualizar la contraseña.', 'alert alert-danger');
                }
            } else {
                 flash('profile_message', $password_err, 'alert alert-danger');
            }
            header('Location: ' . URLROOT . '/users/profile');
            exit();
        }
        
        $user = $this->userModel->getUserById($userId);
        $data = ['user' => $user];
        $this->view('users/profile', $data);
    }
}
