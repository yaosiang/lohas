<?php

class FollowUp extends AppModel {

    public $validate = array(
        'follow_up_time' => array(
            'rule' => array('date', 'ymd'),
            'message' => 'Date only'
        ),
        'contact_time' => array(
            'rule' => array('date', 'ymd'),
            'message' => 'Date only',
            'allowEmpty' => true
        ),
        'contact_result' => array(
            'rule' => array('maxLength', '1024'),
            'message' => 'Maximum 256 characters long'
        ),
        'come_back_time' => array(
            'rule' => array('date', 'ymd'),
            'message' => 'Date only'
        )
    );
    public $belongsTo = array(
        'Registration' => array(
            'className' => 'Registration'
        ),
        'Patient' => array(
            'className' => 'Patient'
        )
    );

    public function getFollowUpId($registrationId) {
        $result = $this->findByRegistrationId($registrationId, array('id'));
        return $result['FollowUp']['id'];
    }

    public function setComBackTime($followUpId, $comeBackTime) {
        if (is_null($comeBackTime)) {
            return false;
        } else {
            $str = "UPDATE follow_up SET come_back_time = '" . $comeBackTime . "' WHERE id = " . $followUpId;
            $this->query($str);
            return true;
        }
    }

}

?>
