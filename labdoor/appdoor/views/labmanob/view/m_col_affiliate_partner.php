<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="uk-width-expand uk-padding-small">
    
	<div class="uk-margin-small uk-panel uk-card uk-card-default uk-card-small uk-width-expand">

		<?php 
		if ($this->session->flashdata('message_display')) 
		{
			echo '<div class="uk-alert-primary" uk-alert><a class="uk-alert-close" uk-close></a>'. $this->session->flashdata('message_display') .'</div>';
		}
		?>
        
        <div class="uk-card-header">
            <h3 class="uk-card-title">Affiliate Partner Details</h3> 
        </div>
        <div class="uk-card-body">
            
            <div class="uk-margin-small">
                
                <?php
				echo '<b>Affiliate Partner ID</b>: '.$affiliate_partner->id;
				echo '<br />'; 
                echo '<b>Affiliate Partner Name</b>: '.$affiliate_partner->firstname.' '.$affiliate_partner->lastname; 
				echo '<br />'; 
				echo '<b>Sex</b>: '.$affiliate_partner->sex;
                echo '<br />';
                echo '<b>Phone Number(s)</b>: '.$affiliate_partner->phone_no;
                echo '<br />';
                echo '<b>Email</b>: '; echo (!empty($affiliate_partner->email)) ? $affiliate_partner->email : 'N/A'; 
				echo '<br />';
                echo '<b>Current Address</b>: '.$affiliate_partner->current_address.' | <b>Current City</b>: '.$affiliate_partner->current_city; 
				echo '<br />';
                echo '<b>Permanent Address</b>: '; echo (!empty($affiliate_partner->permanent_address)) ? $affiliate_partner->permanent_address : 'N/A';
                echo ' | <b>Permanent City</b>: '; echo (!empty($affiliate_partner->permanent_city)) ? $affiliate_partner->permanent_city : 'N/A'; 
				echo '<br />'; 
				echo '<b>Extra Information</b>: '; echo (!empty($affiliate_partner->extra_info)) ? $affiliate_partner->extra_info : 'N/A'; 
                echo '<br />'; 
				echo '<b>Added</b>: <time datetime="'.mdate("%d-%M-%Y, %h:%i %a", strtotime($affiliate_partner->created)).'">'.mdate("%d-%M-%Y, %h:%i %a", strtotime($affiliate_partner->created)).'</time>';
				echo ' | <b>Modified</b>: <time datetime="'.mdate("%d-%M-%Y, %h:%i %a", strtotime($affiliate_partner->modified)).'">'.mdate("%d-%M-%Y, %h:%i %a", strtotime($affiliate_partner->modified)).'</time>'; 
                ?>
                
            </div>
            
        </div>
        <div class="uk-card-footer">
            <div class="uk-margin-small">
                <?php 
                if( ($this->input->get('ref')) && preg_match('/^labmanob\/view\/test_invoice\/([1-9][0-9]*)?$/', strtolower(trim($this->input->get('ref'), "/")), $ref_matches_array) ) 
                {
                    echo anchor('labmanob/view/test_invoice/'.$ref_matches_array[1], 'Back', array ('class' => 'uk-button uk-button-default uk-margin-small-right uk-align-left uk-margin-remove-bottom')); 
                }
                else 
                {
                    echo anchor('labmanob/view/affiliate_partners', 'Back', array ('class' => 'uk-button uk-button-default uk-margin-small-right uk-align-left uk-margin-remove-bottom')); 
                }
                
                echo ((isset($affiliate_partner->id) && (!empty($affiliate_partner->id))) ? anchor('labmanob/edit/affiliate_partner/index/'.$affiliate_partner->id, 'Edit', array ('class' => 'uk-button uk-button-primary uk-margin-small-left uk-align-right uk-margin-remove-bottom', 'title' => 'Edit Affiliate Partner')) : ""); 
                echo ((isset($affiliate_partner->id) && (!empty($affiliate_partner->id))) ? anchor('labmanob/printing/affiliate_partner/'.$affiliate_partner->id.'/2', 'QR Print', array ('class' => 'uk-button uk-button-default uk-margin-small-left uk-align-right uk-margin-remove-bottom', 'target' => '_blank', 'title' => 'Print with QR Code')) : ""); 
                echo ((isset($affiliate_partner->id) && (!empty($affiliate_partner->id))) ? anchor('labmanob/printing/affiliate_partner/'.$affiliate_partner->id.'/3', 'Image Print', array ('class' => 'uk-button uk-button-default uk-margin-small-left uk-align-right uk-margin-remove-bottom', 'target' => '_blank', 'title' => 'Print with QR code and Affiliate Partner Image')) : ""); 
                ?>
            </div>
        </div>
        
    </div>  
    
    
    <?php if (!empty($affiliate_partner_image_data)): ?>
    <div class="uk-clearfix">
    </div>
    
    
    <div class="uk-margin-small uk-panel uk-card uk-card-default uk-card-small uk-width-expand">
        
        <div class="uk-card-header">
            <h3 class="uk-card-title">Affiliate Partner Image</h3> 
        </div>
        <div class="uk-card-body">
            <?php
                if (!empty($encoded_affiliate_partner_image_data) && !empty($affiliate_partner_image_data['file_type'])) 
                {
                    echo '<img class="uk-border-rounded uk-responsive-width uk-align-center" style="max-height: 250px;" src="data:'.$affiliate_partner_image_data['file_type'].';base64,'.$encoded_affiliate_partner_image_data.'" alt="Affiliate Partner Image" />';
                }
                else if (isset($affiliate_partner_image_data['encode_level']) && ($affiliate_partner_image_data['encode_level'] == 0) && !empty($affiliate_partner_image_data['file_path']) && !empty($affiliate_partner_image_data['file_name']))
                {
                    echo '<img class="uk-border-rounded uk-responsive-width uk-align-center" style="max-height: 250px;" src="'. base_url().uploads_path().$affiliate_partner_image_data['file_path'].$affiliate_partner_image_data['file_name'] .'" alt="Affiliate Partner Image" />';
                }
                else 
                {
                    echo '<div class="uk-alert-danger" uk-alert> There was an error! Unable to load the image.</div>';
                }
            ?>
        </div>
        
    </div> 
    <?php endif; ?>
    
    
    
    <div class="uk-height-1-1">
    </div>

    
</div>