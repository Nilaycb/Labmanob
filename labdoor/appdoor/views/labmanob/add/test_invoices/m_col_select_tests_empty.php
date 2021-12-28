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
                echo '<b>ID</b>: '.$_SESSION['test_invoice__patient']['id']; 
                echo '<br />'; 
                echo '<b>Name</b>: '.$_SESSION['test_invoice__patient']['firstname'].' '.$_SESSION['test_invoice__patient']['lastname']; 
                echo '<br />'; 
                echo '<b>Sex</b>: '.$_SESSION['test_invoice__patient']['sex']; 
                ?>
                
            </div>
            
        </div>
        <div class="uk-card-footer">
            <div class="uk-margin-small">
                <?php 
                echo anchor('labmanob/add/new_test_invoice/remove_patient', 'Remove', array ('class' => 'uk-button uk-button-danger uk-margin-small-right uk-align-left uk-margin-remove-bottom')); 
                ?>
            </div>
        </div>
        
    </div> 
    
    
    <div class="uk-clearfix">
    </div>
    
    
    <div class="uk-margin-small uk-panel uk-card uk-card-default uk-card-small uk-width-expand">
        
        <div class="uk-card-header">
            <h3 class="uk-card-title">Select Tests</h3> 
        </div>
        <div class="uk-card-body">
            
            <p>No test found. Add new test first to continue.</p>
            
        </div>
        
    </div>
    
    
    <div class="uk-height-1-1">
    </div>
    
</div>