<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="uk-width-expand uk-padding-small">

<div class="uk-panel uk-margin-small uk-card uk-card-default uk-card-small uk-width-expand">
        
        <div class="uk-card-header">
            <h3 class="uk-card-title"><span uk-search-icon></span> Search Test Invoice Logs</h3> 
        </div>
        <div class="uk-card-body">
            
            <?php 
            if(!empty($error_message)) 
            {
                echo '<div class="uk-alert-danger" uk-alert><a class="uk-alert-close" uk-close></a>'. $error_message .'</div>';
            }
            
            echo validation_errors('<div class="uk-alert-danger" uk-alert><a class="uk-alert-close" uk-close></a>', '</div>'); 
            ?>
            
            <form id="search_test_invoice_logs_form" action="<?php echo site_url('labmanob/search/test_invoice_logs'); ?>" method="get" accept-charset="utf-8">
            
            <div class="uk-margin">
                <div class="uk-inline">
                    <?php 
                    echo form_label('Test Invoice Log ID', 'test_invoice_log_id', array('class' => 'uk-form-label'));
                    if (form_error('test_invoice_log_id')) 
                    {
                        echo '<span class="uk-margin-small-left uk-margin-small-right gs-uk-alert-danger-color" uk-icon="icon: warning"></span>';
                    }
                    ?>
                </div>
                <br />
                <div class="uk-inline">
                    <?php 
                    echo form_input('test_invoice_log_id', set_value('test_invoice_log_id'), array('class' => 'uk-input uk-form-width-large uk-form-large', 'placeholder' => 'Test Invoice Log ID', 'maxlength' => '11', 'id' => 'test_invoice_log_id'));
                    ?>
                </div>
            </div>

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
                    echo form_input('test_invoice_id', set_value('test_invoice_id'), array('class' => 'uk-input uk-form-width-large uk-form-large', 'placeholder' => 'Test Invoice ID', 'maxlength' => '11', 'id' => 'test_invoice_id'));
                    ?>
                </div>
            </div>

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
                    <?php 
                    echo form_input('username', set_value('username'), array('class' => 'uk-input uk-form-width-large uk-form-large', 'placeholder' => 'Username', 'maxlength' => '30', 'id' => 'username'));
                    ?>
                </div>
            </div>

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
                    $options = array(
                        '' => 'Select Previous Payment Status', 
                        'all' => 'All', 
                        'full_paid' => 'Full Paid', 
                        'due' => 'Due'
                    ); 
                    
                    echo form_label('Previous Payment Status', 'prev_payment_status', array('class' => 'uk-form-label')); 
                    if (form_error('prev_payment_status')) 
                    {
                        echo '<span class="uk-margin-small-left uk-margin-small-right gs-uk-alert-danger-color" uk-icon="icon: warning"></span>';
                    }
                    ?>
                </div>
                <br />
                <div class="uk-inline">
                    <?php 
                    echo form_dropdown('prev_payment_status', $options, array(set_value('prev_payment_status', '')), array('class' => 'uk-select uk-form-width-large uk-form-large', 'id' => 'prev_payment_status')); 
                    ?>
                </div>
            </div>

            <div class="uk-margin">
                <div class="uk-inline">
                    <?php 
                    $options = array(
                        '' => 'Select Payment Status', 
                        'all' => 'All', 
                        'full_paid' => 'Full Paid', 
                        'due' => 'Due'
                    ); 
                    
                    echo form_label('Payment Status', 'payment_status', array('class' => 'uk-form-label')); 
                    if (form_error('payment_status')) 
                    {
                        echo '<span class="uk-margin-small-left uk-margin-small-right gs-uk-alert-danger-color" uk-icon="icon: warning"></span>';
                    }
                    ?>
                </div>
                <br />
                <div class="uk-inline">
                    <?php 
                    echo form_dropdown('payment_status', $options, array(set_value('payment_status', '')), array('class' => 'uk-select uk-form-width-large uk-form-large', 'id' => 'payment_status')); 
                    ?>
                </div>
            </div>
            
            <div class="uk-margin">
                <div class="uk-margin">
                    <?php 
                    echo form_submit('submit_search_test_invoice_logs', 'Search', array('class' => 'uk-button uk-button-primary uk-margin-small-right uk-align-left uk-margin-remove-bottom')); 
                    echo form_button('reset_search_test_invoice_logs', 'Reset', array('class' => 'uk-button uk-button-default uk-margin-small-left uk-align-right uk-margin-remove-bottom', 'id' => 'reset_search_test_invoice_logs_form')); 
                    ?>
                </div>
            </div>
            
            <?php 
            echo form_close(); 
            ?>  
            
        </div>
        
    </div>
    
    
    <div class="uk-margin">
        <h3>Test Invoice Logs</h3> 
        <?php 
        echo (isset($total_search_results)) ? '<span class="uk-text-meta"> '.$total_search_results.' results found</span>' : '' ; 
        ?>
        <div class="uk-margin-small">
            <?php 
            if ((isset($test_invoice_logs_table)) && (!$test_invoice_logs_table_empty)) 
            { 
                echo '<div class="uk-overflow-auto">'; 
                echo $test_invoice_logs_table; 
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
            $('#reset_search_test_invoice_logs_form').click(function()
            {
                $('#test_invoice_log_id').val('');
                $('#test_invoice_id').val('');
                $('#username').val('');
                $('#begin_date').val('');
                $('#end_date').val('');
                $('#prev_payment_status').val('');
                $('#payment_status').val('');

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