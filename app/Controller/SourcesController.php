<?php

class SourcesController extends AppController {

    public $uses = array('Source');
    public $components = array('Session');

    public function index() {

        $this->set('sources', $this->paginate('Source'));
        $this->set('title_for_layout', '心樂活診所 - 初診來源');
    }

    public function add() {

        $this->set('title_for_layout', '心樂活診所 - 初診來源');
        
        if ($this->request->is('post')) {
            if ($this->Source->save($this->request->data)) {
                
                $this->Session->setFlash('初診來源 ' . $this->Source->field('description') . ' 資料已新增！', 'alert', array(
                    'plugin' => 'TwitterBootstrap',
                    'class' => 'alert-success'
                ));
                $this->redirect(array('action' => 'index'));
            } else {

                $this->Session->setFlash('無法新增初診來源！', 'alert', array(
                    'plugin' => 'TwitterBootstrap',
                    'class' => 'alert-error'
                ));
            }
        }
    }

    public function edit($id = null) {

        $this->set('title_for_layout', '心樂活診所 - 初診來源');
        
        $this->Source->id = $id;
        
        if ($this->request->is('get')) {
            $this->request->data = $this->Source->read();
        } else {
            if ($this->Source->save($this->request->data)) {
                
                $this->Session->setFlash('初診來源 ' . $this->Source->field('description') . ' 資料已更新！', 'alert', array(
                    'plugin' => 'TwitterBootstrap',
                    'class' => 'alert-success'
                ));
                $this->redirect(array('action' => 'index'));
            } else {

                $this->Session->setFlash('無法更新初診來源！', 'alert', array(
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

        $this->Source->id = $id;
        $source_name = $this->Source->field('description');

        $this->loadModel('Patient');
        $results = $this->Patient->findAllBySourceId($this->Source->id);

        if (empty($results)) {
            if ($this->Source->delete($id)) {

                $this->Session->setFlash('初診來源 ' . $source_name . ' 資料已刪除！', 'alert', array(
                    'plugin' => 'TwitterBootstrap',
                    'class' => 'alert-success'
                ));
            }
        } else {
            $this->Session->setFlash('初診來源 ' . $source_name . ' 資料與其它記錄已連結，不能刪除！', 'alert', array(
                'plugin' => 'TwitterBootstrap',
                'class' => 'alert-error'
            ));
        }

        $this->redirect(array('action' => 'index'));
    }

}

?>