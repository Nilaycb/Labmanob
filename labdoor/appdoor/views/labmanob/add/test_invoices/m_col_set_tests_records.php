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
        
        <div class="uk-card-header">
            <h3 class="uk-card-title">Selected Tests</h3> 
        </div>
        <div class="uk-card-body">
		
			<ol>
		
				<?php 
				
				foreach ($this->cart->contents() as $test_key => $test_items)
				{
					echo '<li>'.$test_items["name"].'</li>';
				}
				
				?>
			
			</ol>
            
        </div>
		<div class="uk-card-footer">
            <div class="uk-margin-small">
                <?php 
                echo anchor('labmanob/add/new_test_invoice/select_tests', 'Back', array ('class' => 'uk-button uk-button-default uk-margin-small-right uk-align-left uk-margin-remove-bottom')); 
                ?>
            </div>
        </div>
        
    </div> 
	
	
	<div class="uk-clearfix">
    </div>
    
    
    <div class="uk-margin-small uk-panel uk-card uk-card-default uk-card-small uk-width-expand">
        
		<?php 
		echo form_open('labmanob/add/new_test_invoice/set_tests_records');
		?>
		
        <div class="uk-card-header">
            <h3 class="uk-card-title">Advanced Options</h3> 
        </div>
        <div class="uk-card-body">
		
			<?php 
			
			if(!empty($error_message)) 
			{
				echo '<div class="uk-alert-danger" uk-alert><a class="uk-alert-close" uk-close></a>'. $error_message .'</div>';
			}
			
			echo validation_errors('<div class="uk-alert-danger" uk-alert><a class="uk-alert-close" uk-close></a>', '</div>'); 
			
			
			$count_tests_array = count($this->cart->contents());
			if (count($this->cart->contents()) > 1) 
			{
				$i = 1;
				
				foreach ($this->cart->contents() as $test_key => $test_item)
				{
					
					echo '<p>';
					echo $i.'. <b>'.$test_item["name"].'</b>';
					echo '<br />';
					echo 'Price '.$test_item["price"].' | Quantity <span id="display_quantity_rowid_'.$test_item["rowid"].'">'.$test_item["qty"].'</span>';
					echo ' | Discount <span id="display_discount_rowid_'.$test_item["rowid"].'">'.(!empty($test_item["discount"]) ? sprintf("%.2f", (float)$test_item["discount"]) : "0.00").'</span>';
					echo ' | Total <span id="display_total_rowid_'.$test_item["rowid"].'">'.($test_item["subtotal"] - func__discount__calc($test_item["discount"], $test_item["subtotal"])).'</span>';
					echo '</p>';
					echo form_hidden('rowid_of_test_id_'.$test_item["test_id"], $test_item['rowid']);
					
					echo '<div class="uk-inline">';
					//echo form_label('Quantity', 'quantity_of_test_id_'.$test_item["test_id"].'', array('class' => 'uk-form-label uk-margin-small-right')); 
					echo form_input('quantity_of_test_id_'.$test_item["test_id"].'', set_value('quantity_of_test_id_'.$test_item["test_id"], $test_item["qty"]), array('id' => 'quantity_of_rowid_'.$test_item["rowid"], 'class' => 'uk-input uk-form-width-medium', 'placeholder' => 'Quantity', 'maxlength' => '9'));
					if (form_error('quantity_of_test_id_'.$test_item["test_id"].'')) 
					{
						echo '<span class="uk-margin-small-left uk-margin-small-right gs-uk-alert-danger-color" uk-icon="icon: warning"></span>';
					}
					echo '</div><br />';
					
					echo '<div class="uk-inline uk-margin-small-top">';
					//echo form_label('Discount', 'discount_on_test_id_'.$test_item["test_id"].'', array('class' => 'uk-form-label uk-margin-small-right')); 
					echo form_input('discount_on_test_id_'.$test_item["test_id"].'', set_value('discount_on_test_id_'.$test_item["test_id"], $test_item["discount"]), array('id' => 'discount_on_rowid_'.$test_item["rowid"], 'class' => 'uk-input uk-form-width-medium', 'placeholder' => 'Discount', 'maxlength' => '9'));
					if (form_error('discount_on_test_id_'.$test_item["test_id"].'')) 
					{
						echo '<span class="uk-margin-small-left uk-margin-small-right gs-uk-alert-danger-color" uk-icon="icon: warning"></span>';
					}
					echo '</div><br />';
					
					echo '<div class="uk-inline uk-margin-small-top">';
					//echo form_label('Discount By', 'discount_by_on_test_id_'.$test_item["test_id"].'', array('class' => 'uk-form-label uk-margin-small-right')); 
					echo form_input('discount_by_on_test_id_'.$test_item["test_id"].'', set_value('discount_by_on_test_id_'.$test_item["test_id"], $test_item["discount_by"]), array('class' => 'uk-input uk-form-width-medium', 'placeholder' => 'Discount By', 'maxlength' => '255'));
					if (form_error('discount_by_on_test_id_'.$test_item["test_id"].'')) 
					{
						echo '<span class="uk-margin-small-left uk-margin-small-right gs-uk-alert-danger-color" uk-icon="icon: warning"></span>';
					}
					echo '</div><br />';
					
					if ($i <= ($count_tests_array - 1)) 
					{
						echo '<hr class="uk-devider-icon" />';
					}
					
					$i += 1;
					
				}
				
			}
			else 
			{
				$i = 1;

				foreach ($this->cart->contents() as $test_key => $test_item)
				{
					echo '<p>';
					echo $i.'. <b>'.$test_item["name"].'</b>';
					echo '<br />';
					echo 'Price '.$test_item["price"].' | Quantity <span id="display_quantity_rowid_'.$test_item["rowid"].'">'.$test_item["qty"].'</span>';
					echo ' | Discount <span id="display_discount_rowid_'.$test_item["rowid"].'">'.(!empty($test_item["discount"]) ? sprintf("%.2f", (float)$test_item["discount"]) : "0.00").'</span>';
					echo ' | Total <span id="display_total_rowid_'.$test_item["rowid"].'">'.($test_item["subtotal"] - func__discount__calc($test_item["discount"], $test_item["subtotal"])).'</span>';
					echo '</p>';
					echo form_hidden('rowid_of_test_id_'.$test_item["test_id"], $test_item['rowid']);
					
					echo '<div class="uk-inline">';
					//echo form_label('Quantity', 'quantity_of_test_id_'.$test_item["test_id"].'', array('class' => 'uk-form-label uk-margin-small-right')); 
					echo form_input('quantity_of_test_id_'.$test_item["test_id"].'', set_value('quantity_of_test_id_'.$test_item["test_id"], $test_item["qty"]), array('id' => 'quantity_of_rowid_'.$test_item["rowid"], 'class' => 'uk-input uk-form-width-medium', 'placeholder' => 'Quantity', 'maxlength' => '9'));
					if (form_error('quantity_of_test_id_'.$test_item["test_id"].'')) 
					{
						echo '<span class="uk-margin-small-left uk-margin-small-right gs-uk-alert-danger-color" uk-icon="icon: warning"></span>';
					}
					echo '</div><br />';
					
					echo '<div class="uk-inline uk-margin-small-top">';
					//echo form_label('Discount', 'discount_on_test_id_'.$test_item["test_id"].'', array('class' => 'uk-form-label uk-margin-small-right')); 
					echo form_input('discount_on_test_id_'.$test_item["test_id"].'', set_value('discount_on_test_id_'.$test_item["test_id"], $test_item["discount"]), array('id' => 'discount_on_rowid_'.$test_item["rowid"], 'class' => 'uk-input uk-form-width-medium', 'placeholder' => 'Discount', 'maxlength' => '9'));
					if (form_error('discount_on_test_id_'.$test_item["test_id"].'')) 
					{
						echo '<span class="uk-margin-small-left uk-margin-small-right gs-uk-alert-danger-color" uk-icon="icon: warning"></span>';
					}
					echo '</div><br />';
					
					echo '<div class="uk-inline uk-margin-small-top">';
					//echo form_label('Discount By', 'discount_by_on_test_id_'.$test_item["test_id"].'', array('class' => 'uk-form-label uk-margin-small-right')); 
					echo form_input('discount_by_on_test_id_'.$test_item["test_id"].'', set_value('discount_by_on_test_id_'.$test_item["test_id"], $test_item["discount_by"]), array('class' => 'uk-input uk-form-width-medium', 'placeholder' => 'Discount By', 'maxlength' => '255'));
					if (form_error('discount_by_on_test_id_'.$test_item["test_id"].'')) 
					{
						echo '<span class="uk-margin-small-left uk-margin-small-right gs-uk-alert-danger-color" uk-icon="icon: warning"></span>';
					}
					echo '</div><br />';
				}
			}
				
			?>
            
        </div>
		<div class="uk-card-footer">
            <div class="uk-margin-small">
                <?php 
                echo anchor('labmanob/add/new_test_invoice/select_tests', 'Back', array ('class' => 'uk-button uk-button-default uk-margin-small-right uk-align-left uk-margin-remove-bottom')); 
				echo form_submit('submit', 'Next', array('class' => 'uk-button uk-button-primary uk-margin-small-left uk-align-right uk-margin-remove-bottom')); 
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
			<?php 
			foreach ($this->cart->contents() as $test_key => $test_item) 
			{
			?>
				function updateTotal_<?php echo $test_item["rowid"]; ?>()
				{
					var qty = 1.00;
					var discount = 0.00;
					var qty_input = $("#quantity_of_rowid_<?php echo $test_item["rowid"]; ?>").val();
					
					if(qty_input)
					{
						var qty_pattern = new RegExp('^(([0-9]+)([.])?)?([0-9]+)$');
						if(qty_pattern.test(qty_input))
						{
							if(parseFloat(qty_input) > 0)
							{
								qty = parseFloat(qty_input);
							}
						}
					}

					var total_input = parseFloat(<?php echo $test_item["price"]; ?>) * qty;
					var discount_input = $("#discount_on_rowid_<?php echo $test_item["rowid"]; ?>").val();
					
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

					$("#display_quantity_rowid_<?php echo $test_item["rowid"]; ?>").text(qty.toFixed(2));
					$("#display_discount_rowid_<?php echo $test_item["rowid"]; ?>").text(discount.toFixed(2));
					$("#display_total_rowid_<?php echo $test_item["rowid"]; ?>").text(total.toFixed(2));
				}

				updateTotal_<?php echo $test_item["rowid"]; ?>();

				$(document).on("change, keyup", "#quantity_of_rowid_<?php echo $test_item["rowid"]; ?>", updateTotal_<?php echo $test_item["rowid"]; ?>);
				$(document).on("change, keyup", "#discount_on_rowid_<?php echo $test_item["rowid"]; ?>", updateTotal_<?php echo $test_item["rowid"]; ?>);
			<?php 
			}
			?>
		})
    </script>

    
</div>