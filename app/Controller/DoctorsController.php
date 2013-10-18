<?php

class DoctorsController extends AppController {

    public $helpers = array('Time');
    public $uses = array('Doctor');
    public $components = array('Session');

    public function index() {

        $this->set('doctors', $this->Doctor->query("SELECT * FROM doctors"));
        $this->set('title_for_layout', '心樂活診所 - 醫師資料');
    }

    public function add() {

        $this->set('title_for_layout', '心樂活診所 - 醫師資料');
        
        if ($this->request->is('post')) {
            if ($this->Doctor->save($this->request->data)) {
                
                $this->Session->setFlash('醫師 ' . $this->Doctor->field('description') . ' 資料已新增！', 'alert', array(
                    'plugin' => 'TwitterBootstrap',
                    'class' => 'alert-success'
                ));
                $this->redirect(array('action' => 'index'));
            } else {

                $this->Session->setFlash('無法新增醫師！', 'alert', array(
                    'plugin' => 'TwitterBootstrap',
                    'class' => 'alert-error'
                ));
            }
        }
    }

    public function edit($id = null) {

        $this->set('title_for_layout', '心樂活診所 - 醫師資料');
        
        $this->Doctor->id = $id;
        
        if ($this->request->is('get')) {
            $data = $this->Doctor->query("SELECT * FROM doctors WHERE id = " . $id);
            $this->set('id', $id);
            $this->set('description', $data[0]['doctors']['description']);
            $this->set('available', $data[0]['doctors']['available']);
            $this->set('vacation_start', $data[0]['doctors']['vacation_start']);
            $this->set('vacation_end', $data[0]['doctors']['vacation_end']);
        } else {
            if ($this->Doctor->save($this->request->data)) {
                
                $this->Session->setFlash('醫師 ' . $this->Doctor->field('description') . ' 資料已更新！', 'alert', array(
                    'plugin' => 'TwitterBootstrap',
                    'class' => 'alert-success'
                ));
                $this->redirect(array('action' => 'index'));
            } else {

                $this->Session->setFlash('無法更新醫師資料！', 'alert', array(
                    'plugin' => 'TwitterBootstrap',
                    'class' => 'alert-error'
                ));
            }
        }
    }

    public function delete($id = null) {

        if ($this->request->is('get')) {
            throw new MethodNotAllowedException();
        }

        $this->Doctor->id = $id;
        $doctor_name = $this->Doctor->field('description');

        $results = $this->Doctor->query("SELECT count(id) AS count FROM doctors_registrations WHERE doctor_id = " . $id);

        if ((int)$results[0][0]['count'] == 0)  {
            if ($this->Doctor->delete($id)) {

                $this->Session->setFlash('醫師 ' . $doctor_name . ' 資料已刪除！', 'alert', array(
                    'plugin' => 'TwitterBootstrap',
                    'class' => 'alert-success'
                ));
            }
        } else {
            $this->Session->setFlash('醫師 ' . $doctor_name . ' 資料與其它記錄已連結，不能刪除！', 'alert', array(
                'plugin' => 'TwitterBootstrap',
                'class' => 'alert-error'
            ));
        }

        $this->redirect(array('action' => 'index'));
    }

}

?>