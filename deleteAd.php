<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

use Maincast\App\classes\formHandler;
require __DIR__ . '/../vendor/autoload.php';



if (!isset($_GET['id'])) {
    header('Location: /tablet.php');
    exit;
}

try {
   
    formHandler::deleteById($_GET['id']);
    echo "Ваше оголошення видалено";
    echo "<a href=' tablet.php?id= '>Повернутися до списку</a><br/>";

}catch (\Exception $e) {
    echo "Помилка: " . $e->getMessage();
    echo "<br><a href='/form.php'>Повернутися до заповлення форми</a>";
    exit;
}


header("Lokation: form.php");
exit;