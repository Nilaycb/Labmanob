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
            <h3 class="uk-card-title">Affiliate Partner Details</h3> 
        </div>
        <div class="uk-card-body">
            
            <div class="uk-margin-small">
                
                <?php
				echo '<b>Affiliate Partner ID</b>: '.$affiliate_partner->id;
				echo '<br />'; 
                echo '<b>Affiliate Partner Name</b>: '.$affiliate_partner->firstname.' '.$affiliate_partner->lastname; 
				echo '<br />'; 
				echo '<b>Sex</b>: '.$affiliate_partner->sex;
                echo '<br />';
                echo '<b>Phone Number(s)</b>: '.$affiliate_partner->phone_no;
                echo '<br />';
                echo '<b>Email</b>: '; echo (!empty($affiliate_partner->email)) ? $affiliate_partner->email : 'N/A'; 
				echo '<br />';
                echo '<b>Current Address</b>: '.$affiliate_partner->current_address.' | <b>Current City</b>: '.$affiliate_partner->current_city; 
				echo '<br />';
                echo '<b>Permanent Address</b>: '; echo (!empty($affiliate_partner->permanent_address)) ? $affiliate_partner->permanent_address : 'N/A';
                echo ' | <b>Permanent City</b>: '; echo (!empty($affiliate_partner->permanent_city)) ? $affiliate_partner->permanent_city : 'N/A'; 
				echo '<br />'; 
				echo '<b>Extra Information</b>: '; echo (!empty($affiliate_partner->extra_info)) ? $affiliate_partner->extra_info : 'N/A'; 
                echo '<br />'; 
				echo '<b>Added</b>: <time datetime="'.mdate("%d-%M-%Y, %h:%i %a", strtotime($affiliate_partner->created)).'">'.mdate("%d-%M-%Y, %h:%i %a", strtotime($affiliate_partner->created)).'</time>';
				echo ' | <b>Modified</b>: <time datetime="'.mdate("%d-%M-%Y, %h:%i %a", strtotime($affiliate_partner->modified)).'">'.mdate("%d-%M-%Y, %h:%i %a", strtotime($affiliate_partner->modified)).'</time>'; 
                ?>
                
            </div>
            
        </div>
        
    </div> 
    
    
    <?php if (!empty($affiliate_partner_image_data)): ?>
    <div class="uk-clearfix">
    </div>
    
    
    <div class="uk-margin-small uk-panel uk-card uk-card-default uk-card-small uk-width-expand">
        
        <div class="uk-card-header">
            <h3 class="uk-card-title">Affiliate Partner Image</h3> 
        </div>
        <div class="uk-card-body">
            <?php
                if (!empty($encoded_affiliate_partner_image_data) && !empty($affiliate_partner_image_data['file_type'])) 
                {
                    echo '<img class="uk-border-rounded uk-responsive-width uk-align-center" style="max-height: 250px;" src="data:'.$affiliate_partner_image_data['file_type'].';base64,'.$encoded_affiliate_partner_image_data.'" alt="Affiliate Partner Image" />';
                }
                else if (isset($affiliate_partner_image_data['encode_level']) && ($affiliate_partner_image_data['encode_level'] == 0) && !empty($affiliate_partner_image_data['file_path']) && !empty($affiliate_partner_image_data['file_name']))
                {
                    echo '<img class="uk-border-rounded uk-responsive-width uk-align-center" style="max-height: 250px;" src="'. base_url().uploads_path().$affiliate_partner_image_data['file_path'].$affiliate_partner_image_data['file_name'] .'" alt="Affiliate Partner Image" />';
                }
                else 
                {
                    echo '<div class="uk-alert-danger" uk-alert> There was an error! Unable to load the image.</div>';
                }
            ?>
        </div>
        
    </div> 
    <?php endif; ?>
    
    
    <div class="uk-clearfix">
    </div>
    
    
    <div class="uk-margin-small uk-panel uk-card uk-card-default uk-card-small uk-width-expand">

        <?php 
		echo form_open('labmanob/edit/affiliate_partner/index/'.$affiliate_partner->id);
		?>

        <div class="uk-card-header">
            <h3 class="uk-card-title">Edit Affiliate Partner</h3> 
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
                    echo form_label('First Name', 'firstname', array('class' => 'uk-form-label'));
                    if (form_error('firstname')) 
                    {
                        echo '<span class="uk-margin-small-left uk-margin-small-right gs-uk-alert-danger-color" uk-icon="icon: warning"></span>';
                    }
                    ?>
                </div>
                <br />
                <div class="uk-inline">
                    <?php 
                    echo form_input('firstname', set_value('firstname', $affiliate_partner->firstname), array('class' => 'uk-input uk-form-width-large uk-form-large', 'placeholder' => 'First Name', 'maxlength' => '150'));
                    ?>
                </div>
            </div>
            
            <div class="uk-margin">
                <div class="uk-inline">
                    <?php 
                    echo form_label('Last Name', 'lastname', array('class' => 'uk-form-label'));
                    if (form_error('lastname')) 
                    {
                        echo '<span class="uk-margin-small-left uk-margin-small-right gs-uk-alert-danger-color" uk-icon="icon: warning"></span>';
                    }
                    ?>
                </div>
                <br />
                <div class="uk-inline">
                    <?php 
                    echo form_input('lastname', set_value('lastname', $affiliate_partner->lastname), array('class' => 'uk-input uk-form-width-large uk-form-large', 'placeholder' => 'Last Name', 'maxlength' => '150'));
                    ?>
                </div>
            </div>
            
            <div class="uk-margin">
                <div class="uk-inline">
                    <?php 
                    $options = array(
                        '' => 'Select Sex', 
                        'Male' => 'Male', 
                        'Female' => 'Female', 
                        'Undefined' => 'Undefined'
                    ); 
                    
                    echo form_label('Sex', 'sex', array('class' => 'uk-form-label')); 
                    if (form_error('sex')) 
                    {
                        echo '<span class="uk-margin-small-left uk-margin-small-right gs-uk-alert-danger-color" uk-icon="icon: warning"></span>';
                    }
                    ?>
                </div>
                <br />
                <div class="uk-inline">
                    <?php 
                    echo form_dropdown('sex', $options, array($affiliate_partner->sex), array('class' => 'uk-select uk-form-width-large uk-form-large')); 
                    ?>
                </div>
            </div>
            
            <div class="uk-margin">
                <div class="uk-inline">
                    <?php 
                    echo form_label('Phone Number(s)', 'phone_no', array('class' => 'uk-form-label')); 
                    if (form_error('phone_no')) 
                    {
                        echo '<span class="uk-margin-small-left uk-margin-small-right gs-uk-alert-danger-color" uk-icon="icon: warning"></span>';
                    }
                    ?>
                </div>
                <br />
                <div class="uk-inline">
                    <?php 
                    echo form_input('phone_no', set_value('phone_no', $affiliate_partner->phone_no), array('class' => 'uk-input uk-form-width-large uk-form-large', 'placeholder' => 'Phone', 'maxlength' => '100'));
                    ?>
                </div>
            </div>
            
            <div class="uk-margin">
                <div class="uk-inline">
                    <?php 
                    echo form_label('Email', 'email', array('class' => 'uk-form-label')); 
                    if (form_error('email')) 
                    {
                        echo '<span class="uk-margin-small-left uk-margin-small-right gs-uk-alert-danger-color" uk-icon="icon: warning"></span>';
                    }
                    ?>
                </div>
                <br />
                <div class="uk-inline">
                    <?php 
                    echo form_input('email', set_value('email', $affiliate_partner->email), array('class' => 'uk-input uk-form-width-large uk-form-large', 'placeholder' => 'Email', 'maxlength' => '150'));
                    ?>
                </div>
            </div>
            
            <div class="uk-margin">
                <div class="uk-inline">
                    <?php 
                    echo form_label('Current Address', 'current_address', array('class' => 'uk-form-label')); 
                    if (form_error('current_address')) 
                    {
                        echo '<span class="uk-margin-small-left uk-margin-small-right gs-uk-alert-danger-color" uk-icon="icon: warning"></span>';
                    }
                    ?>
                </div>
                <br />
                <div class="uk-inline">
                    <?php 
                    echo form_input('current_address', set_value('current_address', $affiliate_partner->current_address), array('class' => 'uk-input uk-form-width-large uk-form-large', 'placeholder' => 'Current Address', 'maxlength' => '255'));
                    ?>
                </div>
            </div>
            
            <div class="uk-margin">
                <div class="uk-inline">
                    <?php 
                    echo form_label('Current City', 'current_city', array('class' => 'uk-form-label')); 
                    if (form_error('current_city')) 
                    {
                        echo '<span class="uk-margin-small-left uk-margin-small-right gs-uk-alert-danger-color" uk-icon="icon: warning"></span>';
                    }
                    ?>
                </div>
                <br />
                <div class="uk-inline">
                    <?php 
                    echo form_input('current_city', set_value('current_city', $affiliate_partner->current_city), array('class' => 'uk-input uk-form-width-large uk-form-large', 'placeholder' => 'Current City', 'maxlength' => '50'));
                    ?>
                </div>
            </div>
            
            <div class="uk-margin">
                <div class="uk-inline">
                    <?php 
                    echo form_label('Permanent Address', 'permanent_address', array('class' => 'uk-form-label')); 
                    if (form_error('permanent_address')) 
                    {
                        echo '<span class="uk-margin-small-left uk-margin-small-right gs-uk-alert-danger-color" uk-icon="icon: warning"></span>';
                    }
                    ?>
                </div>
                <br />
                <div class="uk-inline">
                    <?php 
                    echo form_input('permanent_address', set_value('permanent_address', $affiliate_partner->permanent_address), array('class' => 'uk-input uk-form-width-large uk-form-large', 'placeholder' => 'Permanent Address', 'maxlength' => '255'));
                    ?>
                </div>
            </div>
            
            <div class="uk-margin">
                <div class="uk-inline">
                    <?php 
                    echo form_label('Permanent City', 'permanent_city', array('class' => 'uk-form-label')); 
                    if (form_error('permanent_city')) 
                    {
                        echo '<span class="uk-margin-small-left uk-margin-small-right gs-uk-alert-danger-color" uk-icon="icon: warning"></span>';
                    }
                    ?>
                </div>
                <br />
                <div class="uk-inline">
                    <?php 
                    echo form_input('permanent_city', set_value('permanent_city', $affiliate_partner->permanent_city), array('class' => 'uk-input uk-form-width-large uk-form-large', 'placeholder' => 'Permanent City', 'maxlength' => '50'));
                    ?>
                </div>
            </div>
            
            <div class="uk-margin">
                <div class="uk-inline">
                    <?php 
                    echo form_label('Extra Information', 'extra_info', array('class' => 'uk-form-label')); 
                    if (form_error('extra_info')) 
                    {
                        echo '<span class="uk-margin-small-left uk-margin-small-right gs-uk-alert-danger-color" uk-icon="icon: warning"></span>';
                    }
                    ?>
                </div>
                <br />
                <div class="uk-inline">
                    <?php 
                    echo form_textarea(array('name' => 'extra_info', 'rows' => '5'), set_value('extra_info', $affiliate_partner->extra_info), array('class' => 'uk-textarea uk-form-width-large uk-form-large', 'placeholder' => 'Extra Information', 'maxlength' => '255'));
                    ?>
                </div>
            </div>
        </div>
        <div class="uk-card-footer">
            <div class="uk-margin-small">
                <?php 
                echo anchor('labmanob/view/affiliate_partner/'.$affiliate_partner->id, 'Back', array ('class' => 'uk-button uk-button-default uk-margin-small-right uk-align-left uk-margin-remove-bottom')); 
				
                if ((strtolower($_SESSION['username']) == 'master') || (strtolower($_SESSION['username']) == 'admin')) 
				{
                    echo form_submit('submit', 'Submit', array('class' => 'uk-button uk-button-primary uk-margin-small-left uk-align-right uk-margin-remove-bottom'));
                }

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