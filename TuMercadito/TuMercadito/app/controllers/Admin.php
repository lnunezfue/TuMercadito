<?php
class Admin extends Controller {
    public function __construct(){
        if(!isLoggedIn() || $_SESSION['user_rol'] != 'admin'){
            flash('access_denied', 'No tienes permiso para acceder a esta página.', 'alert alert-danger');
            header('Location: ' . URLROOT . '/pages/dashboard');
            exit();
        }

        $this->rankingModel = $this->model('RankingModel');
        $this->adminModel = $this->model('AdminModel');
    }

    public function index(){
        $data = ['title' => 'Panel de Administración'];
        $this->view('admin/index', $data);
    }

    public function precios(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $productId = $_POST['product_id'];
            $marketId = $_POST['market_id'];
            $newPrice = str_replace(',', '.', $_POST['new_price']);

            if(empty($productId) || empty($marketId) || !is_numeric($newPrice) || $newPrice <= 0){
                flash('price_update_fail', 'Todos los campos son obligatorios y el precio debe ser un número válido.', 'alert alert-danger');
                header('Location: ' . URLROOT . '/admin/precios');
                exit();
            }

            $currentPrice = $this->adminModel->getCurrentPrice($productId, $marketId);

            if($currentPrice){
                $this->adminModel->addPriceToHistory($productId, $marketId, $currentPrice->precio, $currentPrice->fecha_actualizacion);
                
                if($this->adminModel->updatePrice($productId, $marketId, $newPrice)){
                    flash('price_update_success', '¡Precio actualizado correctamente!');
                } else {
                    flash('price_update_fail', 'Error al actualizar el precio (o el precio era el mismo).', 'alert alert-danger');
                }
            } else {
                flash('price_update_fail', 'Error: El producto no tiene un precio asignado en ese mercado.', 'alert alert-danger');
            }
            
            header('Location: ' . URLROOT . '/admin/precios');
            exit();
        }

        $products = $this->rankingModel->getAllProducts();
        $markets = $this->adminModel->getMarkets();
        $data = [
            'products' => $products,
            'markets' => $markets
        ];
        $this->view('admin/precios', $data);
    }
    
    public function productos(){
        $products = $this->rankingModel->getAllProducts();
        $data = [
            'products' => $products
        ];
        $this->view('admin/productos', $data);
    }

    public function addProduct(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $data = [
                'nombre' => trim($_POST['nombre']),
                'unidad_medida' => trim($_POST['unidad_medida']),
                'categoria' => trim($_POST['categoria']),
                'nombre_err' => ''
            ];

            if(empty($data['nombre'])){
                $data['nombre_err'] = 'Por favor, ingrese el nombre del producto.';
            }

            if(empty($data['nombre_err'])){
                if($this->adminModel->addProduct($data)){
                    flash('product_message', 'Producto añadido correctamente.');
                    header('Location: ' . URLROOT . '/admin/productos');
                } else {
                    die('Algo salió mal.');
                }
            } else {
                $this->view('admin/add_product', $data);
            }
        } else {
            $data = ['nombre' => '', 'unidad_medida' => 'Kg', 'categoria' => 'Abarrotes'];
            $this->view('admin/add_product', $data);
        }
    }

    public function editProduct($id){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $data = [
                'id_producto' => $id,
                'nombre' => trim($_POST['nombre']),
                'unidad_medida' => trim($_POST['unidad_medida']),
                'categoria' => trim($_POST['categoria']),
                'nombre_err' => ''
            ];

            if(empty($data['nombre'])){
                $data['nombre_err'] = 'Por favor, ingrese el nombre del producto.';
            }

            if(empty($data['nombre_err'])){
                if($this->adminModel->updateProduct($data)){
                    flash('product_message', 'Producto actualizado correctamente.');
                    header('Location: ' . URLROOT . '/admin/productos');
                } else {
                    die('Algo salió mal.');
                }
            } else {
                $this->view('admin/edit_product', $data);
            }
        } else {
            $product = $this->adminModel->getProductById($id);
            $data = [
                'id_producto' => $id,
                'nombre' => $product->nombre,
                'unidad_medida' => $product->unidad_medida,
                'categoria' => $product->categoria
            ];
            $this->view('admin/edit_product', $data);
        }
    }

    public function deleteProduct($id){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            if($this->adminModel->deleteProduct($id)){
                flash('product_message', 'Producto eliminado correctamente.');
                header('Location: ' . URLROOT . '/admin/productos');
            } else {
                die('Algo salió mal.');
            }
        } else {
            header('Location: ' . URLROOT . '/admin/productos');
        }
    }

    public function mercados(){
        $markets = $this->adminModel->getMarkets();
        $data = [
            'markets' => $markets
        ];
        $this->view('admin/mercados', $data);
    }

    public function addMarket(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $data = [
                'nombre' => trim($_POST['nombre']),
                'direccion' => trim($_POST['direccion']),
                'distrito' => trim($_POST['distrito']),
                'telefono' => trim($_POST['telefono']),
                'nombre_err' => ''
            ];

            if(empty($data['nombre'])){
                $data['nombre_err'] = 'Por favor, ingrese el nombre del mercado.';
            }

            if(empty($data['nombre_err'])){
                if($this->adminModel->addMarket($data)){
                    flash('market_message', 'Mercado añadido correctamente.');
                    header('Location: ' . URLROOT . '/admin/mercados');
                } else {
                    die('Algo salió mal.');
                }
            } else {
                $this->view('admin/add_market', $data);
            }
        } else {
            $data = ['nombre' => '', 'direccion' => '', 'distrito' => '', 'telefono' => ''];
            $this->view('admin/add_market', $data);
        }
    }

    public function editMarket($id){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $data = [
                'id_mercado' => $id,
                'nombre' => trim($_POST['nombre']),
                'direccion' => trim($_POST['direccion']),
                'distrito' => trim($_POST['distrito']),
                'telefono' => trim($_POST['telefono']),
                'nombre_err' => ''
            ];

            if(empty($data['nombre'])){
                $data['nombre_err'] = 'Por favor, ingrese el nombre del mercado.';
            }

            if(empty($data['nombre_err'])){
                if($this->adminModel->updateMarket($data)){
                    flash('market_message', 'Mercado actualizado correctamente.');
                    header('Location: ' . URLROOT . '/admin/mercados');
                } else {
                    die('Algo salió mal.');
                }
            } else {
                $this->view('admin/edit_market', $data);
            }
        } else {
            $market = $this->adminModel->getMarketById($id);
            $data = [
                'id_mercado' => $id,
                'nombre' => $market->nombre,
                'direccion' => $market->direccion,
                'distrito' => $market->distrito,
                'telefono' => $market->telefono
            ];
            $this->view('admin/edit_market', $data);
        }
    }

    public function deleteMarket($id){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            if($this->adminModel->deleteMarket($id)){
                flash('market_message', 'Mercado eliminado correctamente.');
                header('Location: ' . URLROOT . '/admin/mercados');
            } else {
                die('Algo salió mal.');
            }
        } else {
            header('Location: ' . URLROOT . '/admin/mercados');
        }
    }

    public function usuarios(){
        $users = $this->adminModel->getAllUsers($_SESSION['user_id']);
        $data = ['users' => $users];
        $this->view('admin/usuarios', $data);
    }
    
    public function changeRole($userId){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $newRole = $_POST['rol'] == 'admin' ? 'admin' : 'usuario';
            if($this->adminModel->updateUserRole($userId, $newRole)){
                flash('user_message', 'Rol de usuario actualizado.');
            } else {
                flash('user_message', 'Error al actualizar el rol.', 'alert alert-danger');
            }
            header('Location: ' . URLROOT . '/admin/usuarios');
        }
    }

    public function deleteUser($id){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            if($this->adminModel->deleteUser($id)){
                flash('user_message', 'Usuario eliminado correctamente.');
            } else {
                flash('user_message', 'Error al eliminar el usuario.', 'alert alert-danger');
            }
             header('Location: ' . URLROOT . '/admin/usuarios');
        }
    }
}
