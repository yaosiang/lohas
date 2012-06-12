<?php

class BillStatsController extends AppController {

    public $helpers = array('Time', 'Xls');
    public $uses = array('Bill');
    public $components = array('Session');

    public function index() {
        $this->set('title_for_layout', '心樂活診所 - 門診收入');
    }

    public function showAnnualBillStat($y = null) {

        if ($this->request->is('post')) {
            $y = $this->request->data['BillStat']['y']['year'];
        }

        $results = $this->Bill->query("CALL getAnnualBillStat(" . $y . ")");
        $this->set('results', $results);
        $this->set('year', $y);
        $this->set('title_for_layout', '心樂活診所 - 門診收入');

        CakeLog::write('debug', 'BillStatsController.showAnnualBillStat() - 顯示年門診收入');
    }

    public function downloadAnnualBillStat($y = null) {

        $results = $this->Bill->query("CALL getAnnualBillStat(" . $y . ")");
        $this->set('results', $results);
        $this->set('year', $y);

        CakeLog::write('debug', 'BillStatsController.downloadAnnualBillStat() - 產生年門診收入的 Excel 檔');
    }

    public function showMonthlyBillStat($y = null, $m = null) {

        if ($this->request->is('post')) {
            $y = $this->request->data['BillStat']['y']['year'];
            $m = $this->request->data['BillStat']['m']['month'];
        }

        $results = $this->Bill->query("CALL getMonthlyBillStat(" . $y . ", " . $m . ")");
        $this->set('results', $results);
        $this->set('year', $y);
        $this->set('month', $m);
        $this->set('title_for_layout', '心樂活診所 - 門診收入');

        CakeLog::write('debug', 'BillStatsController.showMonthlyBillStat() - 顯示月門診收入');
    }

    public function downloadMonthlyBillStat($y = null, $m = null) {

        $results = $this->Bill->query("CALL getMonthlyBillStat(" . $y . ", " . $m . ")");
        $this->set('results', $results);
        $this->set('year', $y);
        $this->set('month', $m);

        CakeLog::write('debug', 'BillStatsController.downloadMonthlyBillStat() - 產生月門診收入的 Excel 檔');
    }

    public function showDailyBillStat($y = null, $m = null, $d = null) {

        if ($this->request->is('post')) {
            $y = $this->request->data['BillStat']['y']['year'];
            $m = $this->request->data['BillStat']['m']['month'];
            $d = $this->request->data['BillStat']['d']['day'];
        }

        $results = $this->Bill->query("CALL getDailyBillStat(" . $y . ", " . $m . ", " . $d . ")");
        $this->set('results', $results);
        $this->set('year', $y);
        $this->set('month', $m);
        $this->set('day', $d);
        $this->set('title_for_layout', '心樂活診所 - 門診收入');

        CakeLog::write('debug', 'BillStatsController.showDailyBillStat() - 顯示日門診收入');
    }

    public function downloadDailyBillStat($y = null, $m = null, $d = null) {

        $results = $this->Bill->query("CALL getDailyBillStat(" . $y . ", " . $m . ", " . $d . ")");
        $this->set('results', $results);
        $this->set('year', $y);
        $this->set('month', $m);
        $this->set('day', $d);

        CakeLog::write('debug', 'BillStatsController.downloadDailyBillStat() - 產生當日門診收入的 Excel 檔');
    }

}

?>