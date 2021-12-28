<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="uk-width-expand uk-padding-small">
    
    <div class="uk-panel uk-margin-small uk-card uk-card-default uk-card-small uk-width-expand">
        
        <div class="uk-card-header">
            <h3 class="uk-card-title">Select Test Invoice</h3> 
        </div>
        <div class="uk-card-body">
            
            <?php 
            if(!empty($error_message)) 
            {
                echo '<div class="uk-alert-danger" uk-alert><a class="uk-alert-close" uk-close></a>'. $error_message .'</div>';
            }
            
            echo validation_errors('<div class="uk-alert-danger" uk-alert><a class="uk-alert-close" uk-close></a>', '</div>'); 
            ?>
            
            <?php 
            echo form_open('labmanob/view/test_invoice'); 
            ?>
            
            <div class="uk-margin">
                <div class="uk-inline">
                    <?php 
                    echo form_label('Test Invoice ID', 'test_invoice_id', array('class' => 'uk-form-label'));
                    if (form_error('test_invoice_id')) 
                    {
                        echo '<span class="uk-margin-small-left uk-margin-small-right gs-uk-alert-danger-color" uk-icon="icon: warning"></span>';
                    }
                    ?>
                </div>
                <br />
                <div class="uk-inline">
                    <?php 
                    echo form_input('test_invoice_id', set_value('test_invoice_id'), array('class' => 'uk-input uk-form-width-large uk-form-large', 'placeholder' => 'Test Invoice ID', 'maxlength' => '11'));
                    ?>
                </div>
            </div>
            
            <div class="uk-margin">
                <div class="uk-inline">
                    <?php 
                    echo form_submit('submit_select_test_invoice', 'Continue', array('class' => 'uk-button uk-button-primary')); 
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
    
</div>