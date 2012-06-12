<?php
    /**
     * Export all member records in .xls format
     * with the help of the xlsHelper
     */

    //input the export file name
    $this->Xls->setHeader('年度門診收入表_' . $year);

    $this->Xls->addXmlHeader();
    $this->Xls->setWorkSheetName('AnnualBillStat');
    
    //1st row for columns name
    $this->Xls->openRow();
    $this->Xls->writeString('月份');
    $this->Xls->writeString('掛號費');
    $this->Xls->writeString('部分負擔');
    $this->Xls->writeString('藥費');
    $this->Xls->writeString('自費');
    $this->Xls->writeString('加總');        
    $this->Xls->closeRow();
    
    //rows for data
    foreach ($results as $result):
        $this->Xls->openRow();
        $this->Xls->writeNumber($result[0]['month']);
        $this->Xls->writeNumber($result[0]['registration_fee']);
        $this->Xls->writeNumber($result[0]['copayment']);
        $this->Xls->writeNumber($result[0]['drug_expense']);
        $this->Xls->writeNumber($result[0]['own_expense']);
        $this->Xls->writeNumber($result[0]['total']);
        $this->Xls->closeRow();
    endforeach;
   
    $this->Xls->addXmlFooter();
    exit();

?> 