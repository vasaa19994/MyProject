<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

use Maincast\App\classes\formHandler;
use Maincast\App\classes\Category;
require __DIR__ . '/../vendor/autoload.php';

if (!isset($_GET['id'])) {
    header('Location: form.php');
    exit;
}

$ad = formHandler::fetchById($_GET['id']);
$categories = Category::fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Редагування оголошення</title>
    <link rel="stylesheet" href="style3.css">
</head>
<body>
<h1 id="header">Редагування оголошення</h1>
<form method="post" action="index.php" enctype="multipart/form-data">
<input type="hidden" name="id" value="<?php echo $ad['id']; ?>">
    <p class="test">Назва турніру</p>
    <input class="test2" type="text" name="title" placeholder="Введіть назву" value="<?php echo $ad['title']; ?>">
    <p class="test">Тип гри</p>    
    <select name="category">
    <?php foreach ($categories as $category) { //вивід категорій з бази даних?>
            <option value="<?php echo $category['id']; ?>"><?php echo $category['name'];?></option>
        <?php } ?>
    </select>
    <p class="test">Стадія турніру</p>
    <input class="test2" type="text" name="stage" placeholder="Веедіть стадію турніру" value="<?php echo $ad['stage']; ?>">
    <p class="test">Винагорода</p>
    <input class="test2" type="number" name="pool" placeholder="Винагорода" value="<?php echo $ad['pool']; ?>">    
    <p class="test">Live</p>
    <input type="checkbox" name="live" value="<?php echo $ad['live']; ?>">
    <p class="test">Дата початку турніру</p>
    <input class="test2" type="date" name="beginning" value="<?php echo $ad['beginning']; ?>">
    <p class="test">Дата закінчення турніру</p>
    <input class="test2" type="date" name="ending" value="<?php echo $ad['ending']; ?>">
    <p class="test">Опис турніру</p>
    <textarea id="description" name="description" rows="5" cols="33" value="<?php echo $ad['description']; ?>">
Введіть опис турніру...
</textarea>
    <p class="test">Посилання на детальнішу інформацію</p>
    <input class="test2" type="url" name="url" placeholder="Посилання" value="<?php echo $ad['url']; ?>">
    <p><input class="test2" type="submit" value="Відправити"></p>
    <p class="test">Переглянути таблицю турнірів</p>
    <a href="/tablet.php">Таблиця</a>

</form>
</body>
</html>