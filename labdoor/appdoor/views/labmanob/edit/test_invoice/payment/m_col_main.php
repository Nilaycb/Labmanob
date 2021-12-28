<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="uk-width-expand uk-padding-small">
    
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
                echo '<b>Patient ID</b>: '.$test_invoice->patient_id; 
                echo '<br />'; 
                echo '<b>Name</b>: '.$test_invoice_patient->firstname.' '.$test_invoice_patient->lastname; 
                echo '<br />'; 
				echo '<b>Sex</b>: '.$test_invoice_patient->sex.' | <b>Age</b>: '.$test_invoice->patient_age; 
				echo '<br />';
				echo '<b>Ref By</b>: '.$test_invoice->ref_by.''; 
				echo '<br />';  
                echo '<b>Affiliate Partner ID</b>: '.$test_invoice->affiliate_partner_id; 
                ?>
                
            </div>
            
        </div>
        
    </div> 
    
    
    <div class="uk-clearfix">
    </div>
    
    
    <div class="uk-margin-small uk-panel uk-card uk-card-default uk-card-small uk-width-expand">
        
        <?php 
		echo form_open('labmanob/edit/test_invoice/payment/'.$test_invoice->id);
		?>

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

                if(!empty($error_message)) 
		    	{
		    		echo '<div class="uk-alert-danger" uk-alert><a class="uk-alert-close" uk-close></a>'. $error_message .'</div>';
		    	}
                echo validation_errors('<div class="uk-alert-danger" uk-alert><a class="uk-alert-close" uk-close></a>', '</div>');

                echo '<p>';
				echo 'Total: '.sprintf("%.2f", (float)$test_invoice->total).'';
				echo '<br />';
				echo ($test_invoice->discount != '') ? 'Discount: <span id="display_final_discount">'.$test_invoice->discount.'</span>' : 'Discount: <span id="display_final_discount">0.00</span>';
				echo ($test_invoice->discount_by != '') ? ' | Discount By: '.$test_invoice->discount_by : '';
				echo '<br />';
				echo '<b>Subtotal: <span id="display_final_subtotal">'.sprintf("%.2f", (float)$test_invoice->subtotal).'</span></b><span id="display_paid_symbol"></span>';
				echo ' | Paid: '.sprintf("%.2f", (float)$test_invoice_payment->paid_amount).'';
				echo ($test_invoice_payment->is_full_paid == 0) ? ' | Due: <span id="display_due">'.sprintf("%.2f", (float)($test_invoice->subtotal - $test_invoice_payment->paid_amount)).'</span>' : ' | Due: <span id="display_due">0.00</span>';
				echo '</p>';

                echo '<div class="uk-inline">';
				echo form_label('Discount', 'final_discount', array('class' => 'uk-form-label uk-margin-small-right')); 
				echo '</div><br />';
				echo '<div class="uk-inline">';
				echo form_input('final_discount', set_value('final_discount', $test_invoice->discount), array('id' => 'final_discount', 'class' => 'uk-input uk-form-width-medium', 'placeholder' => 'Discount', 'maxlength' => '9'));
				if (form_error('final_discount')) 
				{
					echo '<span class="uk-margin-small-left uk-margin-small-right gs-uk-alert-danger-color" uk-icon="icon: warning"></span>';
				}
				echo '</div><br />';
				
				echo '<div class="uk-inline uk-margin-small-top">';
				echo form_label('Discount By', 'final_discount_by', array('class' => 'uk-form-label uk-margin-small-right')); 
				echo '</div><br />';
				echo '<div class="uk-inline">';
				echo form_input('final_discount_by', set_value('final_discount_by', $test_invoice->discount_by), array('class' => 'uk-input uk-form-width-medium', 'placeholder' => 'Discount By', 'maxlength' => '200'));
				if (form_error('final_discount_by')) 
				{
					echo '<span class="uk-margin-small-left uk-margin-small-right gs-uk-alert-danger-color" uk-icon="icon: warning"></span>';
				}
                echo '</div><br />';

                echo '<div class="uk-inline uk-margin-small-top">';
				echo form_label('Paid Amount', 'paid_amount', array('class' => 'uk-form-label uk-margin-small-right')); 
				echo '</div><br />';
				echo '<div class="uk-inline">';
				echo form_input('paid_amount', set_value('paid_amount', $test_invoice_payment->paid_amount), array('id' => 'paid_amount', 'class' => 'uk-input uk-form-width-medium', 'placeholder' => 'Paid Amount', 'maxlength' => '15'));
				if (form_error('paid_amount')) 
				{
					echo '<span class="uk-margin-small-left uk-margin-small-right gs-uk-alert-danger-color" uk-icon="icon: warning"></span>';
				}
                echo '</div><br />';

                echo '<hr class="uk-devider-icon" />';
                
                echo '<div class="uk-inline uk-margin-small-top">';
				echo form_label('Extra Information', 'extra_info', array('class' => 'uk-form-label uk-margin-small-right')); 
				echo form_textarea(array('name' => 'extra_info', 'rows' => '5'), set_value('extra_info', $test_invoice->extra_info), array('class' => 'uk-textarea uk-form-width-large uk-form-large', 'placeholder' => 'Extra Information', 'maxlength' => '255'));
				if (form_error('extra_info')) 
				{
					echo '<span class="uk-margin-small-left uk-margin-small-right gs-uk-alert-danger-color" uk-icon="icon: warning"></span>';
				}
				echo '</div><br />';
            }
            ?>
        </div>
        <div class="uk-card-footer">
            <div class="uk-margin-small">
                <?php 
                echo anchor('labmanob/view/test_invoice/'.$test_invoice->id, 'Back', array ('class' => 'uk-button uk-button-default uk-margin-small-right uk-align-left uk-margin-remove-bottom')); 
				
				if ( ($test_invoice_payment->is_full_paid == 1) && ((strtolower($_SESSION['username']) == 'master') || (strtolower($_SESSION['username']) == 'admin')) ) 
				{
					echo form_submit('submit', 'Submit', array('class' => 'uk-button uk-button-primary uk-margin-small-left uk-align-right uk-margin-remove-bottom'));
				} 
				else if ($test_invoice_payment->is_full_paid == 0) 
				{
					echo form_submit('submit', 'Submit', array('class' => 'uk-button uk-button-primary uk-margin-small-left uk-align-right uk-margin-remove-bottom'));
				}


				echo form_reset('reset_form', 'Reset', array('class' => 'uk-button uk-button-default uk-margin-small-left uk-align-right uk-margin-remove-bottom', 'id' => 'reset_form'));  
                ?>
            </div>
        </div>

        <?php 
		echo form_close(); 
		?>
        
    </div>
    
    
    <div class="uk-height-1-1">
    </div>


    <script>
        $(document).ready(function() 
		{
			function update_final_subtotal()
			{
				var discount = 0.00;
				var total_input = parseFloat(<?php echo $test_invoice->total; ?>);
				var discount_input = $("#final_discount").val();
				var paid_amount = 0.00;
                var paid_amount_input = $("#paid_amount").val();
					
				var discount_pattern = new RegExp('^([-]?)(([0-9]+)([.])?)?([0-9]+)[%]?$');

				if(discount_input)
				{
					if(discount_pattern.test(discount_input))
					{
						var discount_pct_pattern = new RegExp('^([-]?)(([0-9]+)([.])?)?([0-9]+)[%]$');

						if(discount_pct_pattern.test(discount_input))
						{
							discount = total_input * (parseFloat(discount_input.split('%')[0]) / 100.00);
						}
						else
						{
							discount = parseFloat(discount_input);
						}
					}
				}

				var total = total_input - discount;
				var due = total - paid_amount;

				$("#display_final_discount").text(discount.toFixed(2));
				$("#display_final_subtotal").text(total.toFixed(2));

				var paid_amount_pattern = new RegExp('^[-+]?\\d+(?:[.]\\d+)?$');

				if(paid_amount_input)
				{
					if(paid_amount_pattern.test(paid_amount_input))
					{
						paid_amount = parseFloat(paid_amount_input);
						due = total - paid_amount;

						if(paid_amount >= total)
						{
							$("#display_paid_symbol").html("<span class='uk-margin-small-left uk-icon-button' uk-icon='check' title='Full Paid'></span>");
						}
						else
						{
							$("#display_paid_symbol").empty();
						}
					}
					else
					{
						$("#display_paid_symbol").empty();
					}
				}
				else
				{
					$("#display_paid_symbol").empty();
				}

				$("#display_due").text(due.toFixed(2));
			}

			update_final_subtotal();

			$(document).on("change, keyup", "#final_discount", update_final_subtotal);
            $(document).on("change, keyup", "#paid_amount", update_final_subtotal);

			$('#reset_form').click(function()
            {
				update_final_subtotal();

				setTimeout(function() {
					update_final_subtotal();	
				}, 100);
            });
		})
    </script>

    
</div>