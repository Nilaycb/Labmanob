<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Labmanob_upload_model extends CI_Model 
{ 

    public function __construct()
    { 
    parent::__construct();
    $this->load->database();
    $this->db->db_select($this->db->database);
    $this->load->helper('install_db_tables'); 
    } 



    // for auto transactions
    public function trans_start()
    {
        $this->db->trans_start();
    }



    // for auto transactions
    public function trans_complete()
    {
        $this->db->trans_complete();
    }



    // for manual transactions
    public function trans_begin()
    {
        $this->db->trans_begin();
    }



    // for manual transactions
    public function trans_rollback()
    {
        $this->db->trans_rollback();
    }



    // for manual transactions
    public function trans_commit()
    {
        $this->db->trans_commit();
    }



    public function trans_status()
    {
        $this->db->trans_status();
    }



    public function clear_patient_image_sess()
    {
        $this->load->library('session');

        if (isset($_SESSION['upload_patient_image__patient_id'])) 
        { 
            unset($_SESSION['upload_patient_image__patient_id']); 
        } 

        if (isset($_SESSION['upload_patient_image__patient'])) 
        { 
            unset($_SESSION['upload_patient_image__patient']); 
        } 

        if (isset($_SESSION['upload_patient_image__redirect_to_add_new_test_invoice'])) 
        { 
            unset($_SESSION['upload_patient_image__redirect_to_add_new_test_invoice']); 
        }
    }



    public function clear_affiliate_partner_image_sess()
    {
        $this->load->library('session');

        if (isset($_SESSION['upload_affiliate_partner_image__affiliate_partner_id'])) 
        { 
            unset($_SESSION['upload_affiliate_partner_image__affiliate_partner_id']); 
        } 

        if (isset($_SESSION['upload_affiliate_partner_image__affiliate_partner'])) 
        { 
            unset($_SESSION['upload_affiliate_partner_image__affiliate_partner']); 
        } 
    }



    /*
     * $encode_level 
     * 0 = no modification
     * 1 = base64 encoded only
     * 2 = encrypted using CI framework
     * 
     * 
     * @return id from files table OR FALSE on failure
     */
    public function upload_affiliate_partner_image($affiliate_partner_id='', $uploaded_image_data=array(), $upload_dir='', $encode_level=0)
    {
        if(empty($affiliate_partner_id))
        {
            return FALSE;
        }

        if(! $this->has_affiliate_partner_id($affiliate_partner_id))
        {
            return FALSE;
        }

        if( empty($uploaded_image_data) || (! is_array($uploaded_image_data)) )
        {
            return FALSE;
        }

        // check if required array keys are there in $uploaded_image_data
        $keys_to_check = array('file_name', 'file_type', 'file_size', 'file_ext', 'image_width', 'image_height');
        if (! $this->array_keys_exists($keys_to_check, $uploaded_image_data)) 
        {
            return FALSE;
        }

        if (empty($upload_dir))
        {
            FALSE;
        }

        if(! is_int($encode_level))
        {
            return FALSE;
        }

        // begin database upload operation
        $flag__proceed_to_update_affiliate_partners_table = FALSE;

        $this->trans_start();

        $db_data = array(
            'file_name' => $uploaded_image_data['file_name'], 
            'file_type' => $uploaded_image_data['file_type'], 
            'file_path' => $upload_dir, 
            'file_size' => $uploaded_image_data['file_size'], 
            'file_ext' => $uploaded_image_data['file_ext'], 
            'encode_level' => $encode_level, 
            'ctrl__status' => 1
        ); 

        $upload_data_to_files_result = $this->new_file($db_data);
                    
        if (($upload_data_to_files_result !== FALSE) && isset($upload_data_to_files_result))
        { 
            if(!empty($uploaded_image_data['image_width']) && !empty($uploaded_image_data['image_height']))
            {
                $db_data = array();
                $db_data = array(
                    'file_id' => $upload_data_to_files_result, 
                    'image_width' => $uploaded_image_data['image_width'], 
                    'image_height' => $uploaded_image_data['image_height'],
                    'ctrl__status' => 1
                ); 

                $upload_data_to_image_files_records_result = $this->new_image_files_record($db_data);
                if (($upload_data_to_image_files_records_result !== FALSE) && isset($upload_data_to_image_files_records_result))
                { 
                    // both database tables have been populated
                    // proceed to update affiliate_partners table
                    $flag__proceed_to_update_affiliate_partners_table = TRUE;
                }
                else 
                {
                    return FALSE;
                }
            }
            else 
            {
                // only files database table has been populated since no image width and height provided
                // proceed to update affiliate_partners table
                $flag__proceed_to_update_affiliate_partners_table = TRUE;
            }

            // codes for updating affiliate_partners table
            if($flag__proceed_to_update_affiliate_partners_table)
            {
                $db_data = array();
                $db_data = array(
                    'img_id' => $upload_data_to_files_result
                );
                
                if($this->update_affiliate_partner($db_data, $affiliate_partner_id))
                {
                    // ALL DATABASE UPLOAD DONE
                    // return files table id
                    $this->trans_complete();

                    return $upload_data_to_files_result;
                }
                else 
                {
                    return FALSE;
                }
            }
            else 
            {
                return FALSE;
            }
        }
        else 
        {
            return FALSE;
        }
    }



    /*
     * $encode_level 
     * 0 = no modification
     * 1 = base64 encoded only
     * 2 = encrypted using CI framework
     * 
     * 
     * @return id from files table OR FALSE on failure
     */
    public function upload_patient_image($patient_id='', $uploaded_image_data=array(), $upload_dir='', $encode_level=0)
    {
        if(empty($patient_id))
        {
            return FALSE;
        }

        if(! $this->has_patient_id($patient_id))
        {
            return FALSE;
        }

        if( empty($uploaded_image_data) || (! is_array($uploaded_image_data)) )
        {
            return FALSE;
        }

        // check if required array keys are there in $uploaded_image_data
        $keys_to_check = array('file_name', 'file_type', 'file_size', 'file_ext', 'image_width', 'image_height');
        if (! $this->array_keys_exists($keys_to_check, $uploaded_image_data)) 
        {
            return FALSE;
        }

        if (empty($upload_dir))
        {
            FALSE;
        }

        if(! is_int($encode_level))
        {
            return FALSE;
        }

        // begin database upload operation
        $flag__proceed_to_update_patients_table = FALSE;

        $this->trans_start();

        $db_data = array(
            'file_name' => $uploaded_image_data['file_name'], 
            'file_type' => $uploaded_image_data['file_type'], 
            'file_path' => $upload_dir, 
            'file_size' => $uploaded_image_data['file_size'], 
            'file_ext' => $uploaded_image_data['file_ext'], 
            'encode_level' => $encode_level, 
            'ctrl__status' => 1
        ); 

        $upload_data_to_files_result = $this->new_file($db_data);
                    
        if (($upload_data_to_files_result !== FALSE) && isset($upload_data_to_files_result))
        { 
            if(!empty($uploaded_image_data['image_width']) && !empty($uploaded_image_data['image_height']))
            {
                $db_data = array();
                $db_data = array(
                    'file_id' => $upload_data_to_files_result, 
                    'image_width' => $uploaded_image_data['image_width'], 
                    'image_height' => $uploaded_image_data['image_height'],
                    'ctrl__status' => 1
                ); 

                $upload_data_to_image_files_records_result = $this->new_image_files_record($db_data);
                if (($upload_data_to_image_files_records_result !== FALSE) && isset($upload_data_to_image_files_records_result))
                { 
                    // both database tables have been populated
                    // proceed to update patients table
                    $flag__proceed_to_update_patients_table = TRUE;
                }
                else 
                {
                    return FALSE;
                }
            }
            else 
            {
                // only files database table has been populated since no image width and height provided
                // proceed to update patients table
                $flag__proceed_to_update_patients_table = TRUE;
            }

            // codes for updating patients table
            if($flag__proceed_to_update_patients_table)
            {
                $db_data = array();
                $db_data = array(
                    'img_id' => $upload_data_to_files_result
                );
                
                if($this->update_patient($db_data, $patient_id))
                {
                    // ALL DATABASE UPLOAD DONE
                    // return files table id
                    $this->trans_complete();

                    return $upload_data_to_files_result;
                }
                else 
                {
                    return FALSE;
                }
            }
            else 
            {
                return FALSE;
            }
        }
        else 
        {
            return FALSE;
        }
    } 



    public function get_img_id_from_affiliate_partners_by_id($id=NULL, $return_as_obj=TRUE) 
    { 
        if(($id === FALSE) || ($id === NULL) || (!preg_match('/^[1-9][0-9]*$/', $id)))
        {
            return FALSE;
        }
        else
        {
            $this->db->select('img_id');
            $this->db->where('id', $id); 
            $query = $this->db->get('affiliate_partners'); 
            
            return ($return_as_obj) ? $query->result() : $query->result_array(); 
        }
    }



    public function get_img_id_from_patients_by_id($id=NULL, $return_as_obj=TRUE) 
    { 
        if(($id === FALSE) || ($id === NULL) || (!preg_match('/^[1-9][0-9]*$/', $id)))
        {
            return FALSE;
        }
        else
        {
            $this->db->select('img_id');
            $this->db->where('id', $id); 
            $query = $this->db->get('patients'); 
            
            return ($return_as_obj) ? $query->result() : $query->result_array(); 
        }
    }



    public function new_file($data) 
    {   
        $datetime = date('Y-m-d H:i:s', now()); 
        
        $this->db->set('created', $datetime, TRUE); 
        
        if ($this->db->insert($this->registry->db_tables['files']['name'], $data, TRUE)) 
        {
            return $this->db->insert_id(); 
        } 
        else 
        {
            return FALSE; 
        } 
        
    } 



    public function new_image_files_record($data) 
    {   
        $datetime = date('Y-m-d H:i:s', now()); 
        
        $this->db->set('created', $datetime, TRUE); 
        
        if ($this->db->insert($this->registry->db_tables['image_files_records']['name'], $data, TRUE)) 
        {
            return $this->db->insert_id(); 
        } 
        else 
        {
            return FALSE; 
        } 
        
    } 



    public function has_affiliate_partner_id($affiliate_partner_id) 
    {
        
        if (empty($affiliate_partner_id)) 
        {
            return FALSE; 
        }
        else 
        {
            $stmt = "SELECT id FROM affiliate_partners WHERE id = ? LIMIT 1"; 
            $query = $this->db->query($stmt, array($affiliate_partner_id)); 
            
            if ($query->num_rows() > 0) 
            {
                return TRUE; 
            }
            else 
            {
                return FALSE; 
            } 
        }
        
    } 



    public function has_patient_id($patient_id) 
    {
        
        if (empty($patient_id)) 
        {
            return FALSE; 
        }
        else 
        {
            $stmt = "SELECT id FROM patients WHERE id = ? LIMIT 1"; 
            $query = $this->db->query($stmt, array($patient_id)); 
            
            if ($query->num_rows() > 0) 
            {
                return TRUE; 
            }
            else 
            {
                return FALSE; 
            } 
        }
        
    } 



    public function update_affiliate_partner($data, $id) 
    {   
        $datetime = date('Y-m-d H:i:s', now()); 
        
        $this->db->set('modified', $datetime, TRUE); 
        $this->db->where('id', $id);
        
        return $this->db->update($this->registry->db_tables['affiliate_partners']['name'], $data);
        
    } 



    public function update_patient($data, $id) 
    {   
        $datetime = date('Y-m-d H:i:s', now()); 
        
        $this->db->set('modified', $datetime, TRUE); 
        $this->db->where('id', $id);
        
        return $this->db->update($this->registry->db_tables['patients']['name'], $data);
        
    } 



    // https://stackoverflow.com/questions/13169588/how-to-check-if-multiple-array-keys-exists
    private function array_keys_exists(array $keys, array $arr) {
        return !array_diff_key(array_flip($keys), $arr);
     }



} 

?>