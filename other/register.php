<? 

session_start();
if(isset($_POST['register'])) {
	include('backup.class.php');
	
	$register = new match();
	
	if($register->process())
		echo 'Success';
	else
		$register->show_errors();
}


$token = $_SESSION['token'] = md5(uniqid(mt_rand(),true));
/*<?=$S_SERVER('PHP_SELF');?>*/

?>

<body>
<div>
<form method="POST" action="<?php echo $_SERVER['PHP_SELF'] ?>">
	<input type="text" name="ruser" />
	<input type="password" name="rpass" />
	<input type="text" name="remail" />
	<input type="hidden" name="token" value="<?=$token;?>"/>
	<input type="submit" name="register" value="Sign up"/>
</form>
</div>
</body>
	