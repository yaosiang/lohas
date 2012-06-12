<?php

class Bill extends AppModel {

    public $validate = array(
        'registration_fee' => array(
            'rule' => array('money', 'left'),
            'message' => 'Money only',
            'allowEmpty' => true
        ),
        'copayment' => array(
            'rule' => array('money', 'left'),
            'message' => 'Money only',
            'allowEmpty' => true
        ),
        'drug_expense' => array(
            'rule' => array('money', 'left'),
            'message' => 'Money only',
            'allowEmpty' => true
        ),
        'own_expense' => array(
            'rule' => array('money', 'left'),
            'message' => 'Money only',
            'allowEmpty' => true
        )
    );
    public $belongsTo = array(
        'Registration' => array(
            'className' => 'Registration',
            'foreignKey' => 'registration_id'
        )
    );

    public function getBillId($registrationId) {
        $result = $this->findByRegistrationId($registrationId, array('id'));
        return $result['Bill']['id'];
    }

}

?>
