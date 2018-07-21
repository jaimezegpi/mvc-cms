<?php
// This code needed in all your pages
if (!defined('SECURITY_KEY') ){ exit($mvc_lang_error['security_key']); }
if(SETUP_SHOW_PATH){ developMode(__FILE__); }
if (isset($_SESSION['mvc_site_admin_'.SETUP_SESSION_ID])){mvc_databaseGlobals();}
mvc_render_adminPage();
?>
