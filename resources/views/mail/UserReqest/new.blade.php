@extends('mail/layouts/default')
@section("title")
    <title>Новая заявка на подбор</title>
@stop
@section('content')
    <table cellpadding="0" cellspacing="0" border="0" align="center" width="100%" style="padding: 35px 0;">
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
                                <singleline label="Title">Новая заявка №{{$userattach->id}}</singleline>
                            </h1>
                            <p style="color: #47c8db !important; font: bold 16px Helvetica, Arial, sans-serif;">
                                <multiline label="Description">{{$userattach->created_at}}</multiline>
                            </p>
                        </td>
                    </tr>
                </table><!-- header-->
                <table cellpadding="0" cellspacing="0" border="0" align="center" width="600" style="min-height: 300px font-family: Helvetica, Arial, sans-serif; " bgcolor="#fff">
                    
                    <tr>
                        <td width="600" valign="top" align="left" style="font-family: Helvetica, Arial, sans-serif; padding: 20px 0 0;" class="content">
                            <table cellpadding="0" cellspacing="0" border="0" style="color: #717171; font: normal 11px Helvetica, Arial, sans-serif; margin: 0; padding: 0;" width="600">
                                <tr>
                                    <td width="21" style="font-size: 1px; line-height: 1px;"></td>
                                    <td style="padding: 0;  font-family: Helvetica, Arial, sans-serif; height:20px; line-height: 20px;" align="center" width="558" height="20">
                                        <p> Данные по запрашиваемому автомобилю</p>
                                    </td>
                                    <td width="21" style="font-size: 1px; line-height: 1px;"></td>
                                </tr>
                            </table>
                            <repeater>
                                
                                <table cellpadding="0" cellspacing="0" border="1" style="color: #717171; font: normal 11px Helvetica, Arial, sans-serif; margin: 0; padding: 0;" width="600">
                                    
                                    <tr>
                                        <td>Марка</td>
                                        <td>{!! $userattach->mark !!}</td>
                                    </tr>
                                    <tr>
                                        <td>Модель</td>
                                        <td>{!! $userattach->model !!}</td>
                                    </tr>
                                    <tr>
                                        <td>Год выпуска</td>
                                        <td>{!! $userattach->year !!}</td>
                                    </tr>
                                    <tr>
                                        <td>Двигатель</td>
                                        <td>{!! $userattach->engine !!}</td>
                                    </tr>
                                    <tr>
                                        <td>Тип топлива</td>
                                        <td>{!! $userattach->engine_type !!}</td>
                                    </tr>
                                    <tr>
                                        <td>VIN номер</td>
                                        <td>{!! $userattach->vin !!}</td>
                                    </tr>
                                    <tr>
                                        <td>Название детали</td>
                                        <td>{!! $userattach->detail !!}</td>
                                    </tr>
                                    <tr>
                                        <td>Номер детали</td>
                                        <td>{!! $userattach->article !!}</td>
                                    </tr>
                                </table>
                            </repeater>
                            <br/>
                            <table cellpadding="0" cellspacing="0" border="0" style="color: #717171; font: normal 11px Helvetica, Arial, sans-serif; margin: 0; padding: 0;" width="600">
                                <tr>
                                    <td width="21" style="font-size: 1px; line-height: 1px;"></td>
                                    <td style="padding: 0;  font-family: Helvetica, Arial, sans-serif; height:20px; line-height: 20px;" align="center" width="558" height="20">
                                        <p> Данные пользователя</p>
                                    </td>
                                    <td width="21" style="font-size: 1px; line-height: 1px;"></td>
                                </tr>
                            </table>
                            <repeater>
        
                                <table cellpadding="0" cellspacing="0" border="1" style="color: #717171; font: normal 11px Helvetica, Arial, sans-serif; margin: 0; padding: 0;" width="600">
            
                                    <tr>
                                        <td>Имя</td>
                                        <td>{!! $userattach->name !!}</td>
                                    </tr>
                                    <tr>
                                        <td>Телефон</td>
                                        <td>{!! $userattach->phone !!}</td>
                                    </tr>
                                    <tr>
                                        <td>Email</td>
                                        <td>{!! $userattach->email !!}</td>
                                    </tr>
                                    <tr>
                                        <td>хочет связаться по</td>
                                        <td>{!! $userattach->connect_type !!}</td>
                                    </tr>
                                    <tr>
                                        <td>Комментарий</td>
                                        <td>{!! $userattach->comment !!}</td>
                                    </tr>
                                    
                                </table>
                            </repeater>
                            <br/>
                        
                        </td>
                    
                    </tr>
                    <tr>
                    
                    </tr>
                    <tr>
                        <td width="600" align="left" style="padding: font-size: 0; line-height: 0; height: 3px;" height="3" colspan="2"></td>
                    </tr>
                </table><!-- body -->
                <br/>
                <table cellpadding="0" cellspacing="0" border="0" align="center" width="600" style="font-family: Helvetica, Arial, sans-serif; line-height: 10px;" class="footer">
                    <tr>
                        <td align="center" style="padding: 5px 0 10px; font-size: 11px; color:#7d7a7a; margin: 0; line-height: 1.2;font-family: Helvetica, Arial, sans-serif;" valign="top">
                        
                        </td>
                    </tr>
                </table><!-- footer-->
            </td>
        
        </tr>
    </table>
@stop