<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="uk-width-expand uk-padding-small">
    
    <div class="uk-panel uk-margin-small uk-card uk-card-default uk-card-small uk-width-expand">
        
        <div class="uk-card-header">
            <h3 class="uk-card-title"> Tests</h3> 
        </div>
        <div class="uk-card-body">
            
            <?php 
            if(!empty($error_message)) 
            {
                echo '<div class="uk-alert-danger" uk-alert><a class="uk-alert-close" uk-close></a>'. $error_message .'</div>';
            }
            
            echo validation_errors('<div class="uk-alert-danger" uk-alert><a class="uk-alert-close" uk-close></a>', '</div>'); 
            ?>
            
            <form id="view_tests_form" action="<?php echo site_url('labmanob/view/tests'); ?>" method="get" accept-charset="utf-8">

            <div class="uk-margin">
                <div class="uk-inline">
                    <?php 
                    echo form_label('Results Per Page', 'results_per_page', array('class' => 'uk-form-label'));
                    if (form_error('results_per_page')) 
                    {
                        echo '<span class="uk-margin-small-left uk-margin-small-right gs-uk-alert-danger-color" uk-icon="icon: warning"></span>';
                    }
                    ?>
                </div>
                <br />
                <div class="uk-inline">
                    <?php 
                    echo form_input('results_per_page', set_value('results_per_page', 10), array('class' => 'uk-input uk-form-width-large uk-form-large', 'placeholder' => 'Results Per Page', 'maxlength' => '11', 'id' => 'results_per_page'));
                    ?>
                </div>
            </div>
            
            <div class="uk-margin">
                <div class="uk-margin">
                    <?php 
                    echo form_submit('submit_view_tests', 'View', array('class' => 'uk-button uk-button-primary uk-margin-small-right uk-align-left uk-margin-remove-bottom')); 
                    
                    echo form_button('reset_view_tests', 'Reset', array('class' => 'uk-button uk-button-default uk-margin-small-left uk-align-right uk-margin-remove-bottom', 'id' => 'reset_view_tests_form')); 
                    ?>
                </div>
            </div>
            
            <?php 
            echo form_close(); 
            ?> 
            
        </div>

        <?php if ((isset($tests_table)) && (!$tests_table_empty)) { ?>
        <div class="uk-card-footer">
            <div class="uk-margin-small">

                <?php if(isset($page) && ($page != '')): ?>
                <form id="view_tests_generate_form" action="<?php echo site_url('labmanob/view/tests/'.$page); ?>" method="get" accept-charset="utf-8">
                <?php else: ?>
                <form id="view_tests_generate_form" action="<?php echo site_url('labmanob/view/tests'); ?>" method="get" accept-charset="utf-8">
                <?php endif; ?>

                <?php
                echo form_hidden('results_per_page', set_value('results_per_page', 10));
                ?>

                <?php 
                echo form_submit('submit_generate_csv', 'Generate', array('class' => 'uk-button uk-button-default uk-margin-small-right uk-align-left uk-margin-remove-bottom', 'title' => 'Generate CSV')); 
                ?>

                <?php 
                echo form_close(); 
                ?> 

            </div>
        </div>
        <?php } ?>
        
    </div>

    <?php
    if(isset($csv_file_requested) && ($csv_file_requested == TRUE)) 
    {
        if(($csv_file_generated) && !empty($csv_file_path)) {
            echo '<div class="uk-alert-primary" uk-alert><a class="uk-alert-close" uk-close></a> CSV generated! <br />'. $csv_file_path .'</div>';
        }
        else {
            echo '<div class="uk-alert-danger" uk-alert><a class="uk-alert-close" uk-close></a> There was an error while generating the CSV! </div>';;
        }
    }
    ?>


    <div class="uk-margin">
        <h3>Tests List</h3> 
        <?php echo (isset($total_results)) ? '<span class="uk-text-meta"> Total '.$total_results.' tests.</span>' : '' ; ?>
        <div class="uk-margin-small">
            <?php 
            if ((isset($tests_table)) && (!$tests_table_empty)) 
            { 
                echo '<div class="uk-overflow-auto">'; 
                echo $tests_table; 
                echo '</div>'; 
            } 
            else 
            { 
                echo 'No test found.'; 
            } 
            ?>
        </div>
        <div class="uk-margin-small">
            <?php 
            if (isset($pagination_links)) 
            { 
                echo str_replace("&submit_generate_csv=Generate", "", $pagination_links); 
            } 
            ?>
        </div>
    </div> 
    
    
    <div class="uk-height-1-1">
    </div>

    
    <script>
        $(document).ready(function() 
		{
            $('#reset_view_tests_form').click(function()
            {
                $('#results_per_page').val('10');
            });
        });
    </script>
    
</div>