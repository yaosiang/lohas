<?php

class Doctor extends AppModel {

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
            'joinTable' => 'doctors_registrations',
            'foreignKey' => 'doctor_id',
            'associationForeignKey' => 'registration_id',
            'unique' => true
        )
    );

    public function getDoctorId($reg_date, $slot) {

        $date = new DateTime($reg_date);
        $dayOfWeek = date_format($date, 'N');
        $dayOfWeek = intval($dayOfWeek);
        $slot = intval($slot);

        return 1;
        // switch ($dayOfWeek) {
        //     case 1:
        //         if ($slot == 1) {
        //             return 2;
        //         } else {
        //             return 1;
        //         }
        //         break;
        //     case 2:
        //         if ($slot == 3) {
        //             return 2;
        //         } else {
        //             return 1;
        //         }
        //         break;
        //     case 3:
        //         if ($slot == 1) {
        //             return 2;
        //         } else {
        //             return 1;
        //         }
        //         break;
        //     case 4:
        //         if ($slot == 2) {
        //             return 2;
        //         } else {
        //             return 1;
        //         }
        //         break;
        //     case 5:
        //         if ($slot == 1) {
        //             return 2;
        //         } else {
        //             return 1;
        //         }
        //         break;
        //     default:
        //         return 1;
        // }
    }

}

?>
