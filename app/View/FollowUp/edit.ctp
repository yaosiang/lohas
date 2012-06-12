<?php echo $this->Form->create(null, array('url' => array('controller' => 'follow_up', 'action' => 'edit'), 'class' => 'form-horizontal')); ?>

<fieldset>
<legend>編輯追蹤名單</legend>

<?php

echo $this->Form->input('Registration.patient_name', array(
    'type' => 'text',
    'label' => '病患姓名',
    'disabled' => true
));

echo $this->Form->input('Patient.phone', array(
    'type' => 'text',
    'label' => '聯絡電話',
    'disabled' => true
));

echo $this->Form->input('contact_result', array(
    'label' => '聯絡結果',
    'type' => 'textarea',
    'class' => 'input-xlarge' 
));

echo $this->Form->hidden('id');

?>

<div class="form-actions">
<?php
    echo $this->Form->submit('儲存修改資料', array(
        'div' => false,
        'class' => 'btn btn-primary',
        ));
    echo $this->Form->button('取消', array('type' => 'reset', 'class' => 'btn'));
?>
</div>

</fieldset>

<?php echo $this->Form->end(); ?>