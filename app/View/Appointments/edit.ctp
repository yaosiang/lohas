<?php echo $this->Form->create('Appointment', array('class' => 'form-horizontal', 'action' => 'edit')); ?>

<fieldset>
<legend>新增預約時間</legend>

<?php 
echo $this->Html->scriptBlock('$("#app_datepicker").datepicker({weekStart: 1});', array('inline' => false));
echo $this->Html->scriptBlock('$(".dropdown-timepicker").timepicker({defaultTime: "' . $appointment_datetime . '"});', array('inline' => false));
?>

<div class="control-group input-append date" id="app_datepicker" data-date="<?php echo $appointment_date; ?>" data-date-format="yyyy-mm-dd">
    <label for="AppointmentAppointmentDate" class="control-label">預約日期</label>
    <div class="controls">
<?php
if ($isNoShow) {
    echo $this->Form->input('appointment_date', array(
        'type' => 'text',
        'label' => false,
        'class' => 'span10',
        'div' => false,
        'disabled' => true
    ));
    echo $this->Form->input('appointment_date', array('type' => 'hidden'));
} else {
    echo $this->Form->input('appointment_date', array(
        'type' => 'text',
        'label' => false,
        'class' => 'span10',
        'div' => false
    ));    
}
?>
    <span class="add-on"><i class="icon-th"></i></span>
    </div>
</div>

<?php
if ($isNoShow) {
    echo $this->Form->input('appointment_datetime', array(
        'type' => 'text',
        'label' => '門診時間',
        'class' => 'dropdown-timepicker',
        'disabled' => true
    ));
    echo $this->Form->input('appointment_datetime', array('type' => 'hidden'));
} else {
    echo $this->Form->input('appointment_datetime', array(
        'type' => 'text',
        'label' => '門診時間',
        'class' => 'dropdown-timepicker'
    ));   
}
?>

<?php
if ($isNameFixed) {
    echo $this->Form->input('contact_name', array(
        'type' => 'text',
        'label' => '聯絡姓名',
        'disabled' => true
    ));
    echo $this->Form->input('contact_name', array('type' => 'hidden'));
    echo $this->Form->input('contact_phone', array(
        'type' => 'text',
        'label' => '聯絡電話',
        'disabled' => true
    ));
    echo $this->Form->input('contact_phone', array('type' => 'hidden'));
} else {
    echo $this->Form->input('contact_name', array(
        'type' => 'text',
        'label' => '聯絡姓名'
    ));
    echo $this->Form->input('contact_phone', array(
        'type' => 'text',
        'label' => '聯絡電話'
    ));
}

if ($isNoShow) {
    echo $this->Form->input('notification_id', array(
        'label' => '提醒方式',
        'options' => $notifications,
        'disabled' => true
    ));
    echo $this->Form->input('notification_id', array('type' => 'hidden'));
    echo $this->Form->input('is_no_show', array(
        'type' => 'checkbox',
        'label' => '爽約',
        'id' => 'is_no_show_checkbox',
        'disabled' => true
    ));
    echo $this->Form->input('is_no_show', array('type' => 'hidden'));
} else {
    echo $this->Form->input('notification_id', array(
        'label' => '提醒方式',
        'options' => $notifications
    ));
    echo $this->Form->input('is_no_show', array(
        'type' => 'checkbox',
        'label' => '爽約',
        'id' => 'is_no_show_checkbox',
    ));
}

echo $this->Form->input('note', array(
    'label' => '備註',
    'type' => 'textarea',
    'class' => 'input-xlarge'
));

echo $this->Form->hidden('id');
?>

<div id = "contact_section">
<legend>編輯關懷內容</legend>
<?php
echo $this->Form->input('AppointmentContact.contact_time', array('type' => 'hidden'));

echo $this->Form->input('AppointmentContact.contact_result', array(
    'type' => 'text',
    'label' => '關懷內容'
));
?>
</div>

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

<?php
$code = '
if ($("#is_no_show_checkbox").is(":checked") == true) {
    $("#contact_section").css("display", "true");
} else {
    $("#contact_section").css("display", "none");
}

$("#is_no_show_checkbox").change(   
    function() {
        if ( $(this).is(":checked") == true) {
            $("#contact_section").show("slow");
        } else {
            $("#contact_section").hide("slow");
        }
    }
);
';
echo $this->Html->scriptBlock($code, array('inline' => false));
?>