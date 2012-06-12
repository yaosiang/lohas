<?php

class Notification extends AppModel {

    public $validate = array(
        'description' => array(
            'rule' => 'alphaNumeric',
            'message' => 'Alphabets and numbers only',
            'required' => true,
            'allowEmpty' => false
        )
    );
    public $hasMany = array(
        'Appointment' => array(
            'className' => 'Appointment'
        )
    );

}

?>
