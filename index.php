<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>留言板</title>
</head>
<body>
    <?php
        error_reporting(0);
        $handle = fopen("count.txt","r");
        $data = (int)fread($handle,8192);
        fclose($handle);
        if(time() - (int)$_SESSION["temp"] > 10){
            $data += 1;
            $handle = fopen("count.txt","w");
            fwrite($handle,"".$data);
            $_SESSION["temp"] = time();
        }
        echo "本站访问次数：".$data;
    ?>
    <?php
        error_reporting(0);
        if($_SESSION["user"]==""){
    ?>
            <form method="post" action="login.php">
                用户名：<input type="text" size="5" name="username">
                密码：<input type="password" size="5" name="userpwd">
                <input type="submit" value="登录">
            </form>
    <?php
            }
    else{
        $_SESSION["publish"] = "no";
    ?>
    <form method="post" action="publish.php" enctype="multipart/form-data">
        <textarea name="mycontent" cols="30" rows="20"></textarea>
        <br>
        <input type="file" name="myfile">
        <br>
        <br>
        <input type="submit" value="留言">
        (当前用户：<?php echo $_SESSION["user"]; ?>,
        <a href="logout.php">注销</a>)
    </form>
    <?php
    }
    ?>
    <table border="1" width="300">
    <?php
        $mysqli = mysqli_connect("localhost:3306","root","xchyzj");
        mysqli_select_db($mysqli,"myweb");
        mysqli_query($mysqli,"set names utf8");
        $results = mysqli_query($mysqli,"select * from liuyan order by mytime desc");
        while($record=mysqli_fetch_array($results)){
        echo "<tr>
            <td>
                (".$record["user"].",".$record["mytime"].")";
        if($_SESSION["user"] == $record["user"]){
            echo "<a href=\"delete.php?id=".$record["id"]."&confirm=no\">删除</a>";
        }
        echo "<br>".$record["mycontent"];
        if($record["myfile"] != ''){
            echo "<br> <a href=\"files\\".$record["myfile"]."\" target='_blank'>附件</a>";
        }

        echo "
        </td>
        </tr>";
        }
    ?>
    </table>
</body>
</html>