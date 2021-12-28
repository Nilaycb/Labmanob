<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Affiliate_partners extends CI_Controller 
{ 

    public function  __construct()
    {
        parent::__construct(); 
        $this->load->helper(array('form', 'file')); 
        $this->load->library(array('session', 'form_validation', 'pagination', 'table'));
        $this->load->model('accounts/login_model', 'login_model'); 
        $this->load->model('labmanob/labmanob_summary_model', 'labmanob_summary_model'); 
        $this->load->model('labmanob/labmanob_add_model', 'labmanob_add_model'); 
        $this->load->model('labmanob/flavor/kalojam/search/labmanob_kalojam_search_model', 'labmanob_kalojam_search_model'); 
    } 



    public function index() 
    {
        if ($this->login_model->login_check() === TRUE) 
        {
            if(strtolower($_SESSION['username']) != 'viewer')
            {
                $h_view_data = array(); 
                $view_data = array(); 
                $f_view_data = array(); 
                
                $h_view_data['title'] = "Search Affiliate Partners"; 
                $view_data['summary'] = $this->labmanob_summary_model->get_full_summary(); 
                
                $this->load->view('header', $h_view_data); 
                $this->load->view('labmanob/l_col_main', $view_data); 
                $this->load->view('labmanob/flavor/kalojam/search/m_col_affiliate_partners', $view_data);
                $this->load->view('labmanob/r_col_main', $view_data); 
                $this->load->view('footer', $f_view_data);
            }
            else 
            {
                $h_view_data = array(); 
                $view_data = array(); 
                $f_view_data = array(); 
                $h_view_data['title'] = "Access Denied"; 
                
                $this->load->view('errors/access/header', $h_view_data); 
                $this->load->view('errors/access/l_col_main', $view_data); 
                $this->load->view('errors/access/m_col_access_denied', $view_data); 
                $this->load->view('errors/access/r_col_main', $view_data); 
                $this->load->view('errors/access/footer', $f_view_data); 
            }
        }
        else
        {
            redirect('accounts/login', 'refresh'); 
        }
    } 



    public function query($page_input='') 
    {
        if ($this->login_model->login_check() === TRUE) 
        {
            $this->form_validation->set_data($this->input->get());

            $this->form_validation->set_rules('affiliate_partner_id', 'Affiliate Partner ID', array('trim', 'is_natural_no_zero', 'min_length[1]', 'max_length[11]')); 

            $this->form_validation->set_rules('affiliate_partner_name', 'Affiliate Partner Name', array('trim', 'max_length[100]', array('check_regex_name', array($this->labmanob_add_model, 'check_regex_name')))); 
            $this->form_validation->set_message('check_regex_name', 'The %s field may only contain alpha-numeric characters, underscores, spaces and must start with an alphabetical character!'); 
            
            $this->form_validation->set_rules('phone_no', 'Phone Number', array('trim', 'is_natural_no_zero', 'min_length[2]', 'max_length[100]')); 
            
            $this->form_validation->set_rules('email', 'Email', 'trim|valid_email'); 
                
            $this->form_validation->set_rules('current_address', 'Current Address', 'trim|max_length[255]'); 
            
            $this->form_validation->set_rules('current_city', 'Current City', 'trim|max_length[50]'); 
            
            $this->form_validation->set_rules('permanent_address', 'Permanent Address', 'trim|max_length[255]'); 
            
            $this->form_validation->set_rules('permanent_city', 'Permanent City', 'trim|max_length[50]'); 
            
            $this->form_validation->set_rules('results_per_page', 'Results Per Page', array('trim', 'is_natural_no_zero', 'min_length[1]', 'max_length[11]')); 
            

            if ($this->form_validation->run() == FALSE) 
            {
                $h_view_data = array(); 
                $view_data = array(); 
                $f_view_data = array(); 
                
                $h_view_data['title'] = "Affiliate Partners"; 
                $view_data['summary'] = $this->labmanob_summary_model->get_full_summary(); 
                
                $this->load->view('header', $h_view_data); 
                $this->load->view('labmanob/l_col_main', $view_data); 
                $this->load->view('labmanob/flavor/kalojam/search/m_col_affiliate_partners', $view_data);
                $this->load->view('labmanob/r_col_main', $view_data); 
                $this->load->view('footer', $f_view_data);
            }
            else
            {
                $error_count = 0;

                if (empty($this->input->post_get('affiliate_partner_id')) && empty($this->input->post_get('affiliate_partner_name')) && empty($this->input->post_get('phone_no')) && empty($this->input->post_get('email')) && empty($this->input->post_get('current_address')) && empty($this->input->post_get('current_city')) && empty($this->input->post_get('permanent_address')) && empty($this->input->post_get('permanent_city')) )
                {
                    $error_count++;
                    $error_message = "Please fill up at least one field besides the Results Per Page field!";
                }

                if($error_count != 0)
                {
                    $h_view_data = array(); 
                    $view_data = array(); 
                    $f_view_data = array(); 
                    
                    $h_view_data['title'] = "Search Affiliate Partners"; 
                    $view_data['summary'] = $this->labmanob_summary_model->get_full_summary(); 
                
                    $view_data['error_message'] = $error_message;

                    $this->load->view('header', $h_view_data); 
                    $this->load->view('labmanob/l_col_main', $view_data); 
                    $this->load->view('labmanob/flavor/kalojam/search/m_col_affiliate_partners', $view_data);
                    $this->load->view('labmanob/r_col_main', $view_data); 
                    $this->load->view('footer', $f_view_data);
                }
                else
                {
                    $affiliate_partner_id_input = $this->input->post_get('affiliate_partner_id');
                    $affiliate_partner_name_input = $this->input->post_get('affiliate_partner_name');
                    $phone_no_input = $this->input->post_get('phone_no');
                    $email_input = $this->input->post_get('email');
                    $current_address_input = $this->input->post_get('current_address');
                    $current_city_input = $this->input->post_get('current_city');
                    $permanent_address_input = $this->input->post_get('permanent_address');
                    $permanent_city_input = $this->input->post_get('permanent_city');
                    $results_per_page_input = $this->input->post_get('results_per_page'); 

                    $page_input_ok = FALSE; 
                    $results_per_page = ($results_per_page_input) ? $results_per_page_input : 10; 

                    $total_search_results = $this->labmanob_kalojam_search_model->count_affiliate_partners_from_search($affiliate_partner_id_input, $affiliate_partner_name_input, $phone_no_input, $email_input, $current_address_input, $current_city_input, $permanent_address_input, $permanent_city_input); 
                    
                    
                    $pgn_config['full_tag_open'] = '<ul class="uk-pagination uk-flex-right uk-margin">'; 
                    $pgn_config['full_tag_close'] = '</ul>'; 
                    $pgn_config['first_link'] = '<span uk-pagination-previous></span><span class="uk-margin-small-right" uk-pagination-previous></span> First'; 
                    $pgn_config['first_tag_open'] = '<li>'; 
                    $pgn_config['first_tag_close'] = '</li>'; 
                    $pgn_config['last_link'] = 'Last <span class="uk-margin-small-left" uk-pagination-next></span><span uk-pagination-next></span>'; 
                    $pgn_config['last_tag_open'] = '<li>'; 
                    $pgn_config['last_tag_close'] = '</li>'; 
                    $pgn_config['next_link'] = 'Next <span class="uk-margin-small-left" uk-pagination-next></span>'; 
                    $pgn_config['next_tag_open'] = '<li>'; 
                    $pgn_config['next_tag_close'] = '</li>'; 
                    $pgn_config['prev_link'] = '<span class="uk-margin-small-right" uk-pagination-previous></span> Previous'; 
                    $pgn_config['prev_tag_open'] = '<li>'; 
                    $pgn_config['prev_tag_close'] = '</li>'; 
                    $pgn_config['cur_tag_open'] = '<li class="uk-active">'; 
                    $pgn_config['cur_tag_close'] = '</li>'; 
                    $pgn_config['num_tag_open'] = '<li>'; 
                    $pgn_config['num_tag_close'] = '</li>'; 
                    
                    $pgn_config['uri_segment'] = 7; 
                    $pgn_config['num_links'] = 2; 
                    $pgn_config['use_page_numbers'] = TRUE; 
                    $pgn_config['reuse_query_string'] = TRUE; 
                    
                    $pgn_config['base_url'] = site_url('labmanob/flavor/kalojam/search/affiliate_partners/query'); 
                    $pgn_config['total_rows'] = $total_search_results;
                    $pgn_config['per_page'] = $results_per_page; 
                    
                    $this->pagination->initialize($pgn_config); 
                    
                    $table_tpl = array(
                        'table_open' => '<table class="uk-table uk-table-striped uk-table-hover uk-table-middle uk-table-small">'
                        ); 
                    
                    $this->table->set_template($table_tpl); 
                    
                    
                    if ($page_input == '') 
                    { 
                        $page = 1; 
                        $page_input_ok = TRUE; 
                    } 
                    else if ((($page_input != '') || (!empty($page_input))) && (preg_match('/^[1-9][0-9]*$/', $page_input))) 
                    { 
                        $page = $page_input; 
                        $page_input_ok = TRUE; 
                    } 
                    else 
                    { 
                        $page_input_ok = FALSE; 
                        show_404(current_url()); 
                    } 
                    
                    
                    if (($total_search_results > 0) && ($page_input_ok === TRUE)) 
                    { 
                        $total_pages = ($total_search_results / $results_per_page); 
                        $total_pages = ceil($total_pages); 
                        
                        if ($page > $total_pages) 
                        { 
                            show_404(current_url()); 
                        } 
                        else 
                        { 
                            $h_view_data = array(); 
                            $view_data = array(); 
                            $f_view_data = array(); 
                            $h_view_data['title'] = "Search Affiliate Partners"; 
                            $view_data['summary'] = $this->labmanob_summary_model->get_full_summary(); 
                            $view_data['pagination_links'] = $this->pagination->create_links(); 
                            $view_data['affiliate_partners_table_empty'] = FALSE; 
                            
                            $this->table->set_heading('ID', 'First Name', 'Last Name', 'Sex', 'Phone No', 'Email', 'Current Address', 'Current City', 'Permanent Address', 'Permanent City', 'Extra Info', 'Added'); 
                            $affiliate_partners = $this->labmanob_kalojam_search_model->affiliate_partners_from_search($affiliate_partner_id_input, $affiliate_partner_name_input, $phone_no_input, $email_input, $current_address_input, $current_city_input, $permanent_address_input, $permanent_city_input, $page, $results_per_page, TRUE); 
                            
                            foreach ($affiliate_partners as $affiliate_partner) { 
                                $affiliate_partner_id_anchor = anchor('labmanob/view/affiliate_partner/'.$affiliate_partner->id, $affiliate_partner->id, array('class' => 'uk-link-reset')); 
                                $this->table->add_row(array('data' => $affiliate_partner_id_anchor, 'class' => 'uk-table-link'), $affiliate_partner->firstname, $affiliate_partner->lastname, $affiliate_partner->sex, $affiliate_partner->phone_no, $affiliate_partner->email, $affiliate_partner->current_address, $affiliate_partner->current_city, $affiliate_partner->permanent_address, $affiliate_partner->permanent_city, $affiliate_partner->extra_info, $affiliate_partner->created); 
                            } 
                                
                            $view_data['affiliate_partners_table'] = $this->table->generate(); 
                            $view_data['total_search_results'] = $total_search_results;
                            
                            $this->load->view('header', $h_view_data); 
                            $this->load->view('labmanob/l_col_main', $view_data); 
                            $this->load->view('labmanob/flavor/kalojam/search/m_col_affiliate_partners__result', $view_data); 
                            $this->load->view('labmanob/r_col_main', $view_data); 
                            $this->load->view('footer', $f_view_data); 
                        } 
                        
                    } 
                    else 
                    { 
                        
                        if ($page == 1) 
                        { 
                            $h_view_data = array(); 
                            $view_data = array(); 
                            $f_view_data = array(); 
                            $h_view_data['title'] = "Search Affiliate Partners"; 
                            $view_data['summary'] = $this->labmanob_summary_model->get_full_summary(); 
                            $view_data['affiliate_partners_table_empty'] = TRUE; 
                            
                            $this->load->view('header', $h_view_data); 
                            $this->load->view('labmanob/l_col_main', $view_data); 
                            $this->load->view('labmanob/flavor/kalojam/search/m_col_affiliate_partners__result', $view_data); 
                            $this->load->view('labmanob/r_col_main', $view_data); 
                            $this->load->view('footer', $f_view_data); 
                        } 
                        else 
                        { 
                            show_404(current_url()); 
                        } 
                        
                    }
                }
            }
        }
        else
        {
            redirect('accounts/login', 'refresh'); 
        }
    } 



    // function return TRUE if date_to_check_input is within the allowed backward range from base_date
    // allowed_backward_date must have to in negetive for this function to work correctly
    private function check_backward_date_range_diff($date_to_check_input='', $base_date='', $allowed_backward_diff='-2 day')
    {
        (empty($base_date)) ? $base_date=date('Y-m-d', now()) : ''/* do nothing, input kept unchanged */ ;
        (empty($allowed_backward_diff)) ? $allowed_backward_diff='-2 day' : ''/* do nothing, input kept unchanged */ ;

        $backward_date_checkpoint = date('Y-m-d', strtotime($allowed_backward_diff, strtotime($base_date)));

        if(!empty($date_to_check_input))
        {
            if( ((strtotime($date_to_check_input) - strtotime($backward_date_checkpoint)) < 0) || ((strtotime($date_to_check_input) - strtotime($base_date)) > 0) )
            {
                return FALSE;
            }
        }

        return TRUE;
    }



} 

?>