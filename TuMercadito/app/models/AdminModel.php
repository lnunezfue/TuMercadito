<?php
class AdminModel {
    private $db;

    public function __construct(){
        $this->db = new Database;
    }

    public function getMarkets(){
        $this->db->query("SELECT * FROM mercados ORDER BY nombre ASC");
        return $this->db->resultSet();
    }

    public function getCurrentPrice($productId, $marketId){
        $this->db->query("SELECT precio, fecha_actualizacion FROM precios WHERE id_producto = :product_id AND id_mercado = :market_id");
        $this->db->bind(':product_id', $productId);
        $this->db->bind(':market_id', $marketId);
        return $this->db->single();
    }

    public function addPriceToHistory($productId, $marketId, $price, $date){
        $this->db->query("INSERT INTO precios_historicos (id_producto, id_mercado, precio, fecha_vigencia) VALUES (:product_id, :market_id, :price, :date)");
        $this->db->bind(':product_id', $productId);
        $this->db->bind(':market_id', $marketId);
        $this->db->bind(':price', $price);
        $this->db->bind(':date', $date);
        
        return $this->db->execute();
    }
    
    public function updatePrice($productId, $marketId, $newPrice){
        $this->db->query("UPDATE precios SET precio = :new_price, fecha_actualizacion = CURDATE() WHERE id_producto = :product_id AND id_mercado = :market_id");
        $this->db->bind(':new_price', $newPrice);
        $this->db->bind(':product_id', $productId);
        $this->db->bind(':market_id', $marketId);

        if($this->db->execute()){
            return $this->db->rowCount() > 0;
        } else {
            return false;
        }
    }
    
    public function getPriceHistory($productId, $marketId){
        $this->db->query("
            (SELECT 
                precio, 
                fecha_vigencia AS fecha 
            FROM precios_historicos
            WHERE id_producto = :product_id_hist AND id_mercado = :market_id_hist)
            UNION
            (SELECT 
                precio, 
                fecha_actualizacion AS fecha 
            FROM precios 
            WHERE id_producto = :product_id_curr AND id_mercado = :market_id_curr)
            ORDER BY fecha ASC
        ");

        $this->db->bind(':product_id_hist', $productId);
        $this->db->bind(':market_id_hist', $marketId);
        $this->db->bind(':product_id_curr', $productId);
        $this->db->bind(':market_id_curr', $marketId);
        
        return $this->db->resultSet();
    }

    public function getProductById($id){
        $this->db->query("SELECT * FROM productos WHERE id_producto = :id");
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    public function addProduct($data){
        $this->db->query("INSERT INTO productos (nombre, unidad_medida, categoria) VALUES (:nombre, :unidad, :categoria)");
        $this->db->bind(':nombre', $data['nombre']);
        $this->db->bind(':unidad', $data['unidad_medida']);
        $this->db->bind(':categoria', $data['categoria']);
        return $this->db->execute();
    }

    public function updateProduct($data){
        $this->db->query("UPDATE productos SET nombre = :nombre, unidad_medida = :unidad, categoria = :categoria WHERE id_producto = :id");
        $this->db->bind(':id', $data['id_producto']);
        $this->db->bind(':nombre', $data['nombre']);
        $this->db->bind(':unidad', $data['unidad_medida']);
        $this->db->bind(':categoria', $data['categoria']);
        return $this->db->execute();
    }

    public function deleteProduct($id){
        $this->db->query("DELETE FROM productos WHERE id_producto = :id");
        $this->db->bind(':id', $id);
        
        if($this->db->execute()){
            return $this->db->rowCount() > 0;
        } else {
            return false;
        }
    }

    public function getMarketById($id){
        $this->db->query("SELECT * FROM mercados WHERE id_mercado = :id");
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    public function addMarket($data){
        $this->db->query("INSERT INTO mercados (nombre, direccion, distrito, telefono) VALUES (:nombre, :direccion, :distrito, :telefono)");
        $this->db->bind(':nombre', $data['nombre']);
        $this->db->bind(':direccion', $data['direccion']);
        $this->db->bind(':distrito', $data['distrito']);
        $this->db->bind(':telefono', $data['telefono']);
        return $this->db->execute();
    }

    public function updateMarket($data){
        $this->db->query("UPDATE mercados SET nombre = :nombre, direccion = :direccion, distrito = :distrito, telefono = :telefono WHERE id_mercado = :id");
        $this->db->bind(':id', $data['id_mercado']);
        $this->db->bind(':nombre', $data['nombre']);
        $this->db->bind(':direccion', $data['direccion']);
        $this->db->bind(':distrito', $data['distrito']);
        $this->db->bind(':telefono', $data['telefono']);
        return $this->db->execute();
    }

    public function deleteMarket($id){
        $this->db->query("DELETE FROM mercados WHERE id_mercado = :id");
        $this->db->bind(':id', $id);
        
        if($this->db->execute()){
            return $this->db->rowCount() > 0;
        } else {
            return false;
        }
    }

    public function getAllUsers($currentAdminId){
        $this->db->query("SELECT id_usuario, nombre, email, rol FROM usuarios WHERE id_usuario != :admin_id ORDER BY nombre ASC");
        $this->db->bind(':admin_id', $currentAdminId);
        return $this->db->resultSet();
    }
    
    public function updateUserRole($userId, $newRole){
        $this->db->query("UPDATE usuarios SET rol = :rol WHERE id_usuario = :id");
        $this->db->bind(':rol', $newRole);
        $this->db->bind(':id', $userId);
        return $this->db->execute();
    }

    public function deleteUser($id){
        $this->db->query("DELETE FROM usuarios WHERE id_usuario = :id");
        $this->db->bind(':id', $id);
        
        if($this->db->execute()){
            return $this->db->rowCount() > 0;
        } else {
            return false;
        }
    }
}
