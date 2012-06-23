<?php

class AuthorizedCompany extends AppModel {

    public $validate = array(
        'description' => array(
            'rule' => 'alphaNumeric',
            'message' => 'Alphabets and numbers only',
            'required' => true,
            'allowEmpty' => false
        )
    );
    public $hasMany = array(
        'Patient' => array(
            'className' => 'Patient'
        )
    );

}

?>
