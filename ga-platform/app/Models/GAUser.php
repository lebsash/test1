<?php

namespace GAPlatform\Models;

use Illuminate\Database\Eloquent\Model;

use DB;

class GAUser extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'GA_User';

    public $timestamps = false;

    protected $primaryKey = 'UserID';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['UserID', 'Email','Name','URL','Points','Source','IP','Created',
                           'AgreementAccepted','Location','PictureURL','IsClient','Zip','Password','Profile',
                           'IsOnGoogle','Headline','Title','BeforeLocation','IsTest','OrderDate','HasCancelled',
                           'AcceptedNDA','Phone','Cell','DisplayEmail','CompanyName','CompanyPhone','CompanyLogo',
                           'ProfessionalRecommendationsScore','DomainName','PrePaid','PaidForward','MonthsCommitment',
                           'MonthsCommitmentStart','hasReviewed','EmailKey','NumberOfHomesPreReg','IsOnOscar',
                           'BuyerSiteURL','SellerSiteURL','VisitorTrackerCode','LeadTrackerCode','MLS','MapMaxLng',
                           'MapMinLng','MapMinLat','MapMaxLat','MapStartZoom','CustomTerms','AgreedCustomTerms',
                           'LandingPageHeadline','LandingPageSubline','LandingPageMenu','MLSLegalDisclaimer',
                           'KPIMonthlyLeads','AccountabilityEnabled','MLSSourceIDs','MLSLegalEachListing',
                           'NeedsMysturyShoppers','MLSMaxListingsPerPage','MLSMaxListingsPerPageMessage','favicon',
                           'accountabilityNewLeadRequiredCallTime','accountabilityLeadReassignNewLeadsIfMissed',
                           'accountabilityConvosToPermanentlyOwnLead','accountabilityLeadReassignAgedLeadsIfMissed',
                           'accountabilityRequiredResponseTimeAfterReassigned','accountabilityNewLeadReassignIfMissed',
                           'accountabilityAddMinutesAttempt1','accountabilityAddMinutesAttempt2',
                           'accountabilityAddMinutesAttempt3','accountabilityAddMinutesAttemptn',
                           'accountabilityAddDaysAfterConvo','accountabilityEarliestRequiredHourInCST',
                           'accountabilityLatestRequiredHourInCST','isSuspended','isGettingDeployed','isLive'];

    protected $guarded = ['UserID'];

    public function scopeSearch($query, $keyword)
    {
        $query->where(function($query) use ($keyword)
            {
                $query->orWhere($this->table.'.Name', 'LIKE', '%'.$keyword.'%');
                $query->orWhere($this->table.'.Email', 'LIKE', '%'.$keyword.'%');
                $query->orWhere($this->table.'.URL', 'LIKE', '%'.$keyword.'%');
                $query->orWhere($this->table.'.Source', 'LIKE', '%'.$keyword.'%');
                $query->orWhere($this->table.'.Location', 'LIKE', '%'.$keyword.'%');
                $query->orWhere($this->table.'.PictureURL', 'LIKE', '%'.$keyword.'%');
                $query->orWhere($this->table.'.Zip', 'LIKE', '%'.$keyword.'%');
                $query->orWhere($this->table.'.Password', 'LIKE', '%'.$keyword.'%');
                $query->orWhere($this->table.'.Headline', 'LIKE', '%'.$keyword.'%');
                $query->orWhere($this->table.'.Title', 'LIKE', '%'.$keyword.'%');
                $query->orWhere($this->table.'.BeforeLocation', 'LIKE', '%'.$keyword.'%');
                $query->orWhere($this->table.'.DomainName', 'LIKE', '%'.$keyword.'%');
                $query->orWhere($this->table.'.EmailKey', 'LIKE', '%'.$keyword.'%');
                $query->orWhere($this->table.'.MLS', 'LIKE', '%'.$keyword.'%');
                $query->orWhere($this->table.'.CustomTerms', 'LIKE', '%'.$keyword.'%');
                $query->orWhere($this->table.'.LandingPageHeadline', 'LIKE', '%'.$keyword.'%');
                $query->orWhere($this->table.'.LandingPageSubline', 'LIKE', '%'.$keyword.'%');
                $query->orWhere($this->table.'.LandingPageMenu', 'LIKE', '%'.$keyword.'%');
                $query->orWhere($this->table.'.MLSLegalDisclaimer', 'LIKE', '%'.$keyword.'%');
            });

        return $query;
    }

    public function scopeGetByUserId($query, $userId)
    {
        $query->where('UserID', $userId);

        return $query;
    }

    public function scopeUserByEmail($query, $email)
    {
        $query->where('Email', $email);

        return $query;
    }

    public function scopeLiveUsers($query)
    {
        $query->where('isLive', 1);

        return $query;
    }

    public function scopeActive($query)
    {
        $query->where('Status', 'active');

        return $query;
    }

    /**
     * Get User's Custom Terms (from legacy)
     */
    public function getUserCustomTerms($userID, $agreed = 0)
    {
        $userResult = GAUser::select(['CustomTerms'])
             ->whereNotNull('CustomTerms')
             ->where('CustomTerms','!=', '')
             ->where('AgreedCustomTerms', '=', $agreed)
             ->where('UserID', $userID)
             ->active();
        if ($customTerms = $userResult->get()->first()) {
            return trim($customTerms->CustomTerms);
        }
        return null;
    }

    /**
     * Get all unsuspended Users
     */
    public function getUsersList()
    {
       
        $userResult = GAUser::select(['UserID', 'Name', DB::raw('CONCAT(UserID," - ",Name) as fullName')])
                            ->where('HasCancelled', 0)
                            ->active()
                            ->orderBy('UserID','DESC');
                   
        return $userResult->get()->toArray();
    }

    /**
     * Get all users/offices
     * 
     * @param integer $perpage perpage
     * @param string $status status
     * @param string $order order column
     * @param string $sort sort
     * @return array of users
     */
    public function getAllUsers($perpage = 50, $status = 'live', $search = '', $order = 'Created', $sort = 'DESC')
    {
        $allUsers = $this->select($this->fillable)
                         ->active()
                         ->orderBy($order, $sort);
        switch($status){
            case 'suspended':
                $allUsers->where('isSuspended', 1);
                break;
            case 'deployed':
                $allUsers->where('isGettingDeployed', 1);
                break;
            case 'live':
                $allUsers->where('isLive', 1);
                break;
            case 'cancelled':
                $allUsers->where('HasCancelled', 1);
                break;
            default: // all
                // no condition
                break;
        }

        // to search
        if (strlen(trim($search))) {
            $allUsers->search(trim($search));
        }

        return $allUsers->paginate($perpage);
    }

    /**
    * update/create a User
    * 
    * @param array $data User details
    */
    public function saveUser($data)
    {
        $oUser = new GAUser();
        $where = [];
        $whereUpdate = [];

        $where['UserID']        = $data['UserID'];

        // common fields
        $whereUpdate['Name']                    = $data['Name'];
        $whereUpdate['Email']                   = $data['Email'];
        $whereUpdate['URL']                     = $data['URL'];
        $whereUpdate['Points']                  = $data['Points'];
        $whereUpdate['Source']                  = $data['Source'];
        $whereUpdate['IP']                      = $data['IP'];
        $whereUpdate['Location']                = $data['Location'];
        $whereUpdate['PictureURL']              = $data['PictureURL'];
        $whereUpdate['Zip']                     = $data['Zip'];
        $whereUpdate['Password']                = $data['Password'];
        $whereUpdate['Headline']                = $data['Headline'];
        $whereUpdate['Title']                   = $data['Title'];
        $whereUpdate['BeforeLocation']          = $data['BeforeLocation'];
        $whereUpdate['AcceptedNDA']             = $data['AcceptedNDA'];
        $whereUpdate['Phone']                   = $data['Phone'];
        $whereUpdate['Cell']                    = $data['Cell'];
        $whereUpdate['DisplayEmail']            = $data['DisplayEmail'];
        $whereUpdate['CompanyName']             = $data['CompanyName'];
        $whereUpdate['CompanyPhone']            = $data['CompanyPhone'];
        $whereUpdate['CompanyLogo']             = $data['CompanyLogo'];
        $whereUpdate['DomainName']              = $data['DomainName'];
        $whereUpdate['MonthsCommitment']        = $data['MonthsCommitment'];
        $whereUpdate['EmailKey']                = $data['EmailKey'];
        $whereUpdate['NumberOfHomesPreReg']     = $data['NumberOfHomesPreReg'];
        $whereUpdate['BuyerSiteURL']            = $data['BuyerSiteURL'];
        $whereUpdate['SellerSiteURL']           = $data['SellerSiteURL'];
        $whereUpdate['MLS']                     = $data['MLS'];
        $whereUpdate['MapMinLng']               = $data['MapMinLng'];
        $whereUpdate['MapMaxLng']               = $data['MapMaxLng'];
        $whereUpdate['MapMinLat']               = $data['MapMinLat'];
        $whereUpdate['MapMaxLat']               = $data['MapMaxLat'];
        $whereUpdate['MapStartZoom']            = $data['MapStartZoom'];
        $whereUpdate['LandingPageHeadline']     = $data['LandingPageHeadline'];
        $whereUpdate['LandingPageSubline']      = $data['LandingPageSubline'];
        $whereUpdate['KPIMonthlyLeads']         = $data['KPIMonthlyLeads'];
        $whereUpdate['MLSSourceIDs']            = $data['MLSSourceIDs'];
        $whereUpdate['MLSMaxListingsPerPage']   = $data['MLSMaxListingsPerPage'];
        $whereUpdate['favicon']                 = $data['favicon'];
        $whereUpdate['accountabilityNewLeadRequiredCallTime']            = $data['accountabilityNewLeadRequiredCallTime'];
        $whereUpdate['accountabilityLeadReassignNewLeadsIfMissed']       = $data['accountabilityLeadReassignNewLeadsIfMissed'];
        $whereUpdate['accountabilityConvosToPermanentlyOwnLead']         = $data['accountabilityConvosToPermanentlyOwnLead'];
        $whereUpdate['accountabilityLeadReassignAgedLeadsIfMissed']      = $data['accountabilityLeadReassignAgedLeadsIfMissed'];
        $whereUpdate['accountabilityRequiredResponseTimeAfterReassigned'] = $data['accountabilityRequiredResponseTimeAfterReassigned'];
        $whereUpdate['accountabilityNewLeadReassignIfMissed']            = $data['accountabilityNewLeadReassignIfMissed'];
        $whereUpdate['accountabilityAddMinutesAttempt1']                 = $data['accountabilityAddMinutesAttempt1'];
        $whereUpdate['accountabilityAddMinutesAttempt2']                 = $data['accountabilityAddMinutesAttempt2'];
        $whereUpdate['accountabilityAddMinutesAttempt3']                 = $data['accountabilityAddMinutesAttempt3'];
        $whereUpdate['accountabilityAddMinutesAttemptn']                 = $data['accountabilityAddMinutesAttemptn'];
        $whereUpdate['accountabilityAddDaysAfterConvo']                  = $data['accountabilityAddDaysAfterConvo'];
        $whereUpdate['accountabilityEarliestRequiredHourInCST']          = $data['accountabilityEarliestRequiredHourInCST'];
        $whereUpdate['accountabilityLatestRequiredHourInCST']            = $data['accountabilityLatestRequiredHourInCST'];
        $whereUpdate['ProfessionalRecommendationsScore']                 = $data['ProfessionalRecommendationsScore'];

        // text
        $whereUpdate['Profile']                 = $data['Profile'];
        $whereUpdate['VisitorTrackerCode']      = $data['VisitorTrackerCode'];
        $whereUpdate['LeadTrackerCode']         = $data['LeadTrackerCode'];
        $whereUpdate['CustomTerms']             = $data['CustomTerms'];
        $whereUpdate['LandingPageMenu']         = $data['LandingPageMenu'];
        $whereUpdate['MLSLegalDisclaimer']      = $data['MLSLegalDisclaimer'];
        $whereUpdate['MLSMaxListingsPerPageMessage'] = $data['MLSMaxListingsPerPageMessage'];
        $whereUpdate['MLSLegalEachListing']     = $data['MLSLegalEachListing'];
        
        // tick boxes
        $whereUpdate['IsClient']              = isset($data['IsClient']) ? 1 : 0;
        $whereUpdate['AgreementAccepted']     = isset($data['AgreementAccepted']) ? 1 : 0;
        $whereUpdate['IsOnGoogle']            = isset($data['IsOnGoogle']) ? 1 : 0;
        $whereUpdate['IsTest']                = isset($data['IsTest']) ? 1 : 0;
        $whereUpdate['HasCancelled']          = isset($data['HasCancelled']) ? 1 : 0;
        $whereUpdate['PrePaid']               = isset($data['PrePaid']) ? 1 : 0;
        $whereUpdate['PaidForward']           = isset($data['PaidForward']) ? 1 : 0;
        $whereUpdate['hasReviewed']           = isset($data['hasReviewed']) ? 1 : 0;
        $whereUpdate['IsOnOscar']             = isset($data['IsOnOscar']) ? 1 : 0;
        $whereUpdate['AgreedCustomTerms']     = isset($data['AgreedCustomTerms']) ? 1 : 0;
        $whereUpdate['AccountabilityEnabled'] = isset($data['AccountabilityEnabled']) ? 1 : 0;
        $whereUpdate['NeedsMysturyShoppers']  = isset($data['NeedsMysturyShoppers']) ? 1 : 0;
        $whereUpdate['isSuspended']           = isset($data['isSuspended']) ? 1 : 0;
        $whereUpdate['isGettingDeployed']     = isset($data['isGettingDeployed']) ? 1 : 0;
        $whereUpdate['isLive']                = isset($data['isLive']) ? 1 : 0;

        return $oUser->updateOrCreate( $where, $whereUpdate );
    }
}
