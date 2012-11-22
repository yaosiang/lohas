<div class="row-fluid">
    <div class="span4">
        <h1><?php echo $this->request->data['Appointment']['parm']; ?> 的搜尋結果</h1>
    </div>
    <div class="span8">
        <?php
        echo $this->Form->create('Appointment', array('class' => 'form-search pull-right', 'action' => 'searchSerialNumber'));
        echo $this->Form->input('parm', array(
            'type' => 'text',
            'placeholder' => '聯絡姓名 or 生日',
        ));
        echo $this->Form->button('找掛號證', array(
            'type' => 'submit',
            'class' => 'btn'
        ));
        echo $this->Html->para(null, '請輸入聯絡姓名 or 生日');
        echo $this->Form->end();
        ?>
    </div>    
</div>

<hr />

<?php
if (is_null($results)) {
    echo $this->Html->div('alert alert-block', '找不到耶！打錯字了嗎？');
}
?>

<?php
if (!is_null($results)) {
    $count = 1;
    ?>
    <table class="table table-striped">
        <thead>
        <th>序號</th>
        <th>掛號證</th>
        <th>病患姓名</th>
        <th>生日</th>
        <th>聯絡電話</th>
        <th>初診日期</th>
        <th>特約廠商</th>
        <th>備註</th>
        <th></th>
    </thead>
    <tbody>
    <?php foreach ($results as $patients): ?>
        <?php foreach ($patients as $result): ?>
            <tr>
                <td><?php echo $count++; ?></td>
                <td><?php echo $result['Patient']['serial_number']; ?></td>
                <td><?php echo $result['Patient']['name']; ?></td>
                <td><?php echo $result['Patient']['birthday']; ?></td>
                <td><?php echo $result['Patient']['phone']; ?></td>
                <td><?php echo $result['Patient']['initial_date']; ?></td>
                <td><?php echo $result['AuthorizedCompany']['description']; ?></td>
                <td><?php echo $result['Patient']['note']; ?></td>
                <td>
                <?php
                    echo $this->Html->link('新增預約記錄', array(
                        'controller' => 'appointments',
                        'action' => 'add', (int) $result['Patient']['serial_number']));
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