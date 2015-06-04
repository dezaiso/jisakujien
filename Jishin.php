<?php
class Easy_botter_org{
function jisin(){
//=============================
//地震判定プログラム
//=============================
/*     goo 天気 地震情報RSSを読み込み、震度3以上の場合、震度を返す*/

$earthquake_pubtime_txt = 'earthquake_pubtime.txt';
 
//前回のRSS読み込み日時を調べる
$last_pubtime = file_get_contents($earthquake_pubtime_txt);
if ($last_pubtime == ''){
$last_pubtime = date('Y-m-d H:i:s',time()-300);
}
 
//$last_pubtime = '2011-03-11 14:00:00';//TEST

$xml = file_get_contents('http://weather.goo.ne.jp/earthquake/index.rdf');//地震情報 - goo 天気
$xml_tree = simplexml_load_string($xml);
 
if (count($xml_tree->channel->item) > 0){
$ts = strtotime((string)$xml_tree->channel->item[0]->pubDate);
file_put_contents($earthquake_pubtime_txt, date('Y-m-d H:i:s',$ts));//読み込み済RSSの日時を保存
chmod($earthquake_pubtime_txt, 0666);
}
 
$shindo_num = '';
$shindo_str = '';
$shindo_pubtime = '';
$shindo_text = '';
$shindo_basyo = '';
$result = array();

foreach($xml_tree->channel->item as $k => $v){
  $text = (string)$v->title;
  $pubtime = date('Y-m-d H:i:s',strtotime((string)$v->pubDate));
  

  if ($pubtime <= $last_pubtime){ //処理済みitemはスルーして次へ
    continue;
  }
 
  if ($pubtime < date('Y-m-d H:i:s',time() - 900)){ //前回から15分（900秒）以内でなければ処理しないで次へ
    continue;
  }
 
//  //震度を取得し、指定以上ならフラグ立て、処理を終了
//  preg_match('/震度([0-9]+)[強弱]*/',$text,$matches);
//  preg_match('/\[震源地\](.*)\[最大震度\]/',$text,$matches_basyo);
//  preg_match('/\(20(.*)分頃発生/',$text,$matches_time);
//  //テスト用に抜き出し部分を加工
  preg_match('/震度([0-9]+)[強弱]*/',$text,$matches);
  preg_match('/\[震源地\](.*)\[最大震度\]/',$text,$matches_basyo);
  preg_match('/\日(.*)分頃発生/',$text,$matches_time);
  $shindo = $matches[1];
 
  if (is_numeric($shindo) && (int)$shindo >= 1){//テストのため震度1でも動作するようにする
$result['num'] = (int)$matches[1];
$result['str'] = $matches[0];
$result['pubtime'] = $pubtime;
$result['text'] = $text;
$result['basyo'] = trim($matches_basyo[1],"　");
$result['time'] = trim($matches_time[1],"　");
$result['word'] = "@dezaiso もう".$result['time']."分過ぎちゃいましたよね…"; //テスト
// $result['word'] = "字、字……、いや、地震ですかっ!　20".$result['time']."分ころ".$result['basyo']."あたりで".$result['str']."くらい？"; //ツィートされます。
//$result['word'] = "字、字……、いや、地震ですかっ!　".$shindo_basyo."あたりで".$shindo_str."くらい？"; //変数読み込めず
break;
}
  }
 
// 確認用
// echo $result['word']."<br />".$shindo."<br /><br />";

//地震ファイルを用意し、書き換える
$jishinmemo = $result['word'];
$fp = fopen("jishin.txt", "w");//ファイル名を変える
fwrite($fp, "$jishinmemo");
fclose($fp);


return $result;
 
}
}