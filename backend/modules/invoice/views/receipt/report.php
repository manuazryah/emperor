<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\GenerateInvoice;
use common\models\InvoiceGenerateDetails;
use common\models\Currency;
use common\models\OnAccountOf;
?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<!--<html>-->
<!--<head>-->
<!--        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title></title>-->
<link rel="stylesheet" href="<?= Yii::$app->homeUrl ?>css/pdf.css">
<style type="text/css">

    @media print {
        thead {display: table-header-group;}
        .main-tabl{width: 100%}
        tfoot {display: table-footer-group}
        /*tfoot {position: absolute;bottom: 0px;}*/
        .footer {position: fixed ; left: 0px; bottom: 20px; right: 0px; font-size:10px; }
        body h6,h1,h2,h3,h4,h5,p,b,tr,td,span,th,div{
            color:#525252 !important;
        }
    }
    @media screen{
        .main-tabl{
            width: 60%;
        }
    }
    .print{
        text-align: center;
        margin-top: 18px;
    }
    .main-tabl{
        font-size: 14px;
        font-weight: 400;
        font-family: 'Montserrat', sans-serif;
        width: 90%;
        max-width: 100%;
        margin: 0 auto;
    }
    .text-center{
        text-align: center;
    }
    .full-width{
        width: 100%;
        display: inline-block;
    }
    .half-width{
        width: 50%;
        float: left;
        display: inline-block;
    }
    .one-three{
        width: 33.333%;
        float: left;
        display: inline-block;
    }
    .header .log-sec{
        float: none;
        margin: 0 auto;
        text-align: center;
        margin-bottom: 40px;
    }
    .form .form-header{
        display: inline-block;
        width: 100%;
        margin-top: 30px;
        margin-bottom: 40px;
        position: relative;
    }
    .form .form-header p{
        margin-top: 0px;
    }
    .form .form-header .input-box{
        min-height: 15px;
        display: block;
        border: 1px solid black;
        padding: 5px 10px;
        max-width: 100%;
        word-break: break-all;
    }
    .form .form-header .left-sec{
        width: 48%;
        float: left;
        display: inline-block;
    }
    .form .form-header .left-sec p{
        padding-left: 5px;
    }
    .form .form-header .left-sec .currency{
        width: 65%;
        float: left;
        display: inline-block;
    }
    .form .form-header .left-sec .cents{
        width: 35%;
        float: left;
        display: inline-block;
    }
    .form .form-header .center-sec{
        width: 30%;
        float: left;
        display: inline-block;
        position: absolute;
        top: -30px;
    }
    .form .form-header .center- p{
        font-size: 15px;
    }
    .form .form-header .right-sec{
        width: 48%;
        float: right;
        display: inline-block;
    }
    .form .details p{
        position: relative;
        overflow: hidden;
        line-height: 1.6;
    }
    .form .details p:after{
        content: ". . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . .";
        position: absolute;
        display: inline-block;
    }
    .form .details p span{
        position: absolute;
        top: -5px;
        margin-left: 20px;
    }
    .form .details .heading{
        margin: 0 auto;
        text-align: center;
        margin-bottom: 50px;
        font-size: 20px;
    }
    .form .details .heading h5{
        font-weight: 400;
        margin-top: 0;
    }
    .form .form-footer .left-sec{
        float: left;
        display: inline-block;
    }
    .form .form-footer .right-sec{
        float: right;
        display: inline-block;
    }
    .form .form-footer p{
        position: relative;
        overflow: hidden;
        line-height: 1.6;
    }
    .form .form-footer p:after{
        content: ". . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . .";
        position: absolute;
        display: inline-block;
    }
    .form .form-footer p span{
        position: absolute;
        top: -5px;
        margin-left: 20px;
    }
    .bl0{
        border-left: 0px !important;
    }
    .bt0{
        border-top: 0px !important;
    }

</style>

<table class="main-tabl" border="0" id="pdf">
    <tr>
        <td>
            <section>
                <div class="header full-width">
                    <div class="log-sec">
                        <div class="logo">
                            <img class="logo" src="<?= Yii::$app->homeUrl ?>images/logoleft.jpg" alt="Company Logo">
                        </div>
                        <p class="address">
                            EMPEROR SHIPPING LINES LLC<br>
                            Room 06 / Floor II; P.O.Box-328231 Near Saqr Port, RAK Medical Bldg,<br> Al Shaam, 
                            Ras Al Khaimah, UAE</p>
                    </div>
                </div>    
                <div class="form">
                    <div class="Recpt-nmbr">
                        <p>Rcpt No: <span><?= $invoice->receipt_no ?></span></p>
                    </div>
                    <?php
                    if ($invoice->amount != '') {
                        $arr = explode('.', $invoice->amount);
                    }
                    if (empty($arr)) {
                        $arr[0] = 0;
                        $arr[1] = 0;
                    }
                    ?>
                    <div class="form-header">
                        <div class="left-sec">
                            <div class="currency">
                                <p>AED / USD</p>
                                <div class="input-box"><?= $arr[0] ?></div>
                            </div>
                            <div class="cents">
                                <p>FILS / CENTS</p>
                                <div class="input-box bl0"><?= $arr[1] != 0 ? $arr[1] : 0 ?></div>
                            </div>
                        </div>
                        <div class="right-sec">
                            <div class="date">
                                <div class="input-box">
                                    Date: <?= date("d M Y", strtotime($invoice->date)); ?>
                                </div>
                            </div>
                            <div class="appnmt-nbr">
                                <div class="input-box bt0">
                                    Appointment Number: <?= $invoice->appointment_no ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="details">
                        <div class="heading">
                            <h5>RECEIPT VOUCHER</h5>
                        </div>
                        <div class="full-width">
                            <p>Received From Mr. / M/s <span><?= $invoice->received_from_name ?></span></p>
                        </div>
                        <div class="full-width">
                            <p>The Sum of AED/USD <span><?= $invoice->amount ?></span></p>
                        </div>
                        <div class="one-three">
                            <p>Cash / Cheque No: <span><?= $invoice->cheque_no ?></span></p>
                        </div>
                        <div class="one-three">
                            <p>Bank <span><?= $invoice->bank_name ?></span></p>
                        </div>
                        <div class="one-three">
                            <p>Date <span><?= date("d M Y", strtotime($invoice->cheque_date)); ?></span></p>
                        </div>
                        <div class="full-width">
                            <p>Being <span><?= $invoice->being ?></span></p>
                        </div>
                        <div class="half-width">
                            <p>Against Vessel M/V <span><?= $invoice->vessel_name ?></span></p>
                        </div>
                        <div class="half-width">
                            <p>At Port <span><?= $invoice->port ?></span></p>
                        </div>
                    </div>
                    <div class="form-footer">
                        <div class="left-sec one-three">
                            <p>Receiver’s Sign: <span></span></p>
                        </div>
                        <div class="right-sec one-three">
                            <p>Receiver’s Name: <span></span></p>
                        </div>
                    </div>
                </div>
            </section>
        </td>
    </tr>
    <tr>
        <td>
            <section>
                <div class="header full-width">
                    <div class="log-sec">
                        <div class="logo">
                            <img class="logo" src="<?= Yii::$app->homeUrl ?>images/logoleft.jpg" alt="Company Logo">
                        </div>
                        <p class="address">
                            EMPEROR SHIPPING LINES LLC<br>
                            Room 06 / Floor II; P.O.Box-328231 Near Saqr Port, RAK Medical Bldg,<br> Al Shaam, 
                            Ras Al Khaimah, UAE</p>
                    </div>
                </div>    
                <div class="form">
                    <div class="Recpt-nmbr">
                        <p>Rcpt No: <span><?= $invoice->receipt_no ?></span></p>
                    </div>
                    <?php
                    if ($invoice->amount != '') {
                        $arr = explode('.', $invoice->amount);
                    }
                    if (empty($arr)) {
                        $arr[0] = 0;
                        $arr[1] = 0;
                    }
                    ?>
                    <div class="form-header">
                        <div class="left-sec">
                            <div class="currency">
                                <p>AED / USD</p>
                                <div class="input-box"><?= $arr[0] ?></div>
                            </div>
                            <div class="cents">
                                <p>FILS / CENTS</p>
                                <div class="input-box bl0"><?= $arr[1] != 0 ? $arr[1] : 0 ?></div>
                            </div>
                        </div>
                        <div class="right-sec">
                            <div class="date">
                                <div class="input-box">
                                    Date: <?= date("d M Y", strtotime($invoice->date)); ?>
                                </div>
                            </div>
                            <div class="appnmt-nbr">
                                <div class="input-box bt0">
                                    Appointment Number: <?= $invoice->appointment_no ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="details">
                        <div class="heading">
                            <h5>RECEIPT VOUCHER</h5>
                        </div>
                        <div class="full-width">
                            <p>Received From Mr. / M/s <span><?= $invoice->received_from_name ?></span></p>
                        </div>
                        <div class="full-width">
                            <p>The Sum of AED/USD <span><?= $invoice->amount ?></span></p>
                        </div>
                        <div class="one-three">
                            <p>Cash / Cheque No: <span><?= $invoice->cheque_no ?></span></p>
                        </div>
                        <div class="one-three">
                            <p>Bank <span><?= $invoice->bank_name ?></span></p>
                        </div>
                        <div class="one-three">
                            <p>Date <span><?= date("d M Y", strtotime($invoice->cheque_date)); ?></span></p>
                        </div>
                        <div class="full-width">
                            <p>Being <span><?= $invoice->being ?></span></p>
                        </div>
                        <div class="half-width">
                            <p>Against Vessel M/V <span><?= $invoice->vessel_name ?></span></p>
                        </div>
                        <div class="half-width">
                            <p>At Port <span><?= $invoice->port ?></span></p>
                        </div>
                    </div>
                    <div class="form-footer">
                        <div class="left-sec one-three">
                            <p>Receiver’s Sign: <span></span></p>
                        </div>
                        <div class="right-sec one-three">
                            <p>Receiver’s Name: <span></span></p>
                        </div>
                    </div>
                </div>
            </section>
        </td>
    </tr>
</table>
<script>
    function printContent(el) {
        var restorepage = document.body.innerHTML;
        var printcontent = document.getElementById(el).innerHTML;
        document.body.innerHTML = printcontent;
        window.print();
        document.body.innerHTML = restorepage;
    }
</script>
<div class="print">
    <button onclick="printContent('pdf')" style="font-weight: bold !important;">Print</button>
    <button onclick="window.close();" style="font-weight: bold !important;">Close</button>
</div>

