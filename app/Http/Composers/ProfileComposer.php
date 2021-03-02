<?php namespace App\Http\Composers;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class ProfileComposer {

    /**
     * The user repository implementation.
     *
     * @var UserRepository
     */
    protected $users;

    /**
     * Create a new profile composer.
     *
     * @param  UserRepository  $users
     * @return void
     */
    public function __construct(User $users)
    {
        // Зависимости разрешаются автоматически службой контейнера...
        $this->users = $users;
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        if (Auth::check())
        {
            $first_name = Auth::user()->first_name;
            $email = Auth::user()->email;
            $phone = Auth::user()->phone;

            $view->with('UserProf', ['first_name'=>$first_name,'email'=>$email,'phone'=>$phone]);
        }
        else
        {
            $view->with('UserProf', ['first_name'=>null,'email'=>null,'phone'=>null]);
        }


    }

}