<div class="row-fluid">
    <div class="span4">
        <h1>醫師列表</h1>
    </div>
    <div class="span12">
    </div>    
</div>

<div class="row-fluid">
    <div class="span12">
        <div class="btn-group">
            <?php echo $this->Html->link('新增醫師資料', '/doctors/add', array('class' => 'btn pull-left', 'icon' => 'plus')); ?>
        </div>
    </div>
</div>

<hr />

<table class="table table-striped">
    <thead>
    <th>醫師序號</th>
    <th>醫師姓名</th>  
    <th>是否執勤中</th>
    <th>假期開始時間</th>
    <th>假期結束時間</th> 
    <th>編輯醫師</th>
    <th>刪除醫師</th>
</thead>
<tbody>
    <?php foreach ($doctors as $doctor): ?>
        <tr>
            <td><?php echo $doctor['doctors']['id']; ?></td>
            <td><?php echo $doctor['doctors']['description']; ?></td>
            <td>
                <?php
                if (strcmp($doctor['doctors']['available'], '1') == 0) {
                    echo '是';
                }
                ?>
            </td>
            <td>
                <?php
                if (!is_null($doctor['doctors']['vacation_start'])) {
                    echo $this->Time->format('Y-m-d h:i', $doctor['doctors']['vacation_start']);
                }
                ?>
            </td>
            <td>
                <?php
                if (!is_null($doctor['doctors']['vacation_end'])) {
                    echo $this->Time->format('Y-m-d h:i', $doctor['doctors']['vacation_end']);
                }
                ?>
            </td>
            <td>
                <?php
                echo $this->Html->link('編輯', array('action' => 'edit', $doctor['doctors']['id']));
                ?>
            </td>
            <td>
                <?php
                echo $this->Form->postLink('刪除', array('action' => 'delete', $doctor['doctors']['id']), array('confirm' => '確定要刪除嗎?'));
                ?>
            </td>    
        </tr>
    <?php endforeach; ?>
</tbody>

</table>