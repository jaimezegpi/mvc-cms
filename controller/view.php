<?php
if (!defined('SECURITY_KEY') ){ exit($mvc_lang_error['security_key']); }
if(SETUP_SHOW_PATH){ developMode(__FILE__);}

if (isset($_GET['view']))
{
	$current_view = cleanViewUrl( $_GET['view'] );
	if($current_view=='index' || $current_view=='head' || $current_view=='header' || $current_view=='footer'){
		$render = false;
	}else{
		$render = true;
	}
	if (SETUP_RENDER_ALL_REQUEST && $render)
	{
		str_replace(".","", $current_view);
		if ( file_exists(SETUP_THEME_PATH.$current_view.".php") ){
		 		require(SETUP_THEME_PATH.$current_view.".php");
			}elseif( file_exists('view/admin/'.$current_view.".php") ){
				require('view/admin/'.$current_view.".php");
			}else{
				$ff=$mvc_lang_error['file_not_exists']." ".$current_view.".php";
				array_push($error, $mvc_lang_error['file_not_exists']." ".SETUP_THEME_PATH.$current_view.".php");
				require(SETUP_THEME_PATH.SETUP_THEME_DEFAULT_PAGE); 
			}
	}else{
		switch ($_GET['view']) {
			/* You can set custom php file to alias url*/
			default:
				if ( file_exists(SETUP_THEME_PATH.SETUP_THEME_DEFAULT_PAGE) ){ $current_view=SETUP_THEME_DEFAULT_PAGE; require(SETUP_THEME_PATH.SETUP_THEME_DEFAULT_PAGE); }else{ array_push($error, $mvc_lang_error['file_not_exists'].SETUP_THEME_DEFAULT_PAGE);}
				break;
		}
	}
}else{
	if ( file_exists(SETUP_THEME_PATH.SETUP_THEME_DEFAULT_PAGE) ){ 
		$current_view = SETUP_THEME_DEFAULT_PAGE; 
		require(SETUP_THEME_PATH.SETUP_THEME_DEFAULT_PAGE); 
	}else{ 
		array_push($error, $mvc_lang_error['file_not_exists']." ".SETUP_THEME_DEFAULT_PAGE." Not Exist");
	}
}
?>