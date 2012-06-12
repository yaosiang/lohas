<?php

/**
 * Export all member records in .xls format
 * with the help of the xlsHelper
 */
//input the export file name
$this->Xls->setHeader('當日簡訊提醒名單_' . $year . '-' . $month . '-' . $day);

$this->Xls->addXmlHeader();
$this->Xls->setWorkSheetName('DailyCallList');

//1st row for columns name
$this->Xls->openRow();
$this->Xls->writeString('預約時間');
$this->Xls->writeString('聯絡姓名');
$this->Xls->writeString('聯絡電話');
$this->Xls->closeRow();

//rows for data
foreach ($results as $result):
    $this->Xls->openRow();
    $this->Xls->writeString($this->Time->format('Y-m-d H:i', $result['appointments']['appointment_time']));
    $this->Xls->writeString($result['appointments']['contact_name']);
    $this->Xls->writeString($result['appointments']['contact_phone']);
    $this->Xls->closeRow();
endforeach;

$this->Xls->addXmlFooter();
exit();
?> 