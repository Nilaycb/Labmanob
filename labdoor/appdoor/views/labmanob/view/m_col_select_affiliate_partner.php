<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="uk-width-expand uk-padding-small">
    
    <div class="uk-panel uk-margin-small uk-card uk-card-default uk-card-small uk-width-expand">
        
        <div class="uk-card-header">
            <h3 class="uk-card-title">Select Affiliate Partner</h3> 
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
            echo form_open('labmanob/view/affiliate_partner'); 
            ?>
            
            <div class="uk-margin">
                <div class="uk-inline">
                    <?php 
                    echo form_label('Affiliate Partner ID', 'affiliate_partner_id', array('class' => 'uk-form-label'));
                    if (form_error('affiliate_partner_id')) 
                    {
                        echo '<span class="uk-margin-small-left uk-margin-small-right gs-uk-alert-danger-color" uk-icon="icon: warning"></span>';
                    }
                    ?>
                </div>
                <br />
                <div class="uk-inline">
                    <?php 
                    echo form_input('affiliate_partner_id', set_value('affiliate_partner_id'), array('class' => 'uk-input uk-form-width-large uk-form-large', 'placeholder' => 'Affiliate Partner ID', 'maxlength' => '11'));
                    ?>
                </div>
            </div>
            
            <div class="uk-margin">
                <div class="uk-inline">
                    <?php 
                    echo form_submit('submit_select_affiliate_partner', 'Continue', array('class' => 'uk-button uk-button-primary')); 
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