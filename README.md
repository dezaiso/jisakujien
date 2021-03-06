#字作字演bot返信ファイル


twitterの[字作字演botアカウントによる返信](https://twitter.com/jisakujien_typo/with_replies)の内容を記載したファイルです。

- [`tl_pattern.php`](https://github.com/dezaiso/jisakujien/blob/master/tl_pattern.php) ←タイムラインに流れるツイートに反応する返事
- [`reply_pattern.php`](https://github.com/dezaiso/jisakujien/blob/master/reply_pattern.php) ←@jisakujien_typo宛のリプライに対する返事
- [`tw/reply.txt`](https://github.com/dezaiso/jisakujien/blob/master/tw/reply.txt) ←`reply_pattern.php`でひっかからなかったツイートへの返信
- [`tw/data.txt`](https://github.com/dezaiso/jisakujien/blob/master/tw/data.txt) ←定期的にツイートする内容


の4種類のファイルによって成り立っています。



##作業の進め方

作業の進め方などはWikiの`Github Flow`に記載していますのでそちらをご覧ください。
https://github.com/dezaiso/jisakujien/wiki/Github-Flow


##記述ルール

そもそも字作字演botは、[EasyBotter](http://pha22.net/twitterbot/)というプログラムによって動いています。タイムラインに反応する形の返信の方法や編集の仕方などは、
[ここ](http://pha22.net/twitterbot/2.0/pattern.php)などを参考にしてください。phpの連想配列形式で書いてください。正規表現も使用可能です。

反応する単語はすでに存在して、返信文だけを追記する場合は該当箇所に追加するようにしてください。

反応する単語そのものから記載する場合には、


```sass
//「もじもじ」に対する返信
"もじもじ"=> array(
  "もじもーじ",
  "もじもじ〜",
),

```

という区切り単位で追加してもらえるといいですね。


上のほうにあるものから反応してしまうので、`文字`とか`タイポ`みたいな頻繁に出てきてしまう単語は極力後ろに配置するようにしてください。

- 大日本タイポ組合
- 大日本タイポ
- タイポ

というような順番だと、うまいこと反応します。逆だと全部**タイポ**に反応してしまう。


- `tl_pattern.php` では、タイムラインにちょいちょい出てくるワードをさらっと拾うような感じで、
- `reply_pattern.php` では、その返事に対する反応を想像しながら深いところまでえぐるような感じで

使い分けていただけるといいですね。うまいこと誘導尋問的にやりとりできるようになると達人感が出ます。

##ふぉんとうによろしくおねがいします。

くれぐれも、**文字に関する単語など、[字作字演bot](https://twitter.com/jisakujien_typo/)がフォローしているアカウントが話題にしそうなワードに絶妙に反応し、返事はできるだけダジャレを含めて返す**ようにしてください。字作字演のキャラクター形成のためにもよろしくおねがいします。

みんなで字作字演botを育てていきましょう。よろしくお願いしマシューカーター #グッドデザイソ

##ライセンスについて
- [本プログラムはMITライセンスのもと公開しています。](https://github.com/dezaiso/jisakujien/blob/master/LICENSE.md)
- [EasyBotterはpha氏がPHPライセンスのもと公開しています。](https://github.com/dezaiso/jisakujien/blob/master/EasyBotter_LICENSE.txt)
