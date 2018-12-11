<html>
<head>
<meta charset="UTF-8">
</head>
<h2>注目選手の打席や投球を投稿しよう！</h2>
<form action="misson6_upload.php" method="post" enctype="multipart/form-data"><br/>
<a href="http://tt-462.99sv-coco.com/misson6_logout.php">ログアウト</a><br/><br/>
チーム名：<input type="text" name="team" size="30"><br/>
選手名：<input type="text" name="player" size="30"><br/>
利き（投打）：<input type="text" name="dominant" size="30"><br/>
ポジション：<input type="text" name="position" size="30"><br/>
場所・大会・打席数・投球イニング：<input type="text" name="place" size="30"><br/>
結果・内容・コメント：<input type="text" name="comment" size="30"><br/>
動画：<input type="file" name="upfile"><br/>
<input type="submit" value="アップロード"><br/><br/><br/>
</html>

<?php
//データベースへの接続
$dsn='データベース名';
$user='ユーザー名';
$password='パスワード';
$pdo=new PDO($dsn,$user,$password);

//セッション開始
session_start();
if($_SESSION['login']!="1"){
	header('Location:http://tt-462.99sv-coco.com/misson6_login.php');
	exit();
}

$team=$_POST['team'];
$player=$_POST['player'];
$dominant=$_POST['dominant'];
$position=$_POST['position'];
$place=$_POST['place'];
$comment=$_POST['comment'];
$file=$_FILES['upfile'];

if(isset($_FILES['upfile']['error'])&&is_int($_FILES['upfile']['error'])&& $_FILES["upfile"]["name"]!==""){
	//エラーチェック
	switch($_FILES['upfile']['error']){
		case UPLOAD_ERR_OK:
			break;
		case UPLOAD_ERR_NO_FILE:
			throw new RuntimeException('ファイルが選択されていません',400);
		case UPLOAD_ERR_SIZE:
			throw new RuntimeException('ファイルサイズが大きすぎます',400);
		default:
			throw new RuntimeException('その他のエラーが発生しました',500);
	}
	
	//画像をバイナリデータにする
	$raw_data=file_get_contents($_FILES['upfile']['tmp_name']);
	
	//拡張子を見る
	$tmp=pathinfo($_FILES["upfile"]["name"]);
	$extension=$tmp["extension"];
	if($extension==="jpg" || $extension==="jpeg" || $extension==="JPG"	 || $extension==="JPEG"){
		$extension="jpeg";
	}
	elseif($extension==="png" || $extension==="PNG"){
		$extension="png";
	}
	elseif($extension==="gif" || $extension==="GIF"){
		$extension="gif";
	}
	elseif($extension==="mp4" || $extension==="MP4"){
		$extension="mp4";
	}
	else{
		echo"非対応ファイルです。<br/>";
		exit(1);
		}
}

  //DBに格納するファイルネーム設定
            //サーバー側の一時的なファイルネームと取得時刻を結合した文字列にsha256をかける．
            $date = getdate();
            $fname = $_FILES["upfile"]["tmp_name"].$date["year"].$date["mon"].$date["mday"].$date["hours"].$date["minutes"].$date["seconds"];
            $fname = hash("sha256", $fname);
            
if(!empty($team)){
	$sql=$pdo->prepare("INSERT INTO new_misson6_upload (team,player,dominant,position,place,comment,fname,extension,raw_data) VALUES (:team,:player,:dominant,:position,:place,:comment,:fname,:extension,:raw_data)");
	$sql->bindParam(':team',$team,PDO::PARAM_STR);
	$sql->bindParam(':player',$player,PDO::PARAM_STR);
	$sql->bindParam(':dominant',$dominant,PDO::PARAM_STR);
	$sql->bindParam(':position',$position,PDO::PARAM_STR);
	$sql->bindParam(':place',$place,PDO::PARAM_STR);
	$sql->bindParam(':comment',$comment,PDO::PARAM_STR);
	$sql->bindValue(':fname',$fname, PDO::PARAM_STR);
    $sql->bindValue(':extension',$extension, PDO::PARAM_STR);
    $sql->bindValue(':raw_data',$raw_data, PDO::PARAM_STR);
	$sql->execute();
	echo"投稿に成功しました。<br/>ログアウトし、注目選手動画掲示板で確認してください。";
	
}
?>

