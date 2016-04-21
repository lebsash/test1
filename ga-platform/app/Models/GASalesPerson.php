<?php

namespace GAPlatform\Models;

use Illuminate\Database\Eloquent\Model;

use DB;
use GAPlatform\Models\GALeadTodo;
use GAPlatform\Models\GALeadCall;
use GAPlatform\Models\GALead;
use GAPlatform\Models\GAOffice;

// class GASalesPerson extends Model
class GASalesPerson extends Model 
{
    /**
     * The database table used by the model.
     *
     * @var string
     */

    protected $table = 'GA_SalesPerson';

    public $timestamps = false;

    protected $primaryKey = 'SalesPersonID';

    protected $guarded = ['SalesPersonID'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['SalesPersonID','StripeCustomerID','Name','Title','Office','Cell','ReceiveTextAlerts','ReceivePhoneAlerts',
                           'PictureURL','UserID','isBroker','Email','Password','isRealtor','isLender','MLSN',
                           'AgentAssignedLender_SalesPersonID','numberOfLeads','WantsSellerLeads','getRenters',
                           'getBuyers','SignedContract','subdomain','accountabilityResponseScore','accountabilityFrequencyScore',
                           'accountabilityCommissionScore','LastLiveDate','NotifyFavor','NotifyHouseView','NotifyEmailOpen',
                           'ImmediateActionScore','ReceiveDailyTODO','NumberOfLeadsRecently','sendText','automatedText','amountTime',
                           'card_brand', 'card_last_four', 'trial_ends_at'
                          ];

    private $legacyFieldNames = ['notifyFavor','notifyHouseView','notifyEmailOpen','getRenters','getBuyers','ImmediateActionScore',
                           'accountabilityFrequencyScore','accountabilityCommissionScore','password','agentAssignedLender_SalesPersonID',
                           'salesPersonID','MLSN','name','title','email','office','cell','userID','pictureURL','receiveTextAlerts',
                           'receivePhoneAlerts','isBroker'];

    public function scopeSearch($query, $keyword)
    {
        $query->where(function($query) use ($keyword)
            {
                $query->orWhere($this->table.'.Name', 'LIKE', '%'.$keyword.'%');
                $query->orWhere($this->table.'.Email', 'LIKE', '%'.$keyword.'%');
                $query->orWhere($this->table.'.Title', 'LIKE', '%'.$keyword.'%');
                $query->orWhere($this->table.'.Office', 'LIKE', '%'.$keyword.'%');
                $query->orWhere($this->table.'.Cell', 'LIKE', '%'.$keyword.'%');
                $query->orWhere($this->table.'.PictureURL', 'LIKE', '%'.$keyword.'%');
                $query->orWhere($this->table.'.Password', 'LIKE', '%'.$keyword.'%');
                $query->orWhere($this->table.'.subdomain', 'LIKE', '%'.$keyword.'%');
                $query->orWhere($this->table.'.automatedText', 'LIKE', '%'.$keyword.'%');
            });

        return $query;
    }

    public function scopeSalesPersonByCredentials($query, $email, $password)
    {
        $query->where('Email', $email);
        $query->where('Password', $password);

        return $query;
    }
    
    public function scopeSalesPersonByEmail($query, $email, $returnLegacyFieldNames = false)
    {
        if ($returnLegacyFieldNames) {
            $query->select($this->legacyFieldNames);
        }
        $query->where('Email', $email);

        return $query;
    }

    /**
     * Get all user agents
     * 
     * @param integer $perpage perpage
     * @param string $status status
     * @param string $order order column
     * @param string $sort sort
     * @return array of users
     */


    public function getAllAgents($perpage = 50, $status = 'live', $search = '', $order = 'SalesPersonID', $sort = 'DESC')
    {
        $allSalesPerson = $this->select(['U.UserID',
                                         'GA_SalesPerson.SalesPersonID',
                                         'GA_SalesPerson.StripeCustomerID',
                                         'GA_SalesPerson.Office',
                                         'GA_SalesPerson.Name as AgentsName',
                                         'GA_SalesPerson.Email as UserName',
                                         'GA_SalesPerson.Password',
                                         'U.NeedsMysturyShoppers',
                                         'U.Name',
                                         'U.Email',
                                         'U.Created',
                                         'U.Location',
                                         'U.CompanyName',
                                         'U.BuyerSiteURL',
                                         'U.SellerSiteURL',
                                         'U.MapMinLng',
                                         'U.KPIMonthlyLeads',
                                         DB::raw('(SELECT COUNT(*) From GA_Lead L WHERE
                                                        L.Created > DATE_SUB(NOW(), INTERVAL 7 day) AND
                                                        L.SalesPersonID IN (SELECT SalesPersonID FROM GA_SalesPerson S WHERE S.Userid=U.UserID)
                                                  ) AS numberofLeadsLastWeek'),
                                         DB::raw('(SELECT COUNT(*) From GA_Lead L WHERE
                                                        L.Created > DATE_SUB(NOW(), INTERVAL 31 day) AND
                                                        L.SalesPersonID IN (SELECT SalesPersonID FROM GA_SalesPerson S WHERE S.Userid=U.UserID)
                                                  ) AS numberofLeadsLastMonth'),
                                         ])
                               ->join('GA_User as U', 'GA_SalesPerson.UserID', '=', 'U.UserID')
                               ->orderBy($order, $sort);
        switch($status){
            case 'suspended':
                $allSalesPerson->where('isSuspended', 1);
                break;
            case 'deployed':
                $allSalesPerson->where('isGettingDeployed', 1);
                break;
            case 'live':
                $allSalesPerson->where('isLive', 1);
                break;
            default: // all
                // no condition
                break;
        }

        // to search
        if (strlen(trim($search))) {
            $allSalesPerson->search(trim($search));
        }

        return $allSalesPerson->paginate($perpage);
    }

    /**
    * update/create a Agent
    * 
    * @param array $data User details
    */
    public function saveAgent($data)
    {
        $oSalesPerson = new GASalesPerson();
        $where = [];
        $whereUpdate = [];

        $where['SalesPersonID']        = $data['SalesPersonID'];

        // common fields
        $whereUpdate['StripeCustomerID'] = $data['StripeCustomerID'];
        $whereUpdate['UserID']         = $data['UserID'];
        $whereUpdate['Name']           = $data['Name'];
        $whereUpdate['Email']          = $data['Email'];
        $whereUpdate['Title']          = $data['Title'];
        $whereUpdate['Office']         = $data['Office'];
        $whereUpdate['Cell']           = $data['Cell'];
        $whereUpdate['Password']       = $data['Password'];
        $whereUpdate['MLSN']           = $data['MLSN'];
        $whereUpdate['subdomain']      = $data['subdomain'];
        $whereUpdate['numberOfLeads']  = $data['numberOfLeads'];
        $whereUpdate['NumberOfLeadsRecently'] = $data['NumberOfLeadsRecently'];
        $whereUpdate['automatedText']  = $data['automatedText'];
        $whereUpdate['PictureURL']     = $data['PictureURL'];

        // tick boxes
        $whereUpdate['ReceiveTextAlerts']  = isset($data['ReceiveTextAlerts']) ? 1 : 0;
        $whereUpdate['ReceivePhoneAlerts'] = isset($data['ReceivePhoneAlerts']) ? 1 : 0;
        $whereUpdate['isBroker']           = isset($data['isBroker']) ? 1 : 0;
        $whereUpdate['isRealtor']          = isset($data['isRealtor']) ? 1 : 0;
        $whereUpdate['isLender']           = isset($data['isLender']) ? 1 : 0;
        $whereUpdate['WantsSellerLeads']   = isset($data['WantsSellerLeads']) ? 1 : 0;
        $whereUpdate['NotifyFavor']        = isset($data['NotifyFavor']) ? 1 : 0;
        $whereUpdate['NotifyHouseView']    = isset($data['NotifyHouseView']) ? 1 : 0;
        $whereUpdate['NotifyEmailOpen']    = isset($data['NotifyEmailOpen']) ? 1 : 0;
        $whereUpdate['ReceiveDailyTODO']   = isset($data['ReceiveDailyTODO']) ? 1 : 0;
        $whereUpdate['sendText']           = isset($data['sendText']) ? 1 : 0;

        return $oSalesPerson->updateOrCreate( $where, $whereUpdate );
    }

    /**
    * transfer Agent Leads
    * 
    * @param integer $oldAgentId Agent Id
    * @param integer $newAgentId Agent Id
    */
    public function transferLeads($oldAgentId, $newAgentId)
    {
        // update Lead table
        GALead::where('SalesPersonID', $oldAgentId)->update(['SalesPersonID' => $newAgentId]);

        // update Lead todo table
        GALeadTodo::where('SalesPersonID', $oldAgentId)->update(['SalesPersonID' => $newAgentId]);

        // update Lead call table
        GALeadCall::where('SalesPersonID', $oldAgentId)->update(['SalesPersonID' => $newAgentId]);

        return true;
    }
}
