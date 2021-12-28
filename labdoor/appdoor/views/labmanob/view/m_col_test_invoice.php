<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="uk-width-expand uk-padding-small">
    
    <?php 
    if($this->session->flashdata('message_display')) 
    {
        echo '<div class="uk-alert-primary" uk-alert><a class="uk-alert-close" uk-close></a>'. $this->session->flashdata('message_display') .'</div>';
    }
    ?>

    <div class="uk-margin-small uk-panel uk-card uk-card-default uk-card-small uk-width-expand">
        
        <div class="uk-card-header">
            <h3 class="uk-card-title">Test Invoice</h3> 
        </div>
        <div class="uk-card-body">
            
            <div class="uk-margin-small">
                
                <?php
				echo '<b>Test Invoice ID</b>: '.$test_invoice->id;
				echo '<br />';
				echo '<b>Issued</b>: <time datetime="'.mdate("%d-%M-%Y, %h:%i %a", strtotime($test_invoice->created)).'">'.mdate("%d-%M-%Y, %h:%i %a", strtotime($test_invoice->created)).'</time>';
				echo ' | <b>Modified</b>: <time datetime="'.mdate("%d-%M-%Y, %h:%i %a", strtotime($test_invoice->modified)).'">'.mdate("%d-%M-%Y, %h:%i %a", strtotime($test_invoice->modified)).'</time>'; 
                echo '<br />';  
                echo '<b>Patient ID</b>: '. anchor('labmanob/view/patient/'.$test_invoice->patient_id.'?ref=labmanob/view/test_invoice/'.$test_invoice->id, $test_invoice->patient_id, array ('class' => 'uk-link-text')); 
                echo '<br />'; 
                echo '<b>Name</b>: '.$test_invoice_patient->firstname.' '.$test_invoice_patient->lastname; 
                echo '<br />'; 
				echo '<b>Sex</b>: '.$test_invoice_patient->sex.' | <b>Age</b>: '.$test_invoice->patient_age; 
                echo '<br />';
                echo '<b>Contact Number</b>: '.$test_invoice_patient->phone_no; 
                echo '<br />'; 
				echo '<b>Ref By</b>: '.$test_invoice->ref_by.''; 
                echo '<br />'; 
                echo '<b>Affiliate Partner ID</b>: '. anchor('labmanob/view/affiliate_partner/'.$test_invoice->affiliate_partner_id.'?ref=labmanob/view/test_invoice/'.$test_invoice->id, $test_invoice->affiliate_partner_id, array ('class' => 'uk-link-text')); 
                ?>
                
            </div>
            
        </div>
        <?php if(isset($qrCodeUrl)) : ?>
        <div class="uk-card-footer">
            <div class="">
                <img class="uk-responsive-width" src="<?php echo $qrCodeUrl; ?>" />
            </div>
        </div>
        <?php endif; ?>
        
    </div> 
    
    
    <div class="uk-clearfix">
    </div>
    
    
    <div class="uk-margin-small uk-panel uk-card uk-card-default uk-card-small uk-width-expand">

        <div class="uk-card-header">
            <h3 class="uk-card-title">Tests</h3> 
        </div>
        <div class="uk-card-body">
            <?php 
            if (isset($test_invoice_records_table))
            { 
                echo '<div class="uk-overflow-auto">'; 
                echo $test_invoice_records_table; 
                echo '</div>'; 
                echo '<hr class="uk-devider-icon" />';

                echo '<p>';
				echo 'Total: '.sprintf("%.2f", (float)$test_invoice->total).'';
				echo '<br />';
				echo 'Discount: '.$test_invoice->discount.'';	
				echo ' | Discount By: '.$test_invoice->discount_by.'';			
				echo '<br />';
				echo'<b>Subtotal</b>: '.sprintf("%.2f", (float)$test_invoice->subtotal).'';
				echo ' | Paid: '.sprintf("%.2f", (float)$test_invoice_payment->paid_amount).'';
				echo ($test_invoice_payment->is_full_paid == 0) ? ' | Due: '.sprintf("%.2f", (float)($test_invoice->subtotal - $test_invoice_payment->paid_amount)) : '<span class="uk-margin-small-left uk-icon-button" uk-icon="check" title="Full Paid"></span>';
				echo '</p>';

                echo '<hr class="uk-devider-icon" />';
				
				echo '<p>';
				echo '<b>Extra Info</b>: '.(($test_invoice->extra_info == "") ? "No data" : $test_invoice->extra_info).'';
				echo '</p>';
            }
            ?>
        </div>
        <div class="uk-card-footer">
            <div class="uk-margin-small">
                <?php 
                echo anchor('labmanob/view/test_invoices', 'Back', array ('class' => 'uk-button uk-button-default uk-margin-small-right uk-align-left uk-margin-remove-bottom')); 
                echo ((isset($test_invoice->id) && (!empty($test_invoice->id))) ? anchor('labmanob/edit/test_invoice/payment/'.$test_invoice->id, 'Edit Payment', array ('class' => 'uk-button uk-button-primary uk-margin-small-left uk-align-right uk-margin-remove-bottom', 'title' => 'Edit Payment')) : ""); 
                echo ((isset($test_invoice->id) && (!empty($test_invoice->id))) ? anchor('labmanob/printing/test_invoice/'.$test_invoice->id, 'Full Print', array ('class' => 'uk-button uk-button-default uk-margin-small-left uk-align-right uk-margin-remove-bottom', 'target' => '_blank', 'title' => 'Print This Page')) : ""); 
                echo ((isset($test_invoice->id) && (!empty($test_invoice->id))) ? anchor('labmanob/printing/test_invoice/'.$test_invoice->id.'/mini', 'Print', array ('class' => 'uk-button uk-button-default uk-margin-small-left uk-align-right uk-margin-remove-bottom', 'target' => '_blank', 'title' => 'Print This Page')) : ""); 
                ?>
            </div>
        </div>
        
    </div>


    <div class="uk-margin">
        <h3>Test Invoice Logs</h3> 
        <?php 
        echo (isset($total_test_invoice_logs_results)) ? '<span class="uk-text-meta"> '.$total_test_invoice_logs_results.' logs found</span>' : '' ; 
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
                echo 'No test invoice logs found.'; 
            } 
            ?>
        </div>
        <!-- <div class="uk-margin-small"> -->
            <?php 
            // if (isset($pagination_links)) 
            // { 
            //     echo $pagination_links; 
            // } 
            ?>
        <!-- </div> -->
    </div>
    
    
    <div class="uk-height-1-1">
    </div>

    
</div>