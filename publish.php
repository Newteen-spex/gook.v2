<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php
    error_reporting(0);
    date_default_timezone_set('Asia/Shanghai');
    if(trim($_POST["mycontent"]) != "" && $_SESSION["publish"] != "ok"){
        $mysqli = mysqli_connect("localhost:3306","root","xchyzj");
        mysqli_select_db($mysqli,"myweb");
        mysqli_query($mysqli,"set names utf8");

        $mycontent = trim($_POST["mycontent"]);
        $mycontent = htmlspecialchars($mycontent);
        $mycontent = str_replace("\n","<br>",$mycontent);
        $mycontent = str_replace(" ","&nbsp",$mycontent);

        mysqli_query($mysqli,"insert into liuyan (mycontent,mytime,user)
        values ('".$mycontent."','".date('Y-m-d H:m:s')."','".$_SESSION["user"]."')");

        $upfile = $_FILES["myfile"];
        if($upfile["name"] != ''){
            if(is_uploaded_file($upfile["tmp_name"]) && $upfile["size"] < 1024*1024){
                $id = mysqli_insert_id($mysqli);
                $filename = $_SESSION["user"].'_'.$upfile["name"];
                $filepath = 'files/'.$filename;
                move_uploaded_file($upfile["tmp_name"],$filepath);
                $query = "update liuyan set myfile='".$filename."' where id='".$id."'";
                mysqli_query($mysqli,$query);
                echo "文件上传成功！";

            }else{
                echo "文件上传失败！";
            }
        }
        $_SESSION["publish"] = "ok";
        echo "<br>发布成功！";
    }else{
        echo "请输入内容！";
    }
    
?>
<a href="index.php">返回</a>
</body>
</html>