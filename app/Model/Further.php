<?php

class Further extends AppModel {

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
            'joinTable' => 'furthers_registrations',
            'foreignKey' => 'further_id',
            'associationForeignKey' => 'registration_id',
            'unique' => true
        )
    );

    public function getFurtherId($id = null) {
        if (is_null($id)) {
            return null;
        }
        $result = $this->query("SELECT id FROM furthers_registrations WHERE registration_id = " . $id);
        if (!empty($result)) {
            $furtherId = $result[0]['furthers_registrations']['id'];
            return $furtherId;
        } else {
            return null;
        }
    }

    public function setFurtherToFinish($id = null) {
        if (is_null($id)) {
            return false;
        } else {
            $str = "UPDATE furthers_registrations SET further_id = 3 WHERE id = " . $id;
            $this->query($str);
            return true;
        }
    }

}

?>
