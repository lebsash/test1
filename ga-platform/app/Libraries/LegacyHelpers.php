<?php

/*
 * Helpers - global functions/helpers
 * Caezar Rosales <8bytes@gmail.com>
 *
 */

namespace GAPlatform\Libraries;

use Request;
use Response;
use Config;
use Session;

use GAPlatform\Models\GALiketosell;
use GAPlatform\Models\GASalesPerson;
use GAPlatform\Models\GAUser;
use GAPlatform\Models\GAZipSold;
use GAPlatform\Libraries\Helpers;

class LegacyHelpers
{
    /**
    * Get agent info
    * From /lib.php - getAgent()
    * 
    * @param integer $userID Agent UserID
    * @param boolean $getZipSolds include the sold zips records
    * @param array Agent formatted info from legacy code
    */
    static public function getAgent($userID, $getZipSolds = false)
    {
        $userInfo = $likeToSell = $return = $zipSolds = [];

        if ($userInfoResult = GAUser::getByUserId($userID)->active()->first()) {
            $userInfo = $userInfoResult->toArray();

            if ($likeToSellResult = GALiketosell::getByUserId($userID)->first()) {
                $likeToSell = $likeToSellResult->toArray();
            }
            if ($getZipSolds) {
                if ($zipSoldResult = GAZipSold::getByUserId($userID)->first()) {
                    $zipSolds = $zipSoldResult->toArray();
                }
            }

            $return['MLSMaxListingsPerPage'] = $userInfo['MLSMaxListingsPerPage'];
            $return['MLSMaxListingsPerPageMessage'] = $userInfo['MLSMaxListingsPerPageMessage'];
            $return['AccountabilityEnabled'] = $userInfo['AccountabilityEnabled'];
            $return['MLS'] = $userInfo['MLS'];
            $return['BuyerSiteURL'] = $userInfo['BuyerSiteURL'];
            $return['SellerSiteURL'] = $userInfo['SellerSiteURL'];
            $return['IsOnOscar'] = $userInfo['IsOnOscar'];
            $return['NumberOfHomesPreReg'] = $userInfo['NumberOfHomesPreReg'];
            $return['IsClient'] = $userInfo['IsClient'];
            $return['hasReviewed'] = $userInfo['hasReviewed'];
            $return['DomainName'] = $userInfo['DomainName'];
            $return['Volume'] = isset($likeToSell['Volume']) ? $likeToSell['Volume'] : null;
            $return['LastDelivered'] = isset($likeToSell['LastDelivered']) ? $likeToSell['LastDelivered'] : null;
            $return['MonthsCommitment'] = $userInfo['MonthsCommitment'];
            $return['PaidForward'] = $userInfo['PaidForward'];
            $return['DisplayEmail'] = $userInfo['DisplayEmail'];
            $return['Phone'] = $userInfo['Phone'];
            $return['Cell'] = $userInfo['Cell'];
            $return['CompanyName'] = $userInfo['CompanyName'];
            $return['CompanyPhone'] = $userInfo['CompanyPhone'];
            $return['CompanyLogo'] = $userInfo['CompanyLogo'];
            $return['Name'] = $userInfo['Name'];
            $return['Title'] = $userInfo['Title'];
            $return['Email'] = $userInfo['Email'];
            $return['Location'] = $userInfo['Location'];
            $return['PictureURL'] = $userInfo['PictureURL'];
            $return['UserID'] = $userID;
            $return['Zip'] = $zipSolds;
            $return['OrderDate'] = $userInfo['OrderDate'];
            $return['IsOnGoogle'] = $userInfo['IsOnGoogle'];
            $return['URL'] = $userInfo['URL'];
            $return['MLSSourceIds'] = $userInfo['MLSSourceIDs'];
        }

        return $return;
    }

    /**
    * Authorize Agent (modified)
    * Set legacy session and cookie then redirect to CRM (/agent/index.php)
    * From /lib.php - authorizeAgent()
    * 
    * @param array $agentInfo Agent Information
    * @param array $salesPersonInfo Sales Person Information
    * @return array data to emulate legacy sessions/cookies
    */
    static public function authorizeAgent($agentInfo = [], $salesPersonInfo = [])
    {
        $return = [];
        $return['authorize'] = false;

        if (count($agentInfo)) {
            $salesPersonLegacyFieldNames = GASalesPerson::salesPersonByEmail($salesPersonInfo['Email'], true)->first();

            // Create needed cookie
            $return['cookies'][] = cookie('leadauthorized', '1', time() + (10 * 365 * 24 * 60 * 60), '/', config('app.host'));
            $return['cookies'][] = cookie('password', '', time() + 3600 * 24 * 1, config('app.host'));

            // Create needed session
            $return['session'] = ['Agent' => $agentInfo,
                                  'GA_User' => $agentInfo,
                                  'SalesPerson' => ! is_null($salesPersonLegacyFieldNames)
                                                   ? (object) $salesPersonLegacyFieldNames->toArray()
                                                   : [],
                                 ];

            $return['redirect'] = config('app.url') . '/agent/index.php';
            $return['authorize'] = true;

            // Update legacy sessions/cookies
//            $_SESSION = $return['session'];
            Session::set('user.legacyInfo', $return);
        }

        return $return;
    }

    /**
    * Emulate session/cookie data then redirect to '/agent/index.php'
    * 
    * @param string $redirectUrl Custom redirection URL
    * @return void
    */
    static public function authorizeAgentProcess($redirectUrl = '')
    {
        if ($legacySession = Session::get('user.legacyInfo')) {

            $_SESSION = $legacySession['session'];

            $redirect = config('app.url').'/agent/index.php';

            if (strlen($redirectUrl)) {
                $redirect = Helpers::prependHttp($redirectUrl);
            }
            return redirect($redirect)->withCookie($legacySession['cookies'][0])
                                      ->withCookie($legacySession['cookies'][1]);
        }

        return false;
    }
}
