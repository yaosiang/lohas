<?php
/**
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       Cake.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
?>

<!DOCTYPE html>
<html lang="en">
    <head>    
        <?php echo $this->Html->charset(); ?>
        <title>
            <?php echo $title_for_layout; ?>
        </title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">	
        <meta name="description" content="">
        <meta name="author" content="">

        <?php
        echo $this->Html->meta('icon');
        echo $this->Html->css('bootstrap.min');
        echo $this->Html->css('bootstrap-datepicker');
        echo $this->Html->css('bootstrap-timepicker');

        echo $this->fetch('meta');
        echo $this->fetch('css');
        ?>
        <!-- Le styles -->
        <style type="text/css">
            body {
                padding-top: 60px;
                padding-bottom: 40px;
            }
            .marketing h1 {
                margin: 36px 0 27px;
                font-size: 40px;
                font-weight: 300;
                text-align: center;
            }
        </style>
        <?php echo $this->Html->css('bootstrap-responsive.min'); ?>

        <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
        <!--[if lt IE 9]>
              <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
    </head>

    <body>

        <div class="navbar navbar-fixed-top">
            <div class="navbar-inner">
                <div class="container-fluid">

                    <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </a>

                    <a class="brand" href="#">心樂活診所門診預約系統</a>
                </div>
            </div>
        </div>

        <div class="container">

            <!-- Main hero unit for a primary marketing message or call to action -->
            <div class="hero-unit">
                <h1>你好！</h1>
                <p>直到今日，診所已經開業 <?php echo $clinicHistory ?> 個日子，服務過 <?php echo $patientCount ?> 位病患，看過 <?php echo $registrationCount ?> 個診次。在世界末日之前，我們將繼續服務下去！</p>
            </div>

            <div class="marketing">
                <h1>專門為你設計</h1>
            </div>      
            <hr />

            <div class="row">
                <div class="span4">
                    <h2>病患資料</h2>
                    <p> 只需要記錄下病患姓名，聯絡電話，掛號證即可。快速方便，不需要重覆輸入大量資料。</p>
                    <p><?php echo $this->Html->link('前往 >>', '/patients', array('class' => 'btn')); ?></p>
                </div>
                <div class="span4">
                    <h2>門診清單</h2>
                    <p> 門診清單不只能幫助你建立門診資料，也能夠記錄下每次門診的收入，甚至是後續採取的動作。</p>
                    <p><?php echo $this->Html->link('前往 >>', '/registrations/showDailyRegistration', array('class' => 'btn')); ?></p>           
                </div>
                <div class="span4">
                    <h2>預約記錄</h2>
                    <p> 透過預約記錄，你可以幫助病患事先預約門診時間。建立預約記錄將一併建立該時段門診資料。因此，不用花時間複製貼上。</p>
                    <p><?php echo $this->Html->link('前往 >>', '/appointments/showDailyAppointment', array('class' => 'btn')); ?></p>           
                </div>
<!--                 <div class="span4">
                    <h2>預約關懷</h2>
                    <p> 若病患在約定的預約時間沒有來，預約關懷能協助你記錄下聯絡結果，看是要改約時間，或者就原諒他吧。</p>
                    <p><?php echo $this->Html->link('前往 >>', '/appointment_contacts/showMonthlyAppointmentContact', array('class' => 'btn')); ?></p>          
                </div>
 -->                <div class="span4">
                    <h2>回診追蹤</h2>
                    <p> 找出那些病患尚未回診，一向是耗費時間的事情。回診追蹤幫助你列出清單，並在病患回診時，自動記錄下回診時間。</p>
                    <p><?php echo $this->Html->link('前往 >>', '/follow_up/showMonthlyFollowUp', array('class' => 'btn')); ?></p>          
                </div>
                <div class="span4">
                    <h2>簡訊提醒</h2>
                    <p> 整理出當天需要簡訊提醒的病患，若病患需要重覆提醒也沒問題！</p>
                    <p><?php echo $this->Html->link('前往 >>', '/calllists/showCallList', array('class' => 'btn')); ?></p>          
                </div>                        
                <div class="span4">
                    <h2>門診收入</h2>
                    <p> 統計年度、月份、日期的門診收入狀況，幫助檢視診所收入狀況，也能夠匯出成報表。</p>
                    <p><?php echo $this->Html->link('前往 >>', '/billstats', array('class' => 'btn')); ?></p>          
                </div>                        
                <div class="span4">
                    <h2>初診統計</h2>
                    <p> 統計年度、月份、日期的初診來源狀況，直接反應診所客源，以提供診所宣傳方式的參考。</p>
                    <p><?php echo $this->Html->link('前往 >>', '/sourcestats', array('class' => 'btn')); ?></p> 
                </div>                
            </div>

            <hr />

            <div id="footer">
                <p>&copy; 心樂活診所 <?php echo date('Y') ?></p>
            </div>

        </div>
        <?php //echo $this->element('sql_dump'); ?>

        <!-- Le javascript
    ================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->
        <!--
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.min.js"></script>
        -->
        <?php echo $this->Html->script('jquery.min'); ?>
        <?php echo $this->Html->script('bootstrap.min'); ?>
        <?php echo $this->Html->script('bootstrap-datepicker'); ?>
        <?php echo $this->Html->script('bootstrap-timepicker'); ?>
        <?php echo $this->fetch('script'); ?>

    </body>
</html>
