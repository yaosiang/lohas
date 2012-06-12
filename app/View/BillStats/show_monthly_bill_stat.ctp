<div class="row-fluid">
    <div class="span6">
        <h1><?php echo $year; ?> 年 <?php echo $month; ?> 月門診收入</h1>
    </div>
    <div class="span4">
    </div>    
</div>

<div class="row-fluid">
    <div class="span10">
    </div>
</div>

<div class="row-fluid">
    <div class="span10">
        <div class="btn-group">
            <?php echo $this->Html->link('匯出檔案', '/bill_stats/downloadMonthlyBillStat/' . $year . '/' . $month, array('class' => 'btn pull-left', 'icon' => 'download')); ?>
        </div>
    </div>
</div>

<hr />

<table class="table table-striped">
    <thead>
        <th>月份</th>
        <th>日期</th>
        <th>掛號費</th>
        <th>部分負擔</th>
        <th>藥費</th>
        <th>自費</th>
        <th>加總</th>
    </thead>
    <tbody>
    <?php foreach ($results as $result): ?>
    <tr>
        <td><?php 
            if (is_null($result[0]['day'])) {
                echo '加總';
            } else {
                echo $month;
            } ?>
        </td>
        <td><?php echo $result[0]['day']; ?></td>
        <td><?php echo $result[0]['registration_fee']; ?></td>
        <td><?php echo $result[0]['copayment']; ?></td>
        <td><?php echo $result[0]['drug_expense']; ?></td>
        <td><?php echo $result[0]['own_expense']; ?></td>
        <td><?php echo $result[0]['total']; ?></td>
    </tr>
    <?php endforeach; ?>
    </tbody>

</table>