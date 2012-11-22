<?php

/**
 * Export all member records in .xls format
 * with the help of the xlsHelper
 */
//input the export file name

if (intval($id) == 1) {
    $doctor = '范庭瑋';
} else {
    $doctor = '簡崇暐';
}

$this->Xls->setHeader('Registration_' . $year . '-' . $month . '-' . $day . '_' . $doctor);

$this->Xls->addXmlHeader();
$this->Xls->setWorkSheetName('DailyRegistration');

//1st row for columns name
$this->Xls->openRow();
$this->Xls->writeString('診別');
$this->Xls->writeString('門診時間');
$this->Xls->writeString('醫師');
$this->Xls->writeString('病患姓名');
$this->Xls->writeString('掛號証');
$this->Xls->writeString('就診身分');
$this->Xls->writeString('掛號費');
$this->Xls->writeString('部分負擔');
$this->Xls->writeString('藥費');
$this->Xls->writeString('自費');
$this->Xls->writeString('備註');
$this->Xls->writeString('後續動作');
$this->Xls->writeString('預約日期');
$this->Xls->writeString('追蹤日期');
$this->Xls->closeRow();

//rows for data
foreach ($results as $result):
    $this->Xls->openRow();
    $this->Xls->writeString($result['time_slots']['time_slot']);
    $this->Xls->writeString($result['registrations']['registration_time']);
    $this->Xls->writeString($result['doctors']['doctor']);
    $this->Xls->writeString($result['registrations']['patient_name']);
    $this->Xls->writeString($result['patients']['serial_number']);
    $this->Xls->writeString($result['concated_identities']['identities']);
    $this->Xls->writeNumber($result['bills']['registration_fee']);
    $this->Xls->writeNumber($result['bills']['copayment']);
    $this->Xls->writeNumber($result['bills']['drug_expense']);
    $this->Xls->writeNumber($result['bills']['own_expense']);
    $this->Xls->writeString($result['registrations']['note']);
    $this->Xls->writeString($result['furthers']['description']);
    $this->Xls->writeString($result['furthers_appointment_time']['appointment_time']);
    $this->Xls->writeString($result['furthers_follow_up_time']['follow_up_time']);
    $this->Xls->closeRow();
endforeach;

$this->Xls->addXmlFooter();
exit();
?> 