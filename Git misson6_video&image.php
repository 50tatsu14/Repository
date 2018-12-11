<html>
<head>
<meta charset="UTF-8">
</head>
<h2>注目選手動画掲示板</h2><br/>
動画投稿は<a href="http://tt-462.99sv-coco.com/misson6_login.php">こちら</a>から<br/><br/>
</html>

<?php
//データベースへの接続
$dsn='データベース名';
$user='ユーザー名';
$password='パスワード';
$pdo=new PDO($dsn,$user,$password);


//入力データをselectによって表示する
//$sql='SELECT*FROM new_misson6_upload';
//$results=$pdo->query($sql);
//foreach($results as $row){
//	echo $row['id'].',';
//	echo $row['team'].',';
//	echo $row['player'].',';
//	echo $row['dominant'].',';
//	echo $row['position'].',';
//	echo $row['place'].',';
//	echo $row['comment'].'<br>';
//}
    //DBから取得して表示する．
    $sql = "SELECT * FROM new_misson6_upload ORDER BY id;";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    while ($row = $stmt -> fetch(PDO::FETCH_ASSOC)){
        echo $row['id'].',';
	    echo "チーム名：".$row['team'].'　,　';
	    echo "選手名：".$row['player'].'<br>';
        echo "利き(投打)：".$row['dominant'].'　,　';
	    echo "ポジション：".$row['position'].'<br>';
	    echo $row['place'].'<br>';
	    echo $row['comment'].'<br>';
        //動画と画像で場合分け
        $target = $row["id"];
        if($row["extension"] == "mp4"){
            echo ("<video src=\"misson6_media.php?target=$target\" width=\"426\" height=\"240\" controls></video>");
        }
        elseif($row["extension"] == "jpeg" || $row["extension"] == "png" || $row["extension"] == "gif"){
            echo ("<img src='misson6_media.php?target=$target'>");
        }
        echo ("<br/><br/>");
    }
?>