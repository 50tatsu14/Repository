<html>
<head>
<meta charset="UTF-8">
</head>

<?php

//データベースへの接続
$dsn='データベース名';
$user='ユーザー名';
$password='パスワード';
$pdo=new PDO($dsn,$user,$password);


$name=$_POST['name'];
$comment=$_POST['comment'];
$pass=$_POST['pass'];
$date=date("Y/m/d H:i:s");


//削除機能
$delete=$_POST['delete'];
$delpass=$_POST['delpass'];
//削除番号と削除パスワードが空でない時
if(!empty($delete)&&!empty($delpass)){
	$sql='select * from new_misson4';
	$result=$pdo->query($sql);
	foreach($result as $row){
//削除番号と投稿番号が一致している時
		if($row['id']==$delete){
			if($row['pass']==$delpass){
				$sql="delete from new_misson4 where id=$delete";
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
	$sql='select * from new_misson4';
	$result=$pdo->query($sql);
	foreach($result as $row){
//編集番号と投稿番号が一致している時
		if($row['id']==$edit){
			if($row['pass']==$edipass){
				$a=$row['name'];
				$b=$row['comment'];
				$c=$row['id'];
			}else{
				echo "パスワードが違います。";
			}
		}
	}
}
		
//editnumが空でない時（編集モード）
$editnum=$_POST['editnum'];
if(!empty($editnum)){
	$sql="update new_misson4 set name='$name' , comment='$comment' where id=$editnum";
	$result=$pdo->query($sql);
}elseif(!empty($comment) && !empty($name)&&!empty($pass)){
	$sql=$pdo->prepare("INSERT INTO new_misson4 (name,comment,date,pass) VALUES (:name,:comment,:date,:pass)");
	$sql->bindParam(':name',$name,PDO::PARAM_STR);
	$sql->bindParam(':comment',$comment,PDO::PARAM_STR);
	$sql->bindparam('date',$date,PDO::PARAM_STR);
	$sql->bindparam('pass',$pass,PDO::PARAM_STR);
	$sql->execute();
}

?>
<form action="new_misson_4.php" method="post">
<input type="text" name="name" value="<?php echo $a;?>" size="30" placeholder="名前"><br/>
<input type="text" name="comment" value="<?php echo $b;?>" size="30" placeholder="コメント"><br/>
<input type="text" name="pass" size="30" placeholder="パスワード">
<input type="submit">
<input type="hidden" name="editnum" value="<?php echo $c;?>" size="30" ><br>
</form>

<form action="new_misson_4.php" method="post">
<input type="text" name="delete" size="30" placeholder="削除対象番号"><br/>
<input type="text" name="delpass" size="30" placeholder="パスワード">
<input type="submit" value="削除"><br/>
</form>

<form action="new_misson_4.php" method="post">
<input type="text" name="edit" size="30" placeholder="編集対象番号"><br/>
<input type="text" name="edipass" size="30" placeholder="パスワード">
<input type="submit" value="編集"><br/><br/>
</html>



<?php
//ループ関数で投稿ごとに改行し全データを表示
$sql='SELECT*FROM new_misson4 order by id asc';
$results=$pdo->query($sql);
foreach($results as $row){
	echo $row['id'].',';
	echo $row['name'].',';
	echo $row['comment'].',';
	echo $row['date'].'<br>';
}
?>