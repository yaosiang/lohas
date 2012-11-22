<?php

class TimeSlot extends AppModel {

    public $validate = array(
        'description' => array(
            'rule' => 'alphaNumeric',
            'message' => 'Alphabets and numbers only',
            'required' => true,
            'allowEmpty' => false
        )
    );
    public $hasMany = array(
        'Registration' => array(
            'className' => 'Registration'
        )
    );

    public function getTimeSlotId($datetime) {

        // 1 means 早
        // 2 menas 午
        // 3 means 晚

        $date = new Datetime($datetime);
        $morningEnd = new Datetime($datetime);
        $afternoonStart = new Datetime($datetime);
        $eveningStart = new Datetime($datetime);

        $morningEnd->setTime(12, 0, 0);
        $afternoonStart->setTime(14, 30, 0);
        $eveningStart->setTime(18, 0, 0);

        if ($date > $morningEnd) {
            if ($date > $eveningStart) {
                return 3;
            } else {
                return 2;
            }
        } else {
            return 1;
        }
    }

}

?>
