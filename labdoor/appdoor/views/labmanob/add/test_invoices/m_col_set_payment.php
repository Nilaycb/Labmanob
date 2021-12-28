<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="uk-width-expand uk-padding-small">
    
    <div class="uk-margin-small uk-panel uk-card uk-card-default uk-card-small uk-width-expand">
        
        <div class="uk-card-header">
            <h3 class="uk-card-title">Selected Patient</h3> 
        </div>
        <div class="uk-card-body">
            
            <div class="uk-margin-small">
                
                <?php 
                echo '<b>ID</b>: '.$_SESSION['test_invoice__patient']['id']; 
                echo '<br />'; 
                echo '<b>Name</b>: '.$_SESSION['test_invoice__patient']['firstname'].' '.$_SESSION['test_invoice__patient']['lastname']; 
                echo '<br />'; 
                echo '<b>Sex</b>: '.$_SESSION['test_invoice__patient']['sex']; 
                ?>
                
            </div>
            
        </div>
        <div class="uk-card-footer">
            <div class="uk-margin-small">
                <?php 
                echo anchor('labmanob/add/new_test_invoice/remove_patient', 'Remove', array ('class' => 'uk-button uk-button-danger uk-margin-small-right uk-align-left uk-margin-remove-bottom')); 
                ?>
            </div>
        </div>
        
    </div> 
    
    
    <div class="uk-clearfix">
    </div>
    
    
    <div class="uk-margin-small uk-panel uk-card uk-card-default uk-card-small uk-width-expand">
        
        <?php 
		echo form_open('labmanob/add/new_test_invoice/set_payment');
		?>

        <div class="uk-card-header">
            <h3 class="uk-card-title">Tests Cart</h3> 
        </div>
        <div class="uk-card-body">
            <?php 
            if (isset($payment_table))
            { 
                echo '<div class="uk-overflow-auto">'; 
                echo $payment_table; 
                echo '</div>'; 
                echo '<hr class="uk-devider-icon" />';

                if(!empty($error_message)) 
		    	{
		    		echo '<div class="uk-alert-danger" uk-alert><a class="uk-alert-close" uk-close></a>'. $error_message .'</div>';
		    	}
                echo validation_errors('<div class="uk-alert-danger" uk-alert><a class="uk-alert-close" uk-close></a>', '</div>');

                echo '<p>';
				echo 'Total: '.sprintf("%.2f", (float)$final_total).'';
				echo ' | Discount: <span id="display_final_discount">0.00</span>';
				echo ' | <b>Subtotal: <span id="display_final_subtotal">'.sprintf("%.2f", (float)$final_total).'</span></b><span id="display_paid_symbol"></span>';
				echo '</p>';

                echo '<div class="uk-inline">';
				//echo form_label('Discount', 'final_discount', array('class' => 'uk-form-label uk-margin-small-right')); 
				echo form_input('final_discount', set_value('final_discount'), array('id' => 'final_discount', 'class' => 'uk-input uk-form-width-medium', 'placeholder' => 'Discount', 'maxlength' => '9'));
				if (form_error('final_discount')) 
				{
					echo '<span class="uk-margin-small-left uk-margin-small-right gs-uk-alert-danger-color" uk-icon="icon: warning"></span>';
				}
				echo '</div><br />';
				
				echo '<div class="uk-inline uk-margin-small-top">';
				//echo form_label('Discount By', 'final_discount_by', array('class' => 'uk-form-label uk-margin-small-right')); 
				echo form_input('final_discount_by', set_value('final_discount_by'), array('class' => 'uk-input uk-form-width-medium', 'placeholder' => 'Discount By', 'maxlength' => '200'));
				if (form_error('final_discount_by')) 
				{
					echo '<span class="uk-margin-small-left uk-margin-small-right gs-uk-alert-danger-color" uk-icon="icon: warning"></span>';
				}
                echo '</div><br />';

                echo '<div class="uk-inline uk-margin-small-top">';
				//echo form_label('Paid Amount', 'paid_amount', array('class' => 'uk-form-label uk-margin-small-right')); 
				echo form_input('paid_amount', set_value('paid_amount'), array('id' => 'paid_amount', 'class' => 'uk-input uk-form-width-medium', 'placeholder' => 'Paid Amount', 'maxlength' => '15'));
				if (form_error('paid_amount')) 
				{
					echo '<span class="uk-margin-small-left uk-margin-small-right gs-uk-alert-danger-color" uk-icon="icon: warning"></span>';
				}
                echo '</div><br />';

                echo '<hr class="uk-devider-icon" />';
                
                echo '<div class="uk-inline">';
				//echo form_label('Patient Age', 'patient_age', array('class' => 'uk-form-label uk-margin-small-right')); 
				echo form_input('patient_age', set_value('patient_age'), array('class' => 'uk-input uk-form-width-medium', 'placeholder' => 'Patient\'s Age', 'maxlength' => '3'));
				if (form_error('patient_age')) 
				{
					echo '<span class="uk-margin-small-left uk-margin-small-right gs-uk-alert-danger-color" uk-icon="icon: warning"></span>';
				}
                echo '</div><br />';
                
                echo '<div class="uk-inline uk-margin-small-top">';
				//echo form_label('Ref By', 'ref_by', array('class' => 'uk-form-label uk-margin-small-right')); 
				echo form_input('ref_by', set_value('ref_by'), array('class' => 'uk-input uk-form-width-medium', 'placeholder' => 'Ref By', 'maxlength' => '200', 'id' => 'ref_by'));
				if (form_error('ref_by')) 
				{
					echo '<span class="uk-margin-small-left uk-margin-small-right gs-uk-alert-danger-color" uk-icon="icon: warning"></span>';
				}
                echo '</div><br />';
                
                echo '<div class="uk-inline uk-margin-small-top">';
				//echo form_label('Affiliate Partner ID', 'affiliate_partner_id', array('class' => 'uk-form-label uk-margin-small-right')); 
				echo form_input('affiliate_partner_id', set_value('affiliate_partner_id', 1), array('class' => 'uk-input uk-form-width-medium', 'placeholder' => 'Affiliate Partner ID', 'maxlength' => '11', 'id' => 'affiliate_partner_id'));
				if (form_error('affiliate_partner_id')) 
				{
					echo '<span class="uk-margin-small-left uk-margin-small-right gs-uk-alert-danger-color" uk-icon="icon: warning"></span>';
				}
                echo '</div><br />';
                
                echo '<div class="uk-inline uk-margin-small-top">';
				//echo form_label('Extra Information', 'extra_info', array('class' => 'uk-form-label uk-margin-small-right')); 
				echo form_textarea(array('name' => 'extra_info', 'rows' => '5'), set_value('extra_info'), array('class' => 'uk-textarea uk-form-width-large uk-form-large', 'placeholder' => 'Extra Information', 'maxlength' => '255'));
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
                echo anchor('labmanob/add/new_test_invoice/set_tests_records', 'Back', array ('class' => 'uk-button uk-button-default uk-margin-small-right uk-align-left uk-margin-remove-bottom')); 
				echo form_submit('submit', 'Finish', array('class' => 'uk-button uk-button-primary uk-margin-small-left uk-align-right uk-margin-remove-bottom')); 
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
				var total_input = parseFloat(<?php echo $final_total; ?>);
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

				$("#display_final_discount").text(discount.toFixed(2));
				$("#display_final_subtotal").text(total.toFixed(2));

				var paid_amount_pattern = new RegExp('^[-+]?\\d+(?:[.]\\d+)?$');

				if(paid_amount_input)
				{
					if(paid_amount_pattern.test(paid_amount_input))
					{
						paid_amount = parseFloat(paid_amount_input);

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
			}

			update_final_subtotal();

			$(document).on("change, keyup", "#final_discount", update_final_subtotal);
            $(document).on("change, keyup", "#paid_amount", update_final_subtotal);

			<?php 
			$external_optional_settings_dir = $this->config->item('labmanob_external_path', 'labmanob').$this->config->item('labmanob_settings_optional_dir', 'labmanob');
			$ref_by_suggestions_file_name = 'ref_by_suggestions';
			$ref_by_suggestions_file_path = $external_optional_settings_dir.$ref_by_suggestions_file_name;
			
			if(file_exists($ref_by_suggestions_file_path) && is_file($ref_by_suggestions_file_path)) 
			{
				$ref_by_suggestions_file_contents = file_get_contents($ref_by_suggestions_file_path);
				
				$this->load->helper('security');

				$ref_by_suggestions_file_contents = xss_clean($ref_by_suggestions_file_contents);
				$ref_by_suggestions_file_contents_array = explode(PHP_EOL, $ref_by_suggestions_file_contents);
				$ref_by_suggestions_file_contents_array = array_filter($ref_by_suggestions_file_contents_array, function($a) {
					return trim($a) !== "";
				});

				echo 'var ref_by_suggestions = [ ';
				foreach ($ref_by_suggestions_file_contents_array as $ref_by_suggestion) {
					echo '"'.$ref_by_suggestion.'",';
				}
				echo ' ];';
			}
			else 
			{
				echo 'var ref_by_suggestions = [];';
			}
			?>

			$("#ref_by").autocomplete({
				source: ref_by_suggestions
			});
		});
    </script>

    
</div>