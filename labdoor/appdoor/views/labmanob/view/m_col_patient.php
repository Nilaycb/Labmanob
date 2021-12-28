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
            <h3 class="uk-card-title">Patient Details</h3> 
        </div>
        <div class="uk-card-body">
            
            <div class="uk-margin-small">
                
                <?php
				echo '<b>Patient ID</b>: '.$patient->id;
				echo '<br />'; 
                echo '<b>Patient Name</b>: '.$patient->firstname.' '.$patient->lastname; 
				echo '<br />'; 
				echo '<b>Sex</b>: '.$patient->sex;
                echo '<br />';
                echo '<b>Phone Number(s)</b>: '.$patient->phone_no;
                echo '<br />';
                echo '<b>Email</b>: '; echo (!empty($patient->email)) ? $patient->email : 'N/A'; 
				echo '<br />';
                echo '<b>Current Address</b>: '.$patient->current_address.' | <b>Current City</b>: '.$patient->current_city; 
				echo '<br />';
                echo '<b>Permanent Address</b>: '; echo (!empty($patient->permanent_address)) ? $patient->permanent_address : 'N/A';
                echo ' | <b>Permanent City</b>: '; echo (!empty($patient->permanent_city)) ? $patient->permanent_city : 'N/A'; 
				echo '<br />'; 
				echo '<b>Extra Information</b>: '; echo (!empty($patient->extra_info)) ? $patient->extra_info : 'N/A'; 
                echo '<br />'; 
				echo '<b>Added</b>: <time datetime="'.mdate("%d-%M-%Y, %h:%i %a", strtotime($patient->created)).'">'.mdate("%d-%M-%Y, %h:%i %a", strtotime($patient->created)).'</time>';
				echo ' | <b>Modified</b>: <time datetime="'.mdate("%d-%M-%Y, %h:%i %a", strtotime($patient->modified)).'">'.mdate("%d-%M-%Y, %h:%i %a", strtotime($patient->modified)).'</time>'; 
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
                    echo anchor('labmanob/view/patients', 'Back', array ('class' => 'uk-button uk-button-default uk-margin-small-right uk-align-left uk-margin-remove-bottom')); 
                }

                echo ((isset($patient->id) && (!empty($patient->id))) ? anchor('labmanob/edit/patient/index/'.$patient->id, 'Edit', array ('class' => 'uk-button uk-button-primary uk-margin-small-left uk-align-right uk-margin-remove-bottom', 'title' => 'Edit Patient')) : ""); 
                echo ((isset($patient->id) && (!empty($patient->id))) ? anchor('labmanob/printing/patient/'.$patient->id.'/2', 'QR Print', array ('class' => 'uk-button uk-button-default uk-margin-small-left uk-align-right uk-margin-remove-bottom', 'target' => '_blank', 'title' => 'Print with QR Code')) : ""); 
                echo ((isset($patient->id) && (!empty($patient->id))) ? anchor('labmanob/printing/patient/'.$patient->id.'/3', 'Image Print', array ('class' => 'uk-button uk-button-default uk-margin-small-left uk-align-right uk-margin-remove-bottom', 'target' => '_blank', 'title' => 'Print with QR code and Patient Image')) : ""); 
                ?>
            </div>
        </div>
        
    </div>  
    
    
    <?php if (!empty($patient_image_data)): ?>
    <div class="uk-clearfix">
    </div>
    
    
    <div class="uk-margin-small uk-panel uk-card uk-card-default uk-card-small uk-width-expand">
        
        <div class="uk-card-header">
            <h3 class="uk-card-title">Patient Image</h3> 
        </div>
        <div class="uk-card-body">
            <?php
                if (!empty($encoded_patient_image_data) && !empty($patient_image_data['file_type'])) 
                {
                    echo '<img class="uk-border-rounded uk-responsive-width uk-align-center" style="max-height: 250px;" src="data:'.$patient_image_data['file_type'].';base64,'.$encoded_patient_image_data.'" alt="Patient Image" />';
                }
                else if (isset($patient_image_data['encode_level']) && ($patient_image_data['encode_level'] == 0) && !empty($patient_image_data['file_path']) && !empty($patient_image_data['file_name']))
                {
                    echo '<img class="uk-border-rounded uk-responsive-width uk-align-center" style="max-height: 250px;" src="'. base_url().uploads_path().$patient_image_data['file_path'].$patient_image_data['file_name'] .'" alt="Patient Image" />';
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