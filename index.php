<?php
session_start();

/*BASIC MVC*/

/*SANITIZE EXTERNAL INPUT DATA ----------------------- INI*/
$_GET   = filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING);
$_POST  = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

/*EVENT DEFINITION	*/
$error = array();
$event = array();

/*require SETUP configuration file*/
if ( file_exists("setup.php") )	{ require( "setup.php" ); }else{ exit( " Setup.php Not Exist." ); }

/*Conexion Database.*/
if ( defined('DB_CON_FILE') && DB_STATUS && defined('DB_HOST') && defined('DB_NAME') && defined('DB_USER') && defined('DB_PASS') ) {
	if ( file_exists("model/".DB_CON_FILE) )	{ require( "model/".DB_CON_FILE ); }else{ exit( $mvc_lang_error['file_not_exists']." model/".DB_CON_FILE." Not Exist." ); } 
	$sql=new db();
	$sql->sql_open();
}else{

}

/*require Main Function file*/
if ( file_exists("controller/function.php") )	{ require( "controller/function.php" ); }else{ exit( " controller/function.php. Not Exist." ); }

/* Load Database Globals*/
if (!isset($_SESSION['mvc_theme_'.SETUP_SESSION_ID])){mvc_databaseGlobals();}

/*Show error php.*/
if ( defined('SETUP_SHOW_ERROR') ) {
	ini_set('display_errors', 'On');
	ini_set('display_errors', 1);
}



/* Security.*/
if (!defined('SECURITY_KEY') ){ exit($mvc_lang_error['security_key']); }
if(SETUP_SHOW_PATH){ developMode(__FILE__); }

/*Execute required action*/
/*require action file*/
if ( file_exists("controller/action.php") )	{ require( "controller/action.php" ); }else{ exit( $mvc_lang_error['file_not_exists']." controller/action.php. Not Exist." ); }

/*Charge LAYOUT !!IMPORTANT*/
/*
if ( file_exists(SETUP_THEME_PATH."index.php") )	{
	require( SETUP_THEME_PATH."index.php" );
}else{
	exit( $mvc_lang_error['file_not_exists']." view/index.php. Not Exist." );
}
*/

if ( file_exists("controller/view.php") )	{
	require( "controller/view.php" ); }else{ exit( $mvc_lang_error['file_not_exists']." controller/view.php");
}
				

/*End Database Connection*/
if ( defined('DB_STATUS') && isset($sql) ) {
	if (DB_STATUS)
	{
		if ( defined('DB_CON_FILE') ) {
		$sql->sql_close();
		}
	}	
}

?>