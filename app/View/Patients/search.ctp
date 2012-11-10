<div class="row-fluid">
    <div class="span4">
        <h1>搜尋結果</h1>
    </div>
    <div class="span8">
        <?php echo $this->Form->create('Patient', array('class' => 'well form-search pull-right', 'action' => 'search'));
            echo $this->Form->input('parm', array(
                'type' => 'text',
                'placeholder' => '姓名 或 掛號證',
                ));
            echo $this->Form->button('找病患', array(
                'type' => 'submit',
                'class' => 'btn'
                ));
            echo $this->Html->para(null, '請輸入姓名 or 掛號証');
            echo $this->Form->end(); 
        ?>
    </div>    
</div>

<hr />

<?php 
    if (is_null($patients)) {
        echo $this->Html->div('alert alert-block', '找不到耶！試試其它字，好嗎？');
    }
?>

<?php
    if (!is_null($patients)) {
?>
<table class="table table-striped">
    <thead>
        <th>掛號証</th>
        <th>病患姓名</th>
        <th>生日</th>
        <th>聯絡電話</th>
        <th>初診日期</th>
        <th>初診來源</th>
        <th>特約廠商</th>
        <th>備註</th>
        <th>編輯病患</th>
    </thead>
    <tbody>
    <?php foreach ($patients as $patient): ?>
    <tr>
        <td><?php echo $patient['Patient']['serial_number']; ?></td>
        <td><?php echo $patient['Patient']['name']; ?></td>
        <td><?php echo $patient['Patient']['birthday']; ?></td>
        <td><?php echo $patient['Patient']['phone']; ?></td>
        <td><?php echo $this->Time->format('Y-m-d', $patient['Patient']['initial_date']); ?></td>
        <td><?php echo $patient['Source']['description']; ?></td>
        <td><?php echo $patient['AuthorizedCompany']['description']; ?></td>
        <td><?php echo $patient['Patient']['note']; ?></td>
        <td>
            <?php
            echo $this->Html->link('編輯', array('action' => 'edit', $patient['Patient']['id']));
            ?>
        </td>        
    </tr>
    <?php endforeach; ?>
    </tbody>

</table>
<?php
}
?>