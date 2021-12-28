<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="uk-width-expand uk-padding-small">
    
    <div>
        <h3>Add New Test Category</h3>
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
            echo form_open('labmanob/add/new_test_category'); 
            ?>
            
            <div class="uk-margin">
                <div class="uk-inline">
                    <?php 
                    echo form_label('Category Name', 'category_name', array('class' => 'uk-form-label'));
                    if (form_error('category_name')) 
                    {
                        echo '<span class="uk-margin-small-left uk-margin-small-right gs-uk-alert-danger-color" uk-icon="icon: warning"></span>';
                    }
                    ?>
                </div>
                <br />
                <div class="uk-inline">
                    <?php 
                    echo form_input('category_name', set_value('category_name'), array('class' => 'uk-input uk-form-width-large uk-form-large', 'placeholder' => 'Category Name', 'maxlength' => '150'));
                    ?>
                </div>
            </div>
            
            <div class="uk-margin">
                <div class="uk-inline">
                    <?php 
                    echo form_label('Category Code Name', 'category_codename', array('class' => 'uk-form-label'));
                    if (form_error('category_codename')) 
                    {
                        echo '<span class="uk-margin-small-left uk-margin-small-right gs-uk-alert-danger-color" uk-icon="icon: warning"></span>';
                    }
                    ?>
                </div>
                <br />
                <div class="uk-inline">
                    <?php 
                    echo form_input('category_codename', set_value('category_codename'), array('class' => 'uk-input uk-form-width-large uk-form-large', 'placeholder' => 'Category Code Name', 'maxlength' => '150'));
                    ?>
                </div>
            </div>
            
            <div class="uk-margin">
                <div class="uk-inline">
                    <?php 
                    echo form_label('Category Description', 'category_description', array('class' => 'uk-form-label')); 
                    if (form_error('category_description')) 
                    {
                        echo '<span class="uk-margin-small-left uk-margin-small-right gs-uk-alert-danger-color" uk-icon="icon: warning"></span>';
                    }
                    ?>
                </div>
                <br />
                <div class="uk-inline">
                    <?php 
                    echo form_input('category_description', set_value('category_description'), array('class' => 'uk-input uk-form-width-large uk-form-large', 'placeholder' => 'Category Description', 'maxlength' => '255'));
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