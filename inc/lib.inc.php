<?php
header('Content-Type: text/html; charset=utf-8');

// соединение и парсинг

function get_ydata($url) {
    $ch = curl_init();
    $timeout = 5;
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_VERBOSE, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
    $data = curl_exec($ch);
    curl_close($ch);
    return $data;
}

//Ищем релевантное видео с учетом даты создания.
function findVideo($request_string){
    $clear_request_string = rawurlencode ($request_string); // Ищем и заменяем пробел для запроса

    //формируем строку запроса
    $api = get_ydata('https://www.googleapis.com/youtube/v3/search?part=snippet&q='.$clear_request_string.'&maxResults=20&order=date&key='.KEY_YOUTUBE); // спарсили файл с информацией о видео
    $youtube = json_decode($api); // преобразовали JSON-строку в объект PHP
    $summaryVideoList = Array();
    if ($youtube && $youtube != NULL && $youtube->items) { // проверяем ответ, если ключ верен, видео существует и массив с информацией не пуст
        foreach ($youtube->items as $item) { // проходимся по массиву, задавая переменные
            $videoList = array (
                'id'=> $item->id->videoId,
                'published' => $item->snippet->publishedAt,
                'title'=> $item->snippet->title,
                'author' => $item->snippet->channelTitle,
            );
            array_push($summaryVideoList, $videoList);
            }
    }
    return sortVideo($summaryVideoList);
}

//правило сортировки по количеству просмотров
function sortRule($a, $b)
{
    if ($a['viewcount'] == $b['viewcount']) {
        return 0;
    }
    return ($a['viewcount'] > $b['viewcount']) ? -1 : 1;
}

//сортируем видео по просмотрам
function sortVideo($summaryVideoList)
{
    $ids="";
    //формируем строку для запроса по ID
    foreach ($summaryVideoList as $item) {
        $ids .= $item['id'];
        $ids .= ',';
    }

    //формируем строку запроса
    $api = get_ydata('https://www.googleapis.com/youtube/v3/videos?part=statistics&id='.$ids.'&key='.KEY_YOUTUBE);
    $youtube = json_decode($api);
    $count =0;
    if ($youtube && $youtube != NULL && $youtube->items) { // проверяем ответ, если ключ верен, видео существует и массив с информацией не пуст
        foreach ($youtube->items as $item) { // проходимся по массиву, задавая переменные

            $videoList = array (
                'id2'=> $item->id,
                'viewcount' => $item->statistics->viewCount,
            );

            $summaryVideoList[$count] += $videoList;
            $count++;
        }
        usort($summaryVideoList, "sortRule");
    }
return $summaryVideoList;
}
