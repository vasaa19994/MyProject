<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);


use Maincast\App\classes\formHandler;
require __DIR__ . '/../vendor/autoload.php';


$ads = formHandler::fetchAll();
?>

<html>
<head>
    <title>MAINCAST</title>
</head>
<body>
    <h1 style="text-align: center;">Таблиця турнірів</h1>
    <a href="/form.php">створити турнір</a>
    </br>
    </br>
    <table style="width: 60%;" border="1">
        <thead>
            <tr>
                <th style="width: 5%;">ID</th>
                <th style="width: 30%;">Назва тірніру</th>
                <th style="width: 30%;">Тип гри</th>
                <th style="width: 30%;">стадія турніру</th>
                <th style="width: 30%;">Винагорода</th>
                <th style="width: 30%;">LIVE</th>
                <th style="width: 30%;">Дата початку</th>
                <th style="width: 30%;">Дата закінчення</th>
                <th style="width: 30%;">короткий опис турніру</th>
                <th style="width: 30%;">посилання на детальнішуінформацію</th>
                <th style="width: 10%;">Дії</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($ads as $ad) { ?>
            <tr>
                <td><?php echo $ad['id']; ?></td>
                <td><?php echo $ad['title']; ?></td>
                <td><?php echo $ad['category']; ?></td>
                <td><?php echo $ad['stage']; ?></td>
                <td><?php echo $ad['pool']; ?></td>
                <td><?php if ($ad['live'] == 1) {echo "Так";} else {echo "Ні";} ?></td>
                <td><?php echo $ad['beginning']; ?></td>
                <td><?php echo $ad['ending']; ?></td>
                <td><?php echo $ad['description']; ?></td>
                <td><?php echo $ad['url']; ?></td>
                <td><a href="form_display.php?id=<?php echo $ad['id']; ?>">Переглянути</a> </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</body>

</html>