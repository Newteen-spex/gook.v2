<?php
    session_start();
    if(trim($_POST["username"]) != '' && $_POST["userpwd"] != ''){
        $mysqli = mysqli_connect("localhost:3306","root","xchyzj");
        mysqli_select_db($mysqli,"myweb");
        $query = "select * from user where username='".trim($_POST["username"])."' 
        and userpwd='".md5($_POST["userpwd"])."'";
        $result = mysqli_query($mysqli,$query);
        if(mysqli_fetch_array($result)){
            $_SESSION["user"] = trim($_POST["username"]);
            echo "登录成功！<a href='index.php'>继续</a>";
        }else{
            echo "用户名或密码错误！<a href='index.php'>返回</a>";
        }
    }else{
        echo "用户名或密码不能为空！<a href='index.php'>返回</a>";
    }
?>
