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
				echo '<b>Categoty Codename</b>: '.$test_category->category_codename; 
				echo '<br />'; 
				echo '<b>Category Description</b>: '.$test_category->category_description; 
                echo '<br />'; 
				echo '<b>Added</b>: <time datetime="'.mdate("%d-%M-%Y, %h:%i %a", strtotime($test_category->created)).'">'.mdate("%d-%M-%Y, %h:%i %a", strtotime($test_category->created)).'</time>';
				echo ' | <b>Modified</b>: <time datetime="'.mdate("%d-%M-%Y, %h:%i %a", strtotime($test_category->modified)).'">'.mdate("%d-%M-%Y, %h:%i %a", strtotime($test_category->modified)).'</time>'; 
                ?>
                
            </div>
            
        </div>
        
    </div> 
    
    
    <div class="uk-clearfix">
    </div>
    
    
    <div class="uk-margin-small uk-panel uk-card uk-card-default uk-card-small uk-width-expand">

        <?php 
		echo form_open('labmanob/edit/test_category/index/'.$test_category->id);
		?>

        <div class="uk-card-header">
            <h3 class="uk-card-title">Edit Test Category</h3> 
        </div>
        <div class="uk-card-body">

			<?php 
			if(!empty($error_message)) 
			{ 
				echo '<div class="uk-alert-danger" uk-alert><a class="uk-alert-close" uk-close></a>'. $error_message .'</div>';
			}
			
			echo validation_errors('<div class="uk-alert-danger" uk-alert><a class="uk-alert-close" uk-close></a>', '</div>'); 
			?>

            <div class="uk-margin">
                <div class="uk-inline">
                    <?php 
                    echo form_label('Category Name', 'category_name', array('class' => 'uk-form-label'));
                    if (form_error('category_name')) 
                    {
                        echo '<span class="uk-margin-small-left uk-margin-small-right gs-uk-alert-danger-color" uk-icon="icon: warning"></span>';
                    }
                    ?>
                </div>
                <br />
                <div class="uk-inline">
                    <?php 
                    echo form_input('category_name', set_value('category_name', $test_category->category_name), array('class' => 'uk-input uk-form-width-large uk-form-large', 'placeholder' => 'Category Name', 'maxlength' => '150'));
                    ?>
                </div>
            </div>
            
            <div class="uk-margin">
                <div class="uk-inline">
                    <?php 
                    echo form_label('Category Code Name', 'category_codename', array('class' => 'uk-form-label'));
                    if (form_error('category_codename')) 
                    {
                        echo '<span class="uk-margin-small-left uk-margin-small-right gs-uk-alert-danger-color" uk-icon="icon: warning"></span>';
                    }
                    ?>
                </div>
                <br />
                <div class="uk-inline">
                    <?php 
                    echo form_input('category_codename', set_value('category_codename', $test_category->category_codename), array('class' => 'uk-input uk-form-width-large uk-form-large', 'placeholder' => 'Category Code Name', 'maxlength' => '150'));
                    ?>
                </div>
            </div>
            
            <div class="uk-margin">
                <div class="uk-inline">
                    <?php 
                    echo form_label('Category Description', 'category_description', array('class' => 'uk-form-label')); 
                    if (form_error('category_description')) 
                    {
                        echo '<span class="uk-margin-small-left uk-margin-small-right gs-uk-alert-danger-color" uk-icon="icon: warning"></span>';
                    }
                    ?>
                </div>
                <br />
                <div class="uk-inline">
                    <?php 
                    echo form_input('category_description', set_value('category_description', $test_category->category_description), array('class' => 'uk-input uk-form-width-large uk-form-large', 'placeholder' => 'Category Description', 'maxlength' => '255'));
                    ?>
                </div>
            </div>
        </div>
        <div class="uk-card-footer">
            <div class="uk-margin-small">
                <?php 
                echo anchor('labmanob/view/test_category/'.$test_category->id, 'Back', array ('class' => 'uk-button uk-button-default uk-margin-small-right uk-align-left uk-margin-remove-bottom')); 
				echo form_submit('submit', 'Submit', array('class' => 'uk-button uk-button-primary uk-margin-small-left uk-align-right uk-margin-remove-bottom'));
				echo form_reset('reset_form', 'Reset', array('class' => 'uk-button uk-button-default uk-margin-small-left uk-align-right uk-margin-remove-bottom', 'id' => 'reset_form'));  
                ?>
            </div>
        </div>

        <?php 
		echo form_close(); 
		?>
        
    </div>
    
    
    <div class="uk-height-1-1">
    </div>


    <script>
        $(document).ready(function() 
		{
			$('#reset_form').click(function()
            {
				//code
            });
		})
    </script>

    
</div>