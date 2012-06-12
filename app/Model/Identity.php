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
        'Registration' =>
        array(
            'className' => 'Registration',
            'joinTable' => 'identities_registrations',
            'foreignKey' => 'identity_id',
            'associationForeignKey' => 'registration_id',
            'unique' => true
        )
    );

    // 傳回就診身分列表
    public function getIdentityList() {
        return $this->find('list', array('fields' => 'id, description'));
    }

}

?>
