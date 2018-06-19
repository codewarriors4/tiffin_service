<?php

namespace TiffinService;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subscription extends Model
{
    
  
	protected $softDelete = true;

    protected $dates = ['deleted_at'];

    protected $table = 'subscription';
    protected $primaryKey = 'SubId';

      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'SubCost','SubStartDate','SubEndDate','SubStatus','TiffinSeekerId','HomeMakerId','HMPId'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
      
    ];

}
