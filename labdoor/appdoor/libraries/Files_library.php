<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Files_library 
{
    // methods for retrieving db tables should be suffixed with '__db'

    /**
	 * CI Singleton
	 *
	 * @var	object
	 */
	protected $_CI;



    public function __construct() 
    {
        $this->_CI =& get_instance();
        $this->_CI->load->database();
        $this->_CI->db->db_select($this->_CI->db->database); 
    }



    // get 'files' table data using 'id'
    public function get_file_by_id__db($id=NULL, $return_as_obj=TRUE) 
    { 
        if(($id === FALSE) || ($id === NULL) || (!preg_match('/^[1-9][0-9]*$/', $id)))
        {
            return FALSE;
        }
        else
        {
            $this->_CI->db->where('id', $id); 
            $query = $this->_CI->db->get('files'); 
            
            return ($return_as_obj) ? $query->result() : $query->result_array(); 
        }
    }



    // get 'image_files_records' table data using 'file_id'
    public function get_image_files_record_by_file_id__db($file_id=NULL, $return_as_obj=TRUE) 
    { 
        if(($file_id === FALSE) || ($file_id === NULL) || (!preg_match('/^[1-9][0-9]*$/', $file_id)))
        {
            return FALSE;
        }
        else
        {
            $this->_CI->db->where('file_id', $file_id); 
            $query = $this->_CI->db->get('image_files_records'); 
            
            return ($return_as_obj) ? $query->result() : $query->result_array(); 
        }
    }



	/*
	 * * * * * * * *  * $encode_level * * * * * * 
     * 0 = no modification
     * 1 = base64 encoded only
     * 2 = encrypted using CI framework
	 */
    public function get_encoded_image_data($image_data_array_input=array(), $image_encode_level=1, $use_full_path=FALSE) 
    {
        $encoded_image_data = FALSE;

        if($use_full_path)
        {
            if (empty($image_data_array_input['full_path']))
            {
                return FALSE;
            }

            $contents_path = $image_data_array_input['full_path'];
        }
        else 
        {
            if (empty($image_data_array_input['file_path']) || empty($image_data_array_input['file_name']))
            {
                return FALSE;
            }
            
            $contents_path = base_url().uploads_path().$image_data_array_input['file_path'].$image_data_array_input['file_name'];
        }

        if($image_encode_level == 1)
        {
            $contents = @file_get_contents($contents_path);
    
            if ($contents != FALSE) 
            {
                $encoded_image_data = $contents;
            }
        }
        else if($image_encode_level == 2)
        {
            $contents = @file_get_contents($contents_path);
    
            if ($contents != FALSE) 
            {
                $this->_CI->load->library('encryption');
                $encoded_image_data = base64_encode($this->_CI->encryption->decrypt($contents));
            }
        }

        // this returns the $encoded_image_data OR FALSE
        return $encoded_image_data;
    }



}

?>