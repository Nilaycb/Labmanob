<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        
        <?php 
        if (($this->session->flashdata('redirect_second')) && ($this->session->flashdata('redirect_url'))) 
        { 
            echo '<meta http-equiv="refresh" content="'.$this->session->flashdata('redirect_second').';url='.$this->session->flashdata('redirect_url').'" />'; 
        } 
        ?>
        
        <title><?php echo (!empty($title) ? $title.' | Labmanob' : 'Labmanob'); ?></title>
        <link rel="shortcut icon" type="image/x-icon" href="<?php echo assets_url().'labmanob/icon/favicon.ico'; ?>" />
        <?php echo '<meta name="viewport" content="width=device-width, initial-scale=1" />' ;?>
        <link rel="stylesheet" type="text/css" href="<?php echo jquery_ui_url().'jquery-ui.min.css'; ?>" />
        <link rel="stylesheet" type="text/css" href="<?php echo uikit_url().'css/uikit.min.css'; ?>" />
        <link rel="stylesheet" type="text/css" href="<?php echo flatpickr_url().'themes/material_red.css'; ?>" />
        <link rel="stylesheet" type="text/css" href="<?php echo assets_url().'css/main.css'; ?>" />
        <script src="<?php echo jquery_url().'jquery.min.js'; ?>"></script>
        <script src="<?php echo jquery_ui_url().'jquery-ui.min.js'; ?>"></script>
        <script src="<?php echo uikit_url().'js/uikit.min.js'; ?>"></script>
        <script src="<?php echo uikit_url().'js/uikit-icons.min.js'; ?>"></script>
        <script src="<?php echo flatpickr_url().'flatpickr.min.js'; ?>"></script>
        <style>
            
            
        </style>
    </head>
    <body>

        <div id="container-fluid" class="uk-overflow-hidden">
            
            <div id="body">
            
            
                <div id="topnav" uk-sticky>
                    <nav class="uk-navbar-container uk-box-shadow-small uk-margin uk-card uk-card-small uk-card-default uk-card-body" uk-navbar>
                        <div class="uk-navbar-left">
                            <a class="uk-navbar-item uk-logo" href="<?php echo base_url(); ?>"><img class="uk-responsive-height" src="<?php echo assets_url().'labmanob/logo/labmanob.png'; ?>" alt="Labmanob" /></a> 
                        </div>
                        <div class="uk-navbar-right">
                            <ul class="uk-navbar-nav">
                                <li> <a href="<?php echo base_url(); ?>"> <span class="uk-icon uk-margin-small-right" uk-icon="icon: home; ratio: 1"></span> Home </a> </li> 
                                <?php echo ($_SESSION['username'] != 'viewer') ? '<li> <a href="'.site_url('accounts').'"> <span class="uk-icon uk-margin-small-right" uk-icon="icon: user; ratio: 1"></span> Account </a> </li>' : '' ; ?>
                                <li> <a href="<?php echo site_url('accounts/logout'); ?>"> <span class="uk-icon uk-margin-small-right" uk-icon="icon: sign-out; ratio: 1"></span> Log Out </a> </li> 
                            </ul> 
                        </div> 
                    </nav>
                </div>
                
                <div class="uk-panel uk-grid-match" uk-grid>
