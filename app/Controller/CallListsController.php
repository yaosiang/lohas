<?php

class CallListsController extends AppController {

    public $helpers = array('Time');
    public $uses = array('Appointment');
    public $components = array('Session');

    public function showCallList($y = null, $m = null, $d = null) {

        if ($this->request->is('post')) {
            $y = $this->request->data['Appointment']['y']['year'];
            $m = $this->request->data['Appointment']['m']['month'];
            $d = $this->request->data['Appointment']['d']['day'];
        } else {
            $y = date("Y");
            $m = date("m");
            $d = date("d");
        }

        $results = $this->getCallListResults($y, $m, $d);
        $this->set('results', $results);
        $this->set('year', $y);
        $this->set('month', $m);
        $this->set('day', $d);

        $messages = $this->sendCallList($y, $m, $d);
        $this->set('to_be_sending_messages', $messages);

        $this->set('title_for_layout', '心樂活診所 - 簡訊關懷');
    }

    public function downloadCallList($y = null, $m = null, $d = null) {

        $this->autoRender = false;

        $results = $this->getCallListResults($y, $m, $d);

        //create a file
        $filename = 'SMS_' . $y . '-' . $m . '-' . $d . '.csv';
        $csv_file = fopen('php://output', 'w');

        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header('Content-type: application/csv');
        header("Content-Type: application/force-download");
        header("Content-Type: application/download");
        header('Content-Disposition: attachment; filename="' . $filename . '"');

        // Each iteration of this while loop will be a row in your .csv file where each field corresponds to the heading of the column
        foreach ($results as $result) {
            // Array indexes correspond to the field names in your db table(s)
            if (!empty($result['appointments']['contact_phone'])) {

                if (strcmp(date('a', strtotime($result['appointments']['appointment_time'])), 'am')) {
                    $meridiem = '下午';

                    // PM 6:30 以後，改用晚上
                    if (intval(date('g', strtotime($result['appointments']['appointment_time']))) > 6) {
                        $meridiem = '晚上';
                    }

                    if (intval(date('g', strtotime($result['appointments']['appointment_time']))) == 6) {
                        if (intval(date('i', strtotime($result['appointments']['appointment_time']))) == 00) {
                            $meridiem = '晚上';
                        }
                    }
                } else {
                    $meridiem = '上午';
                }

                $row = array(
                    $result['appointments']['contact_phone'],
                    $result['appointments']['contact_name'],
                    $meridiem,
                    $this->niceTimeString(date('g:i', strtotime($result['appointments']['appointment_time'])))
                );

                fputcsv($csv_file, $row, ',', '"');
            }
        }

        fclose($csv_file);
    }

    public function sendCallList($y = null, $m = null, $d = null) {
        
        $results = $this->getCallListResults($y, $m, $d);
        
        $rows = array();

        foreach ($results as $result) {
            // Array indexes correspond to the field names in your db table(s)
            if (!empty($result['appointments']['contact_phone'])) {

                if (strcmp(date('a', strtotime($result['appointments']['appointment_time'])), 'am')) {
                    $meridiem = '下午';

                    // PM 6:30 以後，改用晚上
                    if (intval(date('g', strtotime($result['appointments']['appointment_time']))) > 6) {
                        $meridiem = '晚上';
                    }

                    if (intval(date('g', strtotime($result['appointments']['appointment_time']))) == 6) {
                        if (intval(date('i', strtotime($result['appointments']['appointment_time']))) == 00) {
                            $meridiem = '晚上';
                        }
                    }
                } else {
                    $meridiem = '上午';
                }

                $row = array(
                    $result['appointments']['contact_phone'],
                    $result['appointments']['contact_name'],
                    $meridiem,
                    $this->niceTimeString(date('g:i', strtotime($result['appointments']['appointment_time'])))
                );

                array_push($rows, $row);
            }
        }

        return $rows;
    }

    public function sendMessages() {

        $this->set('messages', $this->request->data);

    }
    
    private function getCallListResults($y = null, $m = null, $d = null) {

        $date = date("Y-m-d", mktime(0, 0, 0, (is_null($m) ? $m = date("m") : $m), (is_null($d) ? $d = date("d") : $d), (is_null($y) ? $y = date("Y") : $y)
                ));
        $subDay = $this->getSubDay($y, $m, $d);
        $results = $this->Appointment->query("CALL getCallList('" . $date . "', " . $subDay . " )");

        return $results;
    }

    private function getSubDay($y = null, $m = null, $d = null) {

        $weekday = date("w", mktime(0, 0, 0, (is_null($m) ? $m = date("m") : $m), (is_null($d) ? $d = date("d") : $d), (is_null($y) ? $y = date("Y") : $y)
                ));
        if ($weekday == 6) {
            return 2;
        } else {
            return 1;
        }
    }

    private function niceTimeString($t = null) {

        if (strcmp(substr($t, -2), '00') == 0) {
            $t = substr($t, 0, -2);
        } elseif (strcmp(substr($t, -2), '30') == 0) {
            $t = substr($t, 0, -2) . '半';
        } else {
            $t = $t . '分';
        }

        $t = str_replace(':', '點', $t);

        return $t;
    }

}

?>