<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="uk-width-expand uk-padding-small">
    
    <div class="uk-panel uk-margin-small uk-card uk-card-default uk-card-small uk-width-expand">
        
        <div class="uk-card-header">
            <h3 class="uk-card-title"><span uk-icon='icon: user'></span> Change Password</h3> 
        </div>
        <div class="uk-card-body">
            
            <?php 
            if($this->session->flashdata('message_display')) 
            {
                echo '<div class="uk-alert-primary" uk-alert><a class="uk-alert-close" uk-close></a>'. $this->session->flashdata('message_display') .'</div>';
            }

            if(!empty($error_message)) 
            {
                echo '<div class="uk-alert-danger" uk-alert><a class="uk-alert-close" uk-close></a>'. $error_message .'</div>';
            }
            
            echo validation_errors('<div class="uk-alert-danger" uk-alert><a class="uk-alert-close" uk-close></a>', '</div>'); 
            ?>
            
            <?php 
            echo form_open('accounts/change_password'); 
            ?>
            
            <div class="uk-margin">
                <div class="uk-inline">
                    <?php 
                    echo form_label('Current Password', 'password', array('class' => 'uk-form-label'));
                    if (form_error('password')) 
                        {
                        echo '<span class="uk-margin-small-left uk-margin-small-right gs-uk-alert-danger-color" uk-icon="icon: warning"></span>';
                        }
                    ?>
                </div>
                <br />
                <div class="uk-inline">
                    <span class="uk-form-icon uk-margin-small-right" uk-icon="icon: lock; ratio: 2"></span>
                    <?php 
                    echo form_password('password', '', array('class' => 'uk-input uk-form-width-large uk-form-large', 'placeholder' => 'Current Password', 'id' => 'password'));
                    ?>
                </div>
            </div>
            
            <div class="uk-margin">
                <div class="uk-inline">
                    <?php 
                    echo form_label('New Password', 'new_password', array('class' => 'uk-form-label'));
                    if (form_error('new_password')) 
                        {
                        echo '<span class="uk-margin-small-left uk-margin-small-right gs-uk-alert-danger-color" uk-icon="icon: warning"></span>';
                        }
                    ?>
                </div>
                <br />
                <div class="uk-inline">
                    <span class="uk-form-icon uk-margin-small-right" uk-icon="icon: lock; ratio: 2"></span>
                    <?php 
                    echo form_password('new_password', '', array('class' => 'uk-input uk-form-width-large uk-form-large', 'placeholder' => 'New Password', 'id' => 'new_password'));
                    ?>
                </div>
            </div>

            <div class="uk-margin">
                <div class="uk-inline">
                    <?php 
                    echo form_label('Confirm Password', 'conf_password', array('class' => 'uk-form-label'));
                    if (form_error('conf_password')) 
                        {
                        echo '<span class="uk-margin-small-left uk-margin-small-right gs-uk-alert-danger-color" uk-icon="icon: warning"></span>';
                        }
                    ?>
                </div>
                <br />
                <div class="uk-inline">
                    <span class="uk-form-icon uk-margin-small-right" uk-icon="icon: lock; ratio: 2"></span>
                    <?php 
                    echo form_password('conf_password', '', array('class' => 'uk-input uk-form-width-large uk-form-large', 'placeholder' => 'Confirm Password', 'id' => 'conf_password'));
                    ?>
                </div>
            </div>
            
            <div class="uk-margin">
                <div class="uk-margin">
                    <?php
                    echo form_button('reset_change_password', 'Reset', array('class' => 'uk-button uk-button-default uk-margin-small-right uk-align-left uk-margin-remove-bottom', 'id' => 'reset_change_password_form')); 
                    echo form_submit('submit_change_password', 'Change', array('class' => 'uk-button uk-button-danger uk-margin-small-left uk-align-right uk-margin-remove-bottom')); 
                    ?>
                </div>
            </div>
            
            <?php 
            echo form_close(); 
            ?>  
            
        </div>
        
    </div> 
    
    
    <div class="uk-height-1-1">
    </div>


    <script>
        $(document).ready(function() 
		{
            $('#reset_change_password_form').click(function()
            {
                $('#password').val('');
                $('#new_password').val('');
                $('#conf_password').val('');
            });
        });
    </script>
    
</div>