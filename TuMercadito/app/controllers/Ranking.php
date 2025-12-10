<?php
class Ranking extends Controller {
    public function __construct(){
        if(!isLoggedIn()){
            header('Location: ' . URLROOT . '/users/login');
        }
        $this->rankingModel = $this->model('RankingModel');
    }

    public function index(){
        $rankingData = [];
        $selectedProduct = null;

        if($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['product_id'])){
            $productId = filter_input(INPUT_POST, 'product_id', FILTER_SANITIZE_NUMBER_INT);
            $rankingData = $this->rankingModel->getRankingByProduct($productId);
            if(!empty($rankingData)){
                $selectedProduct = $rankingData[0]->nombre_producto;
            }
        }

        $products = $this->rankingModel->getAllProducts();

        $data = [
            'products' => $products,
            'ranking' => $rankingData,
            'selected_product' => $selectedProduct
        ];
        
        $this->view('ranking/index', $data);
    }
}