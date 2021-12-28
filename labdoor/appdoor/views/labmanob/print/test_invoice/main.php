<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="uk-margin-small uk-width-expand uk-margin-remove-bottom">
    
    <div class="">
        
        <div class="">
            <h3 class="uk-card-title"><img height="50" width="50" src="<?php echo assets_url().uploads_dir().'logo/'.$this->config->item('business_entity_logo_file_name', 'labmanob'); ?>" /> <?php echo $this->config->item('business_entity_name', 'labmanob'); ?></h3> 
        </div>
        <div class="">
            
            <div class="">
                
				<?php 
                echo '<b>Test Invoice ID</b>: '.$test_invoice->id.' | <b>Issued</b>: <time datetime="'.date("F d, Y h:i a", strtotime($test_invoice->created)).'">'.date("F d, Y", strtotime($test_invoice->created)).'</time>'; 
                echo '<br />';  
                echo '<b>Patient ID</b>: '.$test_invoice->patient_id; 
                echo ' | <b>Name</b>: '.$test_invoice_patient->firstname.' '.$test_invoice_patient->lastname; 
                echo ' | <b>Sex</b>: '.$test_invoice_patient->sex.' | <b>Age</b>: '.$test_invoice->patient_age; 
                echo '<br />';
                echo '<b>Contact Number</b>: '.$test_invoice_patient->phone_no;
                echo '<br />';
                echo '<b>Ref By</b>: '.(($test_invoice->ref_by == "") ? "N/A" : $test_invoice->ref_by).''; 
                echo '<br />';  
                ?>
                <time class="uk-text-meta uk-margin-remove-bottom" datetime="<?php echo mdate("%d-%M-%Y, %h:%i %a", now()); ?>"><?php echo mdate("%d-%M-%Y, %h:%i %a", now()); ?></time>
                
            </div>
            
        </div>
        
    </div> 


    <?php if(isset($qrCodeUrl)) : ?>
    <div class="uk-clearfix">
    </div>


    <div class="uk-margin-small-top uk-margin-small-bottom uk-width-expand">

        <div class="uk-flex uk-flex-middle">
            <div class="">
                <img class="uk-responsive-width" src="<?php echo $qrCodeUrl; ?>" />
            </div>
        </div>

    </div>
    <?php endif; ?>
    
    
    <div class="uk-clearfix">
    </div>
    
    
    <div class="uk-width-expand">
        <div class="">
            <div class="">Tests</div> 
        </div>
        <div class="">
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
                echo (($test_invoice->discount == "") ? '' : 'Discount: '.$test_invoice->discount).'';
                echo (($test_invoice->discount != "") && ($test_invoice->discount_by != "")) ? ' | ' : '';
				echo (($test_invoice->discount_by == "") ? '' : 'Discount By: '.$test_invoice->discount_by.'');		
				echo (($test_invoice->discount != "") || ($test_invoice->discount_by != "")) ? '<br />' : '';
				echo'<b>Subtotal</b>: '.sprintf("%.2f", (float)$test_invoice->subtotal).'';
				echo ' | Paid: '.sprintf("%.2f", (float)$test_invoice_payment->paid_amount).'';
				echo ($test_invoice_payment->is_full_paid == 0) ? ' | Due: '.sprintf("%.2f", (float)($test_invoice->subtotal - $test_invoice_payment->paid_amount)) : '<span class="uk-margin-small-left uk-icon-button" uk-icon="check"></span>';
				echo '</p>';

                if ($print_type != 'mini')
                {
                    echo '<hr class="uk-devider-icon" />';
                    
                    echo '<p>';
                    echo '<b>Additional Info</b>: '.(($test_invoice->extra_info == "") ? "N/A" : $test_invoice->extra_info).'';
                    echo '</p>';
                }
            }
            ?>
        </div>
        
    </div>
    
    
    <div class="uk-height-1-1">
    </div>


    <script>
        $(document).ready(function() 
		{
            window.print();
        })
    </script>

    
</div>