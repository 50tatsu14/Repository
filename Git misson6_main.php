<?php

//データベースへの接続
$dsn='データベース名';
$user='ユーザー名';
$password='パスワード';
$pdo=new PDO($dsn,$user,$password);


$name=$_POST['name'];
$title=$_POST['title'];
$comment=$_POST['comment'];
$pass=$_POST['pass'];
$date=date("Y/m/d H:i:s");

//削除機能
$delete=$_POST['delete'];
$delpass=$_POST['delpass'];
if(!empty($delete)&&!empty($delpass)){
	$sql='select * from last_misson6_main';
	$result=$pdo->query($sql);
	foreach($result as $row){
		if($row['id']==$delete){
			if($row['pass']==$delpass){
				$sql="delete from last_misson6_main where id=$delete";
				$result=$pdo->query($sql);
			}else{
				echo"パスワードが違います。";
			}
		}
	}
}

//編集機能
$edit=$_POST['edit'];
$edipass=$_POST['edipass'];
//編集番号と編集パスワードが空でない時
if(!empty($edit)&&!empty($edipass)){
	$sql='select * from last_misson6_main';
	$result=$pdo->query($sql);
	foreach($result as $row){
//編集番号と投稿番号が一致している時
		if($row['id']==$edit){
			if($row['pass']==$edipass){
				$a=$row['name'];
				$b=$row['title'];
				$c=$row['comment'];
				$d=$row['id'];
			}else{
				echo "パスワードが違います。";
			}
		}
	}
}
		
//editnumが空でない時（編集モード）
$editnum=$_POST['editnum'];
if(!empty($editnum)){
	$sql="update last_misson6_main set name='$name' , title='$title' ,comment='$comment' where id=$editnum";
	$result=$pdo->query($sql);
}elseif(!empty($name) && !empty($title)&&!empty($comment)&&!empty($pass)){
	$sql=$pdo->prepare("INSERT INTO last_misson6_main (name,title,comment,pass,date) VALUES (:name,:title,:comment,:pass,:date)");
	$sql->bindParam(':name',$name,PDO::PARAM_STR);
	$sql->bindParam(':title',$title,PDO::PARAM_STR);
	$sql->bindParam(':comment',$comment,PDO::PARAM_STR);
	$sql->bindParam(':pass',$pass,PDO::PARAM_STR);
	$sql->bindParam(':date',$date,PDO::PARAM_STR);
	$sql->execute();
}

?>
<html>
<head>
<meta charset="UTF-8">
</head>
<form action="misson6_main.php" method="post">
<h2>結果・速報掲示板</h2>
名前：<input type="text" name="name" value="<?php echo $a;?>" size="30"><br/>
タイトル：<input type="text" name="title" value="<?php echo $b;?>" size="50"><br/>
コメント(結果・速報)<br/>
<textarea  name="comment" value="<?php echo $c;?>" rows="8" cols="40"></textarea><br/>
パスワード：<input type="text" name="pass" size="30"><br/>
<input type="submit" value="投稿"><br/>
<input type="hidden" name="editnum" value="<?php echo $d;?>" size="30" >
</form>

<form action="misson6_main.php" method="post">
<input type="text" name="delete" size="30" placeholder="削除対象番号"><br/>
<input type="text" name="delpass" size="30" placeholder="パスワード">
<input type="submit" value="削除"><br/>
</form>

<form action="misson6_main.php" method="post">
<input type="text" name="edit" size="30" placeholder="編集対象番号"><br/>
<input type="text" name="edipass" size="30" placeholder="パスワード">
<input type="submit" value="編集"><br/><br/>
</form>
</html>


<?php
//ループ関数で投稿ごとに改行し全データを表示
$sql='SELECT*FROM last_misson6_main order by id asc';
$results=$pdo->query($sql);
foreach($results as $row){
	echo $row['id'].',';
	echo $row['name'].',';
	echo $row['title'].'<br>';
	echo $row['comment'].'<br>';
	echo $row['date'].'<br>'.'<br>';
}
?>