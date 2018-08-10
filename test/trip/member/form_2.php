<!-- 获取邮箱地址 -->
<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<form action="form_2.php" method="post">
		<p>
			用户名：<input type="text" name="username" maxlength="20" />
		</p>
		<p>
			邮箱：<input type="text" name="email" maxlength="50" />
		</p>
		<input type="submit" name="submit" value="Go!" />
	</form>
	<?php 
		include("form_2.php.php");
		function validate_email($email){
			$regexp="^([_a-z0-9]+)(\.[_a-z0-9]+)*@([a-z0-9]+)(\.[a-z0-9-]+)*(\.[a-z]{2,6})$";
			//验证邮箱地址
			if(eregi($regexp, $email)){
				return 1;
			}else{
				return 0;
			}
		}
			if(isset($_POST['submit'])){
				echo "Hi!".$_POST['username']."</br>";
				if(validate_email($_POST['email'])){
					echo "您的邮箱地址".$_POST['email']."是有效";
				}else{
					echo "您的邮箱地址<font color='red'>".$_POST['email']."</font>是无效";
				}
			}
	 ?>
</body>
</html>