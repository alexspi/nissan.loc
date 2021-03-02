<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 05.09.2016
 * Time: 14:36
 */

namespace App\Http\Composers;

use Illuminate\Contracts\View\View;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;

class CardCountComposer
{
    protected $carts;

    /**
     * Create a new profile composer.
     *
     * @param  UserRepository $users
     * @return void
     */
    public function __construct(Cart $carts)
    {
        // Зависимости разрешаются автоматически службой контейнера...
        $this->carts = $carts;


    }

    /**
     * Bind data to the view.
     *
     * @param  View $view
     * @return void
     */
    public function compose(View $view)
    {
        $count = 0;


        if (session()->exists('cart_id')) {
            $cart_session = session()->get('cart_id');
            if (Auth::check() AND $cart_session !== Null) {
                $user_id = Auth::user()->id;
            } else {
                $user_id = 'guest';
            }

            $count = $this->carts->where('user_id', $user_id)->whereIn('id', $cart_session)->count();
        }


        $view->with('count', $count);

    }
}