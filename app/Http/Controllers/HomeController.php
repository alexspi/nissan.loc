<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Backpack\Base\app\Http\Controllers\AdminController;
use App\Models\User;
use App\Models\Order;
use App\Models\UserAttach;
use App\Models\News;
use Charts;
use YandexMetrika;

class HomeController extends AdminController
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard()
    {

        $user = Charts::database(User::all(), 'bar', 'chartjs')
                      ->title("Пользователи")
                      ->elementLabel("Всего")
                      ->dimensions(1000, 500)
                      ->height(300)
                      ->width(0)
                      ->responsive(false)
                      ->groupByMonth();

        $order = Charts::database(Order::all(), 'bar', 'chartjs')
                       ->title("Заказы")
                       ->elementLabel("Всего")
                       ->dimensions(1000, 500)
                       ->height(300)
                       ->width(0)
                       ->responsive(false)
                       ->groupByMonth();

        $attach = Charts::database(UserAttach::all(), 'bar', 'chartjs')
                        ->title("Заявки")
                        ->elementLabel("Всего")
                        ->dimensions(1000, 500)
                        ->height(300)
                        ->width(0)
                        ->responsive(false)
                        ->groupByMonth();

//        $GeoYandex = YandexMetrika::getVisitsViewsUsers(10)->adapt();
//
//        $GeoYandexDate = $GeoYandex->adaptData['dateArray'];
////        $GeoYandexDate =array_values($GeoYandexDate);
//        $Vizit = $GeoYandex->adaptData['dataArray'][0]['data'];
//        $Prosmotr = $GeoYandex->adaptData['dataArray'][1]['data'];
//        $Posetitel = $GeoYandex->adaptData['dataArray'][2]['data'];
////        dump($GeoYandex->adaptData['dataArray'], $GeoYandexDate);
//
//        $GeoYandexs = Charts::multi('line', 'morris')
//                            ->title("Посещаемость")
//                            ->colors(['#ff0000', '#00ff00', '#0000ff'])
//                            ->height(300)
//                            ->width(0)
//                            ->labels($GeoYandexDate)
//                            ->dataset('Визиты', $Vizit)
//                            ->dataset('Просмотры', $Prosmotr)
//                            ->dataset('Посетители', $Posetitel);
////       dd($GeoYandexs);


        return view('backpack::dashboard', ['user' => $user, 'order' => $order, 'attach' => $attach]);
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application
     */
}
