<?php
ini_set ('display_errors', 1);
error_reporting(E_ALL);
session_start();

use Maincast\App\classes\exeptions\ValidationException;
use Maincast\App\classes\formHandler;

require __DIR__ . '/../vendor/autoload.php';

// Оформа для примання значень

$title = $_POST['title'] ?? null;
$category = $_POST['category'] ?? null;
$stage = $_POST['stage'] ?? null;
$pool = $_POST['pool'] ?? null;
// $live = $_POST['live'] ?? null;
$beginning = $_POST['beginning'] ?? null;
$ending = $_POST['ending'] ?? null;
$description = $_POST['description'] ?? null;
$url = $_POST['url'] ?? null;
$live = isset($_POST['live']) ? 1 : 0;


try 
{
    $formHandler = new formHandler($title, $category, $stage, $pool, $live, $beginning, $ending, $description, $url);
    $formHandler->saveDb();
    
    header("Location: form_display.php?id=" . $formHandler->getId());
    exit;
    
} catch (ValidationException $e) {
    echo "Помилка вводу: " . $e->getMessage();
    echo "<br><a href='form.php'>Павернутися до заповнення форми</a>";
    exit;
}