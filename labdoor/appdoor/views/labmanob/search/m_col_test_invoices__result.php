<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="uk-width-expand uk-padding-small">

<div class="uk-panel uk-margin-small uk-card uk-card-default uk-card-small uk-width-expand">
        
        <div class="uk-card-header">
            <h3 class="uk-card-title"><span uk-search-icon></span> Search Test Invoices</h3> 
        </div>
        <div class="uk-card-body">
            
            <?php 
            if(!empty($error_message)) 
            {
                echo '<div class="uk-alert-danger" uk-alert><a class="uk-alert-close" uk-close></a>'. $error_message .'</div>';
            }
            
            echo validation_errors('<div class="uk-alert-danger" uk-alert><a class="uk-alert-close" uk-close></a>', '</div>'); 
            ?>
            
            <form id="search_test_invoices_form" action="<?php echo site_url('labmanob/search/test_invoices'); ?>" method="get" accept-charset="utf-8">
            
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
                    echo form_label('Patient ID', 'patient_id', array('class' => 'uk-form-label'));
                    if (form_error('patient_id')) 
                    {
                        echo '<span class="uk-margin-small-left uk-margin-small-right gs-uk-alert-danger-color" uk-icon="icon: warning"></span>';
                    }
                    ?>
                </div>
                <br />
                <div class="uk-inline">
                    <?php 
                    echo form_input('patient_id', set_value('patient_id'), array('class' => 'uk-input uk-form-width-large uk-form-large', 'placeholder' => 'Patient ID', 'maxlength' => '11', 'id' => 'patient_id'));
                    ?>
                </div>
            </div>

            <div class="uk-margin">
                <div class="uk-inline">
                    <?php 
                    echo form_label('Ref By', 'ref_by', array('class' => 'uk-form-label'));
                    if (form_error('ref_by')) 
                    {
                        echo '<span class="uk-margin-small-left uk-margin-small-right gs-uk-alert-danger-color" uk-icon="icon: warning"></span>';
                    }
                    ?>
                </div>
                <br />
                <div class="uk-inline">
                    <?php 
                    echo form_input('ref_by', set_value('ref_by'), array('class' => 'uk-input uk-form-width-large uk-form-large', 'placeholder' => 'Ref By', 'maxlength' => '150', 'id' => 'ref_by'));
                    ?>
                </div>
            </div>

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
                    echo form_input('affiliate_partner_id', set_value('affiliate_partner_id'), array('class' => 'uk-input uk-form-width-large uk-form-large', 'placeholder' => 'Affiliate Partner ID', 'maxlength' => '11', 'id' => 'affiliate_partner_id'));
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

            <div class="uk-margin uk-grid-small uk-child-width-auto uk-grid">
                <?php 
                echo form_label('Payment Status: ', 'payment_status', array('class' => 'uk-form-label'));
                if (form_error('payment_status')) 
                {
                    echo '<span class="uk-margin-small-left uk-margin-small-right gs-uk-alert-danger-color" uk-icon="icon: warning"></span>';
                }
                ?>
                <label><?php echo form_radio('payment_status', 'all', set_radio('payment_status', 'all', TRUE), array('class' => 'uk-radio', 'id' => 'payment_status__all')); ?> All</label>
                <label><?php echo form_radio('payment_status', 'full_paid', set_radio('payment_status', 'full_paid', FALSE), array('class' => 'uk-radio', 'id' => 'payment_status__full_paid')); ?> Full Paid</label>
                <label><?php echo form_radio('payment_status', 'due', set_radio('payment_status', 'due', FALSE), array('class' => 'uk-radio', 'id' => 'payment_status__due')); ?> Due</label>
            </div>
            
            <div class="uk-margin">
                <div class="uk-margin">
                    <?php 
                    echo form_submit('submit_search_test_invoices', 'Search', array('class' => 'uk-button uk-button-primary uk-margin-small-right uk-align-left uk-margin-remove-bottom')); 
                    echo form_button('reset_search_test_invoices', 'Reset', array('class' => 'uk-button uk-button-default uk-margin-small-left uk-align-right uk-margin-remove-bottom', 'id' => 'reset_search_test_invoices_form')); 
                    ?>
                </div>
            </div>
            
            <?php 
            echo form_close(); 
            ?>  
            
        </div>
        
    </div>
    
    
    <div class="uk-margin">
        <h3>Test Invoices List</h3> 
        <?php 
        echo (isset($total_search_results)) ? '<span class="uk-text-meta"> '.$total_search_results.' results found</span>' : '' ; 
        echo (isset($total_search_results) && isset($earnings_subtotal)) ? '<span class="uk-text-meta"> and </span>' : '' ;
        echo (isset($earnings_subtotal)) ? '<span class="uk-text-meta"> this page earnings subtotal '.$earnings_subtotal.'</span>' : '' ;
        echo (isset($earnings_subtotal) && isset($earnings_paid_amount)) ? '<span class="uk-text-meta"> and </span>' : '' ;
        echo (isset($earnings_paid_amount)) ? '<span class="uk-text-meta"> total paid '.$earnings_paid_amount.'</span>' : '' ;
        echo (isset($earnings_paid_amount) && isset($earnings_due)) ? '<span class="uk-text-meta"> and </span>' : '' ;
        echo (isset($earnings_due)) ? '<span class="uk-text-meta"> total due '.$earnings_due.'</span>' : '' ;
        ?>
        <div class="uk-margin-small">
            <?php 
            if ((isset($test_invoices_table)) && (!$test_invoices_table_empty)) 
            { 
                echo '<div class="uk-overflow-auto">'; 
                echo $test_invoices_table; 
                echo '</div>'; 
            } 
            else 
            { 
                echo 'No test invoice found.'; 
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
            $('#reset_search_test_invoices_form').click(function()
            {
                $('#test_invoice_id').val('');
                $('#patient_id').val('');
                $('#ref_by').val('');
                $('#affiliate_partner_id').val('');
                $('#begin_date').val('');
                $('#end_date').val('');
                $('#payment_status__all').prop('checked', true);
                $('#payment_status__full_paid').prop('checked', false);
                $('#payment_status__due').prop('checked', false);

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