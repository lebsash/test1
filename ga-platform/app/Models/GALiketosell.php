<?php

namespace GAPlatform\Models;

use Illuminate\Database\Eloquent\Model;

class GALiketosell extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'GA_Liketosell';

    protected $primaryKey = 'ID';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['ID','UserID','Volume','LastDelivered','TargetMinValue','LastEmail'];

    protected $guarded = ['ID'];

    public function scopeGetByUserId($query, $userId)
    {
        $query->where('UserID', $userId);

        return $query;
    }
}
