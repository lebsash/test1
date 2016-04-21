<?php

/*
 * User - default
 * Caezar Rosales <8bytes@gmail.com>
 *
 */

namespace GAPlatform\Http\Controllers;

use GAPlatform\Libraries\LegacyHelpers;

use Session;
use GAPlatform\Models\GAUser;

/**
 * User Controller class
 */
class UserController extends Controller
{
    /**
     * Controller terms agreement
     */
    public function termsAgreementSignature()
    {
        $data = $this->requests();
        $errors = [];

        // check if legacy session exists
        if ($legacySession = Session::get('user.legacyInfo')) {

            if (isset($data['signature_name'])) {
                // validate the signature
                if ($legacySession['session']['Agent']['Name'] != $data['signature_name']) {
                    $errors[] = 'You have typed the wrong Name.';
                }

                // check if we have errors from the validation
                if (count($errors)) {
                    $data['validationErrors'] = $errors;

                // user has signed and no error/s is present
                } else {

                    $ipAddress = \GAPlatform\Libraries\Helpers::getRemoteIP();

                    // update user terms
                    GAUser::where('UserID', $legacySession['session']['Agent']['UserID'])->update(['IP' => $ipAddress])->active();
                    // remember signature
                    Session::set('user.signatureAccepted', true);

                    // proceed to the custom term agreement page
                    return redirect(config('app.url-ga').'/user-agreement');
                }
            }

        // back to login page - request for signature is not present
        } else {
            return redirect(config('app.url-ga').'/login');
        }

        return view('user.terms-agreement-signature', $data);
    }
    /**
     * Controller terms agreement
     */
    public function termsAgreement()
    {
        $data = $this->requests();

        // check if legacy session exists AND is signature signed?
        if ($legacySession = Session::get('user.legacyInfo') && Session::get('user.signatureAccepted')) {

            // set the user's session page
            $userCustomTerms = Session::get('user.termsData');

            // user agrees to terms ?
            if (isset($data['is-agree']) && $data['is-agree'] == 'yes') {

                // update user on agreement term
                GAUser::where('UserID', $legacySession['session']['Agent']['UserID'])
                      ->update(['AgreedCustomTerms' => 1]);

                // XXX: Mandrill submit

                // redirect to agent
                return LegacyHelpers::authorizeAgentProcess();
            }

            // show the terms, not yet accepted
            $data['customTerms'] = $userCustomTerms;

        // back to login page - request for signature is not present
        } else {
            return redirect(config('app.url-ga').'/login');
        }

        return view('user.terms-agreement', $data);
    }
}
