<?php

class AppointmentContactsController extends AppController {

    public $helpers = array('Time');
    public $uses = array('Appointment', 'AppointmentContact');
    public $components = array('Session');

    public function showMonthlyAppointmentContact($y = null, $m = null) {

        if ($this->request->is('get')) { 
            is_null($m) ? $m = date("m") : $m;
            is_null($y) ? $y = date("Y") : $y;
        }

        if ($this->request->is('post')) {
            $y = $this->request->data['AppointmentContact']['y']['year'];
            $m = $this->request->data['AppointmentContact']['m']['month'];
        }

        $results = $this->AppointmentContact->query("CALL getMonthlyAppointmentContact(" . $y . ", " . $m . ")");
        $this->set('results', $results);
        $this->set('year', $y);
        $this->set('month', $m);
    }

    public function edit($id = null) {

    	$this->AppointmentContact->id = $id;

    	if ($this->request->is('get')) {

            $this->request->data = $this->AppointmentContact->read();
            
            $this->set('appointment_time', date('Y-m-d', strtotime($this->request->data['Appointment']['appointment_time']))); 		
    	} else {

            if (empty($this->request->data['AppointmentContact']['contact_result'])) {
                $this->request->data('AppointmentContact.contact_time', '');
            } else {
                $this->request->data('AppointmentContact.contact_time', date('Y-m-d'));
            }
            
            if ($this->AppointmentContact->save($this->request->data)) {
                
                $this->Session->setFlash('關懷名單已更新！', 'alert', array(
                    'plugin' => 'TwitterBootstrap',
                    'class' => 'alert-success'
                ));                
                CakeLog::write('debug', 'AppointmentContactsController.edit() - 更新關懷名單(' . $this->AppointmentContact->id . ')');

                $date = new DateTime($this->AppointmentContact->field('contact_time'));
                $this->redirect(array('action' => 'showMonthlyAppointmentContact', $date->format('Y'), $date->format('m')));
            } else {
                
                $this->Session->setFlash('無法更新關懷名單！', 'alert', array(
                    'plugin' => 'TwitterBootstrap',
                    'class' => 'alert-error'
                ));    
                CakeLog::write('debug', 'AppointmentContactsController.edit() - 無法更新關懷名單');
            }    		
    	}
    }

}

?>