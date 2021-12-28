<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="uk-panel uk-card uk-card-default uk-align-center uk-width-1-2">
    <div class="uk-card-header">
        <div class="uk-grid-small uk-flex-wrap uk-flex-middle" uk-grid> 
            <div class="uk-width-auto"> 
                <img class="uk-border-rounded" width="100" height="100" src="<?php echo assets_url().'labmanob/logo/L.png'; ?>" alt="" /> 
            </div>
            <div class="uk-width-expand"> 
                <h3 class="uk-card-title uk-margin-remove-bottom">Login Panel</h3> 
                <p class="uk-text-meta uk-margin-remove-top">Labmanob</p>
            </div>
        </div>
    </div>
    <div class="uk-card-body">
        
        <?php 
        if ($this->session->flashdata('message_display')) 
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
        echo form_open('accounts/login'); 
        ?>
        
        <div class="uk-margin">
            <div class="uk-inline">
                <?php 
                echo form_label('Username', 'username', array('class' => 'uk-form-label'));
                if (form_error('username')) 
                    {
                    echo '<span class="uk-margin-small-left uk-margin-small-right gs-uk-alert-danger-color" uk-icon="icon: warning"></span>';
                    }
                ?>
            </div>
            <br />
            <div class="uk-inline">
                <span class="uk-form-icon uk-margin-small-right" uk-icon="icon: user; ratio: 2"></span>
                <?php 
                echo form_input('username', set_value('username'), array('class' => 'uk-input uk-form-width-large uk-form-large', 'placeholder' => 'Username', 'maxlength' => '30'));
                ?>
            </div>
        </div>
        
        <div class="uk-margin">
            <div class="uk-inline">
                <?php 
                echo form_label('Password', 'password', array('class' => 'uk-form-label'));
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
                echo form_password('password', '', array('class' => 'uk-input uk-form-width-large uk-form-large', 'placeholder' => 'Password'));
                ?>
            </div>
        </div>
        
        <div class="uk-margin">
            <div class="uk-inline">
                <?php 
                echo form_submit('login', 'Log In', array('class' => 'uk-button uk-button-primary')); 
                ?>
            </div>
        </div>
        
        <?php 
        echo form_close(); 
        ?> 
        
    </div>
    <div class="uk-card-footer"> 
        <div class="gs-dev-name">(c) 2019 labmanob@outlook.com</div> 
    </div> 
</div>