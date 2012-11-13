<div class="row-fluid">
    <div class="span4">
        <h1>病患列表</h1>
    </div>
    <div class="span8">
        <?php
        echo $this->Form->create('Patient', array('class' => 'well form-search pull-right', 'action' => 'search'));
        echo $this->Form->input('parm', array(
            'type' => 'text',
            'placeholder' => '姓名 or 掛號證 or 生日',
            'append' => array('找病患', array('wrap' => 'button', 'class' => 'btn', 'type' => 'submit')),
        ));
        echo $this->Html->para(null, '請輸入姓名 or 掛號証 or 生日');
        echo $this->Form->end();
        ?>
    </div>    
</div>

<div class="row-fluid">
    <div class="span12">
        <div class="btn-group">
<?php echo $this->Html->link('新增病患資料', '/patients/add', array('class' => 'btn pull-left', 'icon' => 'plus')); ?>
        </div>
    </div>
</div>

<hr />

<table class="table table-striped">
    <thead>
    <th>掛號証</th>
    <th>病患姓名</th>
    <th>生日</th>
    <th>聯絡電話</th>
    <th>初診日期</th>
    <th>初診來源</th>
    <th>特約商店</th>
    <th>備註</th>
    <th>編輯病患</th>
    <th>刪除病患</th>
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
            <td>
                <?php
                echo $this->Form->postLink('刪除', array('action' => 'delete', $patient['Patient']['id']), array('confirm' => '確定要刪除嗎?'));
                ?>
            </td>        
        </tr>
    <?php endforeach; ?>
</tbody>

</table>

<?php echo $this->Paginator->pagination(); ?>