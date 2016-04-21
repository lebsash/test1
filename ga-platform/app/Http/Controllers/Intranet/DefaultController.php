<?php

/*
 * Intranet - dashboard
 * Caezar Rosales <8bytes@gmail.com>
 *
 */

namespace GAPlatform\Http\Controllers\Intranet;

use Session;
use GAPlatform\Http\Controllers\Controller;

class DefaultController extends Controller
{
    /**
     * login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function login()
    {
        $data = $this->requests();
        $errors = [];

        // check if already login
        if (Session::get('intranet.admin')) {
            return $this->gotoDashboard();
        }

        if (!isset($data['username']) && !isset($data['1'])) {
            return view('intranet.login', $data);
        }

        // show normal login page if no requested login data
        if (!isset($data['username']) && !isset($data['1'])) {
            return view('intranet.login', $data);
        }

        if (isset($data['username'])) {
            if ($data['username'] != env('INTRANET_USERNAME')) {
                $errors[] = trans('messages.invalid', ['field' => 'Username']);
            }
            if ($data['password'] != env('INTRANET_PASSWORD')) {
                $errors[] = trans('messages.invalid', ['field' => 'Password']);
            }
        }

        if (count($errors)) {
            $data['validationErrors'] = $errors;
        }else{
            Session::set('intranet.admin', true);
            return $this->gotoDashboard();
        }
        return view('intranet.login', $data);
    }
    public function logout()
    {
        Session::forget('intranet.admin');
        return redirect(config('app.url-gai').'/login');
    }
    private function gotoDashboard()
    {
        return redirect(config('app.url-gai').'/dashboard');
    }
}
