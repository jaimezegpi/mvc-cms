<?php
// This code needed in all your pages
if (!defined('SECURITY_KEY') ){ exit($mvc_lang_error['security_key']); }
if(SETUP_SHOW_PATH){ developMode(__FILE__);}
if (isset($_GET['action'])){ $action = $_GET['action']; }else{ $action = ''; }
?>
<!DOCTYPE html>
<html>
<head>
	<title>ADMIN</title>
	<link rel="stylesheet" type="text/css" href="<?php echo SETUP_BASEURL; ?>view/admin/css/grid.css">
	<link rel="stylesheet" type="text/css" href="<?php echo SETUP_BASEURL; ?>view/admin/css/main.css">
	<script type="text/javascript" src='<?php echo SETUP_BASEURL; ?>view/admin/js/functions.js'></script>
</head>

<body>


<section id="admin_header">
	<div>
		<ul>
			<li>
				<a href="<?php echo SETUP_BASEURL;?>admin/logout">Logout</a>
			</li>
		</ul>
	</div>
</section>

<section>
<h1>ADMIN</h1>
<div class="row">
	<div class="mvc-1">
	<?php $menu = $sql->sql_get_admin_menu( 0 );
	foreach($menu AS $key => $item){
		?>
		<li class='menu <?php if ( $item['id'] == $action ){ echo 'active'; }?>'>
			<a href="<?php echo SETUP_BASEURL.$_SESSION['mvc_site_admin_'.SETUP_SESSION_ID ].'/datatree/'.$item['id']; ?>">
				<?php echo $item['value']; ?>
			</a>
			<input type="button" name="" value='+' onClick="mvc_showAddBrenchModal('<?php echo $item['id']; ?>')">
			
		</li>
		<?php
	}?> 
	<input class="button" type="submit" name="" value="+" onClick="mvc_showAddBrenchModal( '0' )">
	</div>
	<div class="mvc-11">

		<form method="POST">

			<?php
			if ( isset($action) ) {

				if ($action == 'datatree'){
					if( isset($_GET['param']) ){
						$mvc_parent_id = $_GET['param'];
					}else{
						$mvc_parent_id = 0;
					}
					$render_childs = mvc_renderChilds( $mvc_parent_id );
				}
			}

			if ( !isset($mvc_parent_id) ){ $mvc_parent_id = 0 ; }

			?>

			<input type="submit" name="" value="Actualizar">
		</form>

		<div id='mvc-modal' class='mvc-modal'>1
			<div class='mvc-modal-content'>
				<div class='row' >
					<div class='mvc-11'>
						<h1 id="mvc-modal-title">:</h1>
					</div>
					<div class='mvc-1'>
						<a href="javascript:void(0)" onClick='mvc_toggle("mvc-modal")'>[x]</a>
					</div>					
				</div>

				<div class='row form mvc-modal-form addbrenchform'>
					<div clas='mvc-12'>
						<form method="POST" id="addbrench" method="POST">
							<input type="text" id="new_parent_id" name="parent_id" value="<?php echo $mvc_parent_id; ?>">
							<input type="text" name="category" placeholder="Category">
							<input type="text" name="name" placeholder="Name">
							<input type="text" name="value" placeholder="Value">
							<input class="button" type="submit" name="brench_action" value="addbrench">
						</form>
					</div>
				</div>

				<div class='row form mvc-modal-form delbrenchform'>
					<div clas='mvc-12'>
						<form method="POST" id="delbrench" method="POST">
							<input type="hidden"  name="parent_id" value="None">
							<input type="text" id="del_id" name="value" value="">
							<input class="button" type="submit" name="brench_action" value="delbrench">+
						</form>
					</div>
				</div>

			</div>

		</div>
	</div>

</div>	
</section>

</body>
</html>
