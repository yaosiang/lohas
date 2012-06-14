<?php

class CallListsController extends AppController {

    public $helpers = array('Time', 'Xls');
    public $uses = array('Appointment');
    public $components = array('Session');

    public function showCallList($y = null, $m = null, $d = null) {

        if ($this->request->is('post')) {
            $y = $this->request->data['Appointment']['y']['year'];
            $m = $this->request->data['Appointment']['m']['month'];
            $d = $this->request->data['Appointment']['d']['day'];
        }

        $date = date("Y-m-d", mktime(0, 0, 0, (is_null($m) ? $m = date("m") : $m), (is_null($d) ? $d = date("d") : $d), (is_null($y) ? $y = date("Y") : $y)
                ));

        $results = $this->Appointment->query("CALL getCallList('" . $date . "')");
        $this->set('results', $results);
        $this->set('year', $y);
        $this->set('month', $m);
        $this->set('day', $d);
        $this->set('title_for_layout', '心樂活診所 - 簡訊關懷');

        CakeLog::write('debug', 'CallListsController.showCallList() - 顯示當日簡訊提醒名單');
    }

    function downloadCallList($y = null, $m = null, $d = null) {

        $date = date("Y-m-d", mktime(0, 0, 0, (is_null($m) ? $m = date("m") : $m), (is_null($d) ? $d = date("d") : $d), (is_null($y) ? $y = date("Y") : $y)
                ));
        $results = $this->Appointment->query("CALL getCallList('" . $date . "')");
        $this->set('results', $results);
        $this->set('date', $date);
    }

}

?>