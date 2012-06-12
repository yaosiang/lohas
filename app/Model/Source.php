<?php

class Source extends AppModel {

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
