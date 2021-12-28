<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Printing extends CI_Controller 
{ 

    public function  __construct()
    {
        parent::__construct(); 
        $this->load->library(array('session', 'pagination', 'table')); 
        $this->load->model('accounts/login_model', 'login_model'); 
        $this->load->model('labmanob/labmanob_summary_model', 'labmanob_summary_model'); 
        $this->load->model('labmanob/labmanob_search_model', 'labmanob_search_model'); 
        $this->load->model('labmanob/labmanob_view_model', 'labmanob_view_model'); 
        
    } 



    public function index() 
    { 
        
        if ($this->login_model->login_check() === TRUE) 
        { 
            redirect(site_url(), 'refresh'); 
        } 
        else 
        { 
            redirect('accounts/login', 'refresh'); 
        } 
        
    } 



    public function test_invoice($id_input='', $print_type='full') 
    { 
        $print_type = strtolower($print_type);
        
        if ($this->login_model->login_check() === TRUE) 
        { 
            $id = NULL;

            if ($id_input == '') 
            { 
                $id_input_ok = FALSE; 
                show_404(current_url()); 
            } 
            else if ((($id_input != '') || (!empty($id_input))) && (preg_match('/^[1-9][0-9]*$/', $id_input))) 
            { 
                $id = $id_input; 
                $id_input_ok = TRUE; 
            } 
            else 
            { 
                $id_input_ok = FALSE; 
                show_404(current_url()); 
            } 

            if (($print_type != 'full') && ($print_type != 'mini'))
            {
                show_404(current_url());
            }

            if(($this->labmanob_view_model->count_test_invoices_by_id($id) > 0) && ($id_input_ok === TRUE))
            {
                $test_invoice = $this->labmanob_view_model->test_invoice($id, TRUE);
                $test_invoice = $test_invoice[0];

                $test_invoice_patient = $this->labmanob_view_model->test_invoice_patient($test_invoice->patient_id, TRUE);
                $test_invoice_patient = $test_invoice_patient[0];

                $test_invoice_payment = $this->labmanob_view_model->test_invoice_payment($test_invoice->id, TRUE);
                $test_invoice_payment = $test_invoice_payment[0];

                $test_invoice_records = $this->labmanob_view_model->test_invoice_records_by_test_invoice_id($id, FALSE);

                $h_view_data = array(); 
                $view_data = array(); 
                $f_view_data = array(); 
            
                $h_view_data['title'] = "Test Invoice"; 
                $view_data['summary'] = $this->labmanob_summary_model->get_full_summary();                 

                $table_tpl_modified = array(
                    'table_open' => '<table class="uk-table-middle">'
                    ); 

                // Kept as an extra template option
                $table_tpl_wide = array(
                    'table_open' => '<table class="uk-table uk-table-striped uk-table-hover uk-table-middle uk-table-small">'
                    ); 
                
                if ($print_type == 'mini')
                {
                    $this->table->set_template($table_tpl_modified);
                    $this->table->set_heading('Serial No', 'Test Name', 'Price', 'Total');
                }
                else 
                {
                    $this->table->set_template($table_tpl_modified);
                    $this->table->set_heading('Serial No', 'Test ID', 'Test Name', 'Price', 'Quantity', 'Total', 'Discount', 'Discount By', 'Subtotal');
                }
            
                $total_discount = 0;
                $total = 0;
                $i = 1;
                foreach ($test_invoice_records as $test_key => $test_items)
                {
                    $test_name_result = $this->labmanob_view_model->get_tests_name_by_id($test_items['test_id']);
                    $test_name = ($test_name_result !== FALSE) ? $test_name_result[0]->test_name : '';

                    $discount = 0;

                    if(!empty($test_items['discount']))
                    {
                        $discount = $this->labmanob_view_model->calc_discount($test_items['discount'], $test_items['total']);
                        $total_discount += $discount;
                    }

                    $total += $test_items['total'];

                    if ($print_type == 'mini')
                    {
                        $this->table->add_row($i, $test_name, $test_items['test_price'], sprintf("%.2f", (float)$test_items['subtotal'])); 
                    }
                    else
                    {
                        $this->table->add_row($i, $test_items['test_id'], $test_name, $test_items['test_price'], $test_items['quantity'], sprintf("%.2f", (float)$test_items['total']), $test_items['discount'], $test_items['discount_by'], sprintf("%.2f", (float)$test_items['subtotal'])); 
                    }
                    
                    $i++;
                }
                $final_total = $test_invoice->total;

                if ($print_type == 'mini')
                {
                    $this->table->add_row('', '', '', sprintf("%.2f", (float)$final_total));
                }
                else
                {
                    $this->table->add_row('', '', '', '', '', sprintf("%.2f", (float)$total), sprintf("%.2f", (float)$total_discount), '', sprintf("%.2f", (float)$final_total));
                }

                /* QR code generator */
                $output_dir = 'test_invoices/';
                $this->load->helper('phpqrcode');
                $qrDataText = $this->config->item('business_entity_name', 'labmanob');
                $qrDataText .= "\n".'Test Invoice ID: '.$test_invoice->id;
                $qrDataText .= "\n".'Invoice Issued: '.$test_invoice->created;
                $qrDataText .= "\n".'Patient ID: '.$test_invoice->patient_id;
                $qrDataText .= "\n".'Patient Name: '.$test_invoice_patient->firstname.' '.$test_invoice_patient->lastname;
                $qrDataText .= "\n".'Patient Phone: '.$test_invoice_patient->phone_no;
                $qrDataText .= "\n".'Ref By: '.$test_invoice->ref_by;
                $qrPixel = 1;
                $qrFrame = 4;
                $qrTempFile = qrcodes_path().$output_dir.'test_invoice_svg_'.$test_invoice->id.'_'.$qrPixel.'_'.$qrFrame.'.png';
                QRcode::png($qrDataText, $qrTempFile, QR_ECLEVEL_M, $qrPixel, $qrFrame); 
                if(file_exists($qrTempFile))
                {
                    $qrCodeUrl = base_url($qrTempFile);
                }
                else
                {
                    $qrCodeUrl = NULL;
                }
                /* QR code generator end */

                $view_data['test_invoice'] = $test_invoice;
                $view_data['test_invoice_patient'] = $test_invoice_patient;
                $view_data['test_invoice_payment'] = $test_invoice_payment;
                $view_data['print_type'] = $print_type;
                $view_data['test_invoice_records_table'] = $this->table->generate();
                $view_data['qrCodeUrl'] = $qrCodeUrl;

                $this->load->view('labmanob/print/header', $h_view_data); 
                $this->load->view('labmanob/print/test_invoice/main', $view_data); 
                $this->load->view('labmanob/print/footer', $f_view_data);
            }
            else
            {
                show_404(current_url());
            }
        }
        else 
        { 
            redirect('accounts/login', 'refresh'); 
        } 
    }



    public function patient($id_input='', $print_level=2) 
    {
        if ($this->login_model->login_check() === TRUE) 
        {
            $id = NULL;
            $id_input_ok = FALSE;

            if ($id_input == '') 
            { 
                $id_input_ok = FALSE; 
            } 
            else if ((($id_input != '') || (!empty($id_input))) && (preg_match('/^[1-9][0-9]*$/', $id_input))) 
            { 
                $id_input_ok = TRUE;
                $id = $id_input;
            }
            else 
            {
                $id_input_ok = FALSE;
                show_404(current_url());
            }

            if ( ($print_level != 1) && ($print_level != 2) && ($print_level != 3) || (!preg_match('/^[1-9][0-9]*$/', $print_level)) )
            {
                show_404(current_url());
            }

            if(($id_input_ok === TRUE) && ($this->labmanob_view_model->count_patients_by_id($id) > 0))
            {
                $patient = $this->labmanob_view_model->test_invoice_patient($id, TRUE);
                $patient = $patient[0];
                

                $h_view_data = array(); 
                $view_data = array(); 
                $f_view_data = array(); 

                $view_data['print_level'] = $print_level; // { 1: without qrcode, profile image; 2: qrcode only; 3: qrcode and profile image }

                /* QR code generator */
                $output_dir = 'patients/';
                $this->load->helper('phpqrcode');
                $qrDataText = $this->config->item('business_entity_name', 'labmanob');
                $qrDataText .= "\n".'Patient ID: '.$patient->id;
                $qrDataText .= "\n".'Patient Name: '.$patient->firstname.' '.$patient->lastname;
                $qrDataText .= "\n".'Sex: '.$patient->sex;
                $qrDataText .= "\n".'Patient Phone: '.$patient->phone_no;
                if(!empty($patient->email)) 
                { 
                    $qrDataText .= "\n".'Email: '.$patient->email;
                } 
                $qrDataText .= "\n".'Current Address: '.$patient->current_address;
                $qrDataText .= "\n".'Current City: '.$patient->current_city;
                if(!empty($patient->permanent_address)) 
                { 
                    $qrDataText .= "\n".'Permanent Address: '.$patient->permanent_address;
                } 
                if(!empty($patient->permanent_city)) 
                { 
                    $qrDataText .= "\n".'Permanent City: '.$patient->permanent_city;
                } 
                $qrDataText .= "\n".'Added: '.$patient->created;
                $qrPixel = 1;
                $qrFrame = 4;
                $qrTempFile = qrcodes_path().$output_dir.'patient_svg_'.$patient->id.'_'.$qrPixel.'_'.$qrFrame.'.png';
                QRcode::png($qrDataText, $qrTempFile, QR_ECLEVEL_M, $qrPixel, $qrFrame); 
                if(file_exists($qrTempFile))
                {
                    $qrCodeUrl = base_url($qrTempFile);
                }
                else
                {
                    $qrCodeUrl = NULL;
                }
                /* QR code generator end */

                /* codes for patient image generation start { */
                if(!empty($patient))
                {
                    $this->load->library('files_library');
                    $get_file_by_id_result = $this->files_library->get_file_by_id__db($patient->img_id, FALSE);

                    if(($get_file_by_id_result != FALSE) && isset($get_file_by_id_result)) 
                    {
                        $get_file_by_id_result = $get_file_by_id_result[0];

                        $view_data['patient_image_data'] = $get_file_by_id_result;
                        
                        if(isset($get_file_by_id_result['encode_level']) && ($get_file_by_id_result['encode_level'] != 0)) 
                        {
                            $encoded_patient_image_data = $this->files_library->get_encoded_image_data($get_file_by_id_result, $get_file_by_id_result['encode_level'], FALSE);
                            
                            if($encoded_patient_image_data !== FALSE)
                            {
                                $view_data['encoded_patient_image_data'] = $encoded_patient_image_data;
                            }
                        }
                    }
                }
                /* } codes for patient image generation end */
            
                $h_view_data['title'] = "Patient";               

                $view_data['patient'] = $patient;
                $view_data['qrCodeUrl'] = $qrCodeUrl;

                $this->load->view('labmanob/print/header', $h_view_data); 
                $this->load->view('labmanob/print/patient/main', $view_data); 
                $this->load->view('labmanob/print/footer', $f_view_data);
            }
            else
            {
                show_404(current_url());
            }
        }
        else
        {
            redirect('accounts/login', 'refresh'); 
        }
    } 



    public function affiliate_partner($id_input='', $print_level=2) 
    {
        if ($this->login_model->login_check() === TRUE) 
        {
            $id = NULL;
            $id_input_ok = FALSE;

            if ($id_input == '') 
            { 
                $id_input_ok = FALSE; 
            } 
            else if ((($id_input != '') || (!empty($id_input))) && (preg_match('/^[1-9][0-9]*$/', $id_input))) 
            { 
                $id_input_ok = TRUE;
                $id = $id_input;
            }
            else 
            {
                $id_input_ok = FALSE;
                show_404(current_url());
            }

            if ( ($print_level != 1) && ($print_level != 2) && ($print_level != 3) || (!preg_match('/^[1-9][0-9]*$/', $print_level)) )
            {
                show_404(current_url());
            }

            if(($id_input_ok === TRUE) && ($this->labmanob_view_model->count_affiliate_partners_by_id($id) > 0))
            {
                $affiliate_partner = $this->labmanob_view_model->affiliate_partner($id, TRUE);
                $affiliate_partner = $affiliate_partner[0];
                

                $h_view_data = array(); 
                $view_data = array(); 
                $f_view_data = array(); 

                $view_data['print_level'] = $print_level; // { 1: without qrcode, profile image; 2: qrcode only; 3: qrcode and profile image }

                /* QR code generator */
                $output_dir = 'affiliate_partners/';
                $this->load->helper('phpqrcode');
                $qrDataText = $this->config->item('business_entity_name', 'labmanob');
                $qrDataText .= "\n".'Affiliate Partner ID: '.$affiliate_partner->id;
                $qrDataText .= "\n".'Affiliate Partner Name: '.$affiliate_partner->firstname.' '.$affiliate_partner->lastname;
                $qrDataText .= "\n".'Sex: '.$affiliate_partner->sex;
                $qrDataText .= "\n".'Affiliate Partner Phone: '.$affiliate_partner->phone_no;
                if(!empty($affiliate_partner->email)) 
                { 
                    $qrDataText .= "\n".'Email: '.$affiliate_partner->email;
                } 
                $qrDataText .= "\n".'Current Address: '.$affiliate_partner->current_address;
                $qrDataText .= "\n".'Current City: '.$affiliate_partner->current_city;
                if(!empty($affiliate_partner->permanent_address)) 
                { 
                    $qrDataText .= "\n".'Permanent Address: '.$affiliate_partner->permanent_address;
                } 
                if(!empty($affiliate_partner->permanent_city)) 
                { 
                    $qrDataText .= "\n".'Permanent City: '.$affiliate_partner->permanent_city;
                } 
                $qrDataText .= "\n".'Added: '.$affiliate_partner->created;
                $qrPixel = 1;
                $qrFrame = 4;
                $qrTempFile = qrcodes_path().$output_dir.'patient_svg_'.$affiliate_partner->id.'_'.$qrPixel.'_'.$qrFrame.'.png';
                QRcode::png($qrDataText, $qrTempFile, QR_ECLEVEL_M, $qrPixel, $qrFrame); 
                if(file_exists($qrTempFile))
                {
                    $qrCodeUrl = base_url($qrTempFile);
                }
                else
                {
                    $qrCodeUrl = NULL;
                }
                /* QR code generator end */

                /* codes for affiliate_partner image generation start { */
                if(!empty($affiliate_partner))
                {
                    $this->load->library('files_library');
                    $get_file_by_id_result = $this->files_library->get_file_by_id__db($affiliate_partner->img_id, FALSE);

                    if(($get_file_by_id_result != FALSE) && isset($get_file_by_id_result)) 
                    {
                        $get_file_by_id_result = $get_file_by_id_result[0];

                        $view_data['affiliate_partner_image_data'] = $get_file_by_id_result;
                        
                        if(isset($get_file_by_id_result['encode_level']) && ($get_file_by_id_result['encode_level'] != 0)) 
                        {
                            $encoded_affiliate_partner_image_data = $this->files_library->get_encoded_image_data($get_file_by_id_result, $get_file_by_id_result['encode_level'], FALSE);
                            
                            if($encoded_affiliate_partner_image_data !== FALSE)
                            {
                                $view_data['encoded_affiliate_partner_image_data'] = $encoded_affiliate_partner_image_data;
                            }
                        }
                    }
                }
                /* } codes for affiliate_partner image generation end */
            
                $h_view_data['title'] = "Affiliate Partner";               

                $view_data['affiliate_partner'] = $affiliate_partner;
                $view_data['qrCodeUrl'] = $qrCodeUrl;

                $this->load->view('labmanob/print/header', $h_view_data); 
                $this->load->view('labmanob/print/affiliate_partner/main', $view_data); 
                $this->load->view('labmanob/print/footer', $f_view_data);
            }
            else
            {
                show_404(current_url());
            }
        }
        else
        {
            redirect('accounts/login', 'refresh'); 
        }
    } 



}

?>