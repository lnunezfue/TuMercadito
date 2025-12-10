<?php
class Graficos extends Controller {
    public function __construct(){
        if(!isLoggedIn()){
            header('Location: ' . URLROOT . '/users/login');
        }
        $this->rankingModel = $this->model('RankingModel');
        $this->adminModel = $this->model('AdminModel');
    }

    public function index(){
        $products = $this->rankingModel->getAllProducts();
        $markets = $this->adminModel->getMarkets();

        $data = [
            'title' => 'Gráficos de Tendencia de Precios',
            'products' => $products,
            'markets' => $markets
        ];
        
        $this->view('graficos/index', $data);
    }
}
