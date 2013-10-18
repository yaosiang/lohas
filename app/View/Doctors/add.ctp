<?php echo $this->Form->create('Doctor', array('class' => 'form-horizontal', 'action' => 'add')); ?>

<fieldset>
    <legend>新增醫師資料</legend>

    <?php
        echo $this->Html->scriptBlock('$("#app1_datepicker").datepicker({weekStart: 1});', array('inline' => false));
        echo $this->Html->scriptBlock('$("#app2_datepicker").datepicker({weekStart: 1});', array('inline' => false));
        echo $this->Html->scriptBlock('$(".dropdown-timepicker1").timepicker({defaultTime: false});', array('inline' => false));
        echo $this->Html->scriptBlock('$(".dropdown-timepicker2").timepicker({defaultTime: false});', array('inline' => false));
    ?>

    <?
    echo $this->Form->input('description', array(
        'label' => '醫師姓名',
    ));

    echo $this->Form->input('available', array(
        'type' => 'checkbox',
        'label' => '是否執勤',
    ));
    ?>
    <div class="control-group input-append date" id="app1_datepicker" data-date="<?php echo date('Y-m-d'); ?>" data-date-format="yyyy-mm-dd">
    <label for="VacationStartDate" class="control-label">休假開始日期</label>
    <div class="controls">
        <?php
        echo $this->Form->input('vacation_start_date', array(
            'type' => 'text',
            'label' => false,
            'class' => 'span10',
            'div' => false
        ));
        ?>
        <span class="add-on"><i class="icon-th"></i></span>
    </div>
    </div>
    <?php
    echo $this->Form->input('vacation_start_time', array(
        'type' => 'text',
        'label' => '開始時間',
        'class' => 'dropdown-timepicker1',
    ));
    ?>
    <div class="control-group input-append date" id="app2_datepicker" data-date="<?php echo date('Y-m-d'); ?>" data-date-format="yyyy-mm-dd">
    <label for="VacationEndDate" class="control-label">休假結束日期</label>
    <div class="controls">
        <?php
        echo $this->Form->input('vacation_end_date', array(
            'type' => 'text',
            'label' => false,
            'class' => 'span10',
            'div' => false
        ));
        ?>
        <span class="add-on"><i class="icon-th"></i></span>
    </div>
    </div>
    <?php
    echo $this->Form->input('vacation_end_time', array(
        'type' => 'text',
        'label' => '結束時間',
        'class' => 'dropdown-timepicker2'
    ));
    ?>

    <div class="form-actions">
        <?php
        echo $this->Form->submit('儲存醫師資料', array(
            'div' => false,
            'class' => 'btn btn-primary',
        ));
        echo $this->Form->button('取消', array('type' => 'reset', 'class' => 'btn'));
        ?>
    </div>

</fieldset>

<?php echo $this->Form->end(); ?>