<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {

    public function __construct()
    {
    parent::__construct();
    $this->load->model('install/Install_db_model', 'install_db_model');
    }

    public function index()
    {
    $this->load->view('install/main');
    }

    public function create_db() 
    {
    $view_data['msg'] = ($this->install_db_model->create_db() ? " Database successfully created." : "Couldn't create database!");
    $this->load->view('install/main', $view_data);
    }

    public function create_tables()
    {
    $view_data['msg'] = ($this->install_db_model->create_tables(true) ? "Tables successfully created." : "Couldn't create tables!");
    $this->load->view('install/main', $view_data);
    }

}

?>