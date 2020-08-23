<div class="top" id="top">
	<a href="index.php"><div class="logo" id="logo"></div></a>
    <div class="user_info" id="user_info">
    	<div><font style="color:#92B22C; font-weight:bold">Welcome, </font><?php echo $_SESSION["name"] ?></div>
        <div style="padding-left:35px"><?php echo $_SESSION["email"] ?></div>
        <div style="padding-left:35px"><?php echo $_SESSION["user_group_name"] ?></div>
    </div>
</div>