<?php

class AppointmentsController extends AppController {

    public $helpers = array('Time');
    public $uses = array('Appointment', 'AppointmentContact', 'Notification', 'Registration', 'TimeSlot');
    public $components = array('Session');

    public function showDailyAppointment($y = null, $m = null, $d = null) {

        $date = date("Y-m-d", mktime(0, 0, 0, 
                (is_null($m) ? $m = date("m") : $m), 
                (is_null($d) ? $d = date("d") : $d), 
                (is_null($y) ? $y = date("Y") : $y)
                ));
        $results = $this->Appointment->query("CALL getDailyAppointment('" . $date . "')");
        $this->set('results', $results);
        $this->set('year', $y);
        $this->set('month', $m);
        $this->set('day', $d);        
    }

    public function add() {

        $this->set('notifications', $this->Notification->find('list', array('fields' => 'id, description')));

        if ($this->request->is('post')) {

            $patient_id = null;

            // 合併門診日期及門診時間
            $appointment_time = $this->request->data['Appointment']['appointment_date'] . ' ' . 
                                date('H:i:s', strtotime($this->request->data['Appointment']['appointment_datetime']));
            $this->request->data('Appointment.appointment_time', $appointment_time);
            $date = new DateTime($this->request->data['Appointment']['appointment_time']);

            // 檢查病歷號是否存在
            if (!empty($this->request->data['Appointment']['serial_number'])) {

                $serial_number = trim($this->request->data['Appointment']['serial_number']);
                $serial_number = str_pad($serial_number, 7, '0', STR_PAD_LEFT);

                $this->loadModel('Patient');
                $result = $this->Patient->findBySerialNumber($serial_number, array('id', 'name', 'phone'));
                // 取出病患 id 及修改 Request 的病患姓名
                if (!empty($result)) {

                    $patient_id = $result['Patient']['id'];
                    $this->request->data('Appointment.contact_name', $result['Patient']['name']);
                    $this->request->data('Appointment.contact_phone', $result['Patient']['phone']);
                    CakeLog::write('debug', 'AppointmentsController.add() - 掛號證 ' . $serial_number . ' 存在，取出 id 與病患姓名');
                }
            }

            // 預先建立預約與門診記錄存放陣列
            $appointment_data = array();
            $registration_data = array();

            // 預約人數可多於一人，同時建立預約與門診陣列資料
            $contact_number = intval($this->request->data['Appointment']['contact_number']) + 1;
            for ($i = 0; $i < $contact_number; $i++) {
                $appointment_data[] = $this->request->data;
                if ($i != 0) {
                    $str = '與『' . $this->request->data['Appointment']['contact_name'] . '』同行';
                    $appointment_data[$i]['Appointment']['contact_name'] = $str;
                    $appointment_data[$i]['Appointment']['note'] = '';
                    $patient_id = null;
                }
                $registration_data[] = array('Registration' => array(
                        'registration_time' => $appointment_data[$i]['Appointment']['appointment_time'],
                        'time_slot_id' => $this->TimeSlot->getTimeSlot($appointment_data[$i]['Appointment']['appointment_time']),
                        'patient_name' => $appointment_data[$i]['Appointment']['contact_name'],
                        'patient_phone' => $appointment_data[$i]['Appointment']['contact_phone'],
                        'patient_id' => $patient_id
                ));

                $this->Appointment->create();
                $this->Registration->create();
                if ($this->Appointment->save($appointment_data[$i]) && 
                    $this->Registration->save($registration_data[$i])) {

                    CakeLog::write('debug', 'AppointmentsController.add() - 建立預約記錄(' . $this->Appointment->id . ')');
                    CakeLog::write('debug', 'AppointmentsController.add() - 建立預約記錄(' . $this->Appointment->id . ')連結的門診資料(' . $this->Registration->id . ')');

                    $this->Appointment->setNextRegistration($this->Registration->id, $this->Appointment->id);
                    CakeLog::write('debug', 'AppointmentsController.add() - 建立預約記錄(' . $this->Appointment->id . ')與預約記錄連結的門診資料(' . $this->Registration->id . ')的關係');

                    $this->Session->setFlash('預約時段已新增！', 'alert', array(
                        'plugin' => 'TwitterBootstrap',
                        'class' => 'alert-success'
                    ));
                } else {

                    $this->Session->setFlash('無法新增預約資料！', 'alert', array(
                        'plugin' => 'TwitterBootstrap',
                        'class' => 'alert-error'
                    ));
                    CakeLog::write('debug', 'AppointmentsController.add() - 無法新增預約資料');
                }
            }

            $this->redirect(array('action' => 'showDailyAppointment', $date->format('Y'), $date->format('m'), $date->format('d')));
        }
    }

    public function edit($id = null) {

        $this->Appointment->id = $id;

        $this->set('notifications', $this->Notification->find('list', array('fields' => 'id, description')));

        // 是否顯示關懷時間與關懷結果
        $isNoShow = $this->isNoShow($id);
        $this->set('isNoShow', $isNoShow);
        CakeLog::write('debug', 'AppointmentsController.edit() - 是否顯示關懷欄位？ ' . $isNoShow);

        // 是否凍結聯絡姓名
        $isNameFixed = $this->isNameFixed($id);
        $this->set('isNameFixed', $isNameFixed);
        CakeLog::write('debug', 'AppointmentsController.edit() - 是否凍結名字欄位？ ' . $isNameFixed);

        $isLinked = $this->isLinkedToOther($id);
        CakeLog::write('debug', 'AppointmentsController.edit() - 連結門診有無資料？ ' . $isLinked);

        if ($this->request->is('get')) {

            $this->request->data = $this->Appointment->read();

            $this->request->data('Appointment.is_no_show', (($isNoShow) ? '1' : '0'));
            
            $date = new DateTime($this->request->data['Appointment']['appointment_time']);
            $this->set('appointment_date', $date->format('Y-m-d'));
            $this->set('appointment_datetime', $date->format('h:i A'));
            $this->request->data('Appointment.appointment_date', $date->format('Y-m-d'));
            $this->request->data('Appointment.appointment_datetime', $date->format('h:i A'));
        } else {
            // 合併預約日期及預約時間
            $appointment_time = $this->request->data['Appointment']['appointment_date'] . ' ' . 
                                date('H:i:s', strtotime($this->request->data['Appointment']['appointment_datetime']));
            $this->request->data('Appointment.appointment_time', $appointment_time);
            $date = new DateTime($appointment_time);

            if (!$isLinked) {

                if ($this->Appointment->save($this->request->data)) {

                    // 未勾選『爽約』
                    if (strcmp($this->request->data['Appointment']['is_no_show'], '0') == 0) {

                        // 更新預約記錄連結的門診資料
                        $this->Registration->id = $this->Appointment->getNextRegistrationId($id);
                        $this->Registration->saveField('registration_time', $this->request->data['Appointment']['appointment_time']);
                        $this->Registration->saveField('patient_name', $this->request->data['Appointment']['contact_name']);
                        CakeLog::write('debug', 'AppointmentsController.edit() - 更新預約記錄(' . $id . ')連結的門診資料(' . $this->Registration->id .')');
                    }

                    // 有勾選『爽約』
                    if (strcmp($this->request->data['Appointment']['is_no_show'], '1') == 0) {

                        if ($isNoShow) {
                            // 過去已經有選『爽約』，修改關懷內容
                            $result = $this->AppointmentContact->findByAppointmentId($id, array('id'));
                            $this->AppointmentContact->id = $result['AppointmentContact']['id'];
                            if (!empty($this->request->data['AppointmentContact']['contact_result'])) {
                                $this->AppointmentContact->saveField('contact_time', date('Y-m-d'));
                                $this->AppointmentContact->saveField('contact_result', $this->request->data['AppointmentContact']['contact_result']);
                            }
                            CakeLog::write('debug', 'AppointmentsController.edit() - 更新預約記錄(' . $id . ')連結的關懷清單(' . $this->AppointmentContact->id . ')');
                        } else {
                            // 之前沒有選過『爽約』，新增至關懷清單
                            $this->AppointmentContact->create();
                            $data = array(
                                'AppointmentContact' => array(
                                    'appointment_id' => $id,
                                    'contact_time' => date('Y-m-d'),
                                    'contact_result' => $this->request->data['AppointmentContact']['contact_result']
                                    ));
                            $this->AppointmentContact->save($data);
                            CakeLog::write('debug', 'AppointmentsController.edit() - 建立預約記錄(' . $id . ')連結的關懷清單(' . $this->AppointmentContact->id . ')');

                            // 因為『沒有出現』，門診記錄要跟著刪除
                            $nextRegistrationId = $this->Appointment->getNextRegistrationId($id);
                            // 先刪除預約記錄與門診資料的關係
                            $this->Appointment->deleteNextRegistration($nextRegistrationId, $id);
                            CakeLog::write('debug', 'AppointmentsController.edit() - 刪除預約記錄(' . $id . ')與預約記錄連結的門診資料(' . $nextRegistrationId .')的關係');
                            // 最後刪除門診資料
                            $this->Registration->delete($nextRegistrationId);
                            CakeLog::write('debug', 'AppointmentsController.edit() - 刪除預約記錄(' . $id . ')連結的門診資料(' . $nextRegistrationId .')');
                        }
                    }

                    $this->Session->setFlash('預約資料已更新！', 'alert', array(
                        'plugin' => 'TwitterBootstrap',
                        'class' => 'alert-success'
                    ));
                    CakeLog::write('debug', 'AppointmentsController.edit() - 更新預約記錄(' . $id . ')');

                    $this->redirect(array('action' => 'showDailyAppointment', $date->format('Y'), $date->format('m'), $date->format('d')));
                } else {

                    $this->Session->setFlash('預約資料不能更新！');
                    CakeLog::write('debug', 'AppointmentsController.edit() - 預約資料不能更新');
                }
            } else {

                $this->Session->setFlash('預約記錄與其他記錄已連結，不能修改『爽約』！', 'alert', array(
                    'plugin' => 'TwitterBootstrap',
                    'class' => 'alert-error'
                ));
                CakeLog::write('debug', 'AppointmentsController.edit() - 預約記錄(' . $id . ')與其他記錄已連結，不能修改『爽約』');

                $this->redirect(array('action' => 'showDailyAppointment', $date->format('Y'), $date->format('m'), $date->format('d')));
            }
        }
    }

    public function delete($id = null) {

        if ($this->request->is('get')) {
            throw new MethodNotAllowedException();
        }

        $this->Appointment->id = $id;
        $date = new DateTime($this->Appointment->field('appointment_time')); 

        if (!$this->isLinkedToOther($id)) {

            // 如果預約記錄是某次門診的後續動作
            $previousRegistrationId = $this->Appointment->getPreviousRegistrationId($id);
            if (!is_null($previousRegistrationId)) {
                // 先刪除預約記錄與某次門診記錄的關係
                $this->Appointment->deletePreviousRegistration($previousRegistrationId, $id);
                CakeLog::write('debug', 'AppointmentsController.delete() - 刪除預約記錄(' . $id .')與預約記錄連結的前次門診資料(' . $previousRegistrationId . ')的關係');
                $this->loadModel('Further');
                // 取得該次門診的後續動作 id
                $furtherId = $this->Further->getFurtherId($previousRegistrationId);
                if (!is_null($furtherId)) {
                    // 設定該次門診的後續動作為放入追蹤清單
                    $this->Further->setFurtherToFinish($furtherId);
                    CakeLog::write('debug', 'RegistrationsController.delete() - 更新預約記錄(' . $id . ')連結的前次門診資料(' . $previousRegistrationId . ')的後續動作為『結束』');
                }
            }

            $nextRegistrationId = $this->Appointment->getNextRegistrationId($id);
            if (!is_null($nextRegistrationId)) {
                // 先刪除預約與門診記錄的關係
                $this->Appointment->deleteNextRegistration($nextRegistrationId, $id);
                CakeLog::write('debug', 'AppointmentsController.delete() - 刪除預約記錄(' . $id . ')與門診資料(' . $nextRegistrationId . ')的關係');
                // 再刪除門診記錄
                $this->Registration->delete($nextRegistrationId);
                CakeLog::write('debug', 'AppointmentsController.delete() - 刪除預約記錄(' . $id . ')連結的門診資料(' . $nextRegistrationId . ')');
            }

            $appointmentContactId = $this->AppointmentContact->getAppointmentContactId($id);
            if (!is_null($appointmentContactId)) {

                $this->AppointmentContact->delete($appointmentContactId);
                CakeLog::write('debug', 'AppointmentsController.delete() - 刪除預約記錄(' . $id . ')連結的關懷資料(' . $appointmentContactId . ')');
            }

            $this->Appointment->delete($id);
            $this->Session->setFlash('預約記錄已刪除！', 'alert', array(
                'plugin' => 'TwitterBootstrap',
                'class' => 'alert-success'
            ));
            CakeLog::write('debug', 'AppointmentsController.delete() - 刪除預約記錄(' . $id . ')');
        } else {

            $this->Session->setFlash('預約資料與其它記錄已連結，不能刪除！', 'alert', array(
                'plugin' => 'TwitterBootstrap',
                'class' => 'alert-error'
            ));
            CakeLog::write('debug', 'AppointmentsController.delete() - 預約資料與其它記錄已連結，不能刪除');
        }

        $this->redirect(array('action' => 'showDailyAppointment', $date->format('Y'), $date->format('m'), $date->format('d')));
    }

    public function search($parm) {
    }

    private function isLinkedToOther($id = null) {

        $isLinked = false;

        $registrationId = $this->Appointment->getNextRegistrationId($id);
        if (!is_null($registrationId)) {

            $this->loadModel('Bill');
            $billId = $this->Bill->getBillId($registrationId);
            if (!is_null($billId)) {
                return $isLinked = true;
            }

            $this->loadModel('Further');
            $furtherId = $this->Further->getFurtherId($registrationId);
            if (!is_null($furtherId)) {
                return $isLinked = true;
            }

            return $isLinked;
        } else {

            return $isLinked;
        }
    }

    private function isNameFixed($id = null) {

        $isNameFixed = false;

        // 如果是門診資料後續動作產生的預約記錄，不可以改名字
        $previousRegistrationId = $this->Appointment->getPreviousRegistrationId($id);
        if (!is_null($previousRegistrationId)) {
            return $isNameFixed = true;
        }

        // 如果是預約記錄連結的門診資料已經設定病患資料，不可以改名字
        $nextRegistrationId = $this->Appointment->getNextRegistrationId($id);
        if (!is_null($nextRegistrationId)) {
            $this->Registration->id = $nextRegistrationId;
            $patient_id = $this->Registration->field('patient_id');
            if (!empty($patient_id)) {
                return $isNameFixed = true;
            }
        }

        // 如果預約記錄有設定爽約，不可以改名字
        $isNameFixed = $this->isNoShow($id);

        return $isNameFixed;
    }

    private function isNoShow($id = null) {

        $isNoShow = false;

        $result = $this->AppointmentContact->findByAppointmentId($id, array('id'));
        if (!empty($result)) {
            $isNoShow = true;
        }

        return $isNoShow;
    }

}

?>
