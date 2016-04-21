<?php

namespace GAPlatform\Models;

use Illuminate\Database\Eloquent\Model;

class GALeadCall extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'GA_LeadCall';

    protected $primaryKey = 'CallID';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['CallID','LeadID','SalesPersonID'];

    protected $guarded = ['CallID'];

}
