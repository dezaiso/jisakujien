<?php
//=============================
//EasyBotterを呼び出します
//=============================
require_once("EasyBotter.php");
$eb = new EasyBotter();


//=============================
//地震関連ここから
//=============================
//震度を取得します
//=============================
require_once("Jishin.php");
$ebo = new Easy_botter_org();

//=============================
//フラグファイル読み出し
// 状態フラグ $joutai
//    [0]quake:地震が起きた
//=============================
//    $joutai_txt = file_get_contents("Jishin_joutai.txt");
//    if($joutai_txt !== ""){
//        $joutai = unserialize($joutai_txt);
//	}
//=============================
//地震のときに停止するならコメントアウトを外すこと。
//=============================
//if($joutai[0]){
//    die("地震で停止しています");
//}
//この一文は、手動でbot.phpを叩くと表示されます。ツイートはされません。

//=============================
//地震判定（毎回）
//=============================
 
$shindo = $ebo->jisin();
 
//if( $shindo['num'] > 0){ //値が返ってきてたら
//  $joutai[0] = TRUE; //「地震が起きた」フラグを立てる
//}
 
//=============================
//フラグファイル格納。
//=============================
//    $response = file_put_contents("Jishin_joutai.txt" , serialize($joutai));
 
//=============================
//地震についてツイート。（動作未確認）
//=============================
// if($dousa[0] !== NULL){
//     if($dousa[0]['word'] !== ""){
//         $response = $eb->setUpdate(array("status"=>$dousa[30]['word']));
//  
//     } else if($dousa[0]['data'] !== ""){
//         $response = $eb->postRandom($dousa[0]['data']);
//     }
// }

if($shindo >= 1){
	$response = $eb->postRandom("jishin.txt");
	$fp = fopen("jishin.txt", "w"); // ツイート後すぐに初期化
	fwrite($fp, "");
	fclose($fp);
}


//=============================
//地震関連ここまで
//=============================

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
    $response = $eb->postRandom("0101.txt");
}
//=============================
//曜日によってbotが読み込むファイルを指定
//=============================
else if($hour  == 9 && $minute == 0 && $weekday == 0){
    $response = $eb->postRandom("w_sun.txt");
}
else if($hour  == 9 && $minute == 0 && $weekday == 1){
    $response = $eb->postRandom("w_mon.txt");
}
else if($hour  == 9 && $minute == 0 && $weekday == 2){
    $response = $eb->postRandom("w_tue.txt");
}
else if($hour  == 9 && $minute == 0 && $weekday == 3){
    $response = $eb->postRandom("w_wed.txt");
}
else if($hour  == 9 && $minute == 0 && $weekday == 4){
    $response = $eb->postRandom("w_thu.txt");
}
else if($hour  == 9 && $minute == 0 && $weekday == 5){
    $response = $eb->postRandom("w_fri.txt");
}
else if($hour  == 9 && $minute == 0 && $weekday == 6){
    $response = $eb->postRandom("w_sat.txt");
}
//=============================
//百人一首を一日に３回
//=============================
else if($hour  == 11 && $minute == 30){
    $response = $eb->postRandom("waka.txt");
}
else if($hour  == 16 && $minute == 0){
    $response = $eb->postRandom("waka.txt");
}
else if($hour  == 22 && $minute == 30){
    $response = $eb->postRandom("waka.txt");
}
//=============================
//字報（17:00は毎日、13:00と02:00は4回に1回）
//=============================
else if($hour  == 13 && $minute == 0 && rand(0,4) == 0){
    $response = $eb->postRandom("1oc.txt");
}
else if($hour  == 2 && $minute == 0 && rand(0,4) == 0){
    $response = $eb->postRandom("2oc.txt");
}
else if($hour  == 17 && $minute == 0){
    $response = $eb->postRandom("5oc.txt");
}

//=============================
//通常ツイートと字動フォロー
//=============================
// ↓1時間ごと（0分ちょうどに実行・通常版）
else if($minute == 0){
    $response = $eb->postRandom("data.txt");
    $response = $eb->autoFollow();
}

//=============================
//タイムラインやリプライに反応
//=============================
//bot.phpを実行したときに毎回実行される通常版
$response = $eb->reply(6,"reply.txt","reply_pattern.php");
$response = $eb->replyTimeline(6,"tl_pattern.php");


?>