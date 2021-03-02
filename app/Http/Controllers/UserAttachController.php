<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Traits\CaptchaTrait;
use Validator;
use App\Models\UserAttach;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewUserRequst;
use App\Models\User;

class UserAttachController extends Controller
{

    use CaptchaTrait;

    public function saveAttach(Request $request)
    {

//        $data['captcha'] = $this->captchaCheck();
        $data = $request->all();
        $data['captcha'] = $this->captchaCheck();

        $validator = Validator::make($data,
            [
                'model'                => 'required',
                'phone'                => 'required_without:email|numeric',
                'email'                => 'required_without:phone|email',
                'g-recaptcha-response' => 'required',
                'captcha'              => 'required|min:1',
            ],
            [
                'model.required'                => 'Email is required',
                'phone.required'                => 'Password is required',
                'g-recaptcha-response.required' => 'Captcha is required',
                'captcha.min'                   => 'Wrong captcha, please try again.',
            ]
        );
        // dd($validator);
        if ($validator->fails()) {
            return redirect('help')
                ->withErrors($validator)
                ->withInput();
        }

        $input = $request->all();

        $userAttach = new Userattach();


        $userAttach->mark = array_get($input, 'mark');
        $userAttach->model = array_get($input, 'model');
        $userAttach->year = array_get($input, 'year');
        $userAttach->engine = array_get($input, 'engine');
        $userAttach->engine_type = array_get($input, 'engine_type');
        $userAttach->vin = array_get($input, 'vin');
        $userAttach->detail = array_get($input, 'detail');
        $userAttach->article = array_get($input, 'article');
        $userAttach->phone = array_get($input, 'phone');
        $userAttach->email = array_get($input, 'email');
        $userAttach->name = array_get($input, 'name');
        $userAttach->connect_type = array_get($input, 'connect_type');
        $userAttach->comment = array_get($input, 'comment');
        $userAttach->status = 1;
        $userAttach->save();
        $userAttachid = $userAttach->id;

        Mail::to('nissan209@acmarshal.ru')->send(new NewUserRequst($userAttach));

        return redirect()->back();
    }
    public function Attach(Request $request)
    {

//        $data['captcha'] = $this->captchaCheck();
        $data = $request->all();
        $data['captcha'] = $this->captchaCheck();

        $validator = Validator::make($data,
            [
                'name'                => 'required',
                'email'                => 'required_without:phone|email',
                'g-recaptcha-response' => 'required',
                'captcha'              => 'required|min:1',
            ],
            [
                'g-recaptcha-response.required' => 'Captcha is required',
                'captcha.min'                   => 'Wrong captcha, please try again.',
            ]
        );
        // dd($validator);
        if ($validator->fails()) {
            return redirect('main')
                ->withErrors($validator)
                ->withInput();
        }

        $input = $request->all();

        $userAttach = new Userattach();


        $userAttach->mark = null;
        $userAttach->model = null;
        $userAttach->year = null;
        $userAttach->engine = null;
        $userAttach->engine_type = null;
        $userAttach->vin = null;
        $userAttach->detail = null;
        $userAttach->article = null;
        $userAttach->phone = null;
        $userAttach->email = array_get($input, 'email');
        $userAttach->name = array_get($input, 'name');
        $userAttach->connect_type = null;
        $userAttach->comment = array_get($input, 'subject');
        $userAttach->status = 1;
        $userAttach->save();
        $userAttachid = $userAttach->id;

        Mail::to('nissan209@acmarshal.ru')->send(new NewUserRequst($userAttach));

        return redirect()->back();
    }
}
