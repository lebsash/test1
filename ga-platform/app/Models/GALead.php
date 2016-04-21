<?php

namespace GAPlatform\Models;

use Illuminate\Database\Eloquent\Model;

class GALead extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'GA_Lead';

    protected $primaryKey = 'LeadID';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['LeadID','SalesPersonID'];

    protected $guarded = ['LeadID'];

}
