<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="uk-width-expand uk-padding-small">
    
    <div>
        <h3>Add New Affiliate Partner</h3>
        <div class="uk-margin-small">
            
            <?php 
            if ($this->session->flashdata('message_display')) 
            {
            echo '<div class="uk-alert-primary" uk-alert><a class="uk-alert-close" uk-close></a>'. $this->session->flashdata('message_display') .'</div>';
            }
            
            if ($this->session->flashdata('message_upload_affiliate_partner_image')) 
            {
            echo '<div class="uk-alert-primary" uk-alert><a class="uk-alert-close" uk-close></a>'. $this->session->flashdata('message_upload_affiliate_partner_image') .'</div>';
            }
            
            if(!empty($error_message)) 
            { 
                echo '<div class="uk-alert-danger" uk-alert><a class="uk-alert-close" uk-close></a>'. $error_message .'</div>';
            }
            
            echo validation_errors('<div class="uk-alert-danger" uk-alert><a class="uk-alert-close" uk-close></a>', '</div>'); 
            ?>
            
            <?php 
            echo form_open('labmanob/add/new_affiliate_partner'); 
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
                    echo form_input('firstname', set_value('firstname'), array('class' => 'uk-input uk-form-width-large uk-form-large', 'placeholder' => 'First Name', 'maxlength' => '150'));
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
                    echo form_input('lastname', set_value('lastname'), array('class' => 'uk-input uk-form-width-large uk-form-large', 'placeholder' => 'Last Name', 'maxlength' => '150'));
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
                    echo form_dropdown('sex', $options, array(), array('class' => 'uk-select uk-form-width-large uk-form-large')); 
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
                    echo form_input('phone_no', set_value('phone_no'), array('class' => 'uk-input uk-form-width-large uk-form-large', 'placeholder' => 'Phone', 'maxlength' => '100'));
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
                    echo form_input('email', set_value('email'), array('class' => 'uk-input uk-form-width-large uk-form-large', 'placeholder' => 'Email', 'maxlength' => '150'));
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
                    echo form_input('current_address', set_value('current_address'), array('class' => 'uk-input uk-form-width-large uk-form-large', 'placeholder' => 'Current Address', 'maxlength' => '255'));
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
                    echo form_input('current_city', set_value('current_city'), array('class' => 'uk-input uk-form-width-large uk-form-large', 'placeholder' => 'Current City', 'maxlength' => '50'));
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
                    echo form_input('permanent_address', set_value('permanent_address'), array('class' => 'uk-input uk-form-width-large uk-form-large', 'placeholder' => 'Permanent Address', 'maxlength' => '255'));
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
                    echo form_input('permanent_city', set_value('permanent_city'), array('class' => 'uk-input uk-form-width-large uk-form-large', 'placeholder' => 'Permanent City', 'maxlength' => '50'));
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
                    echo form_textarea(array('name' => 'extra_info', 'rows' => '5'), set_value('extra_info'), array('class' => 'uk-textarea uk-form-width-large uk-form-large', 'placeholder' => 'Extra Information', 'maxlength' => '255'));
                    ?>
                </div>
            </div>
            
            <div class="uk-margin">
                <div class="uk-inline">
                    <?php 
                    echo form_checkbox('upload_affiliate_partner_image', 'yes', set_checkbox('upload_affiliate_partner_image', 'yes', FALSE), array('class' => 'uk-checkbox', 'id' => 'upload_affiliate_partner_image')); 
                    echo form_label('Upload affiliate partner image', 'upload_affiliate_partner_image', array('class' => 'uk-form-label uk-margin-small-left uk-margin-small-right')); 
                    ?>
                </div>
            </div>
            
            <div class="uk-margin">
                <div class="uk-inline">
                    <?php 
                    echo form_submit('submit', 'Submit', array('class' => 'uk-button uk-button-primary')); 
                    ?>
                </div>
            </div>
            
            <?php 
            echo form_close(); 
            ?>
            
        </div>
        
    </div> 
    
</div>