<div class="row-fluid">
    <div class="span8">
        <h1><?php echo $year; ?> 年 <?php echo $month; ?> 月關懷名單</h1>
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
        <?php echo $this->Form->create('AppointmentContact', array('url' => array('action' => 'showMonthlyAppointmentContact'), 'class' => 'well form-inline')); ?>
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
    <?php echo $this->Html->link('匯出檔案', '/appointment_contacts/downloadMonthlyAppointmentContact/' . $year . '/' . $month, array('class' => 'btn pull-left', 'icon' => 'download')); ?>
</div>

<hr />

<table class="table table-striped">
    <thead>
    <th>預約日期</th>
    <th>聯絡姓名</th>
    <th>聯絡電話</th>
    <th>關懷日期</th>
    <th>關懷結果</th>
    <th>編輯</th>
</thead>
<tbody>
    <?php foreach ($results as $result): ?>
        <tr>
            <td><?php echo $this->Time->format('Y-m-d', $result['appointments']['appointment_time']); ?></td>
            <td><?php echo $result['appointments']['contact_name']; ?></td>
            <td><?php echo $result['appointments']['contact_phone']; ?></td>
            <td><?php
    if (!is_null($result['appointment_contacts']['contact_time'])) {
        echo $this->Time->format('Y-m-d', $result['appointment_contacts']['contact_time']);
    }
        ?>
            </td>
            <td><?php echo $result['appointment_contacts']['contact_result']; ?></td>
            <td><?php
            echo $this->Html->link('編輯', array(
                'action' => 'edit', $result['appointment_contacts']['id'], $result['appointments']['appointment_id'])
            );
        ?>
            </td>
        </tr>
    <?php endforeach; ?>
</tbody>

</table>