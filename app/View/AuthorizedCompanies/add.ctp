<?php echo $this->Form->create('AuthorizedCompany', array('class' => 'form-horizontal', 'action' => 'add')); ?>

<fieldset>
    <legend>新增特約廠商</legend>

    <?php
    echo $this->Form->input('description', array(
        'label' => '廠商名稱',
    ));

    ?>

    <div class="form-actions">
        <?php
        echo $this->Form->submit('儲存特約廠商', array(
            'div' => false,
            'class' => 'btn btn-primary',
        ));
        echo $this->Form->button('取消', array('type' => 'reset', 'class' => 'btn'));
        ?>
    </div>

</fieldset>

<?php echo $this->Form->end(); ?>