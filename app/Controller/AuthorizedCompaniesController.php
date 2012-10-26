<?php

class AuthorizedCompaniesController extends AppController {

    public $uses = array('AuthorizedCompany');
    public $components = array('Session');

    public function index() {

        $this->set('authorized_companies', $this->paginate('AuthorizedCompany'));
        $this->set('title_for_layout', '心樂活診所 - 特約廠商');
    }

    public function add() {

        $this->set('title_for_layout', '心樂活診所 - 特約廠商');
        
        if ($this->request->is('post')) {
            if ($this->AuthorizedCompany->save($this->request->data)) {
                
                $this->Session->setFlash('特約廠商 ' . $this->AuthorizedCompany->field('description') . ' 資料已新增！', 'alert', array(
                    'plugin' => 'TwitterBootstrap',
                    'class' => 'alert-success'
                ));
                $this->redirect(array('action' => 'index'));
            } else {

                $this->Session->setFlash('無法新增特約廠商！', 'alert', array(
                    'plugin' => 'TwitterBootstrap',
                    'class' => 'alert-error'
                ));
            }
        }
    }

    public function edit($id = null) {

        $this->set('title_for_layout', '心樂活診所 - 特約廠商');
        
        $this->AuthorizedCompany->id = $id;
        
        if ($this->request->is('get')) {
            $this->request->data = $this->AuthorizedCompany->read();
        } else {
            if ($this->AuthorizedCompany->save($this->request->data)) {
                
                $this->Session->setFlash('特約廠商 ' . $this->AuthorizedCompany->field('description') . ' 資料已更新！', 'alert', array(
                    'plugin' => 'TwitterBootstrap',
                    'class' => 'alert-success'
                ));
                $this->redirect(array('action' => 'index'));
            } else {

                $this->Session->setFlash('無法更新特約廠商！', 'alert', array(
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

        $this->AuthorizedCompany->id = $id;
        $company_name = $this->AuthorizedCompany->field('description');

        $this->loadModel('Patient');
        $results = $this->Patient->findAllByAuthorizedCompanyId($this->AuthorizedCompany->id);

        if (empty($results)) {
            if ($this->AuthorizedCompany->delete($id)) {

                $this->Session->setFlash('特約廠商 ' . $company_name . ' 資料已刪除！', 'alert', array(
                    'plugin' => 'TwitterBootstrap',
                    'class' => 'alert-success'
                ));
            }
        } else {
            $this->Session->setFlash('特約廠商 ' . $company_name . ' 資料與其它記錄已連結，不能刪除！', 'alert', array(
                'plugin' => 'TwitterBootstrap',
                'class' => 'alert-error'
            ));
        }

        $this->redirect(array('action' => 'index'));
    }

}

?>