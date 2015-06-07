<?php
//=============================
//EasyBotterを呼び出します
//=============================
require_once("EasyBotter.php");
$eb = new EasyBotter();


//=============================
//地震関連
//=============================
require_once("Jishin.php");
$ebo = new Easy_botter_org();
 
$shindo = $ebo->jisin();

if($shindo >= 3){ // 震度3以上だったら作動
	$response = $eb->postRandom("jishin.txt");
	$fp = fopen("jishin.txt", "w"); // ツイート後すぐに初期化
	fwrite($fp, "");
	fclose($fp);
}

//=============================
//date関数を代入する
//=============================
$hour = date("G");
$minute = date("i");
$month = date("n");
$date = date("j");
$weekday = date("w");

//=============================
//天気予報をツイートする
//=============================
if($hour  == 8 && $minute == 0){
    $response = $eb->postRandom("weather_today.txt");
}
else if($hour  == 22 && $minute == 0){
    $response = $eb->postRandom("weather_tomorrow.txt");
}
//=============================
//日時によってbotが読み込むファイルを指定
//=============================
else if($hour  == 9 && $month == 1 && $date == 1){
    $response = $eb->postRandom("./tw/0101.txt");
}
//=============================
//曜日によってbotが読み込むファイルを指定
//=============================
else if($hour  == 9 && $minute == 0 && $weekday == 0){
    $response = $eb->postRandom("./tw/w_sun.txt");
}
else if($hour  == 9 && $minute == 0 && $weekday == 1){
    $response = $eb->postRandom("./tw/w_mon.txt");
}
else if($hour  == 9 && $minute == 0 && $weekday == 2){
    $response = $eb->postRandom("./tw/w_tue.txt");
}
else if($hour  == 9 && $minute == 0 && $weekday == 3){
    $response = $eb->postRandom("./tw/w_wed.txt");
}
else if($hour  == 9 && $minute == 0 && $weekday == 4){
    $response = $eb->postRandom("./tw/w_thu.txt");
}
else if($hour  == 9 && $minute == 0 && $weekday == 5){
    $response = $eb->postRandom("./tw/w_fri.txt");
}
else if($hour  == 9 && $minute == 0 && $weekday == 6){
    $response = $eb->postRandom("./tw/w_sat.txt");
}
//=============================
//百人一首を一日に３回
//=============================
else if($hour  == 11 && $minute == 30){
    $response = $eb->postRandom("./tw/waka.txt");
}
else if($hour  == 16 && $minute == 0){
    $response = $eb->postRandom("./tw/waka.txt");
}
else if($hour  == 22 && $minute == 30){
    $response = $eb->postRandom("./tw/waka.txt");
}
//=============================
//字報（17:00は毎日、13:00と02:00は4回に1回）
//=============================
else if($hour  == 13 && $minute == 0 && rand(0,4) == 0){
    $response = $eb->postRandom("./tw/1oc.txt");
}
else if($hour  == 2 && $minute == 0 && rand(0,4) == 0){
    $response = $eb->postRandom("./tw/2oc.txt");
}
else if($hour  == 17 && $minute == 0){
    $response = $eb->postRandom("./tw/5oc.txt");
}

//=============================
//通常ツイートと字動フォロー
//=============================
// ↓1時間ごと（0分ちょうどに実行・通常版）
else if($minute == 0){
    $response = $eb->postRandom("./tw/data.txt");
    $response = $eb->autoFollow();
}

//=============================
//タイムラインやリプライに反応
//=============================
//bot.phpを実行したときに毎回実行される通常版
$response = $eb->reply(6,"./tw/reply.txt","reply_pattern.php");
$response = $eb->replyTimeline(6,"tl_pattern.php");


?>