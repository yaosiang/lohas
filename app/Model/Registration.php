<?php

class Registration extends AppModel {

    public $validate = array(
        'registration_time' => array(
            'rule' => array('datetime', 'ymd'),
            'message' => 'Datetime only',
            'required' => true,
            'allowEmpty' => false
        ),
        'time_slot_id' => array(
            'rule' => 'numeric',
            'message' => 'Numbers only',
            'allowEmpty' => true
        ),
        'patient_id' => array(
            'rule' => 'numeric',
            'message' => 'Numbers only',
            'allowEmpty' => true
        ),
        'doctor' => array(
            'rule' => array('maxLength', '512'),
            'message' => '最大不能超過 512 個字',
            'allowEmpty' => true
        ),
        'note' => array(
            'rule' => array('maxLength', '1024'),
            'message' => '最大不能超過 1024 個字',
            'allowEmpty' => true
        )
    );
    public $belongsTo = array(
        'Patient' => array(
            'className' => 'Patient',
            'foreignKey' => 'patient_id'
        ),
        'TimeSlot' => array(
            'className' => 'TimeSlot',
            'foreignKey' => 'time_slot_id'
        )
    );
    public $hasOne = array(
        'Bill' => array(
            'className' => 'Bill',
            'dependent' => true
        ),
        'FollowUp' => array(
            'className' => 'FollowUp',
            'dependent' => true
        )
    );
    public $hasAndBelongsToMany = array(
        'Identity' =>
        array(
            'className' => 'Identity',
            'joinTable' => 'identities_registrations',
            'foreignKey' => 'registration_id',
            'associationForeignKey' => 'identity_id',
            'unique' => true
        ),
        'Further' =>
        array(
            'className' => 'Further',
            'joinTable' => 'furthers_registrations',
            'foreignKey' => 'registration_id',
            'associationForeignKey' => 'further_id',
            'unique' => true
        ),
        'Doctor' =>
        array(
            'className' => 'Doctor',
            'joinTable' => 'doctors_registrations',
            'foreignKey' => 'registration_id',
            'associationForeignKey' => 'doctor_id',
            'unique' => true
        ),
    );

    public function getPreviousAppointmentId($id = null) {
        if (is_null($id)) {
            return null;
        }
        $result = $this->query("SELECT appointment_id FROM appointments_registrations WHERE registration_id = " . $id);
        if (!empty($result)) {
            $appointmentId = $result[0]['appointments_registrations']['appointment_id'];
            return $appointmentId;
        } else {
            return null;
        }
    }

    public function getNextAppointmentId($id = null) {
        if (is_null($id)) {
            return null;
        }
        $result = $this->query("SELECT appointment_id FROM registrations_appointments WHERE registration_id = " . $id);
        if (!empty($result)) {
            $nextAppointmentId = $result[0]['registrations_appointments']['appointment_id'];
            return $nextAppointmentId;
        } else {
            return null;
        }
    }

    public function setNextAppointment($rId = null, $aId = null) {
        if (is_null($rId) || is_null($aId)) {
            return false;
        } else {
            $str = "INSERT INTO registrations_appointments (registration_id, appointment_id) VALUES (" . $rId . ", " . $aId . ")";
            $this->query($str);
            return true;
        }
    }

    public function setPreviousAppointment($rId = null, $aId = null) {
        if (is_null($rId) || is_null($aId)) {
            return false;
        } else {
            $str = "INSERT INTO appointments_registrations (registration_id, appointment_id) VALUES (" . $rId . ", " . $aId . ")";
            $this->query($str);
            return true;
        }
    }

    public function deletePreviousAppointment($rId = null, $aId = null) {
        if (is_null($rId) || is_null($aId)) {
            return false;
        } else {
            $str = "DELETE FROM appointments_registrations WHERE registration_id = " . $rId . " AND appointment_id = " . $aId;
            $this->query($str);
            return true;
        }
    }

    public function deleteNextAppointment($rId = null, $aId = null) {
        if (is_null($rId) || is_null($aId)) {
            return false;
        } else {
            $str = "DELETE FROM registrations_appointments WHERE registration_id = " . $rId . " AND appointment_id = " . $aId;
            $this->query($str);
            return true;
        }
    }

}

?>