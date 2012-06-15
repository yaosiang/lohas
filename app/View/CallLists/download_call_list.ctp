<?php

setlocale(LC_TIME, "zh_TW");

$this->layout = 'ajax';
$csv = null;

foreach ($results AS $result) {
    if (!empty($result['appointments']['contact_phone'])) {
        $csv .= $result['appointments']['contact_phone'];
        $csv .= ',' . $result['appointments']['contact_name'];
        $csv .= ',' . strftime('%p', strtotime($result['appointments']['appointment_time']));
        $csv .= ',' . $this->Time->format('h:i', $result['appointments']['appointment_time']);
        $csv .= "\n";
    }
}

header("Content-type: application/vnd.ms-excel");
header("Content-disposition: csv;filename = sms_" . $date . ".csv; size = " . strlen($csv));
echo $csv;

?>