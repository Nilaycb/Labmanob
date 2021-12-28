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
            <h3 class="uk-card-title">Test Details</h3> 
        </div>
        <div class="uk-card-body">
            
            <div class="uk-margin-small">
                
                <?php
				echo '<b>Test ID</b>: '.$test->id;
				echo '<br />'; 
                echo '<b>Test Name</b>: '.$test->test_name; 
				echo '<br />'; 
				echo '<b>Test Codename</b>: '.$test->test_codename; 
				echo '<br />'; 
				echo '<b>Test Category</b>: '.$test_category_codename; 
				echo '<br />'; 
				echo '<b>Test Price</b>: '.$test->test_price; 
				echo '<br />'; 
				echo '<b>Test Description</b>: '.$test->test_description; 
                echo '<br />'; 
				echo '<b>Added</b>: <time datetime="'.mdate("%d-%M-%Y, %h:%i %a", strtotime($test->created)).'">'.mdate("%d-%M-%Y, %h:%i %a", strtotime($test->created)).'</time>';
				echo ' | <b>Modified</b>: <time datetime="'.mdate("%d-%M-%Y, %h:%i %a", strtotime($test->modified)).'">'.mdate("%d-%M-%Y, %h:%i %a", strtotime($test->modified)).'</time>'; 
                ?>
                
            </div>
            
        </div>
        
    </div> 
    
    
    <div class="uk-clearfix">
    </div>
    
    
    <div class="uk-margin-small uk-panel uk-card uk-card-default uk-card-small uk-width-expand">

        <?php 
		echo form_open('labmanob/edit/test/index/'.$test->id);
		?>

        <div class="uk-card-header">
            <h3 class="uk-card-title">Edit Test</h3> 
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
                    echo form_label('Test Name', 'test_name', array('class' => 'uk-form-label'));
                    if (form_error('test_name')) 
                    {
                        echo '<span class="uk-margin-small-left uk-margin-small-right gs-uk-alert-danger-color" uk-icon="icon: warning"></span>';
                    }
                    ?>
                </div>
                <br />
                <div class="uk-inline">
                    <?php 
                    echo form_input('test_name', set_value('test_name', $test->test_name), array('class' => 'uk-input uk-form-width-large uk-form-large', 'placeholder' => 'Test Name', 'maxlength' => '150'));
                    ?>
                </div>
            </div>
            
            <div class="uk-margin">
                <div class="uk-inline">
                    <?php 
                    echo form_label('Test Code Name', 'test_codename', array('class' => 'uk-form-label'));
                    if (form_error('test_codename')) 
                    {
                        echo '<span class="uk-margin-small-left uk-margin-small-right gs-uk-alert-danger-color" uk-icon="icon: warning"></span>';
                    }
                    ?>
                </div>
                <br />
                <div class="uk-inline">
                    <?php 
                    echo form_input('test_codename', set_value('test_codename', $test->test_codename), array('class' => 'uk-input uk-form-width-large uk-form-large', 'placeholder' => 'Test Code Name', 'maxlength' => '150'));
                    ?>
                </div>
            </div>
            
            <div class="uk-margin">
                <div class="uk-inline">
                    <?php 
                    $options = array(); 
                    $options[''] = 'Select Test Category'; 
                    foreach ($test_categories as $test_category) 
                    { 
                        $options[$test_category->id] = $test_category->category_codename; 
                    } 
                    
                    echo form_label('Test Category', 'test_category_id', array('class' => 'uk-form-label')); 
                    if (form_error('test_category_id')) 
                    {
                        echo '<span class="uk-margin-small-left uk-margin-small-right gs-uk-alert-danger-color" uk-icon="icon: warning"></span>';
                    } 
                    ?>
                </div>
                <br />
                <div class="uk-inline">
                    <?php 
                    echo form_dropdown('test_category_id', $options, array($test->test_category_id), array('class' => 'uk-select uk-form-width-large uk-form-large')); 
                    ?>
                </div>
            </div>
            
            <div class="uk-margin">
                <div class="uk-inline">
                    <?php 
                    echo form_label('Test Price', 'test_price', array('class' => 'uk-form-label'));
                    if (form_error('test_price')) 
                    {
                        echo '<span class="uk-margin-small-left uk-margin-small-right gs-uk-alert-danger-color" uk-icon="icon: warning"></span>';
                    }
                    ?>
                </div>
                <br />
                <div class="uk-inline">
                    <?php 
                    echo form_input('test_price', set_value('test_price', $test->test_price), array('class' => 'uk-input uk-form-width-large uk-form-large', 'placeholder' => 'Test Price', 'maxlength' => '15'));
                    ?>
                </div>
            </div>
            
            <div class="uk-margin">
                <div class="uk-inline">
                    <?php 
                    echo form_label('Test Description', 'test_description', array('class' => 'uk-form-label')); 
                    if (form_error('test_description')) 
                    {
                        echo '<span class="uk-margin-small-left uk-margin-small-right gs-uk-alert-danger-color" uk-icon="icon: warning"></span>';
                    }
                    ?>
                </div>
                <br />
                <div class="uk-inline">
                    <?php 
                    echo form_input('test_description', set_value('test_description', $test->test_description), array('class' => 'uk-input uk-form-width-large uk-form-large', 'placeholder' => 'Test Description', 'maxlength' => '255'));
                    ?>
                </div>
            </div>
        </div>
        <div class="uk-card-footer">
            <div class="uk-margin-small">
                <?php 
                echo anchor('labmanob/view/test/'.$test->id, 'Back', array ('class' => 'uk-button uk-button-default uk-margin-small-right uk-align-left uk-margin-remove-bottom')); 
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