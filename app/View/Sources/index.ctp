<div class="row-fluid">
    <div class="span4">
        <h1>初診來源列表</h1>
    </div>
    <div class="span8">
    </div>    
</div>

<div class="row-fluid">
    <div class="span12">
    </div>
</div>

<div class="btn-group">
<?php echo $this->Html->link('新增初診來源', '/sources/add', array('class' => 'btn pull-left', 'icon' => 'plus')); ?>
</div>

<hr />

<table class="table table-striped">
    <thead>
    <th>來源編號</th>
    <th>來源名稱</th>
    <th>編輯來源</th>
    <th>刪除來源</th>
</thead>
<tbody>
<?php foreach ($sources as $source): ?>
        <tr>
            <td><?php echo $source['Source']['id']; ?></td>
            <td><?php echo $source['Source']['description']; ?></td>
            <td>
                <?php
                echo $this->Html->link('編輯', array('action' => 'edit', $source['Source']['id']));
                ?>
            </td>
            <td>
                <?php
                echo $this->Form->postLink('刪除', array('action' => 'delete', $source['Source']['id']), array('confirm' => '確定要刪除嗎?'));
                ?>
            </td>        
        </tr>
    <?php endforeach; ?>
</tbody>

</table>

<?php echo $this->Paginator->pagination(); ?>