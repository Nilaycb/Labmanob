<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="uk-width-expand uk-padding-small">
    
    <div class="uk-margin-small uk-panel uk-card uk-card-default uk-card-small uk-width-expand">
        
        <div class="uk-card-header">
            <h3 class="uk-card-title">Selected Affiliate Partner</h3> 
        </div>
        <div class="uk-card-body">
            
            <div class="uk-margin-small">
                
                <?php 
                echo '<b>ID</b>: '.$affiliate_partner['id']; 
                echo '<br />'; 
                echo '<b>Name</b>: '.$affiliate_partner['firstname'].' '.$affiliate_partner['lastname']; 
                echo '<br />'; 
                echo '<b>Sex</b>: '.$affiliate_partner['sex']; 
                ?>
                
            </div>
            
        </div>
        <div class="uk-card-footer">
            <div class="uk-margin-small">
                <?php 
                echo anchor('labmanob/upload/affiliate_partner_image/remove_affiliate_partner', 'Remove', array ('class' => 'uk-button uk-button-danger uk-margin-small-right uk-align-left uk-margin-remove-bottom')); 
                
                echo anchor('labmanob/upload/affiliate_partner_image/finish', 'Finish', array ('class' => 'uk-button uk-button-default uk-margin-small-left uk-align-right uk-margin-remove-bottom')); 
                ?>
            </div>
        </div>
        
    </div> 
    
    
    <div class="uk-clearfix">
    </div>
    
    
    <div class="uk-margin-small uk-panel uk-card uk-card-default uk-card-small uk-width-expand">
        
        <div class="uk-card-header">
            <h3 class="uk-card-title">Upload Image</h3> 
        </div>
        <div class="uk-card-body">
            
            <?php 
            if ($this->session->flashdata('message_display')) 
            {
                echo '<div class="uk-alert-primary" uk-alert><a class="uk-alert-close" uk-close></a>'. $this->session->flashdata('message_display') .'</div>';
                if (isset($_SESSION['message_display'])) { unset($_SESSION['message_display']); }
            }

            if(!empty($error_message)) 
            {
                echo '<div class="uk-alert-danger" uk-alert><a class="uk-alert-close" uk-close></a>'. $error_message .'</div>';
            }
            
            echo validation_errors('<div class="uk-alert-danger" uk-alert><a class="uk-alert-close" uk-close></a>', '</div>'); 
            ?>

            <div id="message_container"></div>
            
            <?php 
            echo form_open_multipart('labmanob/upload/affiliate_partner_image/upload_image', array('id' => 'upload_image_form')); 
            ?>
            
            <div class="uk-margin">
                <?php /* usual submission */ ?>
                <!-- <div class="">
                    <?php 
                    // echo form_upload('image_file');
                    // echo form_submit('submit_image', 'Upload', array('class' => 'uk-button uk-button-default')); 
                    ?>
                </div> -->
                
                <?php /* XMLHttpRequest submission */ ?>
                <div class="js-upload uk-placeholder uk-text-center">
                    <span uk-icon="icon: cloud-upload"></span>
                    <span class="uk-text-middle">Attach image by dropping it here or</span>
                    <div uk-form-custom>
                        <?php 
                        echo form_upload('image_file');
                        ?>
                        <span class="uk-link">selecting one</span>
                    </div>
                </div>

                <progress id="js-progressbar" class="uk-progress" value="0" max="100" hidden></progress>
            </div>
            
            <?php 
            echo form_close(); 
            ?> 
            
        </div>
        <div class="uk-card-footer" id="upload_image_card_footer">
            <?php /* ajax has first div depedency, check before making any changes */; ?>
            <div class="uk-margin-small">
                <?php 
                echo anchor('labmanob/upload/affiliate_partner_image', '<span class="" uk-icon="refresh"></span> Refresh', array ('class' => 'uk-button uk-button-default uk-margin-small-right uk-align-left uk-margin-remove-bottom')); 
                
                // echo anchor('labmanob/upload/affiliate_partner_image/finish', 'Finish', array ('class' => 'uk-button uk-button-default uk-margin-small-left uk-align-right uk-margin-remove-bottom')); 
                ?>
            </div>
        </div>
    </div> 
    
    
    <?php if (!empty($uploaded_image_data)): ?>
    <div class="uk-clearfix">
    </div>
    
    
    <div class="uk-margin-small uk-panel uk-card uk-card-default uk-card-small uk-width-expand">
        
        <div class="uk-card-header">
            <h3 class="uk-card-title">Uploaded Image</h3> 
        </div>
        <div class="uk-card-body">
            <?php
                if (!empty($encoded_image_data) && !empty($uploaded_image_data['file_type'])) 
                {
                    echo '<img class="uk-border-rounded uk-responsive-width uk-align-center" style="max-height: 250px;" src="data:'.$uploaded_image_data['file_type'].';base64,'.$encoded_image_data.'" alt="Uploaded Image" />';
                }
                else if (!empty($upload_dir) && !empty($uploaded_image_data['file_name']))
                {
                    echo '<img class="uk-border-rounded uk-responsive-width uk-align-center" style="max-height: 250px;" src="'. base_url().uploads_path().$upload_dir.$uploaded_image_data['file_name'] .'" alt="Uploaded Image" />';
                }
                else 
                {
                    echo '<div class="uk-alert-danger" uk-alert> There was an error! Unable to load the image.</div>';
                }
            ?>
        </div>
        
    </div> 
    <?php endif; ?>

    <div id="uploaded_image_preview_container"></div>
    

    <div class="uk-height-1-1">
    </div> 

    <script>
    $(document).ready(function() 
	{
        var bar = document.getElementById('js-progressbar');
        var message_container = document.getElementById('message_container');
        var uploaded_image_preview_container = document.getElementById('uploaded_image_preview_container');
        var csrf_token_name = '<?php echo $this->security->get_csrf_token_name(); ?>';
        var csrf_token_hash = '<?php echo $this->security->get_csrf_hash(); ?>';
        var response = null;

        function uikit_upload_setup() {
            UIkit.upload('.js-upload', {

            url: '<?php echo site_url('labmanob/upload/affiliate_partner_image/upload_image_xmlhttprequest'); ?>',
            multiple: false,
            name: 'image_file',
            params: { [csrf_token_name] : [csrf_token_hash] },

            beforeSend: function (environment) {
                console.log('beforeSend', arguments);

                console.log(csrf_token_hash);

                // The environment object can still be modified here. 
                // var {data, method, headers, xhr, responseType} = environment;

            },
            beforeAll: function () {
                console.log('beforeAll', arguments);
            },
            load: function () {
                console.log('load', arguments);
            },
            error: function () {
                console.log('error', arguments);
                
                setTimeout(function () {
                    bar.setAttribute('hidden', 'hidden');
                }, 1000);

                message_container.innerHTML = '<div class="uk-alert-danger" uk-alert><a class="uk-alert-close" uk-close></a> There was an error! Refresh and try again.</div>';
            },
            complete: function () {
                console.log('complete', arguments);

                <?php /* to convert to an Array */
                // var args = Array.prototype.slice.call(arguments);
                // console.log(args);
                // console.log(arguments.length);
                ?>
                // console.log(arguments.hasOwnProperty(0));

                if(arguments.hasOwnProperty(0)) 
                {
                    response = JSON.parse(arguments[0].response);
                }

                <?php /* reminder: json boleans need to be checked in lowercase otherwise it will generate ReferenceError */; ?>
                if( (response != null) && response.hasOwnProperty('upload_success') && (response.upload_success == true) && response.hasOwnProperty('message_display') && response.hasOwnProperty('uploaded_image_data') && response.uploaded_image_data.hasOwnProperty('file_name') && response.uploaded_image_data.hasOwnProperty('file_type') && (response.hasOwnProperty('encoded_image_data') || response.hasOwnProperty('upload_dir')) )
                {
                    message_container.innerHTML = '<div class="uk-alert-primary" uk-alert><a class="uk-alert-close" uk-close></a> '+response.message_display+'</div>';

                    <?php /* $('#upload_image_card_footer div:first').append('<a href="<?php echo site_url('labmanob/upload/affiliate_partner_image/finish'); ?>" class="uk-button uk-button-default uk-margin-small-left uk-align-right uk-margin-remove-bottom">Finish</a>'); */; ?>

                    $('<div class="uk-clearfix"></div>').insertBefore(uploaded_image_preview_container);
                    $('#uploaded_image_preview_container').addClass('uk-margin-small uk-panel uk-card uk-card-default uk-card-small uk-width-expand')
                    
                    if(response.hasOwnProperty('encoded_image_data'))
                    {
                        uploaded_image_preview_container.innerHTML = '<div class="uk-card-header">'+
                                                                        '<h3 class="uk-card-title">Uploaded Image</h3> '+
                                                                    '</div>'+
                                                                    '<div class="uk-card-body">'+
                                                                        '<img class="uk-border-rounded uk-responsive-width uk-align-center" style="max-height: 250px;" src="data:'+response.uploaded_image_data.file_type+';base64,'+response.encoded_image_data+'" alt="Uploaded Image" />'+
                                                                    '</div>';
                    }
                    else if (response.hasOwnProperty('upload_dir'))
                    {
                        uploaded_image_preview_container.innerHTML = '<div class="uk-card-header">'+
                                                                        '<h3 class="uk-card-title">Uploaded Image</h3> '+
                                                                    '</div>'+
                                                                    '<div class="uk-card-body">'+
                                                                        '<img class="uk-border-rounded uk-responsive-width uk-align-center" style="max-height: 250px;" src="<?php echo base_url().uploads_path(); ?>'+response.upload_dir+response.uploaded_image_data.file_name+'" alt="Uploaded Image" />'+
                                                                    '</div>';
                    }
                    else 
                    {
                        uploaded_image_preview_container.innerHTML = '<div class="uk-card-header">'+
                                                                        '<h3 class="uk-card-title">Uploaded Image</h3> '+
                                                                    '</div>'+
                                                                    '<div class="uk-card-body">'+
                                                                        '<div class="uk-alert-danger" uk-alert><a class="uk-alert-close" uk-close></a> There was an error! Unable to load the image.</div>'+
                                                                    '</div>';
                    }

                    if(response.hasOwnProperty('csrf_hash'))
                    {
                        csrf_token_hash = response.csrf_hash;
                        console.log(response.csrf_hash);
                    }
                } 
                else if((response != null) && response.hasOwnProperty('upload_success') && (response.upload_success != true) && response.hasOwnProperty('error_message')) 
                {
                    message_container.innerHTML = '<div class="uk-alert-danger" uk-alert><a class="uk-alert-close" uk-close></a> Error! '+response.error_message+'</div>';
                    
                    if(response.hasOwnProperty('csrf_hash'))
                    {
                        csrf_token_hash = response.csrf_hash;
                        console.log(response.csrf_hash);
                    }
                }
                else 
                {
                    message_container.innerHTML = '<div class="uk-alert-danger" uk-alert><a class="uk-alert-close" uk-close></a> There was an error! Refresh and try agian.</div>';
                }
            },

            loadStart: function (e) {
                console.log('loadStart', arguments);

                bar.removeAttribute('hidden');
                bar.max = e.total;
                bar.value = e.loaded;
            },

            progress: function (e) {
                console.log('progress', arguments);

                bar.max = e.total;
                bar.value = e.loaded;
            },

            loadEnd: function (e) {
                console.log('loadEnd', arguments);

                bar.max = e.total;
                bar.value = e.loaded;
            },

            completeAll: function () {
                console.log('completeAll', arguments);

                setTimeout(function () {
                    bar.setAttribute('hidden', 'hidden');
                }, 1000);

                uikit_upload_setup();
            }

            });
        };

        uikit_upload_setup();
    });
</script>
    
</div>