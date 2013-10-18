<?php

date_default_timezone_set('Asia/Taipei');

$rows = array_values($messages['Appointment']);
$input_default_text = $rows[0];

echo "<h2>寄出以下訊息：</h2>" . "<br />";
$count = 0;

for ($i = 1; $i < sizeof($rows); $i += 6) {

    $count++;

    $phone = trim($rows[$i]);

    if (!empty($phone)) {
        //$phone  = $rows[$i];
        $phone  = '0900000000';
        $field1 = $rows[$i + 1];
        $field2 = $rows[$i + 2];
        $field3 = $rows[$i + 3];
        $field4 = $rows[$i + 4];
        $field5 = $rows[$i + 5];

        $str = str_replace('[field1]', $field1, $input_default_text);
        $str = str_replace('[field2]', $field2, $str);
        $str = str_replace('[field3]', $field3, $str);
        $str = str_replace('[field4]', $field4, $str);
        $str = str_replace('[field5]', $field5, $str);

        $strOnlineSend  = "http://www.smsgo.com.tw/sms_gw/sendsms.aspx?";
        $strOnlineSend .= "username=xxx";
        $strOnlineSend .= "&password=xxx";
        $strOnlineSend .= "&dstaddr=" . $phone;
        $strOnlineSend .= "&encoding=BIG5";
        $strOnlineSend .= "&smbody=" . urlencode($str);

        echo "<h4>" . $count . ": " . $str . "</h4>";
        $file = @fopen($strOnlineSend, "r");
        $response = stream_get_contents($file);

        $splited_response = preg_split("/[\s,]+/", $response);
        $statuscode = explode("=", $splited_response[1]);
        $statuscode = (int) $statuscode[1];

        if ($statuscode != 0) {
            echo '傳送出錯！ <br />';
            echo '請聯絡xxxxxxxxxx，照著念這段話：<b>簡訊功能出現錯誤了，錯誤代碼是 ' . $statuscode . '</b><br /><br />';
        } else {
            echo '傳送成功！ <br /><br />';
        }

        fclose($file);
    }
}
?>