<?php if ( !isset($mvc_install_cms_result) ){ $mvc_install_cms_result=null;} ?>

<h1>Instalation</h1>
<div id="row">
	
	<div class='mvc-12 <?php if ($mvc_install_cms_result){ echo "mvc_ok"; }else{ echo "hidden"; }	?>'>
		<div class='row'>
			<div class="mvc-6">
				<h2>Thanks!!</h2>
				<p>mvc_config.php and database are created.</p>
				<p>This is an experimental develop.</p>
			</div>
			<div class="mvc-6">
				<h2>Now?</h2>
				<p>Acces to Admin.</p>
				<p>Super ultra Mini Manual.</p>
				<p>Go to online.</p>
				<p>Buy me a coffe :) </p>
			</div>
		</div>
	</div>
	<div class="mvc-12 <?php if ($mvc_install_cms_result){ echo "hidden";}	?>" >
		<h2>Step 1</h2>
		<form action="<?php echo get_site_url(); ?>" method="POST" class="mvc_install_form mvc-block-flex mvc-flex-c mvc-center">
			<input type="hidden" name="action" value="mvc_install_cms">
			<div class="row">
				<div class="mvc-6">
					<p >Host</p>
					<input type="text" id="db_host" name="db_host" value="<?php if(isset($_POST['db_host'])){ echo $_POST['db_host']; }?>" placeholder="localhost">
				</div>
				<div class="mvc-6">
					<p>Database Name</p>
					<input type="text" id="db_name" name="db_name" value="<?php if(isset($_POST['db_name'])){ echo $_POST['db_name']; }?>" placeholder="mvc">
				</div>				
			</div>

			<div class="row">
				<div class="mvc-6">
					<p>Database User Name</p>
					<input type="text" id="db_user" name="db_user" value="<?php if(isset($_POST['db_user'])){ echo $_POST['db_user']; }?>" placeholder="root">
				</div>
				<div class="mvc-6">
					<p>Database Password</p>
					<input type="text" id="db_password" name="db_password" value="<?php if(isset($_POST['db_password'])){ echo $_POST['db_password']; }?>" placeholder="">
				</div>

			</div>

			<div class="row">
				<div class="mvc-6">
					<p>Table Prefix</p>
					<input type="text" id="db_prefix" name="db_prefix" value="<?php if(isset($_POST['db_prefix'])){ echo $_POST['db_prefix']; }else{ echo "mvc_"; }?>" placeholder="mvc_">
				</div>
				<div class="mvc-6">
					<p >Site Name</p>
					<input type="text" id="site_name" name="site_name" value="<?php if(isset($_POST['site_name'])){ echo $_POST['site_name']; }?>" placeholder="MVC">
				</div>

			</div>
			<br>
			<div class="row">
				<div class="mvc-6">
					<p>A.Email</p>
					<input type="text" id="admin_email" name="admin_email" value="<?php if(isset($_POST['admin_email'])){ echo $_POST['admin_email']; }?>" placeholder="defend@theuser.com">
				</div>
				<div class="mvc-6">
					<p>A.Password</p>
					<input type="password" id="admin_password" name="admin_password"  value ="<?php if(isset($_POST['admin_password'])){ echo $_POST['admin_password']; }?>" placeholder="warning by carefull">
				</div>
			</div>


			<div class="row">
				<div class="mvc-12">

						<input type="submit" id="db_submit" name="install" value="Test & Install" >
						<?php
							if ($event){
					          foreach ($event as $key => $value) {
					            echo "<p ><span class='mvc_console_event'> - </span>".$value."</p>";
					          }
							}	
							if ($error){
					          foreach ($error as $key => $value) {
					            echo "<p ><span class='mvc_console_error'> - </span>".$value."</p>";
					          }
							}

						?>

				</div>
				
			</div>
		</form>
	</div>

</div>
