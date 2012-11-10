<div class="row-fluid">
    <div class="span6">
        <h1><?php echo $year; ?> 年 <?php echo $month; ?> 月 <?php echo $day; ?> 日提醒清單</h1>
    </div>
    <div class="span4">
    </div>    
</div>

<div class="row-fluid">
    <div class="span10">
    </div>
</div>

<div class="row-fluid">
    <div class="span12">
        <?php echo $this->Form->create(null, array('url' => array('controller' => 'CallLists', 'action' => 'showCallList'), 'class' => 'well form-inline')); ?>
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
                echo $this->Form->input('d', array(
                    'type' => 'date',
                    'label' => ' 日期 ',
                    'dateFormat' => 'D'
                ));
                ?>
                <button type="submit" class="btn">送出</button>
            </div>
        </fieldset>
        <?php echo $this->Form->end(); ?>
    </div>
</div>

<div class="row-fluid">
    <div class="span12">
        <div class="btn-group">
            <?php echo $this->Html->link('匯出簡訊專用CSV檔', '/call_lists/downloadCallList/' . $year . '/' . $month . '/' . $day, array('class' => 'btn pull-left', 'target' => '_blank', 'icon' => 'download')); ?>
            <a href="#myModal" role="button" class="btn" data-toggle="modal">寄送簡訊</a>
        </div>
    </div>
        
    <!-- Modal -->
    <div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <?php echo $this->Form->create(null, array('url' => array('controller' => 'CallLists', 'action' => 'sendMessages'), 'class' => 'form-inline')); ?>
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3 id="myModalLabel">編輯待發送簡訊</h3>
        </div>
        <div class="modal-body">
            <fieldset>
            <table class="table table-striped">
                <thead>
                <th>聯絡電話</th>
                <th>聯絡姓名</th>
                <th>預約時段</th>
                <th>預約時間</th>
                <th>額外提醒</th>
                </thead>
                <tbody>
                <?php foreach ($to_be_sending_messages as $message): ?>
                    <tr>
                    <td>
                        <?php echo $this->Form->input(uniqid(), array(
                            'type' => 'text',
                            'class' => 'span10',
                            'value' => $message[0]
                        )); ?>
                    </td>
                    <td>
                        <?php echo $this->Form->input(uniqid(), array(
                            'type' => 'text',
                            'class' => 'span8',
                            'value' => $message[1]
                        )); ?>
                    </td>
                    <td>
                        <?php echo $this->Form->input(uniqid(), array(
                            'type' => 'text',
                            'class' => 'span4',
                            'value' => $message[2]
                        )); ?>
                    </td>
                    <td>
                        <?php echo $this->Form->input(uniqid(), array(
                            'type' => 'text',
                            'class' => 'span6',
                            'value' => $message[3]
                        )); ?>
                    </td>
                    <td>
                        <?php echo $this->Form->input(uniqid(), array(
                            'type' => 'text',
                            'class' => 'input-medium',
                            'value' => ''
                        )); ?>
                    </td>                            
                    </tr>
                <?php endforeach; ?>
            </tbody>
            </table>
            </fieldset>

        </div>
        <div class="modal-footer">
            <button class="btn" data-dismiss="modal" aria-hidden="true">關閉</button>
            <button type="submit" class="btn btn-primary">寄出簡訊</button>
        </div>
        <?php echo $this->Form->end(); ?>
    </div>

</div>


<hr />

<table class="table table-striped">
    <thead>
    <th>預約時間</th>
    <th>聯絡姓名</th>
    <th>聯絡電話</th>
    <th>提醒方式</th>
</tr>
</thead>
<tbody>
    <?php foreach ($results as $result): ?>
        <tr>
            <td><?php echo $this->Time->format('Y-m-d H:i', $result['appointments']['appointment_time']); ?></td>
            <td><?php echo $result['appointments']['contact_name']; ?></td>
            <td><?php echo $result['appointments']['contact_phone']; ?></td>
            <td><?php echo $result['notifications']['description']; ?></td>
        </tr>
    <?php endforeach; ?>
</tbody>

</table>