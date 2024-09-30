<?php

namespace Maincast\App\classes;

class Database
{
    private static $instance;
    private $mysqli;

    public function __construct()
    {
        $this->mysqli = new \mysqli ('mysql', 'default', 'secret', 'default');
        if ($this->mysqli->connect_error) {
            die ("Connection failed:" . $this->mysqli->connect_error);
        }
    }

    public static function getInstance()
    {
    if (self::$instance === null) {
        try {
            self::$instance = new self();
        } catch (\Exception $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }
    return self::$instance;
    }
    public function getConection()
    {
        return $this->mysqli;
    }
    public function handleError($query)
    {
    http_response_code(500);
    echo json_encode([
        "error" => "Database Error",
        "message" => $this->mysqli->error,
        "query" => $query
    ]);
    exit;
    }
    public function query($sql, $params = [])
{
    $stmt = $this->mysqli->prepare($sql);
    if ($stmt === false) {
        $this->handleError($sql);
    }

    if (!empty($params)) {
        $stmt->bind_param(...$params);
    }

    if (!$stmt->execute()) {
        $this->handleError($sql);
    }

    return $stmt->get_result();
    }
    public function closeConnection()
    {   
    $this->mysqli->close();
    }
}