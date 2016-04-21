<?php

/*
 * Intranet - Agents
 * Caezar Rosales <8bytes@gmail.com>
 *
 */

namespace GAPlatform\Http\Controllers\Intranet;

use GAPlatform\Http\Controllers\Controller;
use GAPlatform\Libraries\LegacyHelpers;

use Session;
use Request;
use Stripe;
use GAPlatform\Models\GASalesPerson;
use GAPlatform\Models\GAUser;
use GAPlatform\Models\GAOffices;

class OfficesController extends Controller
{
    /**
     * List per page
     */
    protected $perPage = 20;
    
    /**
     * Controller - lists of agents
     */
    public function index($type = null)
    {
        $data = $this->requests();
        $errors = [];
        $data['type'] = $type;

        if (!isset($data['search'])) { $data['search'] = ''; }
        
        $oOffice = new GAOffices();
        if (!is_null($type)) { $data['items'] = $oOffice->getAllOffices($this->perPage, $type, $data['search']); } 
                        else { $data['items'] = $oOffice->getAllOffices($this->perPage, 'all', $data['search']); }
        return view('intranet.Offices.offices', $data);
    }
    
    public function charges_calc($ch)
    {
        $Total_summ =    0;
        $Total_refunds = 0;
        foreach ($ch['data'] as $charges) { 
                $Total_summ     =   $Total_summ    + $charges['amount'];
                $Total_refunds  =   $Total_refunds + $charges['amount_refunded'];
            }
        return array ( "Total_summ"    => $Total_summ,
                       "Total_refunds" => $Total_refunds );    
    }
    public function subscriptions_get ($StripeCustomerID)
    {
          if ((isset($StripeCustomerID))and(strlen($StripeCustomerID)>0)) 
         {
            $stripe       = Stripe::make(env('STRIPE_API_SECRET'));
          return $stripe->subscriptions()->all($StripeCustomerID);
         } else { return null;}
    }

    public function charges_get ($StripeCustomerID, $period = null)
    {
         if ((isset($StripeCustomerID))and(strlen($StripeCustomerID)>0)) 
         {
            $first_day_of_month  = strtotime(date('Y-m-01 00:00:00'));
            $stripe              = Stripe::make(env('STRIPE_API_SECRET'));
            if ($period == null) { $ch = $stripe->charges()->all(array("customer" => $StripeCustomerID) );}
            if ($period == 'month') {
                                $ch = $stripe->charges()->all(array("customer"    => $StripeCustomerID,
                                                                    "created[gt]" => $first_day_of_month) );
                                }

                return $ch;
         } else return null;
    }

    public function infoOffices ($id = null)
    {
        $oOffices    = new GAOffices();
        $data        = array();
        $data_stripe = array();

         if ($Offices = $oOffices->where('id', $id)->first()) {
            $data['id']          = $Offices->id;
            $data['UID']         = $Offices->UID;
            $data['Name']        = $Offices->Name;
            $data['Phone']       = $Offices->Phone;
            $data['Email']       = $Offices->Email;
            $data['Logo_URL']    = $Offices->Logo_URL;
            $data['Logo_ID']     = $Offices->Logo_ID;
            $data['DomainName']  = $Offices->DomainName;
            $data['isActive']    = $Offices->isActive;
            $data['List']        = $Offices->getAllAgents($Offices->UID);
            $data['items']       = "sd";

        $data['OFFICE_TOTAL_SUMM'] = 0;
        $data['OFFICE_TOTAL_SUMM_MONTH'] = 0;
        $data['OFFICE_TOTAL_REF_SUMM'] = 0;
        $data['OFFICE_TOTAL_REF_SUMM_MONTH'] = 0;
      foreach ($data['List'] as $Pers) 
      {

        if ((isset($Pers->StripeCustomerID))and(strlen($Pers->StripeCustomerID)>0)) 
            {    
                    $first_day_of_month = strtotime(date('Y-m-01 00:00:00'));
                    $ch                 = $this->charges_get($Pers->StripeCustomerID);
                    $ch_month           = $this->charges_get($Pers->StripeCustomerID, 'month');
                    $Total_summ         = $this->charges_calc($ch);
                    $Total_summ_month   = $this->charges_calc($ch_month);
                    $subscription       = $this->subscriptions_get($Pers->StripeCustomerID);
                    $data_stripe[$Pers->SalesPersonID]['charges']                =   $ch['data'];
                    $data_stripe[$Pers->SalesPersonID]['SalesPersonName']        =   $Pers->Name;
                    $data_stripe[$Pers->SalesPersonID]['SalesPersonTitle']       =   $Pers->Title;
                    $data_stripe[$Pers->SalesPersonID]['SalesPersonCompanyName'] =   $Pers->CompanyName;
                    $data_stripe[$Pers->SalesPersonID]['subscription']           =   $subscription['data'];
                    $data_stripe[$Pers->SalesPersonID]['Total_summ']             =   $Total_summ;
                    $data_stripe[$Pers->SalesPersonID]['Total_summ_month']       =   $Total_summ_month;

                    $data['OFFICE_TOTAL_SUMM']            =   $data['OFFICE_TOTAL_SUMM']           + $Total_summ['Total_summ'];
                    $data['OFFICE_TOTAL_SUMM_MONTH']      =   $data['OFFICE_TOTAL_SUMM_MONTH']     + $Total_summ_month['Total_summ'];
                    $data['OFFICE_TOTAL_REF_SUMM']        =   $data['OFFICE_TOTAL_REF_SUMM']       + $Total_summ['Total_refunds'];
                    $data['OFFICE_TOTAL_REF_SUMM_MONTH']  =   $data['OFFICE_TOTAL_REF_SUMM_MONTH'] + $Total_summ_month['Total_refunds'];

            }

        }


         

        }

        $out_array = array (
                       "data"          => $data,
                       "stripe_info"   => $data_stripe,
                      );

          return view('intranet.Offices.maininfo', $out_array);

    }


    /**
     * Delete agent
     */
    public function deleteOffice($id = null)
    {
        $data = $this->requests();
        $errors = [];
        $data['id'] = $id;

        $allAgents = [];

        $oOffices = new GAOffices();

        if ($Offices = $oOffices->where('id', $id)->first()) {

            $data['id'] = $Offices->id;
            $data['link'] = "/offices/delete/{$Offices->id}/";
            $data['type'] = "Office";
            $data['button'] = "Delete office";
            $data['confirmInfo'] = 'Office Name: ' . $Offices->Name;
            $data['confirmDesc'] = ' Office UID: ' . $Offices->UID;

            //get all agents
            $allOfficesRaw = GAOffices::where('id', '!=', $Offices->id)
                                         ->orderBy('id', 'desc')
                                         ->get();

            // format agent list for drop down field
            if (!is_null($allOfficesRaw)) {

                $allOfficesRaw = $allOfficesRaw->all();

                foreach ($allOfficesRaw as $thisOffice) {
                    $allOffices[] = ['value' => $thisOffice->id,
                                    'label' => $thisOffice->id . ' - ' . $thisOffice->Name,
                                    'data-1' => $thisOffice->UID
                                   ];
                }
            }

            if (Request::isMethod('post')) {
                if ($data['confirm_id'] == $Offices->id) {
                        $Offices->delete();
                        $data['confirmed'] = trans('messages.deleted', []);
                }
                
            }
            return view('intranet.confirm', $data);

        }

        // unknown salesperson
        return redirect(config('app.url-gai').'/offices');
    }

    /**
     * Add/Update new agent
     */
    public function formOffices($id = null)
    {
        $data = $this->requests();
        $errors = [];
        $data['id'] = $id;

        $oOffices = new GAOffices();



        // Validations
        if (Request::isMethod('post')) {
            if (empty($data['Name'])) {
                $errors[] = trans('messages.required',['field'=>'Name']);
            }
            if (empty($data['Phone'])) {
                $errors[] = trans('messages.required',['field'=>'Phone']);
            }
            if (empty($data['Email'])) {
                $errors[] = trans('messages.required',['field'=>'Email']);
            }
            if (empty($data['UID'])) {
                $errors[] = trans('messages.required',['field'=>'UID']);
            }

            if (count($errors)) {
                $data['validationErrors'] = $errors;
            } else {
                // saving
                if($savedData = $oOffices->saveOffices($data)){

                    // created
                    if ($savedData->wasRecentlyCreated) {
                        $data['created'] = trans('messages.saved', []);

                    // updated
                    } else {
                        $data['updated'] = trans('messages.updated', []);
                    }
                    $savedData->toArray();
                }
            }
        }
        // get agent information
        if ($office = $oOffices->where('id', $id)->first()) {
            $data['office'] = $office->toArray();


        // no agent record
        } else {
            $data['office'] = [];
        }

        return view('intranet.Offices.form', $data);
    }
}
