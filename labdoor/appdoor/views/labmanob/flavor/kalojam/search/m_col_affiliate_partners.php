<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="uk-width-expand uk-padding-small">
    
    <div class="uk-panel uk-margin-small uk-card uk-card-default uk-card-small uk-width-expand">
        
        <div class="uk-card-header">
            <h3 class="uk-card-title"><span uk-search-icon></span> Search Affiliate Partners</h3> 
        </div>
        <div class="uk-card-body">
            
            <?php 
            if(!empty($error_message)) 
            {
                echo '<div class="uk-alert-danger" uk-alert><a class="uk-alert-close" uk-close></a>'. $error_message .'</div>';
            }
            
            echo validation_errors('<div class="uk-alert-danger" uk-alert><a class="uk-alert-close" uk-close></a>', '</div>'); 
            ?>
            
            <form id="search_affiliate_partners_form" action="<?php echo site_url('labmanob/flavor/kalojam/search/affiliate_partners/query'); ?>" method="get" accept-charset="utf-8">
            
            <div class="uk-margin">
                <div class="uk-inline">
                    <?php 
                    echo form_label('Affiliate Partner ID', 'affiliate_partner_id', array('class' => 'uk-form-label'));
                    if (form_error('affiliate_partner_id')) 
                    {
                        echo '<span class="uk-margin-small-left uk-margin-small-right gs-uk-alert-danger-color" uk-icon="icon: warning"></span>';
                    }
                    ?>
                </div>
                <br />
                <div class="uk-inline">
                    <?php 
                    echo form_input('affiliate_partner_id', set_value('affiliate_partner_id'), array('class' => 'uk-input uk-form-width-large uk-form-large', 'placeholder' => 'Affiliate Partner ID', 'maxlength' => '11', 'id' => 'affiliate_partner_id'));
                    ?>
                </div>
            </div>

            <div class="uk-margin">
                <div class="uk-inline">
                    <?php 
                    echo form_label('Affiliate Partner Name', 'affiliate_partner_name', array('class' => 'uk-form-label'));
                    if (form_error('affiliate_partner_name')) 
                    {
                        echo '<span class="uk-margin-small-left uk-margin-small-right gs-uk-alert-danger-color" uk-icon="icon: warning"></span>';
                    }
                    ?>
                </div>
                <br />
                <div class="uk-inline">
                    <?php 
                    echo form_input('affiliate_partner_name', set_value('affiliate_partner_name'), array('class' => 'uk-input uk-form-width-large uk-form-large', 'placeholder' => 'Affiliate Partner Name', 'maxlength' => '150', 'id' => 'affiliate_partner_name'));
                    ?>
                </div>
            </div>

            <div class="uk-margin">
                <div class="uk-inline">
                    <?php 
                    echo form_label('Phone Number', 'phone_no', array('class' => 'uk-form-label'));
                    if (form_error('phone_no')) 
                    {
                        echo '<span class="uk-margin-small-left uk-margin-small-right gs-uk-alert-danger-color" uk-icon="icon: warning"></span>';
                    }
                    ?>
                </div>
                <br />
                <div class="uk-inline">
                    <?php 
                    echo form_input('phone_no', set_value('phone_no'), array('class' => 'uk-input uk-form-width-large uk-form-large', 'placeholder' => 'Phone Number', 'maxlength' => '150', 'id' => 'phone_no'));
                    ?>
                </div>
            </div>
            
            <div class="uk-margin">
                <div class="uk-inline">
                    <?php 
                    echo form_label('Email', 'email', array('class' => 'uk-form-label')); 
                    if (form_error('email')) 
                    {
                        echo '<span class="uk-margin-small-left uk-margin-small-right gs-uk-alert-danger-color" uk-icon="icon: warning"></span>';
                    }
                    ?>
                </div>
                <br />
                <div class="uk-inline">
                    <?php 
                    echo form_input('email', set_value('email'), array('class' => 'uk-input uk-form-width-large uk-form-large', 'placeholder' => 'Email', 'maxlength' => '150', 'id' => 'email'));
                    ?>
                </div>
            </div>
            
            <div class="uk-margin">
                <div class="uk-inline">
                    <?php 
                    echo form_label('Current Address', 'current_address', array('class' => 'uk-form-label')); 
                    if (form_error('current_address')) 
                    {
                        echo '<span class="uk-margin-small-left uk-margin-small-right gs-uk-alert-danger-color" uk-icon="icon: warning"></span>';
                    }
                    ?>
                </div>
                <br />
                <div class="uk-inline">
                    <?php 
                    echo form_input('current_address', set_value('current_address'), array('class' => 'uk-input uk-form-width-large uk-form-large', 'placeholder' => 'Current Address', 'maxlength' => '255', 'id' => 'current_address'));
                    ?>
                </div>
            </div>
            
            <div class="uk-margin">
                <div class="uk-inline">
                    <?php 
                    echo form_label('Current City', 'current_city', array('class' => 'uk-form-label')); 
                    if (form_error('current_city')) 
                    {
                        echo '<span class="uk-margin-small-left uk-margin-small-right gs-uk-alert-danger-color" uk-icon="icon: warning"></span>';
                    }
                    ?>
                </div>
                <br />
                <div class="uk-inline">
                    <?php 
                    echo form_input('current_city', set_value('current_city'), array('class' => 'uk-input uk-form-width-large uk-form-large', 'placeholder' => 'Current City', 'maxlength' => '50', 'id' => 'current_city'));
                    ?>
                </div>
            </div>
            
            <div class="uk-margin">
                <div class="uk-inline">
                    <?php 
                    echo form_label('Permanent Address', 'permanent_address', array('class' => 'uk-form-label')); 
                    if (form_error('permanent_address')) 
                    {
                        echo '<span class="uk-margin-small-left uk-margin-small-right gs-uk-alert-danger-color" uk-icon="icon: warning"></span>';
                    }
                    ?>
                </div>
                <br />
                <div class="uk-inline">
                    <?php 
                    echo form_input('permanent_address', set_value('permanent_address'), array('class' => 'uk-input uk-form-width-large uk-form-large', 'placeholder' => 'Permanent Address', 'maxlength' => '255', 'id' => 'permanent_address'));
                    ?>
                </div>
            </div>
            
            <div class="uk-margin">
                <div class="uk-inline">
                    <?php 
                    echo form_label('Permanent City', 'permanent_city', array('class' => 'uk-form-label')); 
                    if (form_error('permanent_city')) 
                    {
                        echo '<span class="uk-margin-small-left uk-margin-small-right gs-uk-alert-danger-color" uk-icon="icon: warning"></span>';
                    }
                    ?>
                </div>
                <br />
                <div class="uk-inline">
                    <?php 
                    echo form_input('permanent_city', set_value('permanent_city'), array('class' => 'uk-input uk-form-width-large uk-form-large', 'placeholder' => 'Permanent City', 'maxlength' => '50', 'id' => 'permanent_city'));
                    ?>
                </div>
            </div>

            <div class="uk-margin">
                <div class="uk-inline">
                    <?php 
                    echo form_label('Results Per Page', 'results_per_page', array('class' => 'uk-form-label'));
                    if (form_error('results_per_page')) 
                    {
                        echo '<span class="uk-margin-small-left uk-margin-small-right gs-uk-alert-danger-color" uk-icon="icon: warning"></span>';
                    }
                    ?>
                </div>
                <br />
                <div class="uk-inline">
                    <?php 
                    echo form_input('results_per_page', set_value('results_per_page', 10), array('class' => 'uk-input uk-form-width-large uk-form-large', 'placeholder' => 'Results Per Page', 'maxlength' => '11', 'id' => 'results_per_page'));
                    ?>
                </div>
            </div>
            
            <div class="uk-margin">
                <div class="uk-margin">
                    <?php 
                    echo form_submit('submit_search_affiliate_partners', 'Search', array('class' => 'uk-button uk-button-primary uk-margin-small-right uk-align-left uk-margin-remove-bottom')); 
                    echo form_button('reset_search_affiliate_partners', 'Reset', array('class' => 'uk-button uk-button-default uk-margin-small-left uk-align-right uk-margin-remove-bottom', 'id' => 'reset_search_affiliate_partners_form')); 
                    ?>
                </div>
            </div>
            
            <?php 
            echo form_close(); 
            ?>  
            
        </div>
        
    </div> 
    
    
    <div class="uk-height-1-1">
    </div>


    <script>
        $(document).ready(function() 
		{
            $('#reset_search_affiliate_partners_form').click(function()
            {
                $('#affiliate_partner_id').val('');
                $('#affiliate_partner_name').val('');
                $('#phone_no').val('');
                $('#email').val('');
                $('#current_address').val('');
                $('#current_city').val('');
                $('#permanent_address').val('');
                $('#permanent_city').val('');
                $('#results_per_page').val('10');
            });
        });
    </script>
    
</div>