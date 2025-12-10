<?php
class MercadoModel {
    private $db;

    public function __construct(){
        $this->db = new Database;
    }

    public function getAllMarkets(){
        $this->db->query("SELECT * FROM mercados ORDER BY nombre ASC");
        return $this->db->resultSet();
    }

    public function isFavorite($userId, $marketId){
        $this->db->query("SELECT * FROM favoritos WHERE id_usuario = :user_id AND id_mercado = :market_id");
        $this->db->bind(':user_id', $userId);
        $this->db->bind(':market_id', $marketId);
        $this->db->single();
        return $this->db->rowCount() > 0;
    }

    public function addFavorite($userId, $marketId){
        $this->db->query("INSERT INTO favoritos (id_usuario, id_mercado) VALUES (:user_id, :market_id)");
        $this->db->bind(':user_id', $userId);
        $this->db->bind(':market_id', $marketId);
        return $this->db->execute();
    }

    public function removeFavorite($userId, $marketId){
        $this->db->query("DELETE FROM favoritos WHERE id_usuario = :user_id AND id_mercado = :market_id");
        $this->db->bind(':user_id', $userId);
        $this->db->bind(':market_id', $marketId);
        return $this->db->execute();
    }
}
