<?php
header('Content-Type: text/html; charset=utf-8');

	// подключение библиотек
require "inc/lib.inc.php";
require "inc/config.inc.php";
?>
<!DOCTYPE html>
<html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Поиск видео</title>

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>

<form method="post" action="viewVideo.php" accept-charset="UTF-8" autocomplete="off" >
    <div class="form-group">
        <label for="request_string">Поиск</label>
        <input name="request_string" type="text" class="form-control" id="request_string" placeholder="Искать...">
    </div>

    <button type="submit" class="btn btn-primary">Наити</button>
</form>
Пример запросов:
<br>
Строим дом
<br>
Бетонные работы
<br>
и.т.д.

</body>
</html>