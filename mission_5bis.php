<!DOCTYPE html>
<html lang="ja">
    <head>
    <meta charset="UTF-8">
    <title>mission_05-01</title>
    </head>
    <body>
      <?php
        ini_set("display_error","On");
        $name=$_POST["name"];
        $comment=$_POST["comment"];
        $submit=$_POST["submit"];
        $dnum=$_POST["dnum"];
        $delete=$_POST["delete"];
        $mnum=$_POST["mnum"];
        $MNUM=$_POST["MNUM"];
        $edit=$_POST["edit"];
        $pass=$_POST["pass"];
        $passw=$_POST["passw"];
        $passww=$_POST["passww"];
        $Mnum==null;
//データベースに接続
        $dsn='データベース名';
        $user='ユーザー名';
        $password='パスワード';
	    $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
//テーブルを作成
    	$sql = "CREATE TABLE IF NOT EXISTS tbtest1"
    	." ("
    	. "id INT AUTO_INCREMENT PRIMARY KEY,"
    	. "name char(32),"
    	. "comment TEXT,"
    	. "pass TEXT"
    	.");";
        $stmt = $pdo->query($sql);
//データを入力
        if(isset($submit)&&$comment!==""&&$MNUM==null){
    	    $sql = $pdo -> prepare("INSERT INTO tbtest1 (name, comment, pass) VALUES (:name, :comment, :pass)");
    	    $sql -> bindParam(':name', $name, PDO::PARAM_STR);
    	    $sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
    	    $sql -> bindParam(':pass', $pass, PDO::PARAM_STR);
    	    $sql -> execute();  
        }
//削除機能
        elseif(isset($delete)&&$dnum!==""){
            $sql = 'SELECT id, pass FROM tbtest1';
            $stmt=$pdo->query($sql);
            $result=$stmt->fetchAll( );
            foreach ($result as $val){
                if($dnum==$val['id'] && $passw==$val['pass']){
                    $sql='delete from tbtest1 WHERE id=:id';
                    $stmt=$pdo->prepare($sql);
                    $stmt->bindParam(':id',$dnum,PDO::PARAM_INT);
                    $stmt->execute();
                }
            }
        }
//編集機能
        elseif(isset($edit)&&$mnum!==""){
            $sql = "SELECT id, name, comment, pass FROM tbtest1";
            $stmt = $pdo -> query($sql);
            $result=$stmt->fetchAll( );
            foreach($result as $val){
                if($val['id']==$mnum &&$passww==$val['pass']){
                    $rename=$val['name'];
                    $recomment=$val['comment'];
                    $repass=$val['pass'];
                    $Mnum=$mnum;
                }
            }
        }
//編集      
        if(isset($submit)&&$comment!==""){
            $sql='UPDATE tbtest1 SET name=:name, comment=:comment, pass=:pass WHERE id=:id';
            $stmt=$pdo->prepare($sql);
            $stmt->bindParam(':name',$name,PDO::PARAM_STR);
            $stmt->bindParam(':comment',$comment,PDO::PARAM_STR);
            $stmt->bindParam(':pass',$pass,PDO::PARAM_STR);
            $stmt->bindParam(':id',$MNUM,PDO::PARAM_INT);
            $stmt->execute();
        }
 
        ?>
         <form action=" " method="POST">
            <input type="text" name="name" placeholder="pls write ur name"
            value=<?php echo $rename?>>
            <input type="text" name="comment" placeholder="pls write some comment"
            value=<?php echo $recomment?>>
            <input type="password" name="pass" placeholder="write ur password"
            value=<?php echo $repass?>>
            <input type="submit" name="submit" value="送信"><br>
            <input type="number" name="dnum" placeholder="deleting number">
            <input type="text" name="passw">
            <input type="submit" name="delete" value="削除"><br>
            <input type="number" name="mnum" placeholder="editing number">
            <input type="text" name="passww">
            <input type="submit" name="edit" value="編集">
            <input type="hidden" name="MNUM" value=<?php echo $Mnum?>><br>

        </form> 
<?php
//入力したデータレコードを抽出し、表示する
    	$sql = 'SELECT * FROM tbtest1';
    	$stmt = $pdo->query($sql);
    	$results = $stmt->fetchAll();
    	foreach ($results as $row){
    		echo $row['id'].',';
    		echo $row['name'].',';
    		echo $row['comment'].'<br>';
    	echo "<hr>";
	    }
        
        ?>
        
    </body>
</html>