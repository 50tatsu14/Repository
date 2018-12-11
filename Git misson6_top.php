<html>
<head>
<meta charset="UTF-8">
</head>
<h1>高校野球情報サイト</h1>
<a href="http://tt-462.99sv-coco.com/misson6_main_hokkai_tohoku.php">結果・速報掲示板</a>　　　<a href="http://tt-462.99sv-coco.com/misson6_video&image.php">注目選手動画</a><br/><br/>
<h4>本サイトのご利用にあたって</h4>
試合結果や経過速報をご存知の方は「結果・速報掲示板」より書き込みをお願いします。
「結果・速報掲示板」の書き込みや閲覧、また「注目選手動画」の閲覧はどなたにもご利用いただくことができます。「注目選手動画」への動画アップロードには、ユーザー登録とログインが必要となります。<br/><br/><br/>
<form action="misson6_top.php" method="post">
<h3>新規ユーザー登録</h3>
ユーザー名：<input type="text" name="username" size="30"><br/>
メールアドレス：<input type="text" name="mail" size="50"><br/>
パスワード：<input type="password" name="pass" size="50">
<input type="submit" value="新規登録"><br/><br/>
</html>

<?php
//データベースへの接続
$dsn='データベース名';
$user='ユーザー名';
$password='パスワード';
$pdo=new PDO($dsn,$user,$password);

$username=$_POST['username'];
$mail=$_POST['mail'];
$pass=$_POST['pass'];
$salt='abcde12345abcde12345zz';
$cost=12;
$hash=crypt($pass,'$2y$'.$cost.'$'.$salt.'$');

//ユーザー新規登録
if(!empty($username) && !empty($mail)&&!empty($pass)){
	$sql=$pdo->prepare("INSERT INTO misson6_login(username,mail,pass) VALUES (:username,:mail,:pass)");
	$sql->bindParam(':username',$username,PDO::PARAM_STR);
	$sql->bindParam(':mail',$mail,PDO::PARAM_STR);
	$sql->bindparam(':pass',$hash,PDO::PARAM_STR);
	$sql->execute();
	echo"登録完了しました。";
}

?>