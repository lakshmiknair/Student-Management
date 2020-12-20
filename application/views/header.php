<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">     
        <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>        
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
        <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
        <title>Student Management</title>
        <style>
            html, body {
                height: 100%;
            }

            #wrap {
                min-height: 100%;
            }

            #main {
                overflow:auto;
                padding-bottom:150px; /* this needs to be bigger than footer height*/
            }
          
        </style>       
    </head>
    <body>        
        <nav class="navbar navbar-inverse">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a class="navbar-brand" href="<?php echo base_url('index.php/student'); ?>">STUDENT MANAGEMENT</a>
                </div>
                <ul class="nav navbar-nav">
                    <li class="active"><a href="<?php echo base_url('index.php/classes/index'); ?>">CLASS</a></li>
                    <li><a href="<?php echo base_url('index.php/student'); ?>">STUDENTS LIST</a></li>
                    <li><a href="<?php echo base_url('index.php/student/create'); ?>">ADD STUDENT</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <?php if (!isset($this->session->userdata['logged_in'])) { ?>
                            <a href="<?php echo base_url('index.php/user/login'); ?>">
                                <span class="glyphicon glyphicon-log-in"></span> Login</a>
                        <?php } else { ?>
                            <a href="<?php echo base_url('index.php/user/logout'); ?>">
                                <span class="glyphicon glyphicon-log-out"></span> Logout </a>
                        <?php } ?>
                    </li>
                </ul>
            </div>
        </nav>
        <div id="wrap">
            <div class="container clear-top" id="main">