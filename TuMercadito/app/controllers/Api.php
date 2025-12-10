<?php
class Api extends Controller {

    public function __construct(){
        $this->adminModel = $this->model('AdminModel');
        $this->userModel = $this->model('User');
        $this->comparadorModel = $this->model('ComparadorModel'); 

        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');
    }

    public function login(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $postData = json_decode(file_get_contents("php://input"));
            $email = filter_var($postData->email ?? '', FILTER_SANITIZE_EMAIL);
            $password = $postData->password ?? '';

            if(empty($email) || empty($password)){
                http_response_code(400); 
                echo json_encode(['error' => 'Email y contraseña requeridos.']);
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

    public function register(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $data = json_decode(file_get_contents("php://input"));
            $datos = [
                'nombre' => trim($data->nombre ?? ''),
                'email' => trim($data->email ?? ''),
                'password' => $data->password ?? '',
                'confirm_password' => $data->confirm_password ?? ''
            ];

            if(empty($datos['email']) || empty($datos['nombre']) || empty($datos['password'])){
                http_response_code(400);
                echo json_encode(['error' => 'Campos obligatorios.']);
                return;
            }

            if($datos['password'] != $datos['confirm_password']){
                http_response_code(400);
                echo json_encode(['error' => 'Contraseñas no coinciden.']);
                return;
            }

            if($this->userModel->findUserByEmail($datos['email'])){
                http_response_code(400);
                echo json_encode(['error' => 'Correo ya registrado.']);
                return;
            }

            $datos['password'] = password_hash($datos['password'], PASSWORD_DEFAULT);

            if($this->userModel->register($datos)){
                http_response_code(200);
                echo json_encode(['message' => 'Registrado correctamente']);
            } else {
                http_response_code(500);
                echo json_encode(['error' => 'Error al registrar.']);
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
            
            $prediction = function_exists('calculate_linear_regression') 
                          ? calculate_linear_regression($history) 
                          : null;

            echo json_encode(['labels' => $labels, 'data' => $data, 'prediction' => $prediction]);
        } else {
            http_response_code(400);
            echo json_encode(['error' => 'IDs requeridos.']);
        }
    }

    public function getProducts() {
        try {
            if(method_exists($this->comparadorModel, 'getProducts')){
                $products = $this->comparadorModel->getProducts();
            } else {
                $db = new Database;
                $db->query("SELECT id_producto, nombre FROM productos ORDER BY nombre ASC");
                $products = $db->resultSet();
            }
            echo json_encode($products);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Error al cargar productos']);
        }
    }

    public function getMarkets() {
        try {
            $db = new Database; 
            $db->query("SELECT id_mercado, nombre FROM mercados ORDER BY nombre ASC");
            $markets = $db->resultSet();
            echo json_encode($markets);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Error al cargar mercados']);
        }
    }

    public function getRanking($productId = 0) {
        $productId = filter_var($productId, FILTER_SANITIZE_NUMBER_INT);
        if ($productId > 0) {
            $db = new Database;
            $db->query("SELECT m.nombre as nombre_mercado, p.precio 
                         FROM precios p 
                         JOIN mercados m ON p.id_mercado = m.id_mercado 
                         WHERE p.id_producto = :id 
                         ORDER BY p.precio ASC");
            $db->bind(':id', $productId);
            try {
                echo json_encode($db->resultSet());
            } catch (Exception $e) {
                http_response_code(500);
                echo json_encode(['error' => 'Error ranking']);
            }
        } else {
            http_response_code(400);
            echo json_encode(['error' => 'ID inválido']);
        }
    }

    public function compare() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $input = json_decode(file_get_contents("php://input"), true);
            $items = $input['items'] ?? [];

            if (empty($items)) {
                http_response_code(400);
                echo json_encode(['error' => 'La lista está vacía']);
                return;
            }

            $qtyMap = [];
            $ids = [];
            foreach ($items as $item) {
                $pid = (int)$item['id'];
                $qty = (int)$item['qty'];
                $qtyMap[$pid] = $qty;
                $ids[] = $pid;
            }

            $idsString = implode(',', $ids);

            $db = new Database;
            $query = "SELECT p.id_producto, p.precio, m.nombre as nombre_mercado 
                      FROM precios p 
                      JOIN mercados m ON p.id_mercado = m.id_mercado 
                      WHERE p.id_producto IN ($idsString)";
            
            $db->query($query);
            $rawResults = $db->resultSet();

            $totals = [];
            
            foreach($rawResults as $row){
                $pid = $row->id_producto;
                
                $qty = isset($qtyMap[$pid]) ? $qtyMap[$pid] : 1;
                
                $costo = (float)$row->precio * $qty;

                if(!isset($totals[$row->nombre_mercado])){
                    $totals[$row->nombre_mercado] = 0;
                }
                $totals[$row->nombre_mercado] += $costo;
            }

            if(!empty($totals)){
                asort($totals);
                $cheapest = key($totals);
                
                echo json_encode([
                    'recommendation' => [
                        'market' => $cheapest, 
                        'total' => number_format($totals[$cheapest], 2, '.', '')
                    ],
                    'results' => $totals
                ]);
            } else {
                http_response_code(404);
                echo json_encode(['error' => 'No se encontraron precios registrados para estos productos.']);
            }
        }
    }

    public function getAllMarkets() {
        try {
            $db = new Database;
            
            $db->query("SELECT * FROM mercados ORDER BY nombre ASC");
            $markets = $db->resultSet();
            
            foreach($markets as $m){
                $m->is_favorite = false; 
            }

            echo json_encode($markets);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Error al cargar mercados']);
        }
    }

    public function updatePassword(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $data = json_decode(file_get_contents("php://input"));
            
            $userId = $data->user_id ?? 0;
            $newPass = $data->new_password ?? '';
            $confirmPass = $data->confirm_password ?? '';

            if($userId <= 0 || empty($newPass) || empty($confirmPass)){
                http_response_code(400);
                echo json_encode(['error' => 'Datos incompletos']);
                return;
            }

            if($newPass != $confirmPass){
                http_response_code(400);
                echo json_encode(['error' => 'Las contraseñas no coinciden']);
                return;
            }

            $hashedPassword = password_hash($newPass, PASSWORD_DEFAULT);

            if($this->userModel->updatePassword($userId, $hashedPassword)){
                echo json_encode(['message' => 'Contraseña actualizada correctamente']);
            } else {
                http_response_code(500);
                echo json_encode(['error' => 'Error al actualizar contraseña']);
            }
        }
    }

    public function updatePrice(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $data = json_decode(file_get_contents("php://input"));
            
            $productId = filter_var($data->product_id ?? 0, FILTER_SANITIZE_NUMBER_INT);
            $marketId = filter_var($data->market_id ?? 0, FILTER_SANITIZE_NUMBER_INT);
            $newPrice = filter_var($data->new_price ?? 0, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);

            if($productId <= 0 || $marketId <= 0 || $newPrice <= 0){
                http_response_code(400);
                echo json_encode(['error' => 'Datos inválidos. Verifica producto, mercado y precio.']);
                return;
            }

            if($this->adminModel->updatePrice($productId, $marketId, $newPrice)){
                echo json_encode(['message' => 'Precio actualizado correctamente']);
            } else {
                http_response_code(500);
                echo json_encode(['error' => 'No se pudo actualizar el precio']);
            }
        }
    }

    public function addProduct() {
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $data = json_decode(file_get_contents("php://input"));
            
            $datos = [
                'nombre' => trim($data->nombre ?? ''),
                'unidad' => trim($data->unidad ?? ''),
                'categoria' => trim($data->categoria ?? '')
            ];

            if(empty($datos['nombre'])) {
                echo json_encode(['error' => 'El nombre es obligatorio']); return;
            }

            if($this->adminModel->addProduct($datos)){
                echo json_encode(['message' => 'Producto agregado']);
            } else {
                http_response_code(500);
                echo json_encode(['error' => 'Error al agregar']);
            }
        }
    }

    public function editProduct() {
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $data = json_decode(file_get_contents("php://input"));
            
            $datos = [
                'id' => $data->id ?? 0,
                'nombre' => trim($data->nombre ?? ''),
                'unidad' => trim($data->unidad ?? ''),
                'categoria' => trim($data->categoria ?? '')
            ];

            if($this->adminModel->updateProduct($datos)){
                echo json_encode(['message' => 'Producto actualizado']);
            } else {
                http_response_code(500);
                echo json_encode(['error' => 'Error al actualizar']);
            }
        }
    }

    public function deleteProduct($id) {
        if($this->adminModel->deleteProduct($id)){
            echo json_encode(['message' => 'Producto eliminado']);
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Error al eliminar']);
        }
    }

    public function addMarket() {
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $data = json_decode(file_get_contents("php://input"));
            
            $datos = [
                'nombre' => trim($data->nombre ?? ''),
                'distrito' => trim($data->distrito ?? ''),
                'direccion' => trim($data->direccion ?? '')
            ];

            if(empty($datos['nombre']) || empty($datos['distrito'])) {
                echo json_encode(['error' => 'Nombre y Distrito son obligatorios']); return;
            }

            if($this->adminModel->addMarket($datos)){
                echo json_encode(['message' => 'Mercado agregado']);
            } else {
                http_response_code(500);
                echo json_encode(['error' => 'Error al agregar']);
            }
        }
    }

    public function editMarket() {
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $data = json_decode(file_get_contents("php://input"));
            
            $datos = [
                'id' => $data->id ?? 0,
                'nombre' => trim($data->nombre ?? ''),
                'distrito' => trim($data->distrito ?? ''),
                'direccion' => trim($data->direccion ?? '')
            ];

            if($this->adminModel->updateMarket($datos)){
                echo json_encode(['message' => 'Mercado actualizado']);
            } else {
                http_response_code(500);
                echo json_encode(['error' => 'Error al actualizar']);
            }
        }
    }

    public function deleteMarket($id) {
        if($this->adminModel->deleteMarket($id)){
            echo json_encode(['message' => 'Mercado eliminado']);
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Error al eliminar']);
        }
    }

    public function getUsers() {
        try {
            $db = new Database;
            $db->query("SELECT id_usuario, nombre, email, rol, fecha_registro FROM usuarios ORDER BY nombre ASC");
            $users = $db->resultSet();
            echo json_encode($users);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Error al cargar usuarios']);
        }
    }

    public function changeRole() {
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $data = json_decode(file_get_contents("php://input"));
            
            $userId = $data->user_id ?? 0;
            $newRole = $data->rol ?? '';

            if($userId <= 0 || empty($newRole)){
                echo json_encode(['error' => 'Datos inválidos']); return;
            }

            if($this->adminModel->changeRole($userId, $newRole)){
                echo json_encode(['message' => 'Rol actualizado']);
            } else {
                http_response_code(500);
                echo json_encode(['error' => 'Error al cambiar rol']);
            }
        }
    }

    public function deleteUser($id) {
        if($this->adminModel->deleteUser($id)){
            echo json_encode(['message' => 'Usuario eliminado']);
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Error al eliminar']);
        }
    }
}
?>