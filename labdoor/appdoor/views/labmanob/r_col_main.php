<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="uk-width-1-4 uk-padding-small">
    
    <div class="uk-panel uk-overflow-hidden uk-margin-small uk-card uk-card-default uk-card-small uk-width-expand"> 
        <div class="uk-card-header"> 
            <div class="uk-grid-small uk-flex-wrap uk-flex-middle" uk-grid> 
                <div class="uk-width-auto"> 
                    <img class="uk-border-circle uk-responsive-width" src="<?php echo assets_url().uploads_dir().'logo/'.$this->config->item('business_entity_logo_file_name', 'labmanob'); ?>"> 
                </div> 
                <div class="uk-width-expand"> 
                    <h3 class="uk-card-title uk-margin-remove-bottom"><?php echo $this->config->item('business_entity_name', 'labmanob'); ?></h3> 
                    <p class="uk-text-meta uk-margin-remove-top">
                        <time datetime="<?php echo mdate("%F %d, %Y", now()); ?>"><?php echo mdate("%F %d, %Y", now()); ?></time>
                    </p> 
                </div> 
            </div> 
        </div> 
        <div class="uk-card-body"> 
            
            <?php 
            if ($this->login_model->login_check() === TRUE) 
            { 
                
                echo '<p><b>Logged in as</b>: '.$_SESSION['username'].'</p>'; 
                
            } 
            ?>
            
            
        </div> 
        <div class="uk-card-footer">
            
            <?php 
            if ( (strtolower($_SESSION['username']) != 'viewer') && (!empty($summary)) && ( (!empty($summary['total'])) || (!empty($summary['today'])) || (!empty($summary['lastday'])) ) ) 
            { 
                echo '<div class="uk-grid-small uk-grid-match uk-flex-center uk-flex-middle uk-flex-wrap uk-text-center" uk-grid>'; 
                echo '<div class="uk-width-expand">'; 
                echo '<h4>Summary</h4>'; 
                echo '</div>'; 
                echo '</div>'; 
                
                
                echo '<div class="uk-flex uk-flex-center uk-flex-wrap uk-margin-small-top">';  
                
                if (!empty($summary['today'])) 
                { 
                    echo '<div class="uk-margin-small">'; 
                    echo '<h4 class="uk-margin-remove-bottom">Today</h4>'; 
                    echo 'Patients: '.((!empty($summary['today']['count_patients'])) ? $summary['today']['count_patients'].'<br />' : 'No data<br />'); 
                    echo 'Test Invoices: '.((!empty($summary['today']['count_test_invoices'])) ? $summary['today']['count_test_invoices'].'<br />' : 'No data<br />'); 
                    echo 'Earnings: '.((!empty($summary['today']['count_earnings'])) ? sprintf("%.2f", (float)$summary['today']['count_earnings']).'<br />' : 'No data<br />'); 
                    echo 'Earnings Due Paid: '.((!empty($summary['today']['count_earnings_due_paid'])) ? sprintf("%.2f", (float)$summary['today']['count_earnings_due_paid']).'<br />' : 'No data<br />'); 
                    echo 'Earnings Due: '.((!empty($summary['today']['count_earnings_due'])) ? sprintf("%.2f", (float)$summary['today']['count_earnings_due']).'<br />' : 'No data<br />'); 
                    echo '</div>'; 
                } 
                
                if (!empty($summary['lastday'])) 
                { 
                    echo '<div class="uk-margin-small">'; 
                    echo '<h4 class="uk-margin-remove-bottom">Last Day</h4>'; 
                    echo 'Patients: '.((!empty($summary['lastday']['count_patients'])) ? $summary['lastday']['count_patients'].'<br />' : 'No data<br />'); 
                    echo 'Test Invoices: '.((!empty($summary['lastday']['count_test_invoices'])) ? $summary['lastday']['count_test_invoices'].'<br />' : 'No data<br />'); 
                    echo 'Earnings: '.((!empty($summary['lastday']['count_earnings'])) ? sprintf("%.2f", (float)$summary['lastday']['count_earnings']).'<br />' : 'No data<br />'); 
                    echo 'Earnings Due Paid: '.((!empty($summary['lastday']['count_earnings_due_paid'])) ? sprintf("%.2f", (float)$summary['lastday']['count_earnings_due_paid']).'<br />' : 'No data<br />'); 
                    echo 'Earnings Due: '.((!empty($summary['lastday']['count_earnings_due'])) ? sprintf("%.2f", (float)$summary['lastday']['count_earnings_due']).'<br />' : 'No data<br />'); 
                    echo '</div>'; 
                } 

                if (!empty($summary['total']) && (($_SESSION['username'] == 'master') || ($_SESSION['username'] == 'admin')) ) 
                { 
                    echo '<div class="uk-margin-small">'; 
                    echo '<h4 class="uk-margin-remove-bottom">Total</h4>'; 
                    echo 'Patients: '.((!empty($summary['total']['count_patients'])) ? $summary['total']['count_patients'].'<br />' : 'No data<br />'); 
                    echo 'Test Invoices: '.((!empty($summary['total']['count_test_invoices'])) ? $summary['total']['count_test_invoices'].'<br />' : 'No data<br />'); 
                    echo 'Test Categories: '.((!empty($summary['total']['count_test_categories'])) ? $summary['total']['count_test_categories'].'<br />' : 'No data<br />'); 
                    echo 'Tests: '.((!empty($summary['total']['count_tests'])) ? $summary['total']['count_tests'].'<br />' : 'No data<br />'); 
                    echo 'Earnings: '.((!empty($summary['total']['count_earnings'])) ? sprintf("%.2f", (float)$summary['total']['count_earnings']).'<br />' : 'No data<br />'); 
                    echo 'Earnings Due Paid: '.((!empty($summary['total']['count_earnings_due_paid'])) ? sprintf("%.2f", (float)$summary['total']['count_earnings_due_paid']).'<br />' : 'No data<br />'); 
                    echo 'Earnings Due: '.((!empty($summary['total']['count_earnings_due'])) ? sprintf("%.2f", (float)$summary['total']['count_earnings_due']).'<br />' : 'No data<br />'); 
                    echo '</div>'; 
                }
                
                echo '</div>'; 
            } 
            ?> 
            
        </div>
    </div>
    
    <div class="uk-height-1-1">
    </div>
    
</div>