<div class="row-fluid">
    <div class="span8">
        <h1><?php echo $year; ?> 年 <?php echo $month; ?> 月追蹤名單</h1>
    </div>
    <div class="span2">
    </div>    
</div>

<div class="row-fluid">
    <div class="span10">
    </div>
</div>

<div class="row-fluid">
    <div class="span8">
            <?php echo $this->Form->create(null, array('url' => array('controller' => 'follow_up', 'action' => 'showMonthlyFollowUp'), 'class' => 'well form-inline')); ?>
                <fieldset>
                <div class="control-group">
                    <?php 
                        echo $this->Form->input('y', array(
                            'type' => 'date',
                            'label' => '年度 ',
                            'dateFormat' => 'Y',
                            'maxYear' => date('Y'),
                            'minYear' => 2011
                            ));
                        echo $this->Form->input('m', array(
                            'type' => 'date',
                            'label' => ' 月份 ',
                            'dateFormat' => 'M',
                            'monthNames' => false
                            ));
                    ?>
                    <button type="submit" class="btn">送出</button>
                </div>
                </fieldset>
            <?php echo $this->Form->end(); ?>
    </div>
</div>

<div class="btn-group">
    <?php echo $this->Html->link('匯出檔案', '/follow_up/downloadMonthlyFollowUp/' . $year . '/' . $month, array('class' => 'btn pull-left', 'icon' => 'download')); ?>
</div>

<hr />

<table class="table table-striped">
    <thead>
        <th>預定追蹤日期</th>
        <th>病患姓名</th>
        <th>聯絡電話</th>
        <th>聯絡日期</th>
        <th>聯絡結果</th>
        <th>實際回診日期</th>
        <th>編輯</th>
    </thead>
    <tbody>
    <?php foreach ($results as $result): ?>
    <tr>
        <td><?php echo $this->Time->format('Y-m-d', $result['follow_up']['follow_up_time']); ?></td> 
        <td><?php echo $result['registrations']['patient_name']; ?></td>
        <td><?php echo $result['patients']['phone']; ?></td>      
        <td><?php
                if (!is_null($result['follow_up']['contact_time'])) {
                    echo $this->Time->format('Y-m-d', $result['follow_up']['contact_time']); 
                } else {
                    echo '';
                }
            ?>
        </td>
        <td><?php echo $result['follow_up']['contact_result']; ?></td>
        <td><?php
                if (!is_null($result['follow_up']['come_back_time'])) {
                    echo $this->Time->format('Y-m-d', $result['follow_up']['come_back_time']); 
                } else {
                    echo '';
                }
            ?>
        </td>
        <td><?php        
                echo $this->Html->link('編輯', array(
                    'controller' => 'follow_up', 'action' => 'edit', $result['follow_up']['id'], $result['registrations']['registration_id'])
                );
            ?>
        </td>
    </tr>
    <?php endforeach; ?>
    </tbody>

</table>