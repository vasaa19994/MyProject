<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);
require __DIR__ . '/../vendor/autoload.php';
use Maincast\App\classes\Category;
$categories = Category::fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MaincastT</title>
    <link rel="stylesheet" href="style3.css">
</head>
<body>
<h1 id="header">Інформація про турніри</h1>
<form method="post" action="index.php" enctype="multipart/form-data">
    <p class="test">Назва турніру</p>
    <input class="test2" type="text" name="title" placeholder="Введіть назву">
    <p class="test">Тип гри</p>    
    <select name="category">
    <?php foreach ($categories as $category) { //вивід категорій з бази даних?>
            <option value="<?php echo $category['id']; ?>"><?php echo $category['name'];?></option>
        <?php } ?>
    </select>
    <p class="test">Стадія турніру</p>
    <input class="test2" type="text" name="stage" placeholder="Веедіть стадію турніру">
    <p class="test">Винагорода</p>
    <input class="test2" type="number" name="pool" placeholder="Винагорода">    
    <p class="test">Live</p>
    <input type="checkbox" name="live" value="0"> 
    <p class="test">Дата початку турніру</p>
    <input class="test2" type="date" name="beginning">
    <p class="test">Дата закінчення турніру</p>
    <input class="test2" type="date" name="ending">
    <p class="test">Опис турніру</p>
    <textarea id="description" name="description" rows="5" cols="33">
Введіть опис турніру...
</textarea>
    <p class="test">Посилання на детальнішу інформацію</p>
    <input class="test2" type="url" name="url" placeholder="Посилання">
    <p><input class="test2" type="submit" value="Відправити"></p>
    <p class="test">Переглянути таблицю турнірів</p>
    <a href="/tablet.php">Таблиця</a>

</form>
</body>
</html>