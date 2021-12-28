<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="uk-width-expand uk-padding-small">
    
    <div class="uk-margin-small uk-panel uk-card uk-card-default uk-card-small uk-width-expand">
        
        <div class="uk-card-header">
            <h3 class="uk-card-title">Selected Patient</h3> 
        </div>
        <div class="uk-card-body">
            
            <div class="uk-margin-small">
                
                <?php 
                echo '<b>ID</b>: '.$_SESSION['test_invoice__patient']['id']; 
                echo '<br />'; 
                echo '<b>Name</b>: '.$_SESSION['test_invoice__patient']['firstname'].' '.$_SESSION['test_invoice__patient']['lastname']; 
                echo '<br />'; 
                echo '<b>Sex</b>: '.$_SESSION['test_invoice__patient']['sex']; 
                ?>
                
            </div>
            
        </div>
        <div class="uk-card-footer">
            <div class="uk-margin-small">
                <?php 
                echo anchor('labmanob/add/new_test_invoice/remove_patient', 'Remove', array ('class' => 'uk-button uk-button-danger uk-margin-small-right uk-align-left uk-margin-remove-bottom')); 
                ?>
            </div>
        </div>
        
    </div> 
    
    
    <div class="uk-clearfix">
    </div>
    
    
    <div class="uk-margin-small uk-panel uk-card uk-card-default uk-card-small uk-width-expand">
        
        <div class="uk-card-header">
            <h3 class="uk-card-title">Select Tests</h3> 
        </div>
        <div class="uk-card-body">
            
            <?php 
            if(!empty($error_message)) 
            {
                echo '<div class="uk-alert-danger" uk-alert><a class="uk-alert-close" uk-close></a>'. $error_message .'</div>';
            }
            
            echo validation_errors('<div class="uk-alert-danger" uk-alert><a class="uk-alert-close" uk-close></a>', '</div>'); 
            ?>
            
            <?php 
            if (!empty($tests) && (!empty($tests['tests'])) && (!empty($tests['categories'])) && (!empty($test_categories) || (!empty($tests_with_blank_category)))) 
            { 
                $tests_form_input_fields = array(); 
                
                echo '<ul uk-accordion>'; 
                
                if (!empty($tests_with_blank_category)) 
                { 
                    echo '<li>'; 
                    echo '<h4 class="uk-accordion-title">Default</h4>'; 
                    echo '<div class="uk-accordion-content">'; 
                    echo '<div class="uk-flex uk-flex-wrap uk-flex-around uk-flex-wrap-around">'; 
                    foreach($tests_with_blank_category as $test) 
                    { 
                        if (isset($_SESSION['test_invoice__tests_id']) && is_array($_SESSION['test_invoice__tests_id'])) 
                        { 
                            if (in_array($test['id'], $_SESSION['test_invoice__tests_id'])) 
                            { 
                                $tests_form_input_fields[] = form_checkbox('tests_id['.$test["id"].']', $test['id'], TRUE, array('id' => 'check_test_id_'.$test['id'], 'class' => 'uk-hidden')); 
                                echo '<div data-test-id="'.$test['id'].'" class="test-item uk-card uk-card-primary uk-card-small uk-card-body uk-card-hover uk-margin-small-left uk-margin-small-bottom">'; 
                                echo '<div class="uk-card-title">'.$test['test_codename'].'</div>'; 
                                echo '</div>'; 
                            } 
                            else 
                            { 
                                $tests_form_input_fields[] = form_checkbox('tests_id['.$test["id"].']', $test['id'], FALSE, array('id' => 'check_test_id_'.$test['id'], 'class' => 'uk-hidden')); 
                                echo '<div data-test-id="'.$test['id'].'" class="test-item uk-card uk-card-default uk-card-small uk-card-body uk-card-hover uk-margin-small-left uk-margin-small-bottom">'; 
                                echo '<div class="uk-card-title">'.$test['test_codename'].'</div>'; 
                                echo '</div>'; 
                            } 
                        } 
                        else 
                        { 
                            $tests_form_input_fields[] = form_checkbox('tests_id['.$test["id"].']', $test['id'], FALSE, array('id' => 'check_test_id_'.$test['id'], 'class' => 'uk-hidden')); 
                            echo '<div data-test-id="'.$test['id'].'" class="test-item uk-card uk-card-default uk-card-small uk-card-body uk-card-hover uk-margin-small-left uk-margin-small-bottom">'; 
                            echo '<div class="uk-card-title">'.$test['test_codename'].'</div>'; 
                            echo '</div>'; 
                        } 
                    } 
                    echo '</div>'; 
                    echo '</div>'; 
                    echo '</li>'; 
                } 
                
                if ((!empty($tests['categories'])) && (!empty($tests['tests']))) 
                { 
                    foreach($tests['categories'] as $test_category) 
                    { 
                        echo '<li>'; 
                        echo '<h4 class="uk-accordion-title">'.$test_category['category_codename'].'</h4>'; 
                        echo '<div class="uk-accordion-content">'; 
                        echo '<div class="uk-flex uk-flex-wrap uk-flex-around uk-flex-wrap-around">'; 
                        
                        foreach ($tests['tests'] as $test2) 
                        { 
                            foreach ($test2 as $test) 
                            { 
                                if ($test['test_category_id'] == $test_category['id']) 
                                { 
                                    if (isset($_SESSION['test_invoice__tests_id']) && is_array($_SESSION['test_invoice__tests_id'])) 
                                    { 
                                        if (in_array($test['id'], $_SESSION['test_invoice__tests_id'])) 
                                        { 
                                            $tests_form_input_fields[] = form_checkbox('tests_id['.$test["id"].']', $test['id'], TRUE, array('id' => 'check_test_id_'.$test['id'], 'class' => 'uk-hidden')); 
                                            echo '<div data-test-id="'.$test['id'].'" class="test-item uk-card uk-card-primary uk-card-small uk-card-body uk-card-hover uk-margin-small-left uk-margin-small-bottom">'; 
                                            echo '<div class="uk-card-title">'.$test['test_codename'].'</div>'; 
                                            echo '</div>'; 
                                        } 
                                        else 
                                        { 
                                            $tests_form_input_fields[] = form_checkbox('tests_id['.$test["id"].']', $test['id'], FALSE, array('id' => 'check_test_id_'.$test['id'], 'class' => 'uk-hidden')); 
                                            echo '<div data-test-id="'.$test['id'].'" class="test-item uk-card uk-card-default uk-card-small uk-card-body uk-card-hover uk-margin-small-left uk-margin-small-bottom">'; 
                                            echo '<div class="uk-card-title">'.$test['test_codename'].'</div>'; 
                                            echo '</div>'; 
                                        } 
                                    } 
                                    else 
                                    { 
                                        $tests_form_input_fields[] = form_checkbox('tests_id['.$test["id"].']', $test['id'], FALSE, array('id' => 'check_test_id_'.$test['id'], 'class' => 'uk-hidden')); 
                                        echo '<div data-test-id="'.$test['id'].'" class="test-item uk-card uk-card-default uk-card-small uk-card-body uk-card-hover uk-margin-small-left uk-margin-small-bottom">'; 
                                        echo '<div class="uk-card-title">'.$test['test_codename'].'</div>'; 
                                        echo '</div>'; 
                                    } 
                                } 
                            } 
                            
                        } 
                        
                        echo '</div>'; 
                        echo '</div>'; 
                        echo '</li>'; 
                    } 
                } 
                
                echo '</ul>'; 
            } 
            ?>
            
        </div>
        <div class="uk-card-footer">
            
            <?php 
            if(!empty($tests_form_input_fields)) 
            { 
                echo form_open('labmanob/add/new_test_invoice/select_tests'); 
                foreach($tests_form_input_fields as $tests_form_input_field) 
                { 
                    echo $tests_form_input_field; 
                } 
                echo form_submit('submit_select_tests', 'Next', array('class' => 'uk-button uk-button-primary')); 
                echo form_close(); 
            } 
            ?> 
            
        </div> 
        
    </div>
    
    
    <div class="uk-height-1-1">
    </div>
    
    
    <script>
        $(document).ready(function() { $('.test-item').on('click', function() { 
        
        
        if ($('#check_test_id_'+$(this).data('testId')).is(':checked'))
        { 
            $('#check_test_id_'+$(this).data('testId')).prop('checked', false); 
            $(this).removeClass('uk-card-primary'); 
            $(this).addClass('uk-card-default'); 
        } 
        else 
        { 
            $('#check_test_id_'+$(this).data('testId')).prop('checked', true); 
            $(this).removeClass('uk-card-default'); 
            $(this).addClass('uk-card-primary'); 
        } 
        
         }) })
    </script> 
    
</div>