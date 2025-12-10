<?php
class Mercados extends Controller {
    public function __construct(){
        if(!isLoggedIn()){
            header('Location: ' . URLROOT . '/users/login');
        }
        $this->mercadoModel = $this->model('MercadoModel');
    }

    public function index(){
        $markets = $this->mercadoModel->getAllMarkets();
        $userId = $_SESSION['user_id'];

        foreach ($markets as $market) {
            $market->is_favorite = $this->mercadoModel->isFavorite($userId, $market->id_mercado);
        }

        $data = [
            'title' => 'Nuestros Mercados',
            'markets' => $markets
        ];
        
        $this->view('mercados/index', $data);
    }

    public function toggleFavorite($marketId){
        $userId = $_SESSION['user_id'];
        $marketId = filter_var($marketId, FILTER_SANITIZE_NUMBER_INT);

        if ($marketId > 0) {
            if ($this->mercadoModel->isFavorite($userId, $marketId)) {
                $this->mercadoModel->removeFavorite($userId, $marketId);
                flash('market_message', 'Mercado eliminado de tus favoritos.');
            } else {
                $this->mercadoModel->addFavorite($userId, $marketId);
                flash('market_message', 'Mercado añadido a tus favoritos.', 'alert alert-success');
            }
        }
        
        header('Location: ' . URLROOT . '/mercados');
    }
}
