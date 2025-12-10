<?php
class RankingModel {
    private $db;

    public function __construct(){
        $this->db = new Database;
    }

    public function getAllProducts(){
        $this->db->query("SELECT * FROM productos ORDER BY nombre ASC");
        return $this->db->resultSet();
    }

    public function getRankingByProduct($productId){
        $this->db->query("
            SELECT p.nombre AS nombre_producto, m.nombre AS nombre_mercado, pr.precio
            FROM precios pr
            JOIN productos p ON pr.id_producto = p.id_producto
            JOIN mercados m ON pr.id_mercado = m.id_mercado
            WHERE pr.id_producto = :product_id
            ORDER BY pr.precio ASC
        ");
        $this->db->bind(':product_id', $productId);
        return $this->db->resultSet();
    }
}
