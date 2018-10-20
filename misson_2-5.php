<html>
<head>
<meta charset="UTF-8">
</head>



<?php

$filename='misson_2-5_ikeda.txt';
$comment=$_POST['comment'];
$name=$_POST['name'];
$password=$_POST['password'];
$delpass=$_POST['delpass'];
$edipass=$_POST['edipass'];
$date=date("Y/m/d H:i:s");
$newData="<>".$name."<>".$comment."<>".$date."<>".$password."<>";



//削除機能
$delete=$_POST['delete'];
//削除番号が空でない時
if(!empty($delete)){
	$fd=file($filename);
	$fp=fopen($filename,'w');
	for($i=0;$i<count($fd);$i++){
		$num=explode("<>",$fd[$i]);
//削除番号と投稿番号が一致していない時
		if($delete!=$num[0]){
//元の行を書き込む
				fwrite($fp,$fd[$i]);			
//削除番号と投稿番号が一致している時
		}else{
			if($delpass==$num[4]){
//何もしない→削除
			echo" ";
			}else{
				echo"パスワードが違います。";
				fwrite($fp,$fd[$i]);
			}
		}
	}
	fclose($fp);
}



//編集
$edit=$_POST['edit'];
//投稿番号が空でない時
if(!empty($edit)){
	$fd=file($filename);
	for($k=0;$k<count($fd);$k++){
		$ediData=explode("<>",$fd[$k]);
//投稿番号と編集番号が一致した時
		if($edit==$ediData[0]){
			if($edipass==$ediData[4]){
				$a=$ediData[1];
				$b=$ediData[2];
				$c=$ediData[0];
			}else{
				echo"パスワードが違います。";
				fwrite($fp,$fd[$h]);
			}
		}
	}
}
		
	
//editnumが空でない時（編集モード）
$editnum=$_POST['editnum'];
if(!empty($editnum)){
	$fd=file($filename);
	$fp=fopen($filename,'w');
	for($h=0;$h<count($fd);$h++){
		$newtext=explode("<>",$fd[$h]);
//編集番号と投稿番号が一致している時
		if($editnum==$newtext[0]){
			//新しい行を書き込む→編集
				fwrite($fp,$editnum.$newData . PHP_EOL);
//編集番号と投稿番号が一致していない時	
		}else{
//元の行を書き込む
			fwrite($fp,$fd[$h]);
		}
	}
	fclose($fp);
}elseif(!empty($comment) && !empty($name)){
	//ファイルを開き、書き込み
	$fp=fopen($filename,'a');
	$fd=file($filename);
	$cnt=count(file($filename));
	$newcnt=explode("<>",$fd[$cnt-1],1);
	$newcnt=$newcnt[0]+1;
	fwrite($fp,$newcnt.$newData . PHP_EOL);
	//ファイルを閉じる
	fclose($fp);
}

	
	
		
?>
<form action="misson_2-5.php" method="post">
<input type="text" name="name" value="<?php echo $a;?>" size="30" placeholder="名前"><br/>
<input type="text" name="comment" value="<?php echo $b;?>" size="30" placeholder="コメント"><br/>
<input type="text" name="password" size="30" placeholder="パスワード">
<input type="submit">
<input type="hidden" name="editnum" value="<?php echo $c;?>" size="30" ><br>
</form>

<form action="misson_2-5.php" method="post">
<input type="text" name="delete" size="30" placeholder="削除対象番号"><br/>
<input type="text" name="delpass" size="30" placeholder="パスワード">
<input type="submit" value="削除"><br/>
</form>

<form action="misson_2-5.php" method="post">
<input type="text" name="edit" size="30" placeholder="編集対象番号"><br/>
<input type="text" name="edipass" size="30" placeholder="パスワード">
<input type="submit" value="編集"><br/><br/>
</html>


<?php
//ループ関数で投稿ごとに改行し全データを表示
$file=file($filename);
foreach($file as $value){
	$word=explode("<>",$value);
	echo $word[0] . " ";
	echo $word[1] . " ";
	echo $word[2] . " ";
	echo $word[3] . '<br>';
}
?>