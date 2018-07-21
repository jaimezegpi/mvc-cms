<?php
if (!defined('SECURITY_KEY') ){ exit($mvc_lang_error['security_key']); }
if(SETUP_SHOW_PATH){ developMode(__FILE__);}
//Footer
?>
		<footer class="content_footer custom_container">
			<h6><a mailTo="jaimezegpi@yahoo.es">jaimezegpi@yahoo.es</a></h6>
		</footer>
		<?php get_console(); ?>

	</body>
</html>