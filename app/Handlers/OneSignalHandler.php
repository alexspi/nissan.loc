<?php namespace App\Handlers;

use anlutro\cURL\cURL;
use App\Model\Order;
use App\Events\OrderPublishedEvent;

class OneSignalHandler
{

    //признак тестовой отправки
    private $test = false;

    // по умолчанию отправляем "боевое сообщение"
    public function __construct($test = false)
    {
        $this->test = $test;
    }

    public function sendNotify(Order $order)
    {

        $config = \Config::get('onesignal');

        //check if app id is defined
        if (!empty($config['app_id'])) {

            $data = [
                'app_id'          => $config['app_id'],
                'contents'        =>
                    [
                        "en" => $order->id,
                        "en" => $order->total,
                    ],
                'headings'        =>
                    [
                        "en" => 'Новый заказ',
                    ],
                'isAnyWeb'        => true,
                'chrome_web_icon' => $config['icon_url'],
                'firefox_icon'    => $config['icon_url'],
//                'url' => $order->link

            ];
//            dd($data);
            //Если параметр test  ==  true То  мы  в получателя добавляем только себя,
            if ($this->test) {
                $data['include_player_ids'] = [$config['own_player_id']];
            } else {
                //если нет - то  всех.
                $data['included_segments'] = ["All"];
            }
            //add future date if needed
            if (strtotime($order->publish_date) > time()) {
                $data['send_after'] = date(DATE_RFC2822, strtotime($order->publish_date));
                $data['delayed_option'] = 'timezone';
                $data['delivery_time_of_day'] = '10:00AM';
            }

            $curl = new cURL();
            $req = $curl->newJsonRequest('post', $config['url'], $data)->setHeader('Authorization', 'Basic ' . $config['api_key']);
            $result = $req->send();
            if ($result->statusCode <> 200) {
                \Log::error('Unable to push to Onesignal', ['error' => $result->body]);
                return false;
            }

            $result = json_decode($result->body);

            if ($result->id) {
//                \Event::fire(new OrderPublishedEvent($order));
                return $result->recipients;
            }

        }

    }
}