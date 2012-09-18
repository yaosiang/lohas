<div class="row-fluid">
    <div class="span4">
        <h1>特約廠商列表</h1>
    </div>
    <div class="span8">
    </div>    
</div>

<div class="row-fluid">
    <div class="span12">
    </div>
</div>

<div class="btn-group">
<?php echo $this->Html->link('新增特約廠商', '/authorized_companies/add', array('class' => 'btn pull-left', 'icon' => 'plus')); ?>
</div>

<hr />

<table class="table table-striped">
    <thead>
    <th>廠商編號</th>
    <th>廠商名稱</th>
    <th>編輯廠商</th>
    <th>刪除廠商</th>
</thead>
<tbody>
<?php foreach ($authorized_companies as $authorized_company): ?>
        <tr>
            <td><?php echo $authorized_company['AuthorizedCompany']['id']; ?></td>
            <td><?php echo $authorized_company['AuthorizedCompany']['description']; ?></td>
            <td>
                <?php
                echo $this->Html->link('編輯', array('action' => 'edit', $authorized_company['AuthorizedCompany']['id']));
                ?>
            </td>
            <td>
                <?php
                echo $this->Form->postLink('刪除', array('action' => 'delete', $authorized_company['AuthorizedCompany']['id']), array('confirm' => '確定要刪除嗎?'));
                ?>
            </td>        
        </tr>
    <?php endforeach; ?>
</tbody>

</table>

<?php echo $this->Paginator->pagination(); ?>