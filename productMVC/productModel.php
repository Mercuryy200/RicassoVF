<?php
class ProductModel
{
    private $db;

    public function __construct($database)
    {
        $this->db = $database;
    }

    public function getAllProducts()
    {
        $sql = "SELECT * FROM produits";
        $result = $this->db->query($sql);
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getAllCravates()
    {
        $sql = "SELECT * FROM produits WHERE 1=1 AND type ='cravate'";
        $result = $this->db->query($sql);
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getAllChemises(){
        $sql = "SELECT * FROM produits WHERE 1=1 AND type ='chemise'";
        $result = $this->db->query($sql);
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }
}
