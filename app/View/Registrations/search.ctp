<div class="row-fluid">
    <div class="span4">
        <h1>搜尋結果</h1>
    </div>
    <div class="span8">
        <?php
        echo $this->Form->create('Registration', array('class' => 'well form-search pull-right', 'action' => 'search'));
        echo $this->Form->input('parm', array(
            'type' => 'text',
            'placeholder' => '姓名 or 掛號証 or 生日',
        ));
        echo $this->Form->button('找門診', array(
            'type' => 'submit',
            'class' => 'btn'
        ));
        echo $this->Html->para(null, '請輸入姓名 or 掛號証 or 生日');
        echo $this->Form->end();
        ?>
    </div>    
</div>

<hr />

<?php
if (is_null($results)) {
    echo $this->Html->div('alert alert-block', '找不到耶！試試其它字，好嗎？');
}
?>

<?php
if (!is_null($results)) {
    $count = 1;
?>
    <table class="table table-striped">
        <thead>
        <th>序號</th>
        <th>日期</th>
        <th>星期</th>
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
        <th>編輯門診</th>
    </thead>
    <tbody>
    <?php foreach ($results as $patients): ?>
        <?php foreach ($patients as $result): ?>
            <tr>
                <td><?php echo $count++; ?></td>
                <td><?php echo $this->Time->format('Y-m-d', $result['registrations']['registration_time']); ?></td>
                <td><?php echo $this->Time->format('N', $result['registrations']['registration_time']); ?></td>
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
                    ?>
                </td>
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
                    if (strlen($result['registrations']['patient_id']) != 0) {
                        echo $this->Html->link('編輯', array(
                            'action' => 'edit', $result['registrations']['id']));
                    }
                    ?>
                </td>      
            </tr>
        <?php endforeach; ?>
    <?php endforeach; ?>
    </tbody>

    </table>
    <?php
}
?>