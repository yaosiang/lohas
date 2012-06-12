<?php

class SourceStatsController extends AppController {

    public $helpers = array('Xls');
    public $uses = array('Source');
    public $components = array('Session');

    public function index() {
        $this->set('title_for_layout', '心樂活診所 - 初診統計');
    }

    public function showAnnualSourceStat($y = null) {

        if ($this->request->is('post')) {
            $y = $this->request->data['SourceStat']['y']['year'];
        }

        $results = $this->Source->query("CALL getAnnualSourceStat(" . $y . ")");
        $this->set('results', $results);
        $this->set('year', $y);
        $this->set('title_for_layout', '心樂活診所 - 初診統計');

        CakeLog::write('debug', 'SourceStatsController.showAnnualSourceStat() - 顯示年出診來源統計');
    }

    public function downloadAnnualSourceStat($y = null) {

        $results = $this->Source->query("CALL getAnnualSourceStat(" . $y . ")");
        $this->set('results', $results);
        $this->set('year', $y);

        CakeLog::write('debug', 'SourceStatsController.downloadAnnualSourceStat() - 產生年出診來源統計的 Excel 檔');
    }

    public function showMonthlySourceStat($y = null, $m = null) {

        if ($this->request->is('post')) {
            $y = $this->request->data['SourceStat']['y']['year'];
            $m = $this->request->data['SourceStat']['m']['month'];
        }

        $results = $this->Source->query("CALL getMonthlySourceStat(" . $y . ", " . $m . ")");
        $this->set('results', $results);
        $this->set('year', $y);
        $this->set('month', $m);
        $this->set('title_for_layout', '心樂活診所 - 初診統計');

        CakeLog::write('debug', 'SourceStatsController.showMonthlySourceStat() - 顯示月門診收入');
    }

    public function downloadMonthlySourceStat($y = null, $m = null) {

        $results = $this->Source->query("CALL getMonthlySourceStat(" . $y . ", " . $m . ")");
        $this->set('results', $results);
        $this->set('year', $y);
        $this->set('month', $m);

        CakeLog::write('debug', 'SourceStatsController.downloadMonthlySourceStat() - 產生月門診收入的 Excel 檔');
    }

    public function showDailySourceStat($y = null, $m = null, $d = null) {

        if ($this->request->is('post')) {
            $y = $this->request->data['SourceStat']['y']['year'];
            $m = $this->request->data['SourceStat']['m']['month'];
            $d = $this->request->data['SourceStat']['d']['day'];
        }

        $results = $this->Source->query("CALL getDailySourceStat(" . $y . ", " . $m . ", " . $d . ")");
        $this->set('results', $results);
        $this->set('year', $y);
        $this->set('month', $m);
        $this->set('day', $d);
        $this->set('title_for_layout', '心樂活診所門診 - 初診統計');
        
        CakeLog::write('debug', 'SourceStatsController.showDailySourceStat() - 顯示日門診收入');
    }

    public function downloadDailySourceStat($y = null, $m = null, $d = null) {

        $results = $this->Source->query("CALL getDailySourceStat(" . $y . ", " . $m . ", " . $d . ")");
        $this->set('results', $results);
        $this->set('year', $y);
        $this->set('month', $m);
        $this->set('day', $d);

        CakeLog::write('debug', 'SourceStatsController.downloadDailySourceStat() - 產生當日門診收入的 Excel 檔');
    }

}

?>