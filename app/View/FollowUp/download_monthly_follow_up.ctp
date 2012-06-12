<?php

/**
 * Export all member records in .xls format
 * with the help of the xlsHelper
 */
//input the export file name
$this->Xls->setHeader('月份追蹤名單_' . $year . '-' . $month);

$this->Xls->addXmlHeader();
$this->Xls->setWorkSheetName('MonthlyFollowUp');

//1st row for columns name
$this->Xls->openRow();
$this->Xls->writeString('預定追蹤日期');
$this->Xls->writeString('病患姓名');
$this->Xls->writeString('主要聯絡電話');
$this->Xls->writeString('實際聯絡時間');
$this->Xls->writeString('聯絡結果');
$this->Xls->writeString('實際回診日期');
$this->Xls->closeRow();

//rows for data
foreach ($results as $result):
    $this->Xls->openRow();
    $this->Xls->writeString($result['follow_up']['follow_up_time']);
    $this->Xls->writeString($result['registrations']['patient_name']);
    $this->Xls->writeString($result['patients']['phone']);
    $this->Xls->writeString($result['follow_up']['contact_time']);
    $this->Xls->writeString($result['follow_up']['contact_result']);
    $this->Xls->writeString($result['follow_up']['come_back_time']);
    $this->Xls->closeRow();
endforeach;

$this->Xls->addXmlFooter();
exit();
?> 