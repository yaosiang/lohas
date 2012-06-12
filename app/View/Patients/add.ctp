<?php echo $this->Form->create('Patient', array('class' => 'form-horizontal', 'action' => 'add')); ?>

<fieldset>
    <legend>新增病患資料</legend>

    <?php
    echo $this->Form->input('name', array(
        'label' => '病患姓名',
        'value' => $name
    ));

    echo $this->Form->input('serial_number', array(
        'label' => '掛號證'
    ));

    echo $this->Form->input('phone', array(
        'label' => '主要聯絡電話'
    ));

    echo $this->Form->input('initial_date', array(
        'type' => 'date',
        'label' => '初診日期',
        'dateFormat' => 'YMD',
        'maxYear' => date('Y'),
        'minYear' => 2011,
        'monthNames' => false
    ));

    echo $this->Form->input('source_id', array(
        'label' => '初診來源',
        'options' => $sources,
        'empty' => '（請選擇）'
    ));

    echo $this->Form->input('note', array(
        'label' => '備註',
        'type' => 'textarea',
        'class' => 'input-xlarge'
    ));
    ?>

    <div class="form-actions">
        <?php
        echo $this->Form->submit('儲存病患資料', array(
            'div' => false,
            'class' => 'btn btn-primary',
        ));
        echo $this->Form->button('取消', array('type' => 'reset', 'class' => 'btn'));
        ?>
    </div>

</fieldset>

<?php echo $this->Form->end(); ?>