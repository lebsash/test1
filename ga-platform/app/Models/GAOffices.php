<?php
namespace GAPlatform\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
use GAPlatform\Models\GASalesPerson;


class GAOffices extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'GAOffices';
    public $timestamps = true;
    protected $primaryKey = 'id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['UID', 'Email','Name','Phone','Logo_URL','Logo_ID','DomainName','isActive'];
    protected $guarded  = ['id'];

   

    public function scopeGetByUserId($query, $id)
    {
        $query->where('id', $id);
        return $query;
    }

    public function scopeOfficeByEmail($query, $email)
    {
        $query->where('Email', $email);
        return $query;
    }

    public function scopeActiveOffices($query)
    {
        $query->where('isActive', 1);
        return $query;
    }

    public function getOfficesList()
    {
       
        $userResult = GAUser::select(['id', 'Name', 'UID'])
                            ->orderBy('Name','DESC');                
        return $userResult->get()->toArray();
    }


public function scopeSearch($query, $keyword)
    {
        $query->where(function($query) use ($keyword)
            {
                $query->orWhere($this->table.'.Name', 'LIKE', '%'.$keyword.'%');
                $query->orWhere($this->table.'.Email', 'LIKE', '%'.$keyword.'%');
                $query->orWhere($this->table.'.Phone', 'LIKE', '%'.$keyword.'%');
                $query->orWhere($this->table.'.UID', 'LIKE', '%'.$keyword.'%');
                $query->orWhere($this->table.'.DomainName', 'LIKE', '%'.$keyword.'%');
            });

        return $query;
    }



    public function getAllAgents($UID)
    {
				$allSalesPerson = DB::table('GA_SalesPerson')
                               ->Join('GA_User', 'GA_SalesPerson.UserID', '=', 'GA_User.UserID')
                               ->where('GA_SalesPerson.Office', $UID)
                               ->get();


      return $allSalesPerson;
  
    }

public function getAllOffices($perpage = 50, $status = 'live', $search = '', $order = 'Name', $sort = 'DESC')
    {
        $allAllOffices = $this->select(['id',
        								 'UID',
                                         'Name',
                                         'Email',
                                         'Phone',
                                         'Logo_URL',
                                         'Logo_ID',
                                         'DomainName',
                                         'isActive',
                                         'created_at'])
                               ->orderBy($order, $sort);

        // to search
        if (strlen(trim($search))) {
            $allAllOffices->search(trim($search));
        }

        return $allAllOffices->paginate($perpage);
    }


    /**
    * update/create a Offices
    * 
    * @param array $data Offices details
    */
    public function saveOffices($data)
    {
        $oUser = new GAOffices();
        $where = [];
        $whereUpdate = [];
        $where['id']        = $data['id'];
        // common fields
        $whereUpdate['Name']                    = $data['Name'];
        $whereUpdate['UID']                     = $data['UID'];
        $whereUpdate['Email']                   = $data['Email'];
        $whereUpdate['Phone']                   = $data['Phone'];
        $whereUpdate['Logo_URL']                = $data['Logo_URL'];
        $whereUpdate['Logo_ID']                 = $data['Logo_ID'];
        $whereUpdate['DomainName']              = $data['DomainName'];
        $whereUpdate['isActive']                = $data['isActive'];
        return $oUser->updateOrCreate( $where, $whereUpdate );
    }
}
