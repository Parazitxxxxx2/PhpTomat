<?php
header('Content-Type: text/html; charset=utf-8');

    // подключение библиотек
	require "inc/lib.inc.php";
	require "inc/config.inc.php";

if(!isset($_POST['request_string']) OR $_POST['request_string'] == "" ){echo 'Не заполнено поле "имя" или в нем пробел';  exit;}

if( strlen($_POST['request_string']) > 156){
    echo "Не может  быт длинее 150 символов"; exit;}
    else { $request_string = $_POST['request_string'];}



$service = 'AIzaSyBxajQgwkGqx-gsfi6Gx3OjAFitGMj1sj4';
$summaryVideoList = FindVideo($request_string); //Получаем массив результатов поиска.
?>

<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <title>Сохранение данных заказа</title>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
<h3 align="center" >Результат поиска по запросу: <span style="color: #FF0000"><?= $request_string ?></span>  </h3>
<?php
$counter =0;
if($summaryVideoList == null){
    echo "Введите корректный запрос. Ответ нулевой длинны";
    echo"<p><a href=\"index.php\">Вернутся к поиску.</a></p>";
    exit;


}
//Рендер данных на страницу
foreach ($summaryVideoList as $item) {
    $counter ++;

    //Заголовок аккардеона
    $head_table = "
       
        <table class=\"table\">
            <thead>
            <tr>
                <th scope=\"col\" width=\"50\">№:</th>
                <th scope=\"col\" width=\"500\">Название:</th>
                <th scope=\"col\">Автор:</th>
                <th scope=\"col\">Дата публикации:</th>
            </tr>
            </thead>
            <tbody>
             ";
if($counter == 1) echo $head_table;
         ?>
            <th scope="row"><?= $counter ?></th>
<?php

          $table = "
            <td>
                <div class=\"panel-group\" id=\"accordion".$counter."\">
                     <div class=\"panel panel-default\">
                        <div class=\"panel-heading\">
                            <h4 class=\"panel-title\">
                                <a data-toggle=\"collapse\"  aria-expanded=\"false\" data-parent=\"#accordion".$counter."\"     href=\"#collapse".$counter."\">
                                    ".$item['title']." </a>
                            </h4>
                        </div>
                        <div id=\"collapse".$counter."\" class=\"panel-collapse collapse in\">
                            <div class=\"panel-body\">
                                <iframe class=\"embed-responsive-item\"
                                        src=\"https://www.youtube.com/embed/".$item['id']."?rel=0\" allowfullscreen></iframe>
                            </div>
                        </div>
                    </div>
                </div>
            </td>           
            <td>".$item['author']."</td>
            <td>".substr($item['published'],0,10)."</td>
          </tr>


        ";
        echo $table;
        ?>
    <?php
}

?>
</tbody>
</table>

	<p><a href="index.php">Вернутся к поиску.</a></p>
</body>
</html>










