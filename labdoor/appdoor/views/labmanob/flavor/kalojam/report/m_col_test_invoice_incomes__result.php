<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="uk-width-expand uk-padding-small">

    <div class="uk-panel uk-margin-small uk-card uk-card-default uk-card-small uk-width-expand">
        
        <div class="uk-card-header">
            <h3 class="uk-card-title">Test Invoice Incomes</h3> 
        </div>
        <div class="uk-card-body">
            
            <?php 
            if(!empty($error_message)) 
            {
                echo '<div class="uk-alert-danger" uk-alert><a class="uk-alert-close" uk-close></a>'. $error_message .'</div>';
            }
            
            echo validation_errors('<div class="uk-alert-danger" uk-alert><a class="uk-alert-close" uk-close></a>', '</div>'); 
            ?>
            
            <form id="test_invoice_incomes_form" action="<?php echo site_url('labmanob/flavor/kalojam/report/test_invoice_incomes/view'); ?>" method="get" accept-charset="utf-8">

            <div class="uk-margin">
                <div class="uk-inline">
                    <?php 
                    echo form_label('Begin Date', 'begin_date', array('class' => 'uk-form-label'));
                    if (form_error('begin_date')) 
                    {
                        echo '<span class="uk-margin-small-left uk-margin-small-right gs-uk-alert-danger-color" uk-icon="icon: warning"></span>';
                    }
                    ?>
                </div>
                <br />
                <div class="uk-inline">
                    <?php 
                    echo form_input('begin_date', set_value('begin_date'), array('class' => 'uk-input uk-form-width-large uk-form-large', 'placeholder' => 'Begin Date', 'maxlength' => '30', 'id' => 'begin_date'));
                    ?>
                </div>
            </div>

            <div class="uk-margin">
                <div class="uk-inline">
                    <?php 
                    echo form_label('End Date', 'end_date', array('class' => 'uk-form-label'));
                    if (form_error('end_date')) 
                    {
                        echo '<span class="uk-margin-small-left uk-margin-small-right gs-uk-alert-danger-color" uk-icon="icon: warning"></span>';
                    }
                    ?>
                </div>
                <br />
                <div class="uk-inline">
                    <?php 
                    echo form_input('end_date', set_value('end_date'), array('class' => 'uk-input uk-form-width-large uk-form-large', 'placeholder' => 'End Date', 'maxlength' => '30', 'id' => 'end_date'));
                    ?>
                </div>
            </div>

            <div class="uk-margin">
                <div class="uk-inline">
                    <?php 
                    echo form_checkbox('group_by', 'date', set_checkbox('group_by', 'date', FALSE), array('class' => 'uk-checkbox', 'id' => 'group_by')); 
                    echo form_label('Group by Date', 'group_by', array('class' => 'uk-form-label uk-margin-small-left uk-margin-small-right')); 
                    ?>
                </div>
            </div>
            
            <div class="uk-margin">
                <div class="uk-margin">
                    <?php 
                    echo form_submit('submit_test_invoice_incomes_form', 'Submit', array('class' => 'uk-button uk-button-primary uk-margin-small-right uk-align-left uk-margin-remove-bottom')); 
                    echo form_button('reset_test_invoice_incomes_form', 'Reset', array('class' => 'uk-button uk-button-default uk-margin-small-left uk-align-right uk-margin-remove-bottom', 'id' => 'reset_test_invoice_incomes_form')); 
                    ?>
                </div>
            </div>
            
            <?php 
            echo form_close(); 
            ?>   
            
        </div>
        
    </div>
    
    
    <div class="uk-margin">
        <h3>Results</h3> 
        <div class="uk-margin-small">
            <?php 
            if ((isset($test_invoice_incomes_table)) && (!$test_invoice_incomes_table_empty)) 
            { 
                echo '<div class="uk-overflow-auto">'; 
                echo $test_invoice_incomes_table; 
                echo '</div>'; 
            } 
            else 
            { 
                echo 'No record found.'; 
            } 
            ?>
        </div>
        <div class="uk-margin-small">
            <?php 
            if (isset($pagination_links)) 
            { 
                echo $pagination_links; 
            } 
            ?>
        </div>
    </div> 


    <div class="uk-height-1-1">
    </div>


    <script>
        $(document).ready(function() 
		{
            $('#reset_test_invoice_incomes_form').click(function()
            {
                $('#begin_date').val('');
                $('#end_date').val('');
                $('#group_by').prop('checked', false);

                $('#begin_date').flatpickr({
                    altInput: true,
                    altFormat: 'F d, Y',
                    dateFormat: 'Y-m-d',
                    defaultDate: null,
                });

                $('#end_date').flatpickr({
                    altInput: true,
                    altFormat: 'F d, Y',
                    dateFormat: 'Y-m-d',
                    defaultDate: null,
                });
            });

            $('#begin_date').flatpickr({
                altInput: true,
                altFormat: 'F d, Y',
                dateFormat: 'Y-m-d',
                defaultDate: null,
            });

            $('#end_date').flatpickr({
                altInput: true,
                altFormat: 'F d, Y',
                dateFormat: 'Y-m-d',
                defaultDate: null,
            });
        });
    </script>
    
</div>