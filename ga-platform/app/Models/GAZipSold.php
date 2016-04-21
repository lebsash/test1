<?php

namespace GAPlatform\Models;

use Illuminate\Database\Eloquent\Model;

class GAZipSold extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'GA_ZipSold';

    protected $primaryKey = 'ZipSoldID';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['ZipSoldID','Zip','UserID'];

    protected $guarded = ['ZipSoldID'];

    public function scopeGetByUserId($query, $userId)
    {
        $query->where('UserID', $userId);

        return $query;
    }
}
