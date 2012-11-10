<?php echo $this->Form->create('Source', array('class' => 'form-horizontal', 'action' => 'add')); ?>

<fieldset>
    <legend>新增初診來源</legend>

    <?php
    echo $this->Form->input('description', array(
        'label' => '來源名稱',
    ));

    ?>

    <div class="form-actions">
        <?php
        echo $this->Form->submit('儲存初診來源', array(
            'div' => false,
            'class' => 'btn btn-primary',
        ));
        echo $this->Form->button('取消', array('type' => 'reset', 'class' => 'btn'));
        ?>
    </div>

</fieldset>

<?php echo $this->Form->end(); ?>