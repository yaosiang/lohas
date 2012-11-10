<?php echo $this->Form->create('Registration', array('class' => 'form-horizontal', 'action' => 'add')); ?>

<fieldset>
    <legend>新增門診資料</legend>

    <?php
    echo $this->Html->scriptBlock('$("#reg_datepicker").datepicker({weekStart: 1});', array('inline' => false));
    echo $this->Html->scriptBlock('$(".dropdown-timepicker").timepicker();', array('inline' => false));
    ?>

    <div class="control-group input-append date" id="reg_datepicker" data-date="<?php echo date('Y-m-d'); ?>" data-date-format="yyyy-mm-dd">
        <label for="RegistrationRegistrationDate" class="control-label">門診日期</label>
        <div class="controls">
            <?php
            echo $this->Form->input('registration_date', array(
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
    echo $this->Form->input('registration_datetime', array(
        'type' => 'text',
        'label' => '門診時間',
        'class' => 'dropdown-timepicker',
    ));

    echo $this->Form->input('patient_name', array(
        'type' => 'text',
        'label' => '姓名',
        'helpInline' => '若病患還沒有掛號證，請輸入姓名',
        'placeholder' => '若病患還沒有掛號證，請輸入姓名',
    ));

    echo $this->Form->input('serial_number', array(
        'type' => 'text',
        'label' => '掛號證',
        'value' => $serial_number,
        'helpInline' => '若病患為複診，請輸入掛號證',
        'placeholder' => '若病患為複診，請輸入掛號證',
    ));

    echo $this->Form->input('note', array(
        'label' => '備註',
        'type' => 'textarea',
        'class' => 'input-xlarge'
    ));
    ?>

    <div class="form-actions">
<?php
echo $this->Form->submit('新增門診資料', array(
    'div' => false,
    'class' => 'btn btn-primary',
));
echo $this->Form->button('取消', array('type' => 'reset', 'class' => 'btn'));
?>
    </div>

</fieldset>

<?php echo $this->Form->end(); ?>