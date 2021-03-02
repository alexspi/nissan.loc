@extends('mail/layouts/default')
@section("title")
    <title>Новая заказ</title>
@stop
@section('content')
<table cellpadding="0" cellspacing="0" border="0" align="center" width="100%" style="padding: 35px 0; ">
    <tr>
        <td align="center" style="margin: 0; padding: 0;">
            <table cellpadding="0" cellspacing="0" border="0" align="center" width="600" style="font-family: Helvetica, Arial, sans-serif;" class="header">
                <tr>
                    <td width="600" align="left" style="padding: font-size: 0; line-height: 0; height: 7px;" height="7" colspan="2"></td>
                </tr>
                <tr>
                    <td width="20" style="font-size: 0px;">&nbsp;</td>
                    <td width="580" align="left" style="padding: 18px 0 10px;">
                        <h1 style="color: #47c8db !important; font: bold 32px Helvetica, Arial, sans-serif; margin: 0; padding: 0; line-height: 40px;">
                            <singleline label="Title">Новый заказ №{{$orderId}}</singleline>
                        </h1>
                        <p style="color: #47c8db !important; font: bold 16px Helvetica, Arial, sans-serif;">
                            <multiline label="Description">{{$orderDateCreate}}</multiline>
                        </p>
                    </td>
                </tr>
            </table><!-- header-->
            <table cellpadding="0" cellspacing="0" border="0" align="center" width="600" style="min-height: 400px; font-family: Helvetica, Arial, sans-serif; " bgcolor="#fff">
                
                <tr>
                    <td width="600" valign="top" align="left" style="font-family: Helvetica, Arial, sans-serif; padding: 20px 0 0;" class="content">
                        <table cellpadding="0" cellspacing="0" border="0" style="color: #717171; font: normal 11px Helvetica, Arial, sans-serif; margin: 0; padding: 0;" width="600">
                            <tr>
                                <td width="21" style="font-size: 1px; line-height: 1px;"></td>
                                <td style="padding: 0;  font-family: Helvetica, Arial, sans-serif; height:20px; line-height: 20px;" align="center" width="558" height="20">
                                    <p> Сумма заказа {{$orderTotal}}</p>
                                </td>
                                <td width="21" style="font-size: 1px; line-height: 1px;"></td>
                            </tr>
                        </table>
                        <repeater>
                            
                            <table cellpadding="0" cellspacing="0" border="1" style="color: #717171; font: normal 11px Helvetica, Arial, sans-serif; margin: 0; padding: 0;" width="600">
                                <thead>
                                <th>Название</th>
                                <th>Номер</th>
                                <th>Количество</th>
                                <th>Цена
                                    <small> если есть на складе</small>
                                </th>
                                </thead>
                                <tbody>
                                @foreach($orderitems as $orderitem)

                                <tr>
                                   
                                        <td>{!! $orderitem['title'] !!}</td>
                                        <td>{!! $orderitem['orig_number'] !!}</td>
                                        <td>{!! $orderitem['amount'] !!}</td>
                                        <td>{!! $orderitem['price'] !!}</td>
                                    
                                </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </repeater>
                        <br/>
                        <table cellpadding="0" cellspacing="0" border="0" style="color: #717171; font: normal 11px Helvetica, Arial, sans-serif; margin: 0; padding: 0;" width="600">
                            <tr>
                                <td width="21" style="font-size: 1px; line-height: 1px;"></td>
                                <td style="padding: 0;  font-family: Helvetica, Arial, sans-serif; height:20px; line-height: 20px;" align="center" width="558" height="20">
                                    <p> Данные заказчика</p>
                                </td>
                                <td width="21" style="font-size: 1px; line-height: 1px;"></td>
                            </tr>
                        </table>
                        <repeater>
                            
                            <table cellpadding="0" cellspacing="0" border="1" style="color: #717171; font: normal 11px Helvetica, Arial, sans-serif; margin: 0; padding: 0;" width="600">
                                <thead>
                                <th>Имя</th>
                                <th>Номер телефона</th>
                                <th>Email</th>
                                <th>Адрес</th>
                                </thead>
                                <tbody>

                                <tr>
                                    @foreach($orderusers as $orderuser)
                                        <td>{!! $orderuser->user_name !!}</td>
                                        <td>{!! $orderuser->user_phone !!}</td>
                                        <td>{!! $orderuser->user_email !!}</td>
                                        <td>{!! $orderuser->user_adress !!}</td>
                                    @endforeach
                                </tr>
                                </tbody>
                            </table>
                        </repeater>
                    
                    </td>
                
                </tr>
                <tr>
                
                </tr>
                <tr>
                    <td width="600" align="left"  height="3" colspan="2"></td>
                </tr>
            </table><!-- body -->
            <br/>
            <table cellpadding="0" cellspacing="0" border="0" align="center" width="600"  class="footer">
                <tr>
                    <td align="center" style="padding: 5px 0 10px; font-size: 11px; color:#7d7a7a; margin: 0; line-height: 1.2;font-family: Helvetica, Arial, sans-serif;" valign="top">
                    
                    </td>
                </tr>
            </table><!-- footer-->
        </td>
    
    </tr>
</table>
@stop