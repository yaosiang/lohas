<?php

class FollowUpController extends AppController {

    public $helpers = array('Time', 'Xls');
    public $uses = array('FollowUp', 'Registration', 'Patient');
    public $components = array('Session');

    public function showMonthlyFollowUp($y = null, $m = null) {

        if ($this->request->is('get')) {
            is_null($m) ? $m = date("m") : $m;
            is_null($y) ? $y = date("Y") : $y;
        }

        if ($this->request->is('post')) {
            $y = $this->request->data['FollowUp']['y']['year'];
            $m = $this->request->data['FollowUp']['m']['month'];
        }

        $results = $this->FollowUp->query("CALL getMonthlyFollowUp(" . $y . ", " . $m . ")");
        $this->set('results', $results);
        $this->set('year', $y);
        $this->set('month', $m);
    }

    public function downloadMonthlyFollowUp($y = null, $m = null) {

        $results = $this->FollowUp->query("CALL getMonthlyFollowUp(" . $y . ", " . $m . ")");
        $this->set('results', $results);
        $this->set('year', $y);
        $this->set('month', $m);

        CakeLog::write('debug', 'FollowUpController.downloadMonthlyFollowUp() - 匯出月追蹤名單');
    }

    public function edit($id = null, $registrationId = null) {

        $this->FollowUp->id = $id;

        if ($this->request->is('get')) {

            $this->request->data = $this->FollowUp->read();
        } else {

            if (empty($this->request->data['FollowUp']['contact_result'])) {
                $this->request->data('FollowUp.contact_time', '');
            } else {
                $this->request->data('FollowUp.contact_time', date('Y-m-d'));
            }

            if ($this->FollowUp->save($this->request->data)) {

                $this->Session->setFlash('追蹤名單已更新！', 'alert', array(
                    'plugin' => 'TwitterBootstrap',
                    'class' => 'alert-success'
                ));
                CakeLog::write('debug', 'FollowUpController.edit() - 更新追蹤名單(' . $this->FollowUp->id . ')');

                $date = new DateTime($this->FollowUp->field('contact_time'));
                $this->redirect(array('action' => 'showMonthlyFollowUp', $date->format('Y'), $date->format('m')));
            } else {

                debug($this->FollowUp->validationErrors);

                $this->Session->setFlash('無法更新追蹤名單！', 'alert', array(
                    'plugin' => 'TwitterBootstrap',
                    'class' => 'alert-error'
                ));
                CakeLog::write('debug', 'FollowUpController.edit() - 無法更新追蹤名單');
            }
        }
    }

}

?>