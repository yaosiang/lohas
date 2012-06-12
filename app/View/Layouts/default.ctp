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
        <meta name="author" content="Yao-Siang Su">

        <?php
        echo $this->Html->meta('icon');
        echo $this->Html->css('bootstrap.min');
        echo $this->Html->css('bootstrap-datepicker');
        echo $this->Html->css('bootstrap-timepicker');
        echo $this->Html->css('bootstrap.min');

        echo $this->fetch('meta');
        echo $this->fetch('css');
        ?>
        <!-- Le styles -->
        <style type="text/css">
            body {
                padding-top: 60px;
                padding-bottom: 40px;
            }
            .sidebar-nav {
                padding: 9px 0;
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

                    <a class="brand" href="/lohas">心樂活診所門診預約系統</a>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row-fluid">
                <div class="span2">
                    <div class="well sidebar-nav">
                        <ul class="nav nav-list">

                            <li class="nav-header">一般行政作業</li>
                            <li>
                                <?php
                                echo $this->Html->link('預約記錄', '/appointments/showDailyAppointment', array('icon' => 'book'));
                                ?>
                            </li>
                            <li>
                                <?php
                                echo $this->Html->link('門診資料', '/registrations/showDailyRegistration', array('icon' => 'tasks'));
                                ?>
                            </li>
                            <li>
                                <?php
                                echo $this->Html->link('病患資料', '/patients', array('icon' => 'user'));
                                ?>
                            </li>
                            <li class="divider"></li>
                            <li class="nav-header">提醒事項作業</li>				
                            <li>
                                <?php
                                echo $this->Html->link('預約關懷', '/appointment_contacts/showMonthlyAppointmentContact', array('icon' => 'fire'));
                                ?>
                            </li>
                            <li>
                                <?php
                                echo $this->Html->link('回診追蹤', '/follow_up/showMonthlyFollowUp', array('icon' => 'eye-open'));
                                ?>
                            </li>
                            <li>
                                <?php
                                echo $this->Html->link('簡訊提醒', '/calllists/showCallList', array('icon' => 'envelope'));
                                ?>
                            </li>
                            <li class="divider"></li>
                            <li class="nav-header">相關統計數據</li>							
                            <li>
                                <?php
                                echo $this->Html->link('門診收入', '/billstats', array('icon' => 'briefcase'));
                                ?>
                            </li>
                            <li>
                                <?php
                                echo $this->Html->link('初診統計', '/sourcestats', array('icon' => 'magnet'));
                                ?>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="span10">
                    <?php echo $this->Session->flash(); ?>
                    <?php echo $this->fetch('content'); ?>
                </div>
            </div>

            <div id="footer">
                <p>&copy; 心樂活診所 <?php echo date('Y') ?></p>
            </div>

        </div>
        <?php //echo $this->element('sql_dump'); ?>

        <!-- Le javascript
    ================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.min.js"></script>
        <?php echo $this->Html->script('bootstrap.min'); ?>
        <?php echo $this->Html->script('bootstrap-datepicker'); ?>
        <?php echo $this->Html->script('bootstrap-timepicker'); ?>
        <?php echo $this->fetch('script'); ?>

    </body>
</html>
