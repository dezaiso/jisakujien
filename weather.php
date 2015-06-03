<?php
//東京を指定
$id = "130010";
$cityName = "東京";
//jsonを呼び出す
$tenki_url = "http://weather.livedoor.com/forecast/webservice/json/v1?city=".$id;

$tenki_json = file_get_contents($tenki_url);
$tenki_obj = json_decode($tenki_json);

$tenki = $tenki_obj -> forecasts;
$tenki_gaikyo = $tenki_obj -> description -> text;

//今日の天気
$today_weather = $tenki[0] -> telop;
$today_max = $tenki[0] -> temperature -> max -> celsius;
$today_min = $tenki[0] -> temperature -> min -> celsius;
//明日の天気
$tomorrow_weather = $tenki[1] -> telop;
$tomorrow_max = $tenki[1] -> temperature -> max -> celsius;
$tomorrow_min = $tenki[1] -> temperature -> min -> celsius;

//今日のファイル：内容（時間帯によって気温が取得できない為）
if($today_max == ""){
	$todays = "グッドも〜じング！　きょうの東京地方の天気は「".$today_weather."」の予想です。きょうも一日もじもじして行きましょう！　#字作字演";
}else{
	$todays = "グッドも〜じング！　きょうの東京地方の天気は「".$today_weather."」最高気温は".$today_max."℃の予想です。きょうも一日もじもじして行きましょう！　#字作字演";
}
//今日のファイル：書き換え
$fp = fopen("weather_today.txt", "w");//ファイル名を変える
fwrite($fp, "$todays");
fclose($fp);

//明日のファイル：内容（時間帯によって気温が取得できない為）
if($tomorrow_max == "" || $tomorrow_min == ""){
	$tomorrows = "あすの東京地方の天気は「".$tomorrow_weather."」の予想です。あすの朝も明るく明朝体っぽく行きましょう〜　 #字作字演";
}else{
	$tomorrows = "あすの東京地方の天気は「".$tomorrow_weather."」最高気温は".$tomorrow_max."℃、最低気温は".$tomorrow_min."℃の予想です。あすの朝も明るく明朝体っぽく行きましょう〜　 #字作字演";
}
//明日のファイル：書き換え
$fp = fopen("weather_tomorrow.txt", "w");//ファイル名を変える
fwrite($fp, "$tomorrows");
fclose($fp);
?>