<?php
    if ( mysqli_num_rows($items) ) {

      
      $old_cat='';
      if($level>0){
        ?>
        <div onClick="mvc_toggle( 'sub_container_<?php echo $parent_id;?>' )" >[+-]</div>
        <ul id="sub_container_<?php echo $parent_id;?>" class="sub_item">
        <?php
      }

      foreach ($items as $key => $value) {
        $basic_value=$value['value'];
        if( isset($_POST[$value['id']]) ){
          if ($_POST[$value['id']] !== $value['value'] ){
            if( $_POST[$value['id']] ){
              $result = mvc_updateNode($value['id'], $_POST[$value['id']] );
              if ( !$result ){ $basic_value = $_POST[$value['id']]; }else{$basic_value=$value['value']; }
            }
          }
        }

        
        ?>
        <li>
          <p><?php echo $value['id']?> : <?php echo $value['name']; ?> / <?php echo $value['category']; ?> / <?php echo $value['update_datetime']; ?></p>
          <input type="text" name="<?php echo $value['id']?>" value='<?php echo $basic_value;?>'>
          <input class="button" type="button" name="" value="+" onClick="mvc_showAddBrenchModal( '<?php echo $value['id']?>' )">
          <input class="button" type="button" name="" value="-" onClick="mvc_showDelBrenchModal( '<?php echo $value['id']?>' )">
            <?php  
            $level=$level+1;
            mvc_renderChilds($value['id'], $level ); ?>
        </li>

        <?php
        $old_cat = $value['category'];

      }

      if($level>0){
        ?>
          <li>

            <input class="button" type="button" name="" value="+" onClick="mvc_showAddBrenchModal( '<?PHP ECHO $parent_id; ?>' )">
          </li>
        </ul>
        <?php
      }

    }else{

    }
?>