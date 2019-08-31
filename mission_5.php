<?php
	$dsn = 'mysql:dbname=tb210162db;localhost';
	$user = 'tb-210162';
	$password = 'MJz8SUZhmK';
	$pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));

    $sql = "CREATE TABLE IF NOT EXISTS keijiban2"
	." ("
	. "id INT AUTO_INCREMENT PRIMARY KEY,"
	. "name char(32),"
    . "comment TEXT,"
    . "time TEXT,"
    . "password TEXT"
	.");";
    $stmt = $pdo->query($sql);
    
    if(isset($_POST['change']))
    //変更ボタンを押した場合
    {
        //まずは変数定義
        
        $cnumber = $_POST['c_number'];
        //$filename = "mission_5-1.txt";
    
        //$fp = fopen($filename ,"a");
        //$txt = file($filename)  ;

        $sql = 'SELECT * FROM keijiban2';
        $stmt = $pdo->query($sql);
        $results = $stmt->fetchAll();

        //foreach($txt as $bun){
        foreach ($results as $row){
            //$txts = explode("<>", $bun);
            if($row['id']==$cnumber ){
                if($row['password']==$_POST['c_password']){
                    $pass = true;
                    break;
                }else{
                    echo "パスワードが違います"."<br>";
                    $name ="名前";
                    $comment = "コメント";
                    $cnumber = " ";
                    $pass = false;
                    break;
                }
            }
        }
        if($pass == true)
        {
            echo "変更内容を送信してください"."<br>";
            foreach ($results as $row){
                //$txts = explode("<>", $bun);
    
                if($row['id']==$cnumber)
                {
                    $name = $row['name'];
                    $comment = $row['comment'];
                
                    //echo $cnumber;
                    //echo $name;
                    //echo $comment;
                }
    
            }  
            //$pass = false;
        }
        
          
    
        //echo $name;
        //    }
    }else{
        $name ="名前";
        $comment = "コメント";
        $cnumber = " ";
    }
    
?>

<html>
    <meta charset="utf-8">
    <body>
    <form name="form1" method="post" action="mission_5-1.php">
    名前：<br>
    <INPUT type="text" name="name" value="<?php echo $name; ?>">
    <br>
    コメント：<br>
    <INPUT type="text" name="comment" value="<?php echo $comment; ?>">
    
    <INPUT type="hidden" name="cnumber" value="<?php echo $cnumber; ?>">
    <br>
    パスワード：<br>
    <INPUT type="text" name="password" value="password">
    <br>
    <INPUT type="submit" name="send" value="送信">
    <br>
    削除番号：<br>
    <INPUT type="text" name="d_number" value="削除番号">
    <INPUT type="text" name="d_password" value="password">
    <br>
    <INPUT type="submit" name="delete" value="削除">
    <br>
    編集番号：<br>
    <INPUT type="text" name="c_number" value="編集番号">
    <INPUT type="text" name="c_password" value="password">
    <br>
    <INPUT type="submit" name="change" value="編集">
    </form>
    </form>

</body>

</html>

<?php

if(isset($_POST['change']))
    //変更ボタンを押した場合
    {
        $sql = 'SELECT * FROM keijiban2';
	                $stmt = $pdo->query($sql);
	                $results = $stmt->fetchAll();
	                foreach ($results as $row){
		                //$rowの中にはテーブルのカラム名が入る
		                echo $row['id'].',';
		                echo $row['name'].',';
                        echo $row['comment'].',';
                        echo $row['time'].'<br>';
	                    echo "<hr>";
	                }
    }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
       
    if(isset($_POST['send'])){
        //送信ボタンを押した場合
            
            if($_POST["cnumber"] > 0){
            
                //$filename = "mission_3-5.txt";
                //$fp = fopen($filename ,"a");
                //$txt = file($filename) ;
                $id = $_POST["cnumber"] ;
                $name = $_POST["name"];
                $comment = $_POST["comment"];
                $time = date('Y年m月d日 h時i分');
                $sql = 'update keijiban2 set name=:name,comment=:comment,time=:time where id=:id';
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':name', $name, PDO::PARAM_STR);
                $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
                $stmt->bindParam(':time', $time, PDO::PARAM_STR);
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                $stmt->execute();

                $sql = 'SELECT * FROM keijiban2';
                $stmt = $pdo->query($sql);
                $results = $stmt->fetchAll();

                foreach ($results as $row){
                    //$rowの中にはテーブルのカラム名が入る
                    echo $row['id'].',';
		                echo $row['name'].',';
                        echo $row['comment'].',';
                        echo $row['time'].'<br>';
	                    echo "<hr>";
                }                
            }else{
                //通常バージョン
                //もし空欄なら
                $time = date('Y年m月d日 h時i分');
                $comment = $_POST["comment"];
                if (strlen($_POST['comment']) < 1) {
                    echo "何か入力してください";
                }else{
    
                    $sql = $pdo -> prepare("INSERT INTO keijiban2 (name, comment, time,  password) VALUES (:name, :comment, :time, :password)");
                    $sql -> bindParam(':name', $name, PDO::PARAM_STR);
                    $sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
                    $sql -> bindParam(':time', $time, PDO::PARAM_STR);
                    $sql -> bindParam(':password', $password, PDO::PARAM_STR);
                    $name = $_POST["name"];
                    $comment = $_POST["comment"];
                    $password = $_POST["password"];
                    $sql -> execute();

                    $sql = 'SELECT * FROM keijiban2';
	                $stmt = $pdo->query($sql);
	                $results = $stmt->fetchAll();
	                foreach ($results as $row){
		                //$rowの中にはテーブルのカラム名が入る
		                echo $row['id'].',';
		                echo $row['name'].',';
                        echo $row['comment'].',';
                        echo $row['time'].'<br>';
	                    echo "<hr>";
	                }
                }
            }
        }
        if(isset($_POST['delete']))
        //削除ボタンを押した場合
        {
            //まずは変数定義
            $dnumber = $_POST['d_number'];

            $sql = 'SELECT * FROM keijiban2';
	        $stmt = $pdo->query($sql);
	        $results = $stmt->fetchAll();
	        foreach ($results as $row){
		                //$rowの中にはテーブルのカラム名が入る
                if($row['id']==$dnumber ){
                    if($row['password']==$_POST['d_password']){
                        $pass = true;
                        break;
                    }else{
                        echo "パスワードが違います"."<br>";
                        //$name ="名前";
                        //$comment = "コメント";
                        //$cnumber = " ";
                        $pass = false;
                        break;
                    }
                }
	        }

            if($pass == true){
                $id = $_POST['d_number'];
                $sql = 'delete from keijiban2 where id=:id';
	            $stmt = $pdo->prepare($sql);
	            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
	            $stmt->execute();
            }
            
            $sql = 'SELECT * FROM keijiban2';
	        $stmt = $pdo->query($sql);
	        $results = $stmt->fetchAll();
	        foreach ($results as $row){
		        //$rowの中にはテーブルのカラム名が入る
		        echo $row['id'].',';
		        echo $row['name'].',';
                echo $row['comment'].',';
                echo $row['time'].'<br>';
	            echo "<hr>";
            }
            /*$filename = "mission_3-5.txt";
            $fp = fopen($filename ,"a");
            $txt = file($filename)  ;
            foreach($txt as $bun){
                $txts = explode("<>", $bun);
                if($txts[0]==$dnumber ){
                    if($txts[4]==$_POST['d_password']){
                        $pass = true;
                        break;
                    }else{
                        echo "パスワードが違います"."<br>";
    
                        $pass = false;
                        break;
                    }
                }
            }
            if($pass == true){
    
                //削除番号を抜いてファイルを表示
                foreach($txt as $bun)
                {
                    $txts = explode("<>", $bun);
    
                    if($txts[0]==$dnumber)
                    {
                    
                    }else{
                        foreach($txts as $i){
                            if($txts[4] == $i){
    
                            }else{
                                echo $i;
                            }
                        }   
                        echo "<br>";   
                    }
    
                }
    
                //ファイルを削除（ファイルを消しても$txtのデータは消えない）
                unlink($filename);
    
                //ファイルをもう一度作る
                $filename2 = "mission_3-5.txt";
                $fp2 = fopen($filename2 ,"a");
    
                //ファイルを削除番号を抜いて、復元する
                foreach($txt as $bun)
                {
                    $txts = explode("<>", $bun);
                    if($txts[0]==$dnumber) //削除番号なら何もやらない
                    {
                    
                    }else{
                        fwrite($fp2, $bun);
                    }
                }
                fclose( $fp2 );
            }else{
                foreach($txt as $bun)
                {
                    $txts = explode("<>", $bun);
                    foreach($txts as $i){
                        if($txts[4] == $i){
    
                        }else{
                            echo $i;
                        }
                    }   
                    echo "<br>";   
                }
            }*/
        }
    
        
    }

?>
