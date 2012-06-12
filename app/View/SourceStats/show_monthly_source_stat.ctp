<div class="row-fluid">
    <div class="span6">
        <h1><?php echo $year; ?> 年 <?php echo $month; ?> 月初診來源統計</h1>
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
            <?php echo $this->Html->link('匯出檔案', '/source_stats/downloadMonthlySourceStat/' . $year . '/' . $month, array('class' => 'btn pull-left', 'icon' => 'download')); ?>
        </div>
    </div>
</div>

<hr />

<table class="table table-striped">
    <thead>
        <th>門診來源</th>
        <th>人數</th>
    </thead>
    <tbody>
    <?php foreach ($results as $result): ?>
    <tr>
        <td><?php echo $result['sources']['description']; ?></td>
        <td><?php echo $result[0]['counts']; ?></td>
    </tr>
    <?php endforeach; ?>
    </tbody>

</table>