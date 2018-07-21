<?php
if (!defined('SECURITY_KEY') ){ exit($mvc_lang_error['security_key']); }
if(SETUP_SHOW_PATH){ developMode(__FILE__);}
/*
Put next code in setup file and include before this file. Or only uncoment this an set the vars..
define('DB_HOST', '');
define('DB_NAME', '');
define('DB_USER', '');
define('DB_PASS', '');
*/
/*
if ( !defined('DB_HOST') || !defined('DB_NAME') || defined('DB_USER') || defined('DB_PASS')){
  exit();
}{

}
*/
class db{
  private $dbhost;
  private $dbuser;
  private $dbpass;
  private $dbname;
  private $conn;

/*Constructor*/
  function __construct($dbuser = DB_USER, $dbpass = DB_PASS, $dbname = DB_NAME, $dbhost = DB_HOST){
    $this->dbhost = $dbhost;
    $this->dbuser = $dbuser;
    $this->dbpass = $dbpass;
    $this->dbname = $dbname;
  }

/*Make connection to database*/
  public function sql_open(){

      $this->conn = @mysqli_connect($this->dbhost, $this->dbuser, $this->dbpass,$this->dbname); 
      
      if (mysqli_connect_errno())
      {
        array_push($GLOBALS["error"],mysqli_connect_errno().' - '.mysqli_connect_error().' Check Database Connections in setup.php ;) </p>');
      }else{
        mysqli_set_charset($this->conn,"utf8"); //Quita el problema de los acentos.
      }
  }

/*WARNING!! Insecure Query, be carefull,.
Return: array*/
  public function sql_query_read($query){
    $valores = array();
    $result = @mysqli_query($this->conn,$query);
    if (!$result) {
      array_push($GLOBALS["error"],'<p>Error sql_query_read '.$query.'</p>');
    }else{
      $num_rows= mysqli_num_rows($result);
      for($i=0;$i<$num_rows;$i++){
        $row = mysqli_fetch_assoc($result);
        array_push($valores, $row);
      }
    }
    return $valores;
  }

/*WARNING!! Insecure Query, be carefull..
Return: boolean
*/
  public function sql_query_execute($sql){
    if ($sql)
    {
      $result=@mysqli_query($this->conn,$sql);
    }
     if (!$result) {
      array_push($GLOBALS["error"], '<p>Error sql_query_execute '.$sql.'</p>');
      return false;
    }else{    
      return true;
    }
  }

//Get last reg id (from primary key)
//Return: id from current insert reg.
  public function sql_id(){
    return mysqli_insert_id($this->conn);
  }

//Close current connection
  public function sql_close(){
    @mysqli_close($this->conn);   
  }

//Clean input value..Use this.
  public function sql_escape($value){
    if ($value){return mysqli_real_escape_string($this->conn,$value);}else{ return false;}
  }

/*-------------------------------------------Your Custom Class INI
//------------*******Code********
//-------------------------------------------Your Custom Class END
*/

/* custom cms class
ACCESS

  sql_get_user( user )
  * id or mail


sql_get_admin_menu( level )
* level or parent id


*/

  public function sql_install_mvc($admin_email, $admin_password, $table_prefix, $site_name, $theme, $home_page){
    $q_error = null;
    $actual_date = date('Y-m-d H:i:s');
    $query="
      CREATE TABLE `".$table_prefix."brain_node` (
        `id` int(10) UNSIGNED NOT NULL,
        `parent_id` int(10) NOT NULL,
        `category` varchar(128) NOT NULL,
        `name` varchar(30) NOT NULL,
        `value` longtext NOT NULL,
        `create_datetime` datetime DEFAULT NULL,
        `update_datetime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

      INSERT INTO `".$table_prefix."brain_node` (`id`, `parent_id`, `category`, `name`, `value`, `create_datetime`, `update_datetime`) VALUES
      (1, 0, 'cms', 'setup', 'Setup', NULL, '$actual_date'),
      (2, 0, 'cms', 'users', 'Users', NULL, '$actual_date'),
      (3, 0, 'data', 'pages', 'Pages', NULL, '$actual_date'),
      (4, 0, 'data', 'forms', 'Forms', NULL, '$actual_date'),
      (7, 2, 'main_admin', 'Main Admin', '$admin_email', NULL, '$actual_date'),
      (8, 7, 'email', 'Email', '$admin_email', NULL, '$actual_date'),
      (9, 7, 'password', 'Password', '$admin_password', NULL, '$actual_date'),
      (100, 1, 'site_name', 'Site Name', '$site_name', NULL, '$actual_date'),
      (101, 1, 'theme', 'Theme', '$theme', NULL, '$actual_date'),
      (102, 1, 'home', 'Home Page', '$home_page', NULL, '$actual_date'),
      (103, 1, 'access', 'Access Page', 'access', NULL, '$actual_date'),
      (104, 1, 'admin', 'Admin Page', 'admin', NULL, '$actual_date');

      ALTER TABLE `".$table_prefix."brain_node`
        ADD PRIMARY KEY (`id`);

      ALTER TABLE `".$table_prefix."brain_node`
        MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;
    ";
    $query_data = explode(";", $query);
    
    foreach ($query_data as $key => $value) {

      $result = null;
      $value = trim($value);
      if ($value && $value !== ''){
        $result=@mysqli_query($this->conn,$value);
        if (!$result ) {
          array_push($GLOBALS["error"], '<p>!!Error : '.$value.'</p>');
          $q_error = 1;
        }else{
          array_push($GLOBALS["event"], '<p>Query : '.$value.'</p>');
        }
      }

    }
    if($q_error){ return false; }else{ return true; }
  }

  public function control_sqlResult($result){
        if (!$result ) {
          array_push($GLOBALS["error"], '<p>!!Error sql</p>');
          return false;
        }else{
          return true;
        }
  }

  public function sql_get_user_xxx( $value ){
    if (!$value){ return false; }
    global $sql;
    $value=$sql->sql_escape($value);
    $query=" SELECT id, category, name, value, ( SELECT value FROM ".DB_PREFIX."brain_node AS b WHERE parent_id=id AND category='password' ) AS password FROM ".DB_PREFIX."brain_node AS a WHERE id='".$value."' OR ( parent_id='2' AND value='".$value."' )  ";
    echo $query;
    $result=@mysqli_query($this->conn,$query);
    if ( $sql->control_sqlResult($result) ){
      return $result;
    }else{
      return false;
    }
  }

  public function sql_get_user( $value ){
    if (!$value){ return false; }

    global $sql;
    $value=$sql->sql_escape($value);
    $query="";
    if ( is_numeric($value) ){ $query ="SELECT * FROM ".DB_PREFIX."brain_node WHERE id = $value OR parent_id = $value;"; }
    if ( filter_var($value, FILTER_VALIDATE_EMAIL) ){ $query ="SELECT * FROM ".DB_PREFIX."brain_node as b Where b.parent_id = ( SELECT id FROM mvc_brain_node AS a WHERE parent_id = 2 AND value='$value' LIMIT 1 ) OR id = ( SELECT id FROM mvc_brain_node AS a WHERE parent_id = 2 AND value='$value' LIMIT 1 );"; }  
    if (!$query){return false;}
    //echo $query;
    $result=@mysqli_query($this->conn,$query);
    if ( $sql->control_sqlResult($result) ){
      return $result;
    }else{
      return false;
    }
  }

  public function sql_get_admin_menu( $value="0" ){
    global $sql;
    $value=$sql->sql_escape($value);
    if(!$value){ $value="0"; }
    $query="SELECT * FROM ".DB_PREFIX."brain_node WHERE parent_id='".$value."';  ";
    $result=@mysqli_query($this->conn,$query);
    if ( $sql->control_sqlResult($result) ){
      return $result;
    }else{
      return false;
    }
  }
  public function sql_get_setup_values(){
    global $sql;
    $query="SELECT * FROM ".DB_PREFIX."brain_node WHERE parent_id='1';  ";
    $result=@mysqli_query($this->conn,$query);
    if ( $sql->control_sqlResult($result) ){
      return $result;
    }else{
      return false;
    }
  }

  public function sql_getChilds($parent_id){
    global $sql;
    $query="SELECT * FROM ".DB_PREFIX."brain_node WHERE parent_id='$parent_id' ORDER BY category;  ";
    //echo $query;
    $result=@mysqli_query($this->conn,$query);
    if ( $sql->control_sqlResult($result) ){
      return $result;
    }else{
      return false;
    }
  }

  public function sql_updateNode($node_id, $new_value){
    global $sql;

    $query="UPDATE ".DB_PREFIX."brain_node SET value='$new_value' WHERE id='$node_id'; ";
    //echo $query;
    $result=$sql->sql_query_execute($query);
    if ( $result ){
      return $result;
    }else{
      return false;
    }
  }

  public function sql_delNode($node_id){
    global $sql;
    if (!$node_id || !is_numeric($node_id) ){ return false; }

    $query="DELETE FROM ".DB_PREFIX."brain_node WHERE id='$node_id'; ";
    $result=$sql->sql_query_execute($query);
    if ( $result ){
      return $result;
      array_push($GLOBALS["event"], '<p> Node Deleted '.$node_id.' Query : '.$query.'</p>');
    }else{
      return false;
    }
  }
  
/*END OF CLASS*/
}
?>