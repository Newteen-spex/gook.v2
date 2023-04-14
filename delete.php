<?php
    session_start();

    if($_GET["confirm"] == "no"){
        echo "确认删除？<a href=\"delete.php?id=".$_GET["id"].
            "&confirm=yes\">确认</a>or<a href='index.php'>返回</a>";
    }

    if($_GET["id"] != '' && $_GET["confirm"] == "yes"){
        $mysqli = mysqli_connect("localhost:3306","root","xchyzj");
        mysqli_select_db($mysqli,"myweb");

        $results = mysqli_query($mysqli,"select * from liuyan where id=".$_GET["id"].
            " and user='".$_SESSION["user"]."';");
        $record = mysqli_fetch_array($results);
        if(!$record){
            echo "删除失败！<br><a href='index.php'>返回</a>";
        }else{
            mysqli_query($mysqli,"delete from liuyan where id=".$_GET["id"].";");
            if($record["myfile"] != NULL){
                unlink("files/".$record["myfile"]);
            }
            echo "留言删除成功！<br><a href='index.php'>返回</a>";
        }
    }
?>
