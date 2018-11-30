<?php

defined('BASEPATH') OR exit('No direct script access allowed');

if(!function_exists('is_ajax_request'))
{
    function is_ajax_request()
    {
        $CI =& get_instance();

        return $CI->input->is_ajax_request() && strpos($CI->config->base_url(), $_SERVER['HTTP_HOST']) != FALSE;
    }
}