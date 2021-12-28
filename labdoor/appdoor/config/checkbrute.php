<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/* checkbrute configuration start */ 

$config['checkbrute']['use_checkbrute'] = FALSE; 
$config['checkbrute']['allowed_attempts'] = 5; 

/* All login attempts are counted from the past 2 hours. */ 
/* set value in seconds */ 

$config['checkbrute']['time_duration'] = (2 * 60 * 60); 

/* checkbrute configuration end */ 

?>