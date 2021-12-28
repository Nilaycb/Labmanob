<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="uk-width-expand uk-padding-small">
    
    <div class="uk-panel uk-margin-small uk-card uk-card-default uk-card-small uk-width-expand">
        
        <div class="uk-card-header">
            <h3 class="uk-card-title"><span uk-search-icon></span> Search Tests Invoice Frequency</h3> 
        </div>
        <div class="uk-card-body">
            
            <?php 
            if(!empty($error_message)) 
            {
                echo '<div class="uk-alert-danger" uk-alert><a class="uk-alert-close" uk-close></a>'. $error_message .'</div>';
            }
            
            echo validation_errors('<div class="uk-alert-danger" uk-alert><a class="uk-alert-close" uk-close></a>', '</div>'); 
            ?>
            
            <form id="search_tests_invoice_freq_form" action="<?php echo site_url('labmanob/search/tests_invoice_freq'); ?>" method="get" accept-charset="utf-8">
            
            <div class="uk-margin">
                <div class="uk-inline">
                    <?php 
                    echo form_label('Test ID', 'test_id', array('class' => 'uk-form-label'));
                    if (form_error('test_id')) 
                    {
                        echo '<span class="uk-margin-small-left uk-margin-small-right gs-uk-alert-danger-color" uk-icon="icon: warning"></span>';
                    }
                    ?>
                </div>
                <br />
                <div class="uk-inline">
                    <?php 
                    echo form_input('test_id', set_value('test_id'), array('class' => 'uk-input uk-form-width-large uk-form-large', 'placeholder' => 'Test ID', 'maxlength' => '11', 'id' => 'test_id'));
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
                <div class="uk-margin">
                    <?php 
                    echo form_submit('submit_search_tests_invoice_freq', 'Search', array('class' => 'uk-button uk-button-primary uk-margin-small-right uk-align-left uk-margin-remove-bottom')); 
                    echo form_button('reset_search_tests_invoice_freq', 'Reset', array('class' => 'uk-button uk-button-default uk-margin-small-left uk-align-right uk-margin-remove-bottom', 'id' => 'reset_search_tests_invoice_freq_form')); 
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


    <script>
        $(document).ready(function() 
		{
            $('#reset_search_tests_invoice_freq_form').click(function()
            {
                $('#test_id').val('');
                $('#begin_date').val('');
                $('#end_date').val('');

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