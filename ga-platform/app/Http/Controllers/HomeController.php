<?php

/*
 * Home - default
 * Caezar Rosales <8bytes@gmail.com>
 *
 */

namespace GAPlatform\Http\Controllers;

use GAPlatform\Libraries\LegacyHelpers;

use Session;
use GAPlatform\Models\GASalesPerson;
use GAPlatform\Models\GAUser;

/**
 * Home Controller class
 */
class HomeController extends Controller
{
    /**
     * Controller index method
     */
    public function index()
    {
        return view('home.index', []);
    }

    /**
     * Controller login
     */
    public function login()
    {
        $data = $this->requests();
        $errors = [];

        // show normal login page if no requested login data
        if (!isset($data['email']) && !isset($data['1'])) {
            return view('home.login', []);
        }

        // Login from an email link (base64 encode/decode)
        $redirect = '';
        if ( !isset($data['email']) && ( isset($data['1']) && isset($data['2']) ) ) {
            $data['email'] = base64_decode($data['1']);
            $data['password'] = base64_decode($data['2']);
            if (isset($data['r'])) {
                $redirect = base64_decode($data['r']);
            }

        // Login from normal POST request
        }else{
            if (!isset($data['termsOfService'])) {
                $errors[] = trans('messages.required', ['field' => 'Terms of Service Agreement']);
            }
            if (!isset($data['password'])) {
                $errors[] = trans('messages.missing', ['field' => 'Password']);
            }
        }

        if (count($errors)) {
            $data['validationErrors'] = $errors;
        }else{

            $salesPerson = GASalesPerson::salesPersonByCredentials($data['email'], $data['password'])->first();

            if (!is_null($salesPerson)) {

                $authorizeResult = $this->authorizeSalesPerson($salesPerson->toArray(), $redirect);

                if (!is_null($authorizeResult)) {
                    return $authorizeResult;
                }
            }

            $data['validationErrors'][] = trans('messages.failed', ['field' => 'Authorization']);
        }
        
        return view('home.login', $data);
    }

    /**
    * Authorize a sales person then redirect to "agent/index.php"
    * (emulate legacy sessions/cookies)
    * 
    * @param array $salesPerson SalesPerson Information
    * @param string $redirect Redirect URL
    */
    private function authorizeSalesPerson($salesPerson, $redirect)
    {
        $agentInfo = LegacyHelpers::getAgent($salesPerson['UserID']);

        if (isset($agentInfo['UserID'])) {
            $requestResponse = LegacyHelpers::authorizeAgent($agentInfo, $salesPerson);

            // Check for user custom terms
            $oUser = new GAUser();
            $userCustomTerms = $oUser->getUserCustomTerms($agentInfo['UserID']);

            if (!is_null($userCustomTerms)) {
                // save for signature/terms page use
                Session::set('user.termsData', $userCustomTerms);
                // proceed to signature page
                return redirect(config('app.url-ga').'/user-agreement/signature');
            }

            // login to CRM
            if ($requestResponse['authorize']) {
                return LegacyHelpers::authorizeAgentProcess($redirect);
            }
        }

        return null;
    }
}
