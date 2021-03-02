<?php

namespace App\Services;

use App\Models\UserSocialAccount;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Mail;
use App\Mail\Register;

class SocialAccountService
{
    public function createOrGetUser($providerObj, $providerName)
    {

        $providerUser = $providerObj->user();

        $account = UserSocialAccount::whereProvider($providerName)
            ->whereProviderUserId($providerUser->getId())
            ->first();

        if ($account) {
            return $account->user;
        } else {
            $account = new UserSocialAccount([
                'provider_user_id' => $providerUser->getId(),
                'provider' => $providerName]);
//dump($providerUser);
            $mail = $providerUser->getEmail();

            if ($mail== null){
                $user = User::where('social_id',$providerUser->getId())->first();
                if (!$user) {
                    $pass = str_random(8);
                    $user = User::createBySocialProviderId($providerUser, $pass);
                }
            }else{
                $user = User::whereEmail($mail)->first();
                if (!$user) {

                    $pass = str_random(8);
                    $mail = $providerUser->getEmail();

                    Mail::to($mail)->send(new Register($providerUser, $pass));
                    $user = User::createBySocialProvider($providerUser, $pass);
                }

            }

            $account->user()->associate($user);
            $account->save();

            $role = Role::whereName('user')->first();
            $user->assignRole($role);

            return $user;

        }

    }
}