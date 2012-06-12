<h1>門診收入</h1>

<hr />

<div class="accordion" id="accordion">
    <div class="accordion-group">
      <div class="accordion-heading">
        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
          當日門診收入統計
        </a>
      </div>
      <div id="collapseOne" class="accordion-body collapse in">
        <div class="accordion-inner">
            <?php echo $this->Form->create('BillStat', array('class' => 'form-horizontal', 'action' => 'showDailyBillStat')); ?>
                <fieldset>
                <div class="control-group">
                    <?php 
                        echo $this->Form->input('y', array(
                            'type' => 'date',
                            'label' => '選擇年度',
                            'dateFormat' => 'Y',
                            'maxYear' => date('Y'),
                            'minYear' => 2011
                            ));
                        echo $this->Form->input('m', array(
                            'type' => 'date',
                            'label' => '選擇月份',
                            'dateFormat' => 'M',
                            'monthNames' => false
                            ));
                        echo $this->Form->input('d', array(
                            'type' => 'date',
                            'label' => '選擇日期',
                            'dateFormat' => 'D',
                            ));                        
                ?>

                <div class="form-actions">
                <?php echo $this->Form->submit('送出', array(
                        'div' => false,
                        'class' => 'btn',
                        ));
                ?>
                <button class="btn">取消</button>
                </div>
                </div>
                </fieldset>
            <?php echo $this->Form->end(); ?>
        </div>
      </div>
    </div>
    <div class="accordion-group">
      <div class="accordion-heading">
        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
          月份門診收入統計
        </a>
      </div>
      <div id="collapseTwo" class="accordion-body collapse">
        <div class="accordion-inner">      
            <?php echo $this->Form->create('BillStat', array('class' => 'form-horizontal', 'action' => 'showMonthlyBillStat')); ?>
                <fieldset>
                <div class="control-group">
                    <?php 
                        echo $this->Form->input('y', array(
                            'type' => 'date',
                            'label' => '選擇年度',
                            'dateFormat' => 'Y',
                            'maxYear' => date('Y'),
                            'minYear' => 2011
                            ));
                        echo $this->Form->input('m', array(
                            'type' => 'date',
                            'label' => '選擇月份',
                            'dateFormat' => 'M',
                            'monthNames' => false
                            ));
                ?>

                <div class="form-actions">
                <?php echo $this->Form->submit('送出', array(
                        'div' => false,
                        'class' => 'btn',
                        ));
                ?>
                <button class="btn">取消</button>
                </div>
                </div>
                </fieldset>
            <?php echo $this->Form->end(); ?>
            </div>
        </div>
      </div>
    </div>
    <div class="accordion-group">
      <div class="accordion-heading">
        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseThree">
        年度門診收入統計
        </a>
      </div>
      <div id="collapseThree" class="accordion-body collapse">
        <div class="accordion-inner">
            <div class="btn-group">
            <?php
                for ($y = 2011; $y <= date('Y'); $y++) {
                    echo $this->Html->link($y . '年', array(
                        'controller' => 'BillStats',
                        'action' => 'showAnnualBillStat',
                        $y),
                        array('class' => 'btn btn-large')
                        );
                }
            ?>
            </div>
        </div>
      </div>
    </div>
</div>