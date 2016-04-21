<?php

namespace GAPlatform\Models;

use Illuminate\Database\Eloquent\Model;

class GALeadTodo extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'GA_LeadTODO';

    protected $primaryKey = 'TODOID';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['TODOID','LeadID','SalesPersonID'];

    protected $guarded = ['TODOID'];

}
