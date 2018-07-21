<?php

/*
Get browser user client
*/
function getUserBrowser()
{
    $useragent = $_SERVER ['HTTP_USER_AGENT'];  
    return $useragent;
}

/*
Clean Basic Input Text
*/
function cleanInput($input) 
{
    $search = array(
    '@<script[^>]*?>.*?</script>@si',   // Strip out javascript
    '@<[\/\!]*?[^<>]*?>@si',            // Strip out HTML tags
    '@<style[^>]*?>.*?</style>@siU',    // Strip style tags properly
    '@<![\s\S]*?--[ \t\n\r]*>@'         // Strip multi-line comments
    );
    $output = preg_replace($search, '', $input);
    return $output;
}

/*
Sanitize Basic Input Text
*/
function sanitize($input) {
    if (is_array($input)) {
       foreach($input as $var=>$val) {
           $output[$var] = sanitize($val);
       }
    }else{
       if (get_magic_quotes_gpc()) {
           $input = stripslashes($input);
       }
       $output  = cleanInput($input);
    }
    return $output;
}

/*
Clean Url
*/
function cleanViewUrl($current_view){
  $current_view = str_replace("..", "_", $current_view);
  $current_view = str_replace("./", "", $current_view);
  $current_view = str_replace("/", "", $current_view);
  $current_view = cleanInput($current_view);
  $current_view = strtolower($current_view);
  return $current_view;
}

/*
Get Head.php in theme folder
*/
function get_head(){
  global $mvc_lang_error;
  if ( file_exists(SETUP_THEME_PATH."head.php") ) { require( SETUP_THEME_PATH."head.php" ); }else{ exit(  $mvc_lang_error['file_not_exists']." head.php" ); }
}

/*
Get Header.php in theme folder
*/
function get_header(){
  global $mvc_lang_error;
  if ( file_exists(SETUP_THEME_PATH."header.php") ) { require( SETUP_THEME_PATH."header.php" ); }else{ exit(  $mvc_lang_error['file_not_exists']." header.php" ); }
}

/*
Get Footer.php in theme folder
*/
function get_footer(){
  global $mvc_lang_error;
  if ( file_exists(SETUP_THEME_PATH."footer.php") ) { require( SETUP_THEME_PATH."footer.php" ); }else{ exit(  $mvc_lang_error['file_not_exists']." footer.php" ); }
}

/*
Render Console
*/
function get_console(){
    if (SETUP_SHOW_CONSOLE){ 
      global $event, $error;
      ?>
      <div class="log_console">
      <p>[Event Console]</p>
      <pre>
      <?php
        if (defined('SETUP_SHOW_ERROR'))
        {
          foreach ($event as $key => $value) {
            echo "<p ><span class='mvc_console_event'> - </span>".$value."</p>";
          }
          foreach ($error as $key => $value) {
            echo "<p ><span class='mvc_console_error'> - </span>".$value."</p>";
          }
        }
      ?>
      </pre>
      <p class="log_console_date"><?php echo date('Y-m-d H:i:s'); ?></p>
      </div>
    <?php } 
}

//--------------------------------

function get_site_url(){
  return baseUrl();
}

function mvc_install_cms($post){
  $install_error = false;
  if (count($post)){

    /*HOST*/
    if (isset($post['db_host'])){
      if ($post['db_host']){
        $db_host = $post['db_host'];
      }else{
        $install_error = true;
        array_push($GLOBALS["error"],"Host not set."); 
      }
    }else{array_push($GLOBALS["error"],"Host not set."); $install_error = true;}

    /*DB NAME*/
    if (isset($post['db_name'])){
      if ($post['db_name']){
        $db_name = $post['db_name'];
      }else{
        array_push($GLOBALS["error"],"Database Name not set."); $install_error = true;
      }
    }else{array_push($GLOBALS["error"],"Database Name not set."); $install_error = true; }

    /*DB USER*/
    if (isset($post['db_user'])){
      if ($post['db_user']){
        $db_user = $post['db_user'];
      }else{
        array_push($GLOBALS["error"],"Database UserName not set."); $install_error = true;
      }
    }else{array_push($GLOBALS["error"],"Database UserName not set."); $install_error = true; }


    /*DB USER*/
    if (isset($post['db_prefix'])){
      if ($post['db_prefix']){
        $db_prefix = $post['db_prefix'];
      }else{
        array_push($GLOBALS["error"],"Prefix not set."); $install_error = true;
      }
    }else{array_push($GLOBALS["error"],"Prefix not set."); $install_error = true; }

    /*DB PASS*/
    if (isset($post['db_password'])){
      if ($post['db_password']){
        $db_password = $post['db_password'];
      }else{
        $db_password="";
      }
    }else{ $db_password=""; }

    /*A SITE NAME*/
    if (isset($post['site_name'])){
      if ($post['site_name']){
        $site_name = $post['site_name'];
      }else{
        array_push($GLOBALS["error"],"Site Name not set."); $install_error = true;
      }
    }else{array_push($GLOBALS["error"],"Site Name not set."); $install_error = true; }

    /*A ADMIN EMAIL*/
    if (isset($post['admin_email'])){
      if ($post['admin_email']){
        $admin_email = $post['admin_email'];
      }else{
        array_push($GLOBALS["error"],"Admin email not set."); $install_error = true;
      }
    }else{array_push($GLOBALS["error"],"Admin email not set."); $install_error = true; }

    /*A ADMIN password*/
    if (isset($post['admin_password'])){
      if ($post['admin_password']){
        $admin_password = $post['admin_password'];
      }else{
        array_push($GLOBALS["error"],"Admin password not set."); $install_error = true;
      }
    }else{array_push($GLOBALS["error"],"Admin password not set."); $install_error = true; }

  }else{
    array_push($GLOBALS["error"],"No data in Form"); $install_error = true;
    return false;
  }

  if($install_error ){ return false; }else{
    //proceed to install
    array_push($GLOBALS["event"],"Proceed to test database connection.");

    if ( mvc_testMysqliConnect($db_host, $db_name, $db_user, $db_password) ){
      $mvc_config = fopen('mvc_config.php','w');
      if ($mvc_config){
        fwrite($mvc_config, "<?php\r\n");
        fwrite($mvc_config, "/*Db Config*/\r\n");
        fwrite($mvc_config, "define('DB_HOST','$db_host');\r\n");
        fwrite($mvc_config, "define('DB_NAME','$db_name');\r\n");
        fwrite($mvc_config, "define('DB_USER','$db_user');\r\n");
        fwrite($mvc_config, "define('DB_PASS','$db_password');\r\n");
        fwrite($mvc_config, "define('DB_PREFIX','$db_prefix');\r\n");
        fwrite($mvc_config, "/*--*/\r\n");
        fwrite($mvc_config, "define('SITE_NAME','$site_name');\r\n");
        fwrite($mvc_config, "/*--*/\r\n");
        fwrite($mvc_config, "define('ADMIN_EMAIL','$admin_email');\r\n");
        fwrite($mvc_config, "?>");
        fclose($mvc_config);
        array_push($GLOBALS["event"],"Configuration file mvc_config.php created.");
        include('mvc_config.php');
        include('model/'.DB_CON_FILE);
        
        $sql=new db();
        $sql->sql_open();
        $mvc_install = $sql->sql_install_mvc($admin_email, $admin_password,$db_prefix, $site_name, "mvc", "home");
        $sql->sql_close();
        if ($mvc_install){ return true; }else{ return false; }
      }else{
        array_push($GLOBALS["error"],"Stop!. Cant Create or write mvc_config.php.");
      }

    }else{
      array_push($GLOBALS["error"],"Stop!. Errors in Database connection. try again using other values.");
    }
  }
  return false;
}

function mvc_testMysqliConnect($db_host, $db_name, $db_user, $db_pass){
  $con = @new MySQLi($db_host, $db_user, $db_pass, $db_name);
  if ($con->connect_error) {
     array_push($GLOBALS["error"],"Can't connect to database : " . $con->connect_error);
     return false;
  }
  else {
     return true;
  }
}

function mvc_databaseGlobals(){
  global $sql;
  $setup_values = $sql->sql_get_setup_values();
  foreach ( $setup_values as $key => $value) {
    $_SESSION[ "mvc_".$value['name']."_".SETUP_SESSION_ID]= $value['value'];
  }

}

function mvc_loginUser( $u, $p ){
  if ( !$u || !$p ){ array_push($GLOBALS["error"],"Error: Bad user or pass. Level 0 "); return false; }
  global $sql;
  $f = false;
  $r = array();
  $uname = $sql->sql_get_user($u);
  if (!$uname){ array_push($GLOBALS["error"],"Error: Bad user or pass. Level 1 "); return false; }
  foreach ($uname as $key => $value) {
    $n = $value['name'];
    $ct = $value['category'];
    $vl = $value['value'];
    $pi = $value['parent_id'];
    if ($ct=='password'){
      if ( $vl == $p ){
        $f = true;

      }else{
        array_push($GLOBALS["error"],"Error: Bad user or pass. Level 2 ");
        return false;
      }
    }elseif($pi=='2'){
      array_push($r, array( 'category' => $ct ) );
    }else{
      array_push($r, array( $ct => $vl ) );
    }
  }

  if ( $f ){
    $_SESSION['mvc_user_status_'.SETUP_SESSION_ID ] = 'logged';
    foreach ($r as $key => $value) {
      $_SESSION['user_'.key($value).'_'.SETUP_SESSION_ID ] = $value[key($value)];
    }

    if (!isset( $_SESSION['mvc_user_redirect_'.SETUP_SESSION_ID] ) ){ 

      Header('Location:'.SETUP_BASEURL.$_SESSION['mvc_site_admin_'.SETUP_SESSION_ID]);

    }else{

      Header('Location:'.$_SESSION['mvc_user_redirect_'.SETUP_SESSION_ID] );
    }

    return true;
  }else{
    array_push($GLOBALS["error"],"Error: Bad user or pass. Level 3 ");
    return false;
  }
  array_push($GLOBALS["error"],"Error: Bad user or pass. Level 4 ");
}

function mvc_render_adminPage(){
  if ( isset($_SESSION['mvc_user_status_'.SETUP_SESSION_ID]) ){
    if ( $_SESSION['mvc_user_status_'.SETUP_SESSION_ID]!=='logged' ){
      header("Location:".SETUP_BASEURL.$_SESSION['mvc_site_access_'.SETUP_SESSION_ID]); 
    }
  }else{
    header("Location:".SETUP_BASEURL.$_SESSION['mvc_site_access_'.SETUP_SESSION_ID]); 
  }
    global $sql;
    include('view/admin/admin-home.php');
}


function mvc_updateNode($node_id, $new_value){
  if ( !$node_id ){ return false; }
  if ( !$new_value ){ return false; }
  global $sql;

  $sql=new db();
  $sql->sql_open();
  $items = $sql->sql_updateNode($node_id, $new_value);  
}

/*
level, Name
*/
function mvc_renderChilds($parent_id, $level=0 ){

    global $sql;
    $sql=new db();
    $sql->sql_open();
    $items = $sql->sql_getChilds($parent_id);
    include('view/admin/admin-renderchilds.php');
}

function mvc_actionNew($parent_id, $category, $name, $value ){
  global $sql;
  $sql=new db();
  $sql->sql_open();
  $thiserror = '';
  if ( !$category ){ $thiserror .= 'Need set category</br>'; }
  if ( !$name ){ $thiserror .= 'Need set name</br>'; }
  if ( !$value ){ $thiserror .= 'Need set value</br>'; }
  if (!$thiserror){
    $query = "INSERT INTO ".DB_PREFIX."brain_node ( parent_id, category, name, value )VALUES(
      '$parent_id', '$category', '$name', '$value'
    )";
    $result = $sql->sql_query_execute($query);
    $_POST = array();
    array_push($GLOBALS["event"],"Node created.");
    header("Refresh:0");
  }else{
    array_push($GLOBALS["error"],"Errores:<br> " . $thiserror); 
  }
  //array_push($GLOBALS["error"],"Can't connect to database : " . $con->connect_error);
}

function mvc_actionClone( $parent_id ){
  global $sql;
  $sql=new db();
  $sql->sql_open();
  $items = $sql->sql_getChilds($parent_id);
  foreach ($items as $key => $value) {
  }
}

function mvc_actionDelNode( $id ){
  global $sql;
  $sql=new db();
  $sql->sql_open();
  $items = $sql->sql_delNode($id);
  array_push($GLOBALS["event"],"Node deleted : $id ");
}

function mvc_actionDelNodeChilds($id, $level=0 ){
    if (!$id){ return false; }
    global $sql;
    $sql=new db();
    $sql->sql_open();
    $items = $sql->sql_getChilds($id);
    if ( mysqli_num_rows($items)>0 ){
      foreach ($items as $key => $value) {
         mvc_actionDelNodeChilds($value['id'], $level );
         array_push($GLOBALS["event"],"Node deleted : ".$value['id']." - Parent node: ".$value['parent_id']);
      }
    }
    $level=$level+1;
    mvc_actionDelNode( $id );
}