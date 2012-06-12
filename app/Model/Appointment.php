<?php

class Appointment extends AppModel {

    public $validate = array(
        'appointment_time' => array(
            'rule' => array('datetime', 'ymd'),
            'message' => 'Datetime only',
            'required' => true,
            'allowEmpty' => false
        ),
        'contact_name' => array(
            'rule' => array('maxLength', 256),
            'message' => 'Maximum 256 characters long',
            'required' => true,
            'allowEmpty' => false
        )
    );
    public $belongsTo = array(
        'Notification' => array(
            'className' => 'Notification',
            'foreignKey' => 'notification_id'
        )
    );
    public $hasOne = array(
        'AppointmentContact' => array(
            'className' => 'AppointmentContact',
            'dependent' => true
        )
    );

    public function setNextRegistration($rId = null, $aId = null) {
        if (is_null($rId) || is_null($aId)) {
            return false;
        } else {
            $str = "INSERT INTO appointments_registrations (registration_id, appointment_id) VALUES (" . $rId . ", " . $aId . ")";
            $this->query($str);
            return true;
        }
    }

    public function deleteNextRegistration($rId = null, $aId = null) {
        if (is_null($rId) || is_null($aId)) {
            return false;
        } else {
            $str = "DELETE FROM appointments_registrations WHERE registration_id = " . $rId . " AND appointment_id = " . $aId;
            $this->query($str);
            return true;
        }
    }

    public function deletePreviousRegistration($rId = null, $aId = null) {
        if (is_null($rId) || is_null($aId)) {
            return false;
        } else {
            $str = "DELETE FROM registrations_appointments WHERE registration_id = " . $rId . " AND appointment_id = " . $aId;
            $this->query($str);
            return true;
        }
    }

    public function getPreviousRegistrationId($id = null) {
        if (is_null($id)) {
            return null;
        }
        $result = $this->query("SELECT registration_id FROM registrations_appointments WHERE appointment_id = " . $id);
        if (!empty($result)) {
            $registrationId = $result[0]['registrations_appointments']['registration_id'];
            return $registrationId;
        } else {
            return null;
        }
    }

    public function getNextRegistrationId($id = null) {
        if (is_null($id)) {
            return null;
        }
        $result = $this->query("SELECT registration_id FROM appointments_registrations WHERE appointment_id = " . $id);
        if (!empty($result)) {
            $registrationId = $result[0]['appointments_registrations']['registration_id'];
            return $registrationId;
        } else {
            return null;
        }
    }

}

?>
