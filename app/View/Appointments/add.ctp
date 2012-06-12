<?php echo $this->Form->create('Appointment', array('class' => 'form-horizontal', 'action' => 'add')); ?>

<fieldset>
    <legend>新增預約記錄</legend>

    <?php
    echo $this->Html->scriptBlock('$("#app_datepicker").datepicker({weekStart: 1});', array('inline' => false));
    echo $this->Html->scriptBlock('$(".dropdown-timepicker").timepicker();', array('inline' => false));

    echo $this->Form->input('contact_number', array(
        'options' => array(1, 2, 3),
        'label' => '預約人數'
    ));
    ?>

    <div class="control-group input-append date" id="app_datepicker" data-date="<?php echo date('Y-m-d'); ?>" data-date-format="yyyy-mm-dd">
        <label for="AppointmentAppointmentDate" class="control-label">預約日期</label>
        <div class="controls">
            <?php
            echo $this->Form->input('appointment_date', array(
                'type' => 'text',
                'label' => false,
                'value' => date("Y-m-d"),
                'class' => 'span10',
                'div' => false
            ));
            ?>
            <span class="add-on"><i class="icon-th"></i></span>
        </div>
    </div>
    <?php
    echo $this->Form->input('appointment_datetime', array(
        'type' => 'text',
        'label' => '預約時間',
        'class' => 'dropdown-timepicker',
    ));

    echo $this->Form->input('contact_name', array(
        'type' => 'text',
        'label' => '聯絡姓名'
    ));

    echo $this->Form->input('contact_phone', array(
        'type' => 'text',
        'label' => '聯絡電話'
    ));

    echo $this->Form->input('serial_number', array(
        'type' => 'text',
        'label' => '掛號證',
        'placeholder' => '若病患為複診，請輸入掛號證'
    ));

    echo $this->Form->input('notification_id', array(
        'label' => '提醒方式',
        'options' => $notifications,
        'selected' => '0'
    ));

    echo $this->Form->input('note', array(
        'label' => '備註',
        'type' => 'textarea',
        'class' => 'input-xlarge'
    ));
    ?>

    <div class="form-actions">
<?php
echo $this->Form->submit('新增預約記錄', array(
    'div' => false,
    'class' => 'btn btn-primary',
));
echo $this->Form->button('取消', array('type' => 'reset', 'class' => 'btn'));
?>
    </div>

</fieldset>

<?php echo $this->Form->end(); ?>