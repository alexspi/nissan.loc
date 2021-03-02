{{ trans('backpack::base.click_here_to_reset') }}: <a href="'password/reset', $token).'?email='.urlencode($user->getEmailForPasswordReset()) }}"> {{ $link }} </a>
