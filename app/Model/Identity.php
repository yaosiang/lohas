<?php

class Identity extends AppModel {

    public $validate = array(
        'description' => array(
            'rule' => 'alphaNumeric',
            'message' => 'Alphabets and numbers only',
            'required' => true,
            'allowEmpty' => false
        )
    );
    public $hasAndBelongsToMany = array(
        'Registration' => array(
            'className' => 'Registration',
            'joinTable' => 'identities_registrations',
            'foreignKey' => 'identity_id',
            'associationForeignKey' => 'registration_id',
            'unique' => true
        )
    );

}

?>
