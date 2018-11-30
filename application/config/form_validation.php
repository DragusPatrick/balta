<?php

defined('BASEPATH') OR exit('No direct script access allowed');

$config = array(
    'login' => array(
        array(
            'field' => 'mail',
            'label' => 'mail',
            'rules' => 'required|valid_email'
        ),
        array(
            'field' => 'parola',
            'label' => 'parola',
            'rules' => 'required|min_length[4]'
        )
    ),
    'register' => array(
        array(
            'field' => 'nume',
            'label' => 'numele',
            'rules' => 'required|min_length[4]'
        ),
        array(
            'field' => 'telefon',
            'label' => 'telefon',
            'rules' => 'required|min_length[9]'
        ),
        array(
            'field' => 'mail',
            'label' => 'mail',
            'rules' => 'required|valid_email'
        ),
        array(
            'field' => 'parola',
            'label' => 'parola',
            'rules' => 'required|min_length[4]'
        )
    ),
    'settings' => array(
        array(
            'field' => 'costcr',
            'label' => 'Cost Catch & Release',
            'rules' => 'required'
        ),
        array(
            'field' => 'costrc',
            'label' => 'Cost Retinere',
            'rules' => 'required'
        ),
        array(
            'field' => 'micadj',
            'label' => 'Cost Casuta Mica D-J',
            'rules' => 'required'
        ),
        array(
            'field' => 'micavs',
            'label' => 'Cost Casuta Mica V-S',
            'rules' => 'required'
        ),
        array(
            'field' => 'mediedj',
            'label' => 'Cost Casuta Medie V-S',
            'rules' => 'required'
        ),
        array(
            'field' => 'medievs',
            'label' => 'Cost Casuta Medie V-S',
            'rules' => 'required'
        ),
        array(
            'field' => 'maredj',
            'label' => 'Cost Casuta Mare V-S',
            'rules' => 'required'
        ),
        array(
            'field' => 'marevs',
            'label' => 'Cost Casuta Mare V-S',
            'rules' => 'required'
        ),
        array(
            'field' => 'viladj',
            'label' => 'Cost Camera Vila V-S',
            'rules' => 'required'
        ),
        array(
            'field' => 'vilavs',
            'label' => 'Cost Camera Vila V-S',
            'rules' => 'required'
        ),
        array(
            'field' => 'datefirma',
            'label' => 'Date Firma',
            'rules' => 'required'
        )

    ),
 
);