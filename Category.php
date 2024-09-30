<?php

namespace Maincast\App\classes;
use Maincast\App\classes\Database;

class Category 
{
    public static function fetchAll()
    {
        $db = Database::getInstance();

        
    $result = $db->getConection()->query("SELECT * FROM category");
    return $result->fetch_all(MYSQLI_ASSOC);
    
    }

    public static function fetchById($id)
    {
        $db = Database::getInstance();

        $result = $db->getConection()->query("SELECT * FROM category WHERE id = {$id}");
        return $result->fetch_assoc();

    }
}