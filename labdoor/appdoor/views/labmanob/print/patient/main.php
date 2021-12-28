<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="uk-margin-small uk-width-expand">
    
    <div class="">
        
        <div class="">
            <h3 class="uk-card-title"><img height="50" width="50" src="<?php echo assets_url().uploads_dir().'logo/'.$this->config->item('business_entity_logo_file_name', 'labmanob'); ?>" /> <?php echo $this->config->item('business_entity_name', 'labmanob'); ?></h3> 
        </div>
        <div class="">
            
            <div class="">
                
				<?php 
                echo '<b>Patient ID</b>: '.$patient->id.' | <b>Added</b>: <time datetime="'.date("F d, Y h:i a", strtotime($patient->created)).'">'.date("F d, Y", strtotime($patient->created)).'</time>'; 
				echo '<br />'; 
                echo '<b>Patient Name</b>: '.$patient->firstname.' '.$patient->lastname; 
				echo ' | <b>Sex</b>: '.$patient->sex;
                echo '<br />';
                echo '<b>Phone Number(s)</b>: '.$patient->phone_no;
                echo '<br />';
                if(!empty($patient->email)) 
                { 
                    echo '<b>Email</b>: '.$patient->email;
                    echo '<br />';
                } 
                echo '<b>Current Address</b>: '.$patient->current_address.' | <b>Current City</b>: '.$patient->current_city; 
				echo '<br />';
                if(!empty($patient->permanent_address)) 
                { 
                    echo '<b>Permanent Address</b>: '.$patient->permanent_address;
                    echo (!empty($patient->permanent_city)) ? ' | ' : '<br />';
                } 
                if(!empty($patient->permanent_city)) 
                { 
                    echo '<b>Permanent City</b>: '.$patient->permanent_city;
                    echo '<br />';
                } 
                if(!empty($patient->extra_info)) 
                { 
                    echo '<b>Extra Information</b>: '.$patient->extra_info;
                    echo '<br />';
                } 
                ?>
                <time class="uk-text-meta uk-margin-remove-bottom" datetime="<?php echo mdate("%d-%M-%Y, %h:%i %a", now()); ?>"><?php echo mdate("%d-%M-%Y, %h:%i %a", now()); ?></time>
                
            </div>
            
        </div>
        
    </div> 
    
    
    <div class="uk-clearfix">
    </div>
    
    
    <div class="uk-margin-small uk-width-expand">

        <div class="uk-flex uk-flex-middle">

            <?php if(isset($print_level) && ($print_level != 1) && isset($qrCodeUrl)) : ?>
            <div class="uk-padding-small">
                <img class="uk-responsive-width" src="<?php echo $qrCodeUrl; ?>" />
            </div>
            <?php endif; ?>

            <?php if(isset($print_level) && ($print_level == 3 )) : ?>
            <div class="uk-padding-small">
                <?php
                if (!empty($encoded_patient_image_data) && !empty($patient_image_data['file_type'])) 
                {
                    echo '<img class="uk-border-rounded uk-responsive-width" style="max-height: 95px;" src="data:'.$patient_image_data['file_type'].';base64,'.$encoded_patient_image_data.'" alt="Patient Image" />';
                }
                else if (isset($patient_image_data['encode_level']) && ($patient_image_data['encode_level'] == 0) && !empty($patient_image_data['file_path']) && !empty($patient_image_data['file_name']))
                {
                    echo '<img class="uk-border-rounded uk-responsive-width" style="max-height: 95px;" src="'. base_url().uploads_path().$patient_image_data['file_path'].$patient_image_data['file_name'] .'" alt="Patient Image" />';
                }
                else 
                {
                    // echo '<div class="uk-alert-danger" uk-alert> There was an error! Unable to load the image.</div>';
                }
                ?>
            </div>
            <?php endif; ?>

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