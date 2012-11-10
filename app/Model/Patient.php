<?php

class Patient extends AppModel {

    public $validate = array(
        'nickname' => array(
            'rule' => array('maxLength', '140'),
            'message' => '最大不能超過 140 個字',
            'allowEmpty' => true
        ),
        'serial_number' => array(
            'minLength' => array(
                'rule' => array('minLength', '7'),
                'message' => '掛號證最少需要 7 位'
            ),
            'isUnique' => array(
                'rule' => 'isUnique',
                'message' => '掛號證已經被其它病患使用'
            )
        ),
        'birthday' => array(
            'minLength' => array(
                'rule' => array('minLength', '7'),
                'message' => '生日最少需要 7 位'
            ),
            'maxLength' => array(
                'rule' => array('maxLength', '7'),
                'message' => '生日最多只能 7 位'
            )
        ),
        'initial_date' => array(
            'rule' => array('date', 'ymd'),
            'message' => 'Date only',
            'required' => true,
            'allowEmpty' => false
        ),
        'source_id' => array(
            'rule' => 'numeric',
            'message' => 'Numbers only',
            'allowEmpty' => true
        ),
        'authorized_company_id' => array(
            'rule' => 'numeric',
            'message' => 'Numbers only',
            'allowEmpty' => true
        ),
        'note' => array(
            'rule' => array('maxLength', '1024'),
            'message' => '最大不能超過 1024 個字',
            'allowEmpty' => true
        )
    );
    public $belongsTo = array(
        'Source' => array(
            'className' => 'Source'
        ),
        'AuthorizedCompany' => array(
            'className' => 'AuthorizedCompany'
        )
    );
    public $hasMany = array(
        'Registration' => array(
            'className' => 'Registration'
        )
    );

}

?>
