<?php
    /**
     * Export all member records in .xls format
     * with the help of the xlsHelper
     */

    //input the export file name
    $this->Xls->setHeader('年度初診來源統計表_' . $y);

    $this->Xls->addXmlHeader();
    $this->Xls->setWorkSheetName('AnnualSourceStat');
    
    //1st row for columns name
    $this->Xls->openRow();
    $this->Xls->writeString('初診來源');
    $this->Xls->writeString('人數');
    $this->Xls->closeRow();
    
    //rows for data
    foreach ($results as $result):
        $this->Xls->openRow();
        $this->Xls->writeString($result['sources']['description']);
        $this->Xls->writeNumber($result[0]['counts']);
        $this->Xls->closeRow();
    endforeach;
   
    $this->Xls->addXmlFooter();
    exit();

?> 