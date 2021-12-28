<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        
        <title><?php echo (!empty($title) ? $title.' | Labmanob' : 'Labmanob'); ?></title>
        <link rel="shortcut icon" type="image/x-icon" href="<?php echo assets_url().'labmanob/icon/favicon.ico'; ?>" />
        <?php echo '<meta name="viewport" content="width=device-width, initial-scale=1" />' ;?>
        <link rel="stylesheet" type="text/css" href="<?php echo uikit_url().'css/uikit.min.css'; ?>" />
        <link rel="stylesheet" type="text/css" href="<?php echo assets_url().'css/main.css'; ?>" />
        <script src="<?php echo jquery_url().'jquery.min.js'; ?>"></script>
        <script src="<?php echo uikit_url().'js/uikit.min.js'; ?>"></script>
        <script src="<?php echo uikit_url().'js/uikit-icons.min.js'; ?>"></script>
        <style>
            @media print
        </style>
    </head>
    <body>

        <div id="container-fluid" class="uk-overflow-hidden">
            
            <div id="body">
            
            
                <?php ?>
                
                <div class="uk-panel uk-grid-match" uk-grid>
