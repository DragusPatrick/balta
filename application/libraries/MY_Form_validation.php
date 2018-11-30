<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Form_validation extends CI_Form_validation
{
    function __construct($config = array())
    {
        parent::__construct($config);
    }

    function error_message()
    {
        if (count($this->_error_array) === 0)
        {
            return false;
        }
        else
        {
            $errors_messages = array_values($this->_error_array);

            return $errors_messages[0];
        }
    }
}