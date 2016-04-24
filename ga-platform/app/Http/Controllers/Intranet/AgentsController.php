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
use GAPlatform\Http\Controllers\intranet\Offices;
use GAPlatform\Models\GASalesPerson;
use GAPlatform\Models\GAUser;
use GAPlatform\Models\GAOffices;

class AgentsController extends Controller
{
    /**
     * List per page
     */
    protected $perPage = 20;
    
    /**
     * Controller - lists of agents
     */

    public function subscriptions_get ($StripeCustomerID)
    {
          if ((isset($StripeCustomerID))and(strlen($StripeCustomerID)>0)) 
         {
          $stripe       = Stripe::make(env('STRIPE_API_SECRET'));
          return $stripe->subscriptions()->all($StripeCustomerID);
         } else { return null;}
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


    public function workwithoffice ($data)
    {
       $Out = "";
       foreach ($data  as $value) {
                        $Out[$value['SalesPersonID']] =  array( 'Total_SUMM'    => 0, 
                                                                'subscription'  => 0, 
                                                                'ErrorCharges'  => 0);
               $oOffices    = new GAOffices();
               if ($Offices = $oOffices->where('UID',  $value['Office'])->first()) {
                  $data1['List'] = $Offices->getAllAgents($Offices->UID);
                  $TotalSumm = 0;
                  $subscription = array ();

                  foreach ($data1['List'] as $Pers) 
                        {
                            if ((isset($Pers->StripeCustomerID))and(strlen($Pers->StripeCustomerID)>0)) 
                            {  
 
                             $first_day_of_month = strtotime(date('Y-m-01 00:00:00'));
                             $ch                 = $this->charges_get($Pers->StripeCustomerID);
                             $ch_month           = $this->charges_get($Pers->StripeCustomerID, 'month');
                             $subscription1      = $this->subscriptions_get($Pers->StripeCustomerID);
                             if (isset($subscription1))
                             $subscription[]     = $subscription1['data'];
                                

                             $Total_summ         = $this->charges_calc($ch);
                             $Total_summ_month   = $this->charges_calc($ch_month);
                             $TotalSumm          = $TotalSumm + $Total_summ['Total_summ'];
                             $flag_error=0;
                             foreach ($ch['data'] as $charges) { if (($charges['dispute'])or($charges['status']!='succeeded')) {$flag_error=1;} }
                             $errorAgentCharges = $flag_error; 
                            }    
                        } 
                        $subcount = 0;
                       
                        foreach ($subscription as $key => $value1) {
                          if (isset($value1[0]))
                          if ( $value1[0]['status'] == "active") {$subcount = $subcount + 1;}
                        }

                        $Out[$value['SalesPersonID']] =  array( 'Total_SUMM'    => $TotalSumm, 
                                                                'subscription'  => $subcount, 
                                                                'ErrorCharges'  => $errorAgentCharges);
                }

       }
       return $Out;     
    }


    public function index($type = null)
    {
        $data = $this->requests();
        $errors = [];
        $data['type'] = $type;

        if (!isset($data['search'])) {
            $data['search'] = '';
        }

        $oSalesPerson = new GASalesPerson();

        if (!is_null($type)) {
            $data['items'] = $oSalesPerson->getAllAgents($this->perPage, $type, $data['search']);
        } else {
            $data['items'] = $oSalesPerson->getAllAgents($this->perPage, 'all', $data['search']);
        }
        

        $WOffice = $this->workwithoffice($data['items']);
        return view('intranet.agents.agents', ['items' => $data['items'], 'WOffice' => $WOffice] );
    }
    
    /**
     * Delete agent
     */
    public function deleteAgent($id = null)
    {
        $data = $this->requests();
        $errors = [];
        $data['id'] = $id;

        $allAgents = [];

        $oSalesPerson = new GASalesPerson();

        if ($agent = $oSalesPerson->where('SalesPersonID', $id)->first()) {

            $data['id'] = $agent->SalesPersonID;
            $data['link'] = "/agents/delete/{$agent->SalesPersonID}/";
            $data['type'] = "Agent";
            $data['button'] = "Delete Agent";
            $data['confirmInfo'] = 'Agent Name: ' . $agent->Name;
            $data['confirmDesc'] = ' SalesPerson ID: ' . $agent->SalesPersonID;

            //get all agents
            $allAgentsRaw = GASalesPerson::where('SalesPersonID', '!=', $agent->SalesPersonID)
                                         ->orderBy('SalesPersonID', 'desc')
                                         ->get();

            // format agent list for drop down field
            if (!is_null($allAgentsRaw)) {

                $allAgentsRaw = $allAgentsRaw->all();

                foreach ($allAgentsRaw as $thisAgent) {
                    $allAgents[] = ['value' => $thisAgent->SalesPersonID,
                                    'label' => $thisAgent->SalesPersonID . ' - ' . $thisAgent->Name,
                                    'data-1' => $thisAgent->UserID
                                   ];
                }
            }

            //optional field - for leads
            $data['optinalField'] = ['type' => 'form-dropdown',
                                     'hiddenField1' => $agent->UserID,
                                     'data' => ['fieldName' => 'transferAgentID',
                                                'label' => 'Transfer leads to: ',
                                                'description' => 'Agent that will takeover the leads.',
                                                'options' => $allAgents,
                                               ]
                                    ];

            if (Request::isMethod('post')) {
                if ($data['confirm_id'] == $agent->SalesPersonID) {

                    if (isset($data['transferAgentID']) && intval($data['transferAgentID'])) {

                        // pre delete agent process?
                        $oSalesPerson->transferLeads($agent->SalesPersonID, $data['transferAgentID']);
                        
                        // delete the agent
                        if ($agent->delete()) {
                            $data['confirmed'] = trans('messages.deleted', []);
                        }
                    } else {
                        $errors[] = trans('messages.required', ['field' => 'New Agent']);
                    }
                }

                if (count($errors)) {
                    $data['validationErrors'] = $errors;
                }
            }
            return view('intranet.confirm', $data);
        }

        // unknown salesperson
        return redirect(config('app.url-gai').'/agents');
    }

    /**
     * Add/Update new agent
     */
    public function formAgent($id = null)
    {
        $data = $this->requests();
        $errors = [];
        $data['id'] = $id;

        $oGASalesPerson = new GASalesPerson();
        $oUser = new GAUser();

        $data['usersList'] = $oUser->getUsersList();


        // Validations
        if (Request::isMethod('post')) {
            if (empty($data['Name'])) {
                $errors[] = trans('messages.required',['field'=>'Name']);
            }
            if (empty($data['Title'])) {
                $errors[] = trans('messages.required',['field'=>'Title']);
            }
            if (empty($data['Email'])) {
                $errors[] = trans('messages.required',['field'=>'Email']);
            }
            if (empty($data['UserID'])) {
                $errors[] = trans('messages.required',['field'=>'User']);
            }

            if (count($errors)) {
                $data['validationErrors'] = $errors;
            } else {
                // saving
                if($savedData = $oGASalesPerson->saveAgent($data)){

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
        if ($agent = $oGASalesPerson->where('SalesPersonID', $id)->first()) {
            $data['agent'] = $agent->toArray();



        // no agent record
        } else {
            $data['agent'] = [];
        }

        return view('intranet.agents.form', $data);
    }
}
