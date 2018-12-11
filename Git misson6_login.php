<html>
<head>
<meta charset="UTF-8">
</head>
<form action="misson6_login.php" method="post">
注目選手の動画を投稿するにはログインが必要となります。ユーザー名・パスワードを入力し、ログインしてください。登録のお済みでない方はトップペーシより新規登録をお願いします。<a href="http://tt-462.99sv-coco.com/misson6_top.php">トップページへ</a><br/>
<h3>ログイン画面</h3>
ユーザー名：<input type="text" name="username" size="30"><br/>
パスワード：<input type="password" name="pass" size="50">
<input type="submit" value="ログイン"><br/><br/>
</html>

<?php

//データベースへの接続
$dsn='データベース名';
$user='ユーザー名';
$password='パスワード';
$pdo=new PDO($dsn,$user,$password);

//セッション開始
session_start();


$username=$_POST['username'];
$mail=$_POST['mail'];
$pass=$_POST['pass'];
$salt='abcde12345abcde12345zz';
$cost=12;
$hash=crypt($pass,'$2y$'.$cost.'$'.$salt.'$');

if(!empty($username)&&!empty($pass)){
	$sql='select * from misson6_login';
	$result=$pdo->query($sql);
	foreach($result as $row){
		if($row['username']==$username){
			if($row['pass']==$hash){
				$_SESSION['login']="1";
				header('Location:http://tt-462.99sv-coco.com/misson6_upload.php');
				exit();
			}else{
				echo "パスワードが違います。";
				exit();
			}
		}
	}
	echo "入力されたユーザー名は登録されていません。登録のお済みでない方はトップページより新規登録をお願いします。";
}

?>