<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="uk-width-1-4 uk-padding-small uk-margin-medium-left">
    
    <?php if(strtolower($_SESSION['username']) != 'viewer'): ?>
    <div>
        <h4>Add</h4>
        <ul class="uk-list uk-list-large uk-list-bullet">
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
            <li><?php echo anchor('labmanob/search/patients', 'Patients'); ?></li>
            <li><?php echo anchor('labmanob/search/test_invoices', 'Test Invoices'); ?></li>
            <li><?php echo anchor('labmanob/search/tests_invoice_freq', 'Tests Invoice Frequency'); ?></li>
        </ul>
    </div>
    
    <div>
        <h4>View</h4>
        <ul class="uk-list uk-list-large uk-list-bullet">
            <li><?php echo anchor('labmanob/view/test_category', 'Test Category'); ?></li>
			<li><?php echo anchor('labmanob/view/test_categories', 'Test Categories'); ?></li>
			<li><?php echo anchor('labmanob/view/test', 'Test'); ?></li>
            <li><?php echo anchor('labmanob/view/tests', 'Tests'); ?></li>
            <li><?php echo anchor('labmanob/view/patients', 'Patients'); ?></li>
            <li><?php echo anchor('labmanob/view/test_invoice', 'Test Invoice'); ?></li>
            <li><?php echo anchor('labmanob/view/test_invoices', 'Test Invoices'); ?></li>
        </ul>
    </div>

    <?php if(strtolower($_SESSION['username']) != 'viewer'): ?>
    <div>
        <h4>Edit</h4>
        <ul class="uk-list uk-list-large uk-list-bullet">
            <li><?php echo anchor('labmanob/edit/test/', 'Test'); ?></li>
            <li><?php echo anchor('labmanob/edit/test_category', 'Test Category'); ?></li>
            <li><?php echo anchor('labmanob/edit/test_invoice/payment', 'Test Invoice Payment'); ?></li>
        </ul>
    </div>
    <?php endif; ?>
    
    <div class="uk-height-1-1">
    </div>
    
</div>