<?php
    session_start();
    $_SESSION["user"] = '';
    echo "注销成功！<br> <a href='index.php'>返回登录界面</a>";
?>
