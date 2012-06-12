<?php

class AppointmentContact extends AppModel {

    public $validate = array(
        'contact_time' => array(
            'rule' => array('date', 'ymd'),
            'message' => 'Date only',
            'allowEmpty' => true
        ),
        'contact_result' => array(
            'rule' => array('maxLength', '1024'),
            'message' => 'Maximum 256 characters long',
            'allowEmpty' => true
        )
    );
    public $belongsTo = array(
        'Appointment' => array(
            'className' => 'Appointment',
            'foreignKey' => 'appointment_id'
        )
    );

    public function getAppointmentContactId($appointmentId) {
        $result = $this->findByAppointmentId($appointmentId, array('id'));
        return $result['AppointmentContact']['id'];
    }

}

?>
