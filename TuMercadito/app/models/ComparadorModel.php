<?php
class ComparadorModel {
    private $db;

    public function __construct(){
        $this->db = new Database;
    }

    public function getProducts(){
        $this->db->query("SELECT id_producto, nombre, unidad_medida FROM productos ORDER BY nombre ASC");
        return $this->db->resultSet();
    }
    
    public function getComparisonResults($productIds){
        if (empty($productIds)) {
            return [];
        }
        
        $placeholders = implode(',', array_fill(0, count($productIds), '?'));

        $sql = "
            SELECT 
                m.id_mercado,
                m.nombre AS nombre_mercado,
                p.nombre AS nombre_producto,
                pr.precio
            FROM precios pr
            JOIN productos p ON pr.id_producto = p.id_producto
            JOIN mercados m ON pr.id_mercado = m.id_mercado
            WHERE pr.id_producto IN ($placeholders)
            ORDER BY m.nombre, p.nombre
        ";

        $sql = str_replace($placeholders, implode(',', $productIds), $sql);
        
        $this->db->query($sql);
        return $this->db->resultSet();
    }
}
