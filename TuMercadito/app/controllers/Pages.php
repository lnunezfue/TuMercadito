<?php
class Pages extends Controller {
    public function __construct(){
    }
    
    public function index(){
        if(isLoggedIn()){
            header('Location: ' . URLROOT . '/pages/dashboard');
        }
        $data = [
            'title' => 'Bienvenido a TuMercadito',
            'description' => 'La herramienta inteligente para comparar precios y ahorrar en tus compras.'
        ];
        
        $this->view('pages/index', $data);
    }

    public function dashboard(){
        $data = [];
        $this->view('pages/dashboard', $data);
    }
}
