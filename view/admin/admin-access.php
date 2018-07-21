<?php
// This code needed in all your pages
if (!defined('SECURITY_KEY') ){ exit($mvc_lang_error['security_key']); }
if(SETUP_SHOW_PATH){ developMode(__FILE__);}
if ( isset($_POST['access']) ){	mvc_loginUser( $_POST['mail'], $_POST['password'] ); }
?>
<?php include('header.php'); ?>
<h1>Access</h1>
<div class="row">
	<div class="mvc-12">
		<form action="" method="POST">
			<div class="row" >
				<div class="mvc-3-9 mvc-center">
					<input type="text" name="mail" placeholder="x@x.x"><br><input type="password" name="password" placeholder="!****">
					<p><input type="submit" name="access" value="Access"></p>
				</div>
			</div>
		</form>
	</div>
</div>
<?php include('footer.php'); ?>