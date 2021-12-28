<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Install_db_model extends CI_Model 
{
    var $my_dbname;

    public function __construct()
    {
    parent::__construct();
    $this->load->config('database');
    $this->load->dbforge();
    $this->load->database();
    $this->my_dbname = $this->db->database;
    $this->db->db_select($this->my_dbname);
    }



    public function create_db()
    {
    try {
        return ($this->dbforge->create_database($this->my_dbname) ? TRUE : FALSE);
        }
    catch(Exception $e) {
        echo "Couldn't create database:". $this->my_dbname ."\n\n";
        echo $e->getMessage();
        }
    }



    public function create_tables($use_dbforge=FALSE)
    {
    $this->load->helper('install_db_tables');
    
    if($use_dbforge) 
        {
        $this->db->trans_start(); 
        
        /** table (1/a) : "users" start { **/
        $this->dbforge->add_field($this->registry->db_tables['users']['fields']);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->add_key(array('email', 'verified'));
        
        if ($this->config->item('sql', 'db') == 'mysql') 
        { 
            $table_attr['users'] = array('ENGINE' => 'InnoDB');
        } 
        else 
        { 
            $table_attr['users'] = array(); 
        } 
        
        try {
            $table_1a1_return = ($this->dbforge->create_table($this->registry->db_tables['users']['name'], TRUE, $table_attr['users']) ? TRUE : FALSE);
            }
        catch (Exception $e) {
            echo "Couldn't create table: " .$this->registry->db_tables['users']['name']. "\n\n";
            echo $e->getMessage();
            }
        
        try {
            $table_1a2_return = (($this->db->insert_batch($this->registry->db_tables['users']['name'], $this->registry->db_tables['users']['insert_fields'], TRUE)) ? TRUE : FALSE);
            }
        catch (Exception $e) {
            echo "Couldn't populate table: " .$this->registry->db_tables['users']['name']. "\n\n";
            echo $e->getMessage();
            }
        
        if (($table_1a1_return === TRUE) && ($table_1a2_return === TRUE)) 
        { 
        $table_1a_return = TRUE; 
        }
        else 
        { 
        $table_1a_return = FALSE; 
        } 
        /** table (1/a) : "users" end } **/
        
        /** table (2/a) : "login_attempts" start { **/
        $this->dbforge->add_field($this->registry->db_tables['login_attempts']['fields']);
        $this->dbforge->add_key('id', TRUE);
        
        if ($this->config->item('sql', 'db') == 'mysql') 
        { 
            $table_attr['login_attempts'] = array('ENGINE' => 'InnoDB');
        } 
        else 
        { 
            $table_attr['login_attempts'] = array(); 
        } 
        
        try {
            $table_2a_return = ($this->dbforge->create_table($this->registry->db_tables['login_attempts']['name'], TRUE, $table_attr['login_attempts']) ? TRUE : FALSE);
            }
        catch (Exception $e) {
            echo "Couldn't create table: " .$this->registry->db_tables['login_attempts']['name']. "\n\n";
            echo $e->getMessage();
            }
        /** table (2/a) : "login_attempts" end } **/
        
        /** table (3/a) : "patients" start { **/
        $this->dbforge->add_field($this->registry->db_tables['patients']['fields']);
        $this->dbforge->add_key('id', TRUE);
        
        if ($this->config->item('sql', 'db') == 'mysql') 
        { 
            $table_attr['patients'] = array('ENGINE' => 'InnoDB');
        } 
        else 
        { 
            $table_attr['patients'] = array(); 
        } 
        
        try {
            $table_3a_return = ($this->dbforge->create_table($this->registry->db_tables['patients']['name'], TRUE, $table_attr['patients']) ? TRUE : FALSE);
            }
        catch (Exception $e) {
            echo "Couldn't create table: " .$this->registry->db_tables['patients']['name']. "\n\n";
            echo $e->getMessage();
            }
        /** table (3/a) : "patients" end } **/
        
        /** table (4/a) : "test_categories" start { **/
        $this->dbforge->add_field($this->registry->db_tables['test_categories']['fields']);
        $this->dbforge->add_key('id', TRUE);
        
        if ($this->config->item('sql', 'db') == 'mysql') 
        { 
            $table_attr['test_categories'] = array('ENGINE' => 'InnoDB');
        } 
        else 
        { 
            $table_attr['test_categories'] = array(); 
        } 
        
        try {
            $table_4a_return = ($this->dbforge->create_table($this->registry->db_tables['test_categories']['name'], TRUE, $table_attr['test_categories']) ? TRUE : FALSE);
            }
        catch (Exception $e) {
            echo "Couldn't create table: " .$this->registry->db_tables['test_categories']['name']. "\n\n";
            echo $e->getMessage();
            }
        /** table (4/a) : "test_categories" end } **/
        
        /** table (5/a) : "tests" start { **/
        $this->dbforge->add_field($this->registry->db_tables['tests']['fields']);
        $this->dbforge->add_key('id', TRUE);
        
        if ($this->config->item('sql', 'db') == 'mysql') 
        { 
            $table_attr['tests'] = array('ENGINE' => 'InnoDB');
        } 
        else 
        { 
            $table_attr['tests'] = array(); 
        } 
        
        try {
            $table_5a_return = ($this->dbforge->create_table($this->registry->db_tables['tests']['name'], TRUE, $table_attr['tests']) ? TRUE : FALSE);
            }
        catch (Exception $e) {
            echo "Couldn't create table: " .$this->registry->db_tables['tests']['name']. "\n\n";
            echo $e->getMessage();
            }
        /** table (5/a) : "tests" end } **/
        
        /** table (6/a) : "test_invoices" start { **/
        $this->dbforge->add_field($this->registry->db_tables['test_invoices']['fields']);
        $this->dbforge->add_key('id', TRUE);
        
        if ($this->config->item('sql', 'db') == 'mysql') 
        { 
            $table_attr['test_invoices'] = array('ENGINE' => 'InnoDB');
        } 
        else 
        { 
            $table_attr['test_invoices'] = array(); 
        } 
        
        try {
            $table_6a_return = ($this->dbforge->create_table($this->registry->db_tables['test_invoices']['name'], TRUE, $table_attr['test_invoices']) ? TRUE : FALSE);
            }
        catch (Exception $e) {
            echo "Couldn't create table: " .$this->registry->db_tables['test_invoices']['name']. "\n\n";
            echo $e->getMessage();
            }
        /** table (6/a) : "test_invoices" end } **/
        
        /** table (7/a) : "test_invoice_records" start { **/
        $this->dbforge->add_field($this->registry->db_tables['test_invoice_records']['fields']);
        $this->dbforge->add_key('id', TRUE);
        /** $this->dbforge->add_key(array('test_invoice_id', 'test_id')); **/
        
        if ($this->config->item('sql', 'db') == 'mysql') 
        { 
            $table_attr['test_invoice_records'] = array('ENGINE' => 'InnoDB');
        } 
        else 
        { 
            $table_attr['test_invoice_records'] = array(); 
        } 
        
        try {
            $table_7a_return = ($this->dbforge->create_table($this->registry->db_tables['test_invoice_records']['name'], TRUE, $table_attr['test_invoice_records']) ? TRUE : FALSE);
            }
        catch (Exception $e) {
            echo "Couldn't create table: " .$this->registry->db_tables['test_invoice_records']['name']. "\n\n";
            echo $e->getMessage();
            }
        /** table (7/a) : "test_invoice_records" end } **/
        
        /** table (8/a) : "test_invoice_payments" start { **/
        $this->dbforge->add_field($this->registry->db_tables['test_invoice_payments']['fields']);
        $this->dbforge->add_key('id', TRUE);
        
        if ($this->config->item('sql', 'db') == 'mysql') 
        { 
            $table_attr['test_invoice_payments'] = array('ENGINE' => 'InnoDB');
        } 
        else 
        { 
            $table_attr['test_invoice_payments'] = array(); 
        } 
        
        try {
            $table_8a_return = ($this->dbforge->create_table($this->registry->db_tables['test_invoice_payments']['name'], TRUE, $table_attr['test_invoice_payments']) ? TRUE : FALSE);
            }
        catch (Exception $e) {
            echo "Couldn't create table: " .$this->registry->db_tables['test_invoice_payments']['name']. "\n\n";
            echo $e->getMessage();
            }
        /** table (8/a) : "test_invoice_payments" end } **/

        /** table (9/a) : "test_invoice_logs" start { **/
        $this->dbforge->add_field($this->registry->db_tables['test_invoice_logs']['fields']);
        $this->dbforge->add_key('id', TRUE);
        
        if ($this->config->item('sql', 'db') == 'mysql') 
        { 
            $table_attr['test_invoice_logs'] = array('ENGINE' => 'InnoDB');
        } 
        else 
        { 
            $table_attr['test_invoice_logs'] = array(); 
        } 
        
        try {
            $table_9a_return = ($this->dbforge->create_table($this->registry->db_tables['test_invoice_logs']['name'], TRUE, $table_attr['test_invoice_logs']) ? TRUE : FALSE);
            }
        catch (Exception $e) {
            echo "Couldn't create table: " .$this->registry->db_tables['test_invoice_logs']['name']. "\n\n";
            echo $e->getMessage();
            }
        /** table (9/a) : "test_invoice_logs" end } **/
        
        /** table (10/a) : "affiliate_partners" start { **/
        $this->dbforge->add_field($this->registry->db_tables['affiliate_partners']['fields']);
        $this->dbforge->add_key('id', TRUE);
        
        if ($this->config->item('sql', 'db') == 'mysql') 
        { 
            $table_attr['affiliate_partners'] = array('ENGINE' => 'InnoDB');
        } 
        else 
        { 
            $table_attr['affiliate_partners'] = array(); 
        } 
        
        try {
            $table_10a_return = ($this->dbforge->create_table($this->registry->db_tables['affiliate_partners']['name'], TRUE, $table_attr['affiliate_partners']) ? TRUE : FALSE);
            }
        catch (Exception $e) {
            echo "Couldn't create table: " .$this->registry->db_tables['affiliate_partners']['name']. "\n\n";
            echo $e->getMessage();
            }
        /** table (10/a) : "affiliate_partners" end } **/
        
        /** table (11/a) : "files" start { **/
        $this->dbforge->add_field($this->registry->db_tables['files']['fields']);
        $this->dbforge->add_key('id', TRUE);
        
        if ($this->config->item('sql', 'db') == 'mysql') 
        { 
            $table_attr['files'] = array('ENGINE' => 'InnoDB');
        } 
        else 
        { 
            $table_attr['files'] = array(); 
        } 
        
        try {
            $table_11a1_return = ($this->dbforge->create_table($this->registry->db_tables['files']['name'], TRUE, $table_attr['files']) ? TRUE : FALSE);
            }
        catch (Exception $e) {
            echo "Couldn't create table: " .$this->registry->db_tables['files']['name']. "\n\n";
            echo $e->getMessage();
            }
        
        try {
            $table_11a2_return = (($this->db->insert_batch($this->registry->db_tables['files']['name'], $this->registry->db_tables['files']['insert_fields'], TRUE)) ? TRUE : FALSE);
            }
        catch (Exception $e) {
            echo "Couldn't populate table: " .$this->registry->db_tables['files']['name']. "\n\n";
            echo $e->getMessage();
            }
        
        if (($table_11a1_return === TRUE) && ($table_11a2_return === TRUE)) 
        { 
        $table_11a_return = TRUE; 
        }
        else 
        { 
        $table_11a_return = FALSE; 
        } 
        /** table (11/a) : "files" end } **/
        
        /** table (12/a) : "image_files_records" start { **/
        $this->dbforge->add_field($this->registry->db_tables['image_files_records']['fields']);
        $this->dbforge->add_key('id', TRUE);
        
        if ($this->config->item('sql', 'db') == 'mysql') 
        { 
            $table_attr['image_files_records'] = array('ENGINE' => 'InnoDB');
        } 
        else 
        { 
            $table_attr['image_files_records'] = array(); 
        } 
        
        try {
            $table_12a1_return = ($this->dbforge->create_table($this->registry->db_tables['image_files_records']['name'], TRUE, $table_attr['image_files_records']) ? TRUE : FALSE);
            }
        catch (Exception $e) {
            echo "Couldn't create table: " .$this->registry->db_tables['image_files_records']['name']. "\n\n";
            echo $e->getMessage();
            }
        
        try {
            $table_12a2_return = (($this->db->insert_batch($this->registry->db_tables['image_files_records']['name'], $this->registry->db_tables['image_files_records']['insert_fields'], TRUE)) ? TRUE : FALSE);
            }
        catch (Exception $e) {
            echo "Couldn't populate table: " .$this->registry->db_tables['image_files_records']['name']. "\n\n";
            echo $e->getMessage();
            }
        
        if (($table_12a1_return === TRUE) && ($table_12a2_return === TRUE)) 
        { 
        $table_12a_return = TRUE; 
        }
        else 
        { 
        $table_12a_return = FALSE; 
        } 
        /** table (12/a) : "image_files_records" end } **/
        
        $this->db->trans_complete(); 
        
        return ((($table_1a_return) && ($table_2a_return) && ($table_3a_return) && ($table_4a_return) && ($table_5a_return) && ($table_6a_return) && ($table_7a_return) && ($table_8a_return) && ($table_9a_return) && ($table_10a_return) && ($table_11a_return) && ($table_12a_return) && ($this->db->trans_status() !== FALSE)) ? TRUE : FALSE);
        }
    else 
        {
        $this->db->trans_start(); 
        
        /** table (1/b) : "users" start { **/
        try {
            $table_1b1_return = ($this->db->query($this->registry->db_tables['users']['query']) ? TRUE : FALSE);
            }
        catch (Exception $e) {
            echo "Couldn't create table: " .$this->registry->db_tables['users']['name']. "\n\n";
            echo $e->getMessage();
            }
        
        try {
            $table_1b2_return = ($this->db->query($this->registry->db_tables['users']['insert_query']) ? TRUE : FALSE);
            }
        catch (Exception $e) {
            echo "Couldn't populate table: " .$this->registry->db_tables['users']['name']. "\n\n";
            echo $e->getMessage();
            }
        
        if (($table_1b1_return === TRUE) && ($table_1b2_return === TRUE)) 
        { 
        $table_1b_return = TRUE; 
        }
        else 
        { 
        $table_1b_return = FALSE; 
        } 
            /** table (1/b) : "users" end } **/
            
            /** table (2/b) : "login_attempts" start { **/
        try {
            $table_2b_return = ($this->db->query($this->registry->db_tables['login_attempts']['query']) ? TRUE : FALSE);
            }
        catch (Exception $e) {
            echo "Couldn't create table: " .$this->registry->db_tables['login_attempts']['name']. "\n\n";
            echo $e->getMessage();
            }
            /** table (2/b) : "login_attempts" end } **/
            
            /** table (3/b) : "patients" start { **/
        try {
            $table_3b_return = ($this->db->query($this->registry->db_tables['patients']['query']) ? TRUE : FALSE);
            }
        catch (Exception $e) {
            echo "Couldn't create table: " .$this->registry->db_tables['patients']['name']. "\n\n";
            echo $e->getMessage();
            }
            /** table (3/b) : "patients" end } **/
            
            /** table (4/b) : "test_categories" start { **/
        try {
            $table_4b_return = ($this->db->query($this->registry->db_tables['test_categories']['query']) ? TRUE : FALSE);
            }
        catch (Exception $e) {
            echo "Couldn't create table: " .$this->registry->db_tables['test_categories']['name']. "\n\n";
            echo $e->getMessage();
            }
            /** table (4/b) : "test_categories" end } **/
            
            /** table (5/b) : "tests" start { **/
        try {
            $table_5b_return = ($this->db->query($this->registry->db_tables['tests']['query']) ? TRUE : FALSE);
            }
        catch (Exception $e) {
            echo "Couldn't create table: " .$this->registry->db_tables['tests']['name']. "\n\n";
            echo $e->getMessage();
            }
            /** table (5/b) : "tests" end } **/
            
            /** table (6/b) : "test_invoices" start { **/
        try {
            $table_6b_return = ($this->db->query($this->registry->db_tables['test_invoices']['query']) ? TRUE : FALSE);
            }
        catch (Exception $e) {
            echo "Couldn't create table: " .$this->registry->db_tables['test_invoices']['name']. "\n\n";
            echo $e->getMessage();
            }
            /** table (6/b) : "test_invoices" end } **/
            
            /** table (7/b) : "test_invoice_records" start { **/
        try {
            $table_7b_return = ($this->db->query($this->registry->db_tables['test_invoice_records']['query']) ? TRUE : FALSE);
            }
        catch (Exception $e) {
            echo "Couldn't create table: " .$this->registry->db_tables['test_invoice_records']['name']. "\n\n";
            echo $e->getMessage();
            }
            /** table (7/b) : "test_invoice_records" end } **/
            
            /** table (8/b) : "test_invoice_payments" start { **/
        try {
            $table_8b_return = ($this->db->query($this->registry->db_tables['test_invoice_payments']['query']) ? TRUE : FALSE);
            }
        catch (Exception $e) {
            echo "Couldn't create table: " .$this->registry->db_tables['test_invoice_payments']['name']. "\n\n";
            echo $e->getMessage();
            }
            /** table (8/b) : "test_invoice_payments" end } **/

            /** table (9/b) : "test_invoice_logs" start { **/
        try {
            $table_9b_return = ($this->db->query($this->registry->db_tables['test_invoice_logs']['query']) ? TRUE : FALSE);
            }
        catch (Exception $e) {
            echo "Couldn't create table: " .$this->registry->db_tables['test_invoice_logs']['name']. "\n\n";
            echo $e->getMessage();
            }
            /** table (9/b) : "test_invoice_logs" end } **/
            
            /** table (10/b) : "affiliate_partners" start { **/
        try {
            $table_10b_return = ($this->db->query($this->registry->db_tables['affiliate_partners']['query']) ? TRUE : FALSE);
            }
        catch (Exception $e) {
            echo "Couldn't create table: " .$this->registry->db_tables['affiliate_partners']['name']. "\n\n";
            echo $e->getMessage();
            }
            /** table (10/b) : "affiliate_partners" end } **/
            
            /** table (11/b) : "files" start { **/
        try {
            $table_11b1_return = ($this->db->query($this->registry->db_tables['files']['query']) ? TRUE : FALSE);
            }
        catch (Exception $e) {
            echo "Couldn't create table: " .$this->registry->db_tables['files']['name']. "\n\n";
            echo $e->getMessage();
            }
        
        try {
            $table_11b2_return = ($this->db->query($this->registry->db_tables['files']['insert_query']) ? TRUE : FALSE);
            }
        catch (Exception $e) {
            echo "Couldn't populate table: " .$this->registry->db_tables['files']['name']. "\n\n";
            echo $e->getMessage();
            }
        
        if (($table_11b1_return === TRUE) && ($table_11b2_return === TRUE)) 
        { 
        $table_11b_return = TRUE; 
        }
        else 
        { 
        $table_11b_return = FALSE; 
        } 
            /** table (11/b) : "files" end } **/
            
            /** table (12/b) : "image_files_records" start { **/
        try {
            $table_12b1_return = ($this->db->query($this->registry->db_tables['image_files_records']['query']) ? TRUE : FALSE);
            }
        catch (Exception $e) {
            echo "Couldn't create table: " .$this->registry->db_tables['image_files_records']['name']. "\n\n";
            echo $e->getMessage();
            }
        
        try {
            $table_12b2_return = ($this->db->query($this->registry->db_tables['image_files_records']['insert_query']) ? TRUE : FALSE);
            }
        catch (Exception $e) {
            echo "Couldn't populate table: " .$this->registry->db_tables['image_files_records']['name']. "\n\n";
            echo $e->getMessage();
            }
        
        if (($table_12b1_return === TRUE) && ($table_12b2_return === TRUE)) 
        { 
        $table_12b_return = TRUE; 
        }
        else 
        { 
        $table_12b_return = FALSE; 
        } 
            /** table (12/b) : "image_files_records" end } **/
            
            $this->db->trans_complete(); 
            
            return ((($table_1b_return) && ($table_2b_return) && ($table_3b_return) && ($table_4b_return) && ($table_5b_return) && ($table_6b_return) && ($table_7b_return) && ($table_8b_return) && ($table_9b_return) && ($table_10b_return) && ($table_11b_return) && ($table_12b_return) && ($this->db->trans_status() !== FALSE)) ? TRUE : FALSE);
        }
    }

} 

?>