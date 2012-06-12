<?php
$code =
        "var regDate = new Date(" . $year . ", " . $month . ", " . $day . ");
        $('#dp').datepicker({weekStart: 1})
            .on('changeDate', function(ev){
                regDate = new Date(ev.date);
                $('#regDate').text($('#dp').data('date'));
                $('#dp').datepicker('hide');

                var dateStr = $('#dp').data('date');
                dateStr = dateStr.replace('-', '/');
                dateStr = dateStr.replace('-', '/');
                currectUrl = location.pathname;
                var str = currectUrl.lastIndexOf('showDailyRegistration');
                var str2 = 'showDailyRegistration/';
                if ((str+str2.length) == currectUrl.length) {
                    window.location = currectUrl.concat(dateStr);
                } else {
                    currectUrl = currectUrl.substring(0, str).concat(str2);
                    window.location = currectUrl.concat(dateStr);
                }
            });";
echo $this->Html->scriptBlock($code, array('inline' => false));
?>

<div class="row-fluid">
    <div class="span6">
        <h1>
            <span id="regDate"><?php echo $year; ?>-<?php echo $month; ?>-<?php echo $day; ?></span>
            門診記錄
            <?php echo $this->Html->link('', '#', array('class' => 'btn', 'icon' => 'calendar', 'id' => 'dp', 'data-date-format' => 'yyyy-mm-dd', 'data-date' => $year . '-' . $month . '-' . $day)); ?>
        </h1>
    </div>
    <div class="span2">
        <div class="btn-group pull-right">
            <?php echo $this->Html->link('新增門診時段', '/registrations/add', array('class' => 'btn', 'icon' => 'plus')); ?>
        </div>        
    </div>
    <div class="span4">
        <?php
        echo $this->Form->create('Registration', array('class' => 'well form-search pull-right', 'action' => 'search'));
        echo $this->Form->input('parm', array(
            'type' => 'text',
            'placeholder' => '請輸入姓名',
            'append' => array('找門診', array('wrap' => 'button', 'class' => 'btn', 'type' => 'submit')),
        ));
        echo $this->Form->end();
        ?>
    </div>    
</div>

<hr />

<table class="table table-striped">
    <thead>
    <th>診別</th>
    <th>時間</th>
    <th>病患姓名</th>
    <th>掛號證</th>
    <th>就診身分</th>
    <th>掛號費</th>
    <th>部分負擔</th>
    <th>藥費</th>
    <th>自費</th>
    <th>後續動作</th>
    <th>預約日期</th>
    <th>追蹤日期</th>
    <th>備註</th>
    <th>建立病患</th>
    <th>編輯</th>
    <th>刪除</th>
</thead>
<tbody>
    <?php foreach ($results as $result): ?>
        <tr>
            <td><?php echo $result['time_slots']['time_slot']; ?></td>
            <td><?php echo $this->Time->format('h:i A', $result['registrations']['registration_time']); ?></td>
            <td><?php echo $result['registrations']['patient_name']; ?></td>
            <td>
                <?php
                if (!is_null($result['patients']['serial_number'])) {
                    echo (int) $result['patients']['serial_number'];
                } else {
                    '';
                }
                ?>
            <td>
                <?php
                if (!isset($result['concated_identities']['identities'])) {
                    echo '';
                } else {
                    echo $result['concated_identities']['identities'];
                }
                ?></td>
            <td><?php echo $result['bills']['registration_fee']; ?></td>
            <td><?php echo $result['bills']['copayment']; ?></td>
            <td><?php echo $result['bills']['drug_expense']; ?></td>
            <td><?php echo $result['bills']['own_expense']; ?></td>
            <td><?php echo $result['furthers']['description']; ?></td>
            <td>
                <?php
                if (!is_null($result['furthers_appointment_time']['appointment_time'])) {
                    echo $this->Time->format('Y-m-d', $result['furthers_appointment_time']['appointment_time']);
                }
                ?>
            </td>
            <td>
                <?php
                if (!is_null($result['furthers_follow_up_time']['follow_up_time'])) {
                    echo $this->Time->format('Y-m-d', $result['furthers_follow_up_time']['follow_up_time']);
                }
                ?>
            </td>
            <td><?php echo $result['registrations']['note']; ?></td>
            <td>
                <?php
                if (strlen($result['registrations']['patient_id']) == 0) {
                    echo $this->Html->link('新增病患', array(
                        'controller' => 'patients',
                        'action' => 'add', $result['registrations']['id'], $result['registrations']['patient_name']));
                }
                ?>
            </td>
            <td>
                <?php
                if (strlen($result['registrations']['patient_id']) != 0) {
                    echo $this->Html->link('編輯', array(
                        'action' => 'edit', $result['registrations']['id']));
                }
                ?>
            </td>
            <td>
                <?php
                echo $this->Form->postLink('刪除', array('action' => 'delete', $result['registrations']['id']), array('confirm' => '確定要刪除嗎?'));
                ?>
            </td>
        </tr>
    <?php endforeach; ?>
</tbody>

</table>