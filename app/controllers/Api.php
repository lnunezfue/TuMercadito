<?php
class Api extends Controller {

    public function __construct(){
        $this->adminModel = $this->model('AdminModel');
        $this->userModel = $this->model('User');
        header('Content-Type: application/json'); 
    }

    public function login(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $postData = json_decode(file_get_contents("php://input"));
            $email = filter_var($postData->email ?? '', FILTER_SANITIZE_EMAIL);
            $password = $postData->password ?? '';

            if(empty($email) || empty($password)){
                 http_response_code(400); 
                 echo json_encode(['error' => 'Email y contraseña son requeridos.']);
                 return;
            }

            $loggedInUser = $this->userModel->login($email, $password);

            if($loggedInUser){
                http_response_code(200);
                echo json_encode([
                    'message' => 'Login exitoso.',
                    'user' => [
                        'id' => $loggedInUser->id_usuario,
                        'nombre' => $loggedInUser->nombre,
                        'email' => $loggedInUser->email,
                        'rol' => $loggedInUser->rol
                    ]
                ]);
            } else {
                http_response_code(401); 
                echo json_encode(['error' => 'Credenciales incorrectas.']);
            }
        }
    }

    public function priceHistory($productId = 0, $marketId = 0){
        $productId = filter_var($productId, FILTER_SANITIZE_NUMBER_INT);
        $marketId = filter_var($marketId, FILTER_SANITIZE_NUMBER_INT);
        
        if ($productId > 0 && $marketId > 0) {
            $history = $this->adminModel->getPriceHistory($productId, $marketId);
            
            $labels = [];
            $data = [];
            foreach($history as $record){
                $labels[] = date("d/m/Y", strtotime($record->fecha));
                $data[] = $record->precio;
            }

            $prediction = calculate_linear_regression($history);

            $chartData = [
                'labels' => $labels,
                'data' => $data,
                'prediction' => $prediction
            ];
            
            echo json_encode($chartData);

        } else {
            http_response_code(400);
            echo json_encode(['error' => 'IDs de producto y mercado son requeridos.']);
        }
    }
}
