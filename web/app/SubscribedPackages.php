<?php

namespace TiffinService;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubscribedPackages extends Model
{
    
  
	protected $softDelete = true;

    protected $dates = ['deleted_at'];

    protected $table = 'subscribedpackages';
    protected $primaryKey = 'SPId';

      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'PackageId','SubscrpId'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
      
    ];

}
