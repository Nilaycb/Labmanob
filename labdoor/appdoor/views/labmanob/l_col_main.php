<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="uk-width-1-4 uk-padding-small uk-margin-medium-left">
    
    <?php if(strtolower($_SESSION['username']) != 'viewer'): ?>
    <div>
        <h4>Add</h4>
        <ul class="uk-list uk-list-large uk-list-bullet">
            <li><?php echo anchor('labmanob/add/new_affiliate_partner', 'New Affiliate Partner'); ?></li>
            <li><?php echo anchor('labmanob/add/new_test_category', 'New Test Category'); ?></li>
            <li><?php echo anchor('labmanob/add/new_test', 'New Test'); ?></li>
            <li><?php echo anchor('labmanob/add/new_patient', 'New Patient'); ?></li>
            <li><?php echo anchor('labmanob/add/new_test_invoice', 'New Test Invoice'); ?></li>
        </ul>
    </div> 
    <?php endif; ?>
    
    <div>
        <h4>Search</h4>
        <ul class="uk-list uk-list-large uk-list-bullet">
            <li><?php echo anchor('labmanob/flavor/kalojam/search/affiliate_partners', 'Affiliate Partners'); ?></li>
            <li><?php echo anchor('labmanob/search/patients', 'Patients'); ?></li>
            <li><?php echo anchor('labmanob/search/test_invoices', 'Test Invoices'); ?></li>
            <li><?php echo anchor('labmanob/search/test_invoice_logs', 'Test Invoice Logs'); ?></li>
            <li><?php echo anchor('labmanob/search/tests_invoice_freq', 'Tests Invoice Frequency'); ?></li>
        </ul>
    </div>
    
    <div>
        <h4>View</h4>
        <ul class="uk-list uk-list-large uk-list-bullet">
            <li><?php echo anchor('labmanob/view/affiliate_partner', 'Affiliate Partner'); ?></li>
            <li><?php echo anchor('labmanob/view/affiliate_partners', 'Affiliate Partners'); ?></li>
            <li><?php echo anchor('labmanob/view/test_category', 'Test Category'); ?></li>
			<li><?php echo anchor('labmanob/view/test_categories', 'Test Categories'); ?></li>
			<li><?php echo anchor('labmanob/view/test', 'Test'); ?></li>
            <li><?php echo anchor('labmanob/view/tests', 'Tests'); ?></li>
            <li><?php echo anchor('labmanob/view/patient', 'Patient'); ?></li>
            <li><?php echo anchor('labmanob/view/patients', 'Patients'); ?></li>
            <li><?php echo anchor('labmanob/view/test_invoice', 'Test Invoice'); ?></li>
            <li><?php echo anchor('labmanob/view/test_invoices', 'Test Invoices'); ?></li>
        </ul>
    </div>

    <?php if(strtolower($_SESSION['username']) != 'viewer'): ?>
    <div>
        <h4>Edit</h4>
        <ul class="uk-list uk-list-large uk-list-bullet">
            <li><?php echo anchor('labmanob/edit/affiliate_partner/', 'Affiliate Partner'); ?></li>
            <li><?php echo anchor('labmanob/edit/test/', 'Test'); ?></li>
            <li><?php echo anchor('labmanob/edit/test_category', 'Test Category'); ?></li>
            <li><?php echo anchor('labmanob/edit/patient/', 'Patient'); ?></li>
            <li><?php echo anchor('labmanob/edit/test_invoice/payment', 'Test Invoice Payment'); ?></li>
        </ul>
    </div>
    <?php endif; ?>

    <?php if(strtolower($_SESSION['username']) != 'viewer'): ?>
    <div>
        <h4>Report</h4>
        <ul class="uk-list uk-list-large uk-list-bullet">
            <?php if ((strtolower($_SESSION['username']) == 'master') || (strtolower($_SESSION['username']) == 'admin')): ?>
            <li><?php echo anchor('labmanob/flavor/kalojam/report/test_invoice_incomes', 'Test Invoice Incomes'); ?></li>
            <?php endif; ?>  
            <li><?php echo anchor('labmanob/flavor/kalojam/report/test_invoices_report', 'Test Invoices Report'); ?></li>
        </ul>
    </div>
    <?php endif; ?>

    <?php if(strtolower($_SESSION['username']) != 'viewer'): ?>
    <div>
        <h4>Upload</h4>
        <ul class="uk-list uk-list-large uk-list-bullet">
            <li><?php echo anchor('labmanob/upload/patient_image', 'Patient Image'); ?></li>
            <li><?php echo anchor('labmanob/upload/affiliate_partner_image', 'Affiliate Partner Image'); ?></li>
        </ul>
    </div>
    <?php endif; ?>
    
    <div class="uk-height-1-1">
    </div>
    
</div>