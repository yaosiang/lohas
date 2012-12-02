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
$count = 1;
?>

<div class="row-fluid">
    <div class="span6">
        <h1>
            <span id="regDate"><?php echo $year; ?>-<?php echo $month; ?>-<?php echo $day; ?></span>
            <?php
            $date = new DateTime($year . '-' . $month . '-' . $day);
            if ($date->format('N') == 1) {
                echo ' 星期一';
            } elseif ($date->format('N') == 2) {
                echo ' 星期二';
            } elseif ($date->format('N') == 3) {
                echo ' 星期三';
            } elseif ($date->format('N') == 4) {
                echo ' 星期四';
            } elseif ($date->format('N') == 5) {
                echo ' 星期五';
            } elseif ($date->format('N') == 6) {
                echo ' 星期六';
            } else {
                echo ' 星期天';
            }
            ?>            
            門診資料
            <?php echo $this->Html->link('', '#', array('class' => 'btn', 'icon' => 'calendar', 'id' => 'dp', 'data-date-format' => 'yyyy-mm-dd', 'data-date' => $year . '-' . $month . '-' . $day)); ?>
        </h1>
    </div>
    <div class="span6">
        <?php
        echo $this->Form->create('Registration', array('class' => 'well form-search pull-right', 'action' => 'search'));
        echo $this->Form->input('parm', array(
            'type' => 'text',
            'placeholder' => '姓名 or 掛號證 or 生日',
            'append' => array('找門診', array('wrap' => 'button', 'class' => 'btn', 'type' => 'submit')),
        ));
        echo $this->Html->para(null, '請輸入姓名 or 掛號證 or 生日');
        echo $this->Form->end();
        ?>
    </div>    
</div>

<div class="btn-group">
    <?php echo $this->Html->link('新增門診資料', '/registrations/add', array('class' => 'btn pull-left', 'icon' => 'plus')); ?>
    <?php echo $this->Html->link('匯出當日門診', '/registrations/downloadDailyRegistration/' . $year . '/' . $month . '/' . $day, array('class' => 'btn pull-left', 'icon' => 'download')); ?>
    <?php echo $this->Html->link('匯出范醫師門診', '/registrations/downloadDailyRegistrationByDoctor/' . $year . '/' . $month . '/' . $day . '/' . 1, array('class' => 'btn pull-left', 'icon' => 'download')); ?>
    <?php echo $this->Html->link('匯出簡醫師門診', '/registrations/downloadDailyRegistrationByDoctor/' . $year . '/' . $month . '/' . $day . '/' . 2, array('class' => 'btn pull-left', 'icon' => 'download')); ?>
</div>        

<hr />

<table class="table table-hover">
    <thead>
    <th>序號</th>
    <th>診別</th>
    <th>時間</th>
    <th>醫師</th>
    <th>病患</th>
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
    <th>預約單</th>
</thead>
<tbody>
    <?php foreach ($results as $result): ?>
        <?php
        if (strcmp($result['doctors']['doctor'], '范庭瑋') == 0 ||
                strcmp($result['doctors']['doctor'], '') == 0) {
            echo "<tr style=\"background-color: #CCFF99;\">";
        } else {
            echo "<tr style=\"background-color: #99CCFF;\">";
        }
        ?>
    <td><?php echo $count++; ?></td>
    <td><?php echo $result['time_slots']['time_slot']; ?></td>
    <td><?php echo $this->Time->format('h:i A', $result['registrations']['registration_time']); ?></td>
    <td><?php echo $result['doctors']['doctor']; ?></td>
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
    <td>
        <?php
        $printLinkStr = '/pdf/registrations/print/' . $result['registrations']['id'];
        if (!is_null($result['furthers_appointment_time']['appointment_time'])) {
            echo $this->Html->link('列印', $printLinkStr);
        }
        ?>
    </td>
    </tr>
<?php endforeach; ?>
</tbody>

</table>