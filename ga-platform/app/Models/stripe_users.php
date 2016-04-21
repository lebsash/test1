<?php

namespace GAPlatform\Models;

use Illuminate\Database\Eloquent\Model;

use DB;
use Laravel\Cashier\Billable;

class stripe_users extends Authenticatable
{
    use Billable;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'stripe_users';
    public $timestamps = true;

     * @var array
     */
    protected $fillable = ['stripe_id', 'card_brand','card_last_four','trial_ends_at'];
   
}
