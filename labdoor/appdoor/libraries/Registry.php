<?php
defined('BASEPATH') OR exit('No direct script access allowed');

final class Registry 
{
    private $data = array();

    public function __construct() 
    {
    }

    public function __set($key, $val) 
    {
    $this->data[$key] = $val;
    }

    public function __get($key) 
    {
    return (array_key_exists($key, $this->data) ? $this->data[$key] : null);
    }

    public function __isset($key) 
    {
    return isset($this->data[$key]);
    }

    public function __unset($key) 
    {
    unset($this->data[$key]);
    }


/** The magic methos sleep and wake are used to compress the data when there not being used, this helps save system **/
/** Resources if your Registry gets on the larger side. **/

    public function __sleep() 
    {
    $this->data = serialize($this->data);
    }

    public function __wake() 
    {
    $this->data = unserialize($this->data);
    }

    public function getAll() 
    {
    return $this->data;
    }

} 

?>