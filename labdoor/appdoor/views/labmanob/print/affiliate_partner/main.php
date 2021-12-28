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
                echo '<b>Affiliate Partner ID</b>: '.$affiliate_partner->id.' | <b>Added</b>: <time datetime="'.date("F d, Y h:i a", strtotime($affiliate_partner->created)).'">'.date("F d, Y", strtotime($affiliate_partner->created)).'</time>'; 
				echo '<br />'; 
                echo '<b>Affiliate Partner Name</b>: '.$affiliate_partner->firstname.' '.$affiliate_partner->lastname; 
				echo ' | <b>Sex</b>: '.$affiliate_partner->sex;
                echo '<br />';
                echo '<b>Phone Number(s)</b>: '.$affiliate_partner->phone_no;
                echo '<br />';
                if(!empty($affiliate_partner->email)) 
                { 
                    echo '<b>Email</b>: '.$affiliate_partner->email;
                    echo '<br />';
                } 
                echo '<b>Current Address</b>: '.$affiliate_partner->current_address.' | <b>Current City</b>: '.$affiliate_partner->current_city; 
				echo '<br />';
                if(!empty($affiliate_partner->permanent_address)) 
                { 
                    echo '<b>Permanent Address</b>: '.$affiliate_partner->permanent_address;
                    echo (!empty($affiliate_partner->permanent_city)) ? ' | ' : '<br />';
                } 
                if(!empty($affiliate_partner->permanent_city)) 
                { 
                    echo '<b>Permanent City</b>: '.$affiliate_partner->permanent_city;
                    echo '<br />';
                } 
                if(!empty($affiliate_partner->extra_info)) 
                { 
                    echo '<b>Extra Information</b>: '.$affiliate_partner->extra_info;
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
                if (!empty($encoded_affiliate_partner_image_data) && !empty($affiliate_partner_image_data['file_type'])) 
                {
                    echo '<img class="uk-border-rounded uk-responsive-width" style="max-height: 95px;" src="data:'.$affiliate_partner_image_data['file_type'].';base64,'.$encoded_affiliate_partner_image_data.'" alt="Affiliate Partner Image" />';
                }
                else if (isset($affiliate_partner_image_data['encode_level']) && ($affiliate_partner_image_data['encode_level'] == 0) && !empty($affiliate_partner_image_data['file_path']) && !empty($affiliate_partner_image_data['file_name']))
                {
                    echo '<img class="uk-border-rounded uk-responsive-width" style="max-height: 95px;" src="'. base_url().uploads_path().$affiliate_partner_image_data['file_path'].$affiliate_partner_image_data['file_name'] .'" alt="Affiliate Partner Image" />';
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