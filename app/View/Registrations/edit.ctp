<?php echo $this->Form->create('Registration', array('class' => 'form-horizontal', 'action' => 'edit')); ?>

<fieldset>
    <legend>編輯門診資料</legend>

    <?php
    echo $this->Html->scriptBlock('$("#reg_datepicker").datepicker({weekStart: 1});', array('inline' => false));
    echo $this->Html->scriptBlock('$("#further_datepicker").datepicker({weekStart: 1});', array('inline' => false));
    echo $this->Html->scriptBlock('$(".dropdown-timepicker").timepicker({defaultTime: "' . $registration_datetime . '"});', array('inline' => false));
    echo $this->Html->scriptBlock('$(".further-dropdown-timepicker").timepicker({defaultTime: "' . $further_datetime . '"});', array('inline' => false));
    ?>

    <div class="control-group input-append date" id="reg_datepicker" data-date="<?php echo $registration_date; ?>" data-date-format="yyyy-mm-dd">
        <label for="RegistrationRegistrationDate" class="control-label">門診日期</label>
        <div class="controls">
            <?php
            echo $this->Form->input('registration_date', array(
                'id' => 'registration_date',
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
    echo $this->Form->input('registration_datetime', array(
        'type' => 'text',
        'label' => '門診時間',
        'class' => 'dropdown-timepicker'
    ));

    echo $this->Form->input('Registration.patient_name', array(
        'type' => 'text',
        'label' => '病患姓名',
        'disabled' => true
    ));

    echo $this->Form->input('Identity', array(
        'multiple' => 'checkbox inline',
        'label' => '就診身分'
    ));

    echo $this->Form->input('Bill.registration_fee', array(
        'label' => '掛號費',
        'class' => 'span8',
        'append' => '元'
    ));
    echo $this->Form->input('Bill.copayment', array(
        'label' => '部分負擔',
        'class' => 'span8',
        'append' => '元'
    ));
    echo $this->Form->input('Bill.drug_expense', array(
        'label' => '藥費',
        'class' => 'span8',
        'append' => '元'
    ));
    echo $this->Form->input('Bill.own_expense', array(
        'label' => '自費',
        'class' => 'span8',
        'append' => '元'
    ));

    echo $this->Form->input('note', array(
        'label' => '備註',
        'type' => 'textarea',
        'class' => 'input-xlarge'
    ));
    ?>

    <legend>編輯後續動作</legend>

    <?php
    echo $this->Form->input('Further', array(
        'id' => 'further_select',
        'type' => 'select',
        'empty' => '（請選擇）',
        'label' => '後續動作'
    ));
    ?>

    <div id = "further_date_section">
        <div class="control-group input-append date" id="further_datepicker" data-date="<?php echo $further_date; ?>" data-date-format="yyyy-mm-dd">
            <label for="RegistrationFurtherDate" class="control-label">日期</label>
            <div class="controls">
                <?php
                echo $this->Form->input('further_date', array(
                    'id' => 'further_date',
                    'type' => 'text',
                    'label' => false,
                    'class' => 'span10',
                    'div' => false,
                    'value' => $further_date
                ));
                ?>
                <span class="add-on"><i class="icon-th"></i></span>
            </div>
        </div>
    </div>

    <div id = "further_datetime_section">
        <?php
        echo $this->Form->input('further_datetime', array(
            'type' => 'text',
            'label' => '時間',
            'class' => 'further-dropdown-timepicker'
        ));
        ?>
    </div>
    <div id = "notification_section">
        <?php
        if (!is_null($selected_notification)) {
            echo $this->Form->input('notification_id', array(
                'label' => '提醒方式',
                'options' => $notifications,
                'selected' => $selected_notification));
        } else {
            echo $this->Form->input('notification_id', array(
                'label' => '提醒方式',
                'options' => $notifications));
        }
        ?>
    </div>

    <?php
    echo $this->Form->hidden('Registration.id');
    echo $this->Form->hidden('Registration.patient_id');
    echo $this->Form->hidden('Registration.patient_name');
    echo $this->Form->hidden('Patient.phone');
    echo $this->Form->hidden('Patient.authorized_company_id');
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

<?php
$code = '
    // 判斷是否需要秀出『後續動作時間』
    if ($("#further_select :selected").val() == 1) {
        $("#further_date_section").css("display", "true");
        $("#further_datetime_section").css("display", "true");
        $("#notification_section").css("display", "true");
    }
    if ($("#further_select :selected").val() == 2) {
        $("#further_date_section").css("display", "true");
        $("#further_datetime_section").css("display", "none");
        $("#notification_section").css("display", "none");
    }
    if ($("#further_select :selected").val() == 3) {
        $("#further_date_section").css("display", "none");
        $("#further_datetime_section").css("display", "none");
        $("#notification_section").css("display", "none");
    }
    if ($("#further_select :selected").val() == "") {
        $("#further_date_section").css("display", "none");
        $("#further_datetime_section").css("display", "none");
        $("#notification_section").css("display", "none");
    }    

    // 即時顯示或隱藏『後續動作時間』
    $("#further_select").change(
        function() {
            var selected_value = $("#further_select").val();
            if (selected_value == 1) {
                $("#further_date_section").show("slow");
                $("#further_datetime_section").show("slow"); 
                $("#notification_section").show("slow");                
            }
            if (selected_value == 2) {
                $("#further_date_section").show("slow");
                $("#further_datetime_section").hide("slow"); 
                $("#notification_section").hide("slow");
            }
            if (selected_value == 3) {
                $("#further_date_section").hide("slow");
                $("#further_datetime_section").hide("slow"); 
                $("#notification_section").hide("slow");
            }
            if (selected_value == "") {
                $("#further_date_section").hide("slow");
                $("#further_datetime_section").hide("slow");   
                $("#notification_section").hide("slow");
            }            
        }
    );
';
echo $this->Html->scriptBlock($code, array('inline' => false));
?>