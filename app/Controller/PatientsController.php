<?php

class PatientsController extends AppController {

    public $helpers = array('Time');
    public $uses = array('Patient', 'Source');
    public $components = array('Session');

    public function index() {

        // 設定分頁功能
        $this->paginate = array(
            // 以掛號證來排序，降冪排序
            'order' => array('serial_number' => 'desc'),
            // 每頁 25 筆記錄
            'limit' => 25
        );
        $this->set('patients', $this->paginate('Patient'));
        $this->set('title_for_layout', '心樂活診所 - 病患資料');
    }

    public function add($registration_id = null, $patient_name = null) {

        $this->set('title_for_layout', '心樂活診所 - 病患資料');

        // 填滿初診來源
        $this->set('sources', $this->Source->find('list', array('fields' => 'id, description')));

        // 如果已經有輸入名字，塞到『病患姓名』欄位
        if (!is_null($patient_name)) {
            $this->set('name', $patient_name);
        } else {
            $this->set('name', null);
        }

        if ($this->request->is('post')) {

            // 如果掛號證字串不到 7 位數，填滿它
            $this->request->data('Patient.serial_number', str_pad(trim($this->request->data['Patient']['serial_number']), 7, '0', STR_PAD_LEFT));

            if ($this->Patient->save($this->request->data)) {

                // 有指定 Registration id 時，需要更改門診資料
                if (!is_null($registration_id)) {

                    $this->loadModel('Registration');
                    $data = array(
                        'id' => $registration_id,
                        'patient_id' => $this->Patient->id,
                        'patient_name' => $this->Patient->field('name')
                    );
                    $this->Registration->save($data, array('fields' => 'id, patient_id, patient_name'));
                    $this->redirect(array('controller' => 'Registrations', 'action' => 'index'));
                }

                $this->Session->setFlash('病患 ' . $this->Patient->field('name') . ' 資料已新增！', 'alert', array(
                    'plugin' => 'TwitterBootstrap',
                    'class' => 'alert-success'
                ));

                $this->redirect(array('action' => 'index'));
            } else {

                $this->Session->setFlash('無法新增病患資料！', 'alert', array(
                    'plugin' => 'TwitterBootstrap',
                    'class' => 'alert-error'
                ));
            }
        }
    }

    public function edit($id = null) {

        $this->set('title_for_layout', '心樂活診所 - 病患資料');

        $this->Patient->id = $id;
        $this->set('sources', $this->Source->find('list', array('fields' => 'id, description')));

        if ($this->request->is('get')) {

            $this->request->data = $this->Patient->read();
        } else {

            // 如果掛號證字串不到 7 位數，填滿它
            $this->request->data('Patient.serial_number', str_pad(trim($this->request->data['Patient']['serial_number']), 7, '0', STR_PAD_LEFT));

            if ($this->Patient->save($this->request->data)) {

                $this->Session->setFlash('病患 ' . $this->Patient->field('name') . ' 資料已更新！', 'alert', array(
                    'plugin' => 'TwitterBootstrap',
                    'class' => 'alert-success'
                ));
                $this->redirect(array('action' => 'index'));
            } else {

                $this->Session->setFlash('無法更新病患資料！', 'alert', array(
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

        $this->Patient->id = $id;
        $patient_name = $this->Patient->field('name');

        if ($this->Patient->delete($id)) {

            $this->Session->setFlash('病患 ' . $patient_name . ' 資料已刪除！', 'alert', array(
                'plugin' => 'TwitterBootstrap',
                'class' => 'alert-success'
            ));
            $this->redirect(array('action' => 'index'));
        }
    }

    public function search() {

        $this->set('title_for_layout', '心樂活診所 - 病患資料');

        if (!is_null($this->request->data['Patient']['parm'])) {

            $patients = $this->Patient->find('all', array(
                'conditions' => array('Patient.name LIKE' => $this->request->data['Patient']['parm'])
                    ));

            if (empty($patients)) {

                $serial_number = str_pad($this->request->data['Patient']['parm'], 7, '0', STR_PAD_LEFT);

                $patients = $this->Patient->find('all', array(
                    'conditions' => array('Patient.serial_number' => $serial_number)
                        ));

                if (!empty($patients)) {
                    $this->set('patients', $patients);
                } else {
                    $this->set('patients', null);
                }
            } else {
                $this->set('patients', $patients);
            }
        } else {
            $this->set('patients', null);
        }
    }

    private function csv_to_array($filename = '', $delimiter = ',') {

        if (!file_exists($filename) || !is_readable($filename)) {
            return false;
        }

        $header = null;
        $data = array();
        if (($handle = fopen($filename, 'r')) !== false) {
            while (($row = fgetcsv($handle, 1000, $delimiter)) !== false) {
                if (!$header) {
                    $header = $row;
                } else {
                    $data[] = array_combine($header, $row);
                }
            }
            fclose($handle);
        }
        return $data;
    }

    private function compare_date($d1, $d2) {

        // if d1 > d2 return 1
        // if d1 < d2 return -1
        // if d1 = d2 return 0

        $d1_pieces = explode('-', $d1);
        $d2_pieces = explode('-', $d2);

        if ((int) $d1_pieces[0] > (int) $d2_pieces[0]) {
            return 1;
        }

        if ((int) $d1_pieces[0] < (int) $d2_pieces[0]) {
            return -1;
        }

        if ((int) $d1_pieces[0] == (int) $d2_pieces[0]) {
            if ((int) $d1_pieces[1] > (int) $d2_pieces[1]) {
                return 1;
            } else {
                return -1;
            }
        }

        if ((int) $d1_pieces[0] == (int) $d2_pieces[0] && (int) $d1_pieces[1] == (int) $d2_pieces[1]) {
            return 0;
        }
    }

    public function import() {

        App::uses('Folder', 'Utility');
        App::uses('File', 'Utility');

        $this->loadModel('Appointment');
        $this->loadModel('Registration');
        $this->loadModel('Bill');
        $this->loadModel('FollowUp');

        $totalPatientName = $this->Patient->find('list', array('fields' => array('name')));

        $dir = new Folder('/Users/yaosiang/Documents/MAMP/htdocs/lohas/app/tmp/CSVs');
        $files = $dir->find('.*\.csv');

        $fi = array();
        $na = array();
        $re = array();
        $da = array();

        $count = 0;

        foreach ($files as $file) {

            $file = new File($dir->pwd() . DS . $file);
            $data = $this->csv_to_array($dir->pwd() . DS . $file->name);

            foreach ($data as $d) {

                $key = array_search($d['姓名'], $totalPatientName);

                $count++;

                // 修改診別
                if (strcmp($d['診別'], '') != 0) {
                    $no = Set::enum($d['診別'], array('早' => 0, '午' => 1, '晚' => 2));
                    if ($no == 0 || $no == 1 || $no == 2) {
                        $timeslot = $d['診別'];
                    }
                } else {
                    $d['診別'] = $timeslot;
                }

                $time_slot_id = 0;
                if (strcmp($d['診別'], '早') == 0) {
                    $time_slot_id = 1;
                }
                if (strcmp($d['診別'], '午') == 0) {
                    $time_slot_id = 2;
                }
                if (strcmp($d['診別'], '晚') == 0) {
                    $time_slot_id = 3;
                }

                // 建立門診記錄
                // $this->Registration->create();
                // $this->Registration->save(array(
                //         'registration_time' => basename($file->name, '.csv'),
                //         'time_slot_id' => $time_slot_id,
                //         'patient_name' => $d['姓名'],
                //         'patient_id' => $key,
                //         'note' => $d['備註']
                //     ));
                // 建立就診身分
                $identity_id = 0;
                if (strrchr($d['身分'], '+')) {
                    $pieces = explode('+', $d['身分']);
                    foreach ($pieces as $p) {
                        if (strcmp($p, '健') == 0) {
                            $identity_id = 1;
                        }
                        if (strcmp($p, '自') == 0) {
                            $identity_id = 2;
                        }
                        if (strcmp($p, '榮') == 0) {
                            $identity_id = 3;
                        }
                        if (strcmp($p, '福') == 0) {
                            $identity_id = 4;
                        }
                        if (strcmp($p, '重') == 0) {
                            $identity_id = 5;
                        }
                        if (strcmp($p, '殘') == 0) {
                            $identity_id = 6;
                        }
                        // $str = 'INSERT INTO identities_registrations (registration_id, identity_id) VALUES (' . $this->Registration->id . ', ' . $identity_id  . ')';
                        // $this->Patient->query($str);                                                                                                           
                    }
                } else {
                    if (strcmp($d['身分'], '健') == 0) {
                        $identity_id = 1;
                    }
                    if (strcmp($d['身分'], '自') == 0) {
                        $identity_id = 2;
                    }
                    if (strcmp($d['身分'], '榮') == 0) {
                        $identity_id = 3;
                    }
                    if (strcmp($d['身分'], '福') == 0) {
                        $identity_id = 4;
                    }
                    if (strcmp($d['身分'], '重') == 0) {
                        $identity_id = 5;
                    }
                    if (strcmp($d['身分'], '殘') == 0) {
                        $identity_id = 6;
                    }
                    // $str = 'INSERT INTO identities_registrations (registration_id, identity_id) VALUES (' . $this->Registration->id . ', ' . $identity_id  . ')';
                    // $this->Patient->query($str);  
                }

                // 建立門診收入
                // $this->Bill->create();
                // $this->Bill->save(array(
                //     'registration_id' => $this->Registration->id,
                //     'registration_fee' => empty($d['掛號']) ? 0 : $d['掛號'],
                //     'copayment' => empty($d['部分']) ? 0 : $d['部分'],
                //     'drug_expense' => empty($d['藥費']) ? 0 : $d['藥費'],
                //     'own_expense' => empty($d['自費']) ? 0 : $d['自費']
                //     ));

                array_push($fi, basename($file->name, '.csv'));
                array_push($na, $d['姓名']);

                if (strcmp($d['預約'], '') != 0) {

                    if (strrchr($d['預約'], '/')) {

                        $f = str_replace('/', '-', $d['預約']);
                        array_push($da, $f);
                        array_push($re, '預約');
                        // $str = 'INSERT INTO furthers_registrations (registration_id, further_id) VALUES (' . $this->Registration->id .', 1)';
                        // $this->Patient->query($str);
                    }

                    if (strrchr($d['預約'], '月')) {

                        $f = str_replace('月', '-', $d['預約']);

                        if (strrchr($f, '日')) {
                            $f = str_replace('日', '', $f);
                        }

                        if (substr_count($f, '-') == 1) {
                            if ($this->compare_date(date('n-j', strtotime(basename($file->name, '.csv'))), $f) == 1) {
                                $f = '2012-' . $f;
                            } elseif ($this->compare_date(date('n-j', strtotime(basename($file->name, '.csv'))), $f) == -1) {
                                $f = date('Y', strtotime(basename($file->name, '.csv'))) . '-' . $f;
                            }
                        }
                        array_push($da, $f);
                        array_push($re, '預約');
                        // $str = 'INSERT INTO furthers_registrations (registration_id, further_id) VALUES (' . $this->Registration->id .', 1)';
                        // $this->Patient->query($str);                        
                    }
                }

                if (strcmp($d['追蹤'], '') != 0) {

                    if (strrchr($d['追蹤'], '/')) {

                        $r = str_replace('/', '-', $d['追蹤']);
                        array_push($da, $r);
                        array_push($re, '追蹤');
                        // $str = 'INSERT INTO furthers_registrations (registration_id, further_id) VALUES (' . $this->Registration->id .', 2)';
                        // $this->Patient->query($str);
                        // $this->FollowUp->create();
                        // $this->FollowUp->save(array(
                        //     'registration_id' => $this->Registration->id,
                        //     'patient_id' => $key,
                        //     'follow_up_time' => $r
                        //     ));
                    }

                    if (strrchr($d['追蹤'], '月')) {

                        $r = str_replace('月', '-', $d['追蹤']);

                        if (strrchr($r, '日')) {
                            $r = str_replace('日', '', $r);
                        }

                        if (substr_count($r, '-') == 1) {
                            if ($this->compare_date(date('n-j', strtotime(basename($file->name, '.csv'))), $r) == 1) {
                                $r = '2012-' . $r;
                            } elseif ($this->compare_date(date('n-j', strtotime(basename($file->name, '.csv'))), $r) == -1) {
                                $r = date('Y', strtotime(basename($file->name, '.csv'))) . '-' . $r;
                            }
                        }
                        array_push($da, $r);
                        array_push($re, '追蹤');
                        // $str = 'INSERT INTO furthers_registrations (registration_id, further_id) VALUES (' . $this->Registration->id .', 2)';
                        // $this->Patient->query($str);
                        // $this->FollowUp->create();                      
                        // $this->FollowUp->save(array(
                        //    'registration_id' => $this->Registration->id,
                        //    'patient_id' => $key,
                        //    'follow_up_time' => $r
                        //    ));                        
                    }
                }

                if (strcmp($d['追蹤'], '') == 0 && strcmp($d['預約'], '') == 0) {
                    array_push($re, '結束');
                    array_push($da, '');
                    // $str = 'INSERT INTO furthers_registrations (registration_id, further_id) VALUES (' . $this->Registration->id .', 3)';
                    // $this->Patient->query($str);
                }
            }
        }

        for ($i = 1; $i <= count($totalPatientName); $i++) {

            $k = array_keys($na, $totalPatientName[$i]);

            for ($j = 0; $j < count($k); $j++) {

                echo $fi[$k[$j]] . ' | ' . $na[$k[$j]] . ' | ' . $re[$k[$j]] . ' | ' . $da[$k[$j]] . '<br />';

                if (strcmp($re[$k[$j]], '追蹤') == 0) {

                    if (($j + 1) != count($k)) {

                        //         $registration_count = $this->Registration->find('count', array('conditions' => array(
                        //             'Registration.patient_id =' => $i,
                        //             'Registration.registration_time = ' => $fi[$k[$j]]
                        //             )));
                        //         if ($registration_count != 1) {
                        //             $registration_id_list = $this->Registration->find('list', array(
                        //                 'fields' => 'id',
                        //                 'conditions' => array(
                        //                     'Registration.patient_id =' => $i,
                        //                     'Registration.registration_time = ' =>$fi[$k[$j]]
                        //                 )));
                        //             foreach ($registration_id_list as $r_id) {
                        //                 $result = $this->Patient->query('SELECT further_id FROM furthers_registrations WHERE registration_id = ' . $r_id);
                        //                 if ($result[0]['furthers_registrations']['further_id'] == 2) {
                        //                     $follow_up_id = $this->FollowUp->field('id', array(
                        //                         'FollowUp.patient_id =' => $i,
                        //                         'FollowUp.registration_id = ' => $r_id
                        //                         ));
                        //                     $this->FollowUp->id = $follow_up_id;
                        //                     $this->FollowUp->saveField('come_back_time', $fi[$k[$j+1]]);
                        //                 }
                        //             }
                        //         } else {
                        //             $registration_id = $this->Registration->field('id', array(
                        //                     'Registration.patient_id =' => $i,
                        //                     'Registration.registration_time = ' =>$fi[$k[$j]]
                        //                 ));
                        //             $follow_up_id = $this->FollowUp->field('id', array(
                        //                 'FollowUp.patient_id =' => $i,
                        //                 'FollowUp.registration_id = ' => $registration_id
                        //                 ));
                        //             $this->FollowUp->id = $follow_up_id;
                        //             $this->FollowUp->saveField('come_back_time', $fi[$k[$j+1]]);
                        //         }
                    }
                }

                // 還要處理 reg 跟 app 之間的關係
                // TODO!!!!
                if (strcmp($re[$k[$j]], '預約') == 0) {

                    if (($j + 1) != count($k)) {

                        if (strcmp($da[$k[$j]], date('Y-n-j', strtotime($fi[$k[$j + 1]]))) == 0) {
                            // $this->Appointment->create();
                            // $this->Appointment->save(array(
                            //    'appointment_time' => $da[$k[$j]],
                            //    'contact_name' => $na[$k[$j]],
                            //    'contact_phone' => $this->Patient->field('phone', array('Patient.name = ' => $na[$k[$j]])),
                            //    'notification_id' => 1
                            //    ));                          
                        } else {
                            // $this->Appointment->create();
                            // $this->Appointment->save(array(
                            //    'appointment_time' => $fi[$k[$j+1]],
                            //    'contact_name' => $na[$k[$j]],
                            //    'contact_phone' => $this->Patient->field('phone', array('Patient.name = ' => $na[$k[$j]])),
                            //    'notification_id' => 1
                            //    ));
                        }
                    }
                }
            }
        }
    }

}

?>