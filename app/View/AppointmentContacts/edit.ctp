<?php echo $this->Form->create('AppointmentContact', array('class' => 'form-horizontal', 'action' => 'edit')); ?>

<fieldset>
<legend>編輯關懷名單</legend>

<?php
echo $this->Form->input('Appointment.appointment_time', array(
    'type' => 'text',
    'label' => '預約日期',
    'disabled' => true,
    'value' => $appointment_time
));

echo $this->Form->input('Appointment.contact_name', array(
    'type' => 'text',
    'label' => '聯絡姓名',
    'disabled' => true
));

echo $this->Form->input('Appointment.contact_phone', array(
    'type' => 'text',
    'label' => '聯絡電話',
    'disabled' => true
));

echo $this->Form->input('contact_result', array(
    'label' => '聯絡結果',
    'type' => 'textarea',
    'class' => 'input-xlarge'    
));

echo $this->Form->hidden('AppointmentContact.id');
echo $this->Form->hidden('AppointmentContact.appointment_id');

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