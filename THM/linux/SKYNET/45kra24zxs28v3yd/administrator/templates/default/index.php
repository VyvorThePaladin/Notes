<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <?php 
            include("html/header.php");
        ?>
    </head>
    <body>
        <?php
            if(@$_SESSION["admin_login"] == "1"){
                include("html/top.php");
                include("html/menu.php");
                include("html/content.php");
                include("html/footer.php");
            }else{
                include("html/login.php");
            }
        ?>
    </body>
</html>