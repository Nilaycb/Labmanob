<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="uk-width-expand uk-padding-small">
    
    <div>
        <h3>Test Invoices List</h3> 
        <?php echo (isset($total_results)) ? '<span class="uk-text-meta"> Total '.$total_results.' test invoices.</span>' : '' ; ?>
        <div class="uk-margin-small">
            <?php 
            if ((isset($test_invoices_table)) && (!$test_invoices_table_empty)) 
            { 
                echo '<div class="uk-overflow-auto">'; 
                echo $test_invoices_table; 
                echo '</div>'; 
            } 
            else 
            { 
                echo 'No test invoice found.'; 
            } 
            ?>
        </div>
        <div class="uk-margin-small">
            <?php 
            if (isset($pagination_links)) 
            { 
                echo $pagination_links; 
            } 
            ?>
        </div>
    </div> 
    
</div>