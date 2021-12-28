<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="uk-width-expand uk-padding-small">
    
    <div class="uk-margin-small uk-panel uk-card uk-card-default uk-card-small uk-width-expand">
        
        <div class="uk-card-header">
            <h3 class="uk-card-title">Selected Patient</h3> 
        </div>
        <div class="uk-card-body">
            
            <div class="uk-margin-small">
                
                <?php 
                echo '<b>ID</b>: '.$patient['id']; 
                echo '<br />'; 
                echo '<b>Name</b>: '.$patient['firstname'].' '.$patient['lastname']; 
                echo '<br />'; 
                echo '<b>Sex</b>: '.$patient['sex']; 
                ?>
                
            </div>
            
        </div>
        <div class="uk-card-footer">
            <div class="uk-margin-small">
                <?php 
                echo anchor('labmanob/add/new_test_invoice/remove_patient', 'Remove', array ('class' => 'uk-button uk-button-danger uk-margin-small-right uk-align-left uk-margin-remove-bottom')); 
                echo anchor('labmanob/add/new_test_invoice/select_tests', 'Next', array ('class' => 'uk-button uk-button-primary uk-margin-small-left uk-align-right uk-margin-remove-bottom')); 
                ?>
            </div>
        </div>
        
    </div> 
    
    
    <?php if (!empty($patient_image_data)): ?>
    <div class="uk-clearfix">
    </div>
    
    
    <div class="uk-margin-small uk-panel uk-card uk-card-default uk-card-small uk-width-expand">
        
        <div class="uk-card-header">
            <h3 class="uk-card-title">Patient Image</h3> 
        </div>
        <div class="uk-card-body">
            <?php
                if (!empty($encoded_patient_image_data) && !empty($patient_image_data['file_type'])) 
                {
                    echo '<img class="uk-border-rounded uk-responsive-width uk-align-center" style="max-height: 250px;" src="data:'.$patient_image_data['file_type'].';base64,'.$encoded_patient_image_data.'" alt="Patient Image" />';
                }
                else if (isset($patient_image_data['encode_level']) && ($patient_image_data['encode_level'] == 0) && !empty($patient_image_data['file_path']) && !empty($patient_image_data['file_name']))
                {
                    echo '<img class="uk-border-rounded uk-responsive-width uk-align-center" style="max-height: 250px;" src="'. base_url().uploads_path().$patient_image_data['file_path'].$patient_image_data['file_name'] .'" alt="Patient Image" />';
                }
                else 
                {
                    echo '<div class="uk-alert-danger" uk-alert> There was an error! Unable to load the image.</div>';
                }
            ?>
        </div>
        
    </div> 
    <?php endif; ?>
    
    <div class="uk-height-1-1">
    </div> 
    
</div>