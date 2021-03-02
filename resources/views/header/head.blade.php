<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 30.06.2016
 * Time: 13:28
 */ ?>

<meta charset="utf-8">
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
{!! Meta::setFavicon('favicon.ico')->render()  !!}
<script src="https://cdn.onesignal.com/sdks/OneSignalSDK.js" async></script>
@if(Auth::user('administrator'))
<script>
    var OneSignal = OneSignal || [];
    OneSignal.push(["init", {
        appId: "05536478-488b-49f5-836b-4971cce885fd",
        language: 'ru',
        autoRegister: true,
        subdomainName: 'nissan',
        notifyButton: {
            enable: true, // Set to false to hide,
            size: 'large', // One of 'small', 'medium', or 'large'
            theme: 'default', // One of 'default' (red-white) or 'inverse" (whi-te-red)
            position: 'bottom-right', // Either 'bottom-left' or 'bottom-right'               offset: {
            showCredit: false,
            offset: {
                bottom: '90px',
                left: '0px', // Only applied if bottom-left
                right: '80px' // Only applied if bottom-right
            },
            text: {
                "tip.state.unsubscribed": "Получать уведомления о новых статьях прямо в браузере",
                "tip.state.subscribed": "Вы подписаны на уведомления",
                "tip.state.blocked": "Вы заблокировали уведомления",
                "message.prenotify": "Не забудьте подписаться на уведомления о новых статьях",
                "message.action.subscribed": "Спасибо за подписку!",
                "message.action.resubscribed": "Вы подписаны на уведомления",
                "message.action.unsubscribed": "Увы, теперь вы не сможете получать уведомления о самых интересных статьях",
                "dialog.main.title": "Настройки  уведомлений",
                "dialog.main.button.subscribe": "Подписаться",
                "dialog.main.button.unsubscribe": "Поступить опрометчиво и отписаться",
                "dialog.blocked.title": "Снова получать уведомления о самых интересных статьях",
                "dialog.blocked.message": "Следуйте этим инструкциям, чтобы разрешить уведомления:"
            }
        },
        prenotify: true, // Show an icon with 1 unread message for first-time site visitors
        showCredit: false, // Hide the OneSignal logo
        welcomeNotification: {
            "title": "Уведомления о заказах",
            "message": "Спасибо за подписку!"
        },
        promptOptions: {
            showCredit: false, // Hide Powered by OneSignal
            actionMessage: "просит разрешения получать уведомления:",
            exampleNotificationTitleDesktop: "Это просто тестовое сообщение",
            exampleNotificationMessageDesktop: "Уведомления будут приходить на Ваш ПК",
            exampleNotificationTitleMobile: " Пример уведомления",
            exampleNotificationMessageMobile: "Уведомления будут приходить на Ваше устройстве",
            exampleNotificationCaption: "(можно  отписаться в любое время)",
            acceptButtonText: "Продолжить".toUpperCase(),
            cancelButtonText: "Нет, спасибо".toUpperCase()
        }

    }]);
</script>
@endif
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<!--<link href="{{ elixir('css/app.css') }}" rel="stylesheet">
{{--<link href="{{ asset('assets/css/non-responsive.css') }}" rel="stylesheet">--}}
{{--<link href="{{ asset('assets/css/custom.css') }}" rel="stylesheet">--}}
{{--<link href="{{ asset('assets/css/fonts.css') }}" rel="stylesheet">--}}
{{--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.1.1/css/mdb.min.css">--}}-->
<link href="{{ asset('assets/css/style-nissa.css') }}" rel="stylesheet">
<script src="https://use.fontawesome.com/ee77250635.js"></script>
