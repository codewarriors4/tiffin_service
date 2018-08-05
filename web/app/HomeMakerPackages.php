<?php

namespace TiffinService;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HomeMakerPackages extends Model
{
    
  
	protected $softDelete = true;

    protected $dates = ['deleted_at'];

    protected $table = 'homemakerpackages';
    protected $primaryKey = 'HMPId';

      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'HMPName','HMPDesc','HMPCost','HomeMakerId','HomeMakerId',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
      
    ];

}
