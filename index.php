<?php
header('Content-Type: text/html; charset=utf-8');
// подключение библиотек
require "inc/lib.inc.php";
require "inc/config.inc.php";

if(isset($_POST['request_string'])) {
    if ($_POST['request_string'] == "") {
        echo "Поле поиска не может быть пустым";
        echo "<p><a href=\"index.php\">Вернутся к поиску.</a></p>";
        exit;
    }

    if (strlen($_POST['request_string']) > 156) {
        echo "Не строка запроса не может  быт длинее 150 символов";
        echo "<p><a href=\"index.php\">Вернутся к поиску.</a></p>";
        exit;
    }
    $request_string = $_POST['request_string'];
    $summaryVideoList = FindVideo($request_string); //Получаем массив результатов поиска.
}
?>
<!DOCTYPE html>
<html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Поиск видео</title>
<head>

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link href="css/mytheme.css" rel="stylesheet">

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>


<script type="text/javascript" >

    $(document).ready(function(){
        $('.collapse').on('show.bs.collapse', function (e) {
            $('.collapse').collapse("hide")
        })
    })
</script>

</head>
<body>

<form method="post" action="index.php" accept-charset="UTF-8" autocomplete="off" >
    <div class="form-group">
        <label for="request_string">Поиск</label>
        <input name="request_string" type="text" class="form-control" id="request_string" placeholder="Искать...">
    </div>

    <button type="submit" class="btn btn-primary">Наити</button>
</form>

<?php
if($request_string ):?>
<h3 align="center" >Результат поиска по запросу: <span style="color: #FF0000"> <?= $request_string?> </span> </h3>
<?php if(empty($summaryVideoList)){echo "<h3 align=\"center\" > Результат поиска оказался пуст, попробуйте повторить поиск. </h3>";}?>
<?php endif ?>

<?php
if( $summaryVideoList != null){
//Рендер данных на страницу
    $counter=0;

?>
<div class=\"panel-group\" id=\"accordion\">
    <div class=\"panel panel-default\">
<?php
foreach ($summaryVideoList as $item) {
$counter ++;
    $table = "     
                     
                        <div class=\"panel-heading\">
                            <li class=\"panel-title\">
                            
                                <a data-toggle=\"collapse\"  aria-expanded=\"false\" data-parent=\"#accordion".$counter."\"     href=\"#collapse".$counter."\">
                                    ".$counter.".    ".$item['title']." </a><li>Автор: ".$item['author']."</li><li>Дата: ".substr($item['published'],0,10)."</li>
                                    
                            </h4>
                        </div>
                        <div id=\"collapse".$counter."\" class=\"panel-collapse collapse \">
                            <div class=\"panel-body\">
                                <iframe class=\"embed-responsive-item\"
                                        src=\"https://www.youtube.com/embed/".$item['id']."?rel=0\" allowfullscreen></iframe>
                            </div>
                        </div>
    ";
    echo $table;

}

?>
</div>
    </div>
    <?php
}
?>

</body>
</html>