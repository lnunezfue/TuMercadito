<?php
class Comparador extends Controller {
    public function __construct(){
        if(!isLoggedIn()){
            header('Location: ' . URLROOT . '/users/login');
        }
        $this->comparadorModel = $this->model('ComparadorModel');
    }

    public function index(){
        $results = [];
        $totals = [];
        $recommendation = null;

        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $selectedProducts = isset($_POST['products']) ? $_POST['products'] : [];
            $quantities = isset($_POST['quantities']) ? $_POST['quantities'] : [];

            if(!empty($selectedProducts)){
                $rawResults = $this->comparadorModel->getComparisonResults($selectedProducts);
                
                foreach($rawResults as $row){
                    $qtyKey = str_replace('.', '_', $row->nombre_producto);
                    $qty = $quantities[$qtyKey] ?? 1;
                    $results[$row->nombre_mercado][$row->nombre_producto] = (float)$row->precio * (int)$qty;
                    
                    if(!isset($totals[$row->nombre_mercado])){
                        $totals[$row->nombre_mercado] = 0;
                    }
                    $totals[$row->nombre_mercado] += (float)$row->precio * (int)$qty;
                }

                if(!empty($totals)){
                    asort($totals);
                    $cheapestMarket = key($totals);
                    $recommendation = [
                        'market' => $cheapestMarket,
                        'total' => $totals[$cheapestMarket]
                    ];
                }
            }
        }

        $products = $this->comparadorModel->getProducts();
        $data = [
            'products' => $products,
            'results' => $results,
            'totals' => $totals,
            'recommendation' => $recommendation
        ];

        $this->view('comparador/index', $data);
    }
}
