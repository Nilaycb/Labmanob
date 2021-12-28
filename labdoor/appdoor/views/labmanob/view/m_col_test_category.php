<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="uk-width-expand uk-padding-small">
    
	<div class="uk-margin-small uk-panel uk-card uk-card-default uk-card-small uk-width-expand">

		<?php 
		if ($this->session->flashdata('message_display')) 
		{
			echo '<div class="uk-alert-primary" uk-alert><a class="uk-alert-close" uk-close></a>'. $this->session->flashdata('message_display') .'</div>';
		}
		?>
        
        <div class="uk-card-header">
            <h3 class="uk-card-title">Test Category Details</h3> 
        </div>
        <div class="uk-card-body">
            
            <div class="uk-margin-small">
                
                <?php
				echo '<b>Category ID</b>: '.$test_category->id;
				echo '<br />'; 
                echo '<b>Category Name</b>: '.$test_category->category_name; 
				echo '<br />'; 
				echo '<b>Category Codename</b>: '.$test_category->category_codename; 
				echo '<br />'; 
				echo '<b>Category Description</b>: '.$test_category->category_description; 
                echo '<br />'; 
				echo '<b>Added</b>: <time datetime="'.mdate("%d-%M-%Y, %h:%i %a", strtotime($test_category->created)).'">'.mdate("%d-%M-%Y, %h:%i %a", strtotime($test_category->created)).'</time>';
				echo ' | <b>Modified</b>: <time datetime="'.mdate("%d-%M-%Y, %h:%i %a", strtotime($test_category->modified)).'">'.mdate("%d-%M-%Y, %h:%i %a", strtotime($test_category->modified)).'</time>'; 
                ?>
                
            </div>
            
        </div>
        <div class="uk-card-footer">
            <div class="uk-margin-small">
                <?php 
                echo anchor('labmanob/view/test_categories', 'Back', array ('class' => 'uk-button uk-button-default uk-margin-small-right uk-align-left uk-margin-remove-bottom')); 
                ?>
            </div>
        </div>
        
    </div> 
    
    
    
    <div class="uk-height-1-1">
    </div>

    
</div>