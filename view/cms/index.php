<?php
if (!defined('SECURITY_KEY') ){ exit($mvc_lang_error['security_key']); }
if(SETUP_SHOW_PATH){ developMode(__FILE__);}
//LAYOUT
?>
<!DOCTYPE html>
<html lang="es" >
	<head>
		<?php get_head(); ?>
	</head>

	<body >

			<!-- HEADER INI -->
			<header class="content_header custom_container">
			<?php
			get_header();
			?>
			</header>

			<!-- CONTENT INI -->
			<content>

				<?php
				if ( file_exists("controller/view.php") )	{ require( "controller/view.php" ); }else{ exit( $mvc_lang_error['file_not_exists']." controller/view.php"); }
				?>
				
			</content>

			<!-- FOOTER INI -->
			<footer class="content_footer custom_container">
				<?php	get_footer();	?>	
			</footer>
		<?php get_console(); ?>

	</body>
</html>