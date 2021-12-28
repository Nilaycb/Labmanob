<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="uk-width-expand uk-padding-small">
    
    <div>
        <h3>Add New Test</h3>
        <div class="uk-margin-small">
            
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
            echo form_open('labmanob/add/new_test'); 
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
                    echo form_input('test_name', set_value('test_name'), array('class' => 'uk-input uk-form-width-large uk-form-large', 'placeholder' => 'Test Name', 'maxlength' => '150'));
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
                    echo form_input('test_codename', set_value('test_codename'), array('class' => 'uk-input uk-form-width-large uk-form-large', 'placeholder' => 'Test Code Name', 'maxlength' => '150'));
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
                    echo form_dropdown('test_category_id', $options, array(), array('class' => 'uk-select uk-form-width-large uk-form-large')); 
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
                    echo form_input('test_price', set_value('test_price'), array('class' => 'uk-input uk-form-width-large uk-form-large', 'placeholder' => 'Test Price', 'maxlength' => '15'));
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
                    echo form_input('test_description', set_value('test_description'), array('class' => 'uk-input uk-form-width-large uk-form-large', 'placeholder' => 'Test Description', 'maxlength' => '255'));
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