<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);


use Maincast\App\classes\formHandler;
require __DIR__ . '/../vendor/autoload.php';

if (!isset($_GET['id'])) {
    header('Location: form.php');
    exit;
}

$ad = formHandler::fetchById($_GET['id']);


echo '<h1>Дані про Ваш турнір</h1>';
echo 'Назва турніру -' . $ad['title'] ."<br/>";
echo "Категорія -" . $ad['category_name'] ."<br/>";
echo "Стадія турніру -" . $ad['stage'] ."<br/>";
echo 'Винагорода турніру -' . $ad['pool'] ."<br/>";
echo 'Чи тарнслюється -' ;
if ($ad['live'] === 1) {echo "Так - Наживо";} else {echo "Offline";} echo "<br/>";
echo "Початок турніру -" . $ad['beginning'] ."<br/>";
echo "Закінчення турніру -" . $ad['ending'] ."<br/>";
echo "Опис турніру -" . $ad['description'] ."<br/>";
echo "Посилання -" . $ad['url'] ."<br/>";
echo "<a href=' deleteAd.php?id=" . $ad['id'] . "'>Видалити оголошення</a><br/>";
echo "<a href=' edit_form.php?id=" . $ad['id'] . "'>Редагувати оголошення</a><br/>";
echo "<a href=' tablet.php?id= '>Повернутися до списку</a><br/>";