<?php
if(SETUP_SHOW_PATH){ developMode(__FILE__);}
//MANUAL ACTION DETECTION
if ( isset($_POST['action']) ){ $action = $_POST['action']; }elseif( isset($_GET['action']) ){ $action = $_GET['action']; }else{ $action = false; $action = false; }

if ( isset($_POST['parent_id']) && isset($_POST['brench_action']) ){
  $parent_id = $_POST['parent_id'];
  $action = $_POST['brench_action'];
}

$action = sanitize($action);

switch ($action) {
  case 'demo':
    if (isset($_GET['param'])){
      $template_var_demo = "Action detected: ".$_GET['action']." <br> Value: ".$_GET['param'];
    }
     break;

  case 'mvc_install_cms':
  		$mvc_install_cms_result = mvc_install_cms($_POST);
    break;

  case 'logout':
      session_destroy();
      header("Location:".SETUP_BASEURL);
     break;

  case 'addbrench':
    $category = $_POST['category'];
    $name = $_POST['name'];
    $value = $_POST['value'];

    if ( isset($category ) &&  isset($name ) && isset($value )){
      mvc_actionNew($parent_id,  $category, $name, $value);
    }
    
    break;
  case 'clone':
    # code...
    break;

  case 'delbrench':
    $value = $_POST['value'];
    if ( isset($value )){
      mvc_actionDelNodeChilds($value);
    }
    break;

  default:
    # code...
    break;
}
