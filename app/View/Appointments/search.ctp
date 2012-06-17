<div class="row-fluid">
    <div class="span4">
        <h1>搜尋結果</h1>
    </div>
    <div class="span8">
        <?php
        echo $this->Form->create('Appointment', array('class' => 'well form-search pull-right', 'action' => 'search'));
        echo $this->Form->input('parm', array(
            'type' => 'text',
            'placeholder' => '聯絡姓名',
        ));
        echo $this->Form->button('找預約', array(
            'type' => 'submit',
            'class' => 'btn'
        ));
        echo $this->Html->para(null, '搜尋功能還不能用喔！');
        echo $this->Form->end();
        ?>
    </div>    
</div>

<hr />

<?php
if (is_null($results)) {
    echo $this->Html->div('alert alert-block', '找不到耶！試試其它掛號証，好嗎？');
}
?>

<?php
if (!is_null($results)) {
    $count = 1;
    ?>
    <table class="table table-striped">
        <thead>
        <th>序號</th>
        <th>星期</th>
        <th>時間</th>
        <th>聯絡姓名</th>
        <th>聯絡電話</th>
        <th>提醒方式</th>
        <th>備註</th>
        <th>爽約</th>
        <th>聯絡時間</th>
        <th>關懷結果</th>
        <th>編輯</th>
    </thead>
    <tbody>
    <?php foreach ($results as $result): ?>
            <tr>
                <td><?php echo $count++; ?></td>
                <td><?php echo $this->Time->format('h:i A', $result['appointments']['appointment_time']); ?></td>
                <td><?php echo $result['appointments']['contact_name']; ?></td>
                <td><?php echo $result['appointments']['contact_phone']; ?></td>
                <td><?php echo $result['notifications']['description']; ?></td>
                <td><?php echo $result['appointments']['note']; ?></td>
                <td>
                    <?php
                    if (strcmp($result[0]['is_no_show'], '1') == 0) {
                        echo '是';
                    }
                    ?>
                <td><?php echo $result['appointment_contacts']['contact_time']; ?></td>
                <td><?php echo $result['appointment_contacts']['contact_result']; ?></td>
                <td>
                    <?php
                    echo $this->Html->link('編輯', array('action' => 'edit', $result['appointments']['id']));
                    ?>
                </td>  
            </tr>
    <?php endforeach; ?>
    </tbody>

    </table>
    <?php
}
?>