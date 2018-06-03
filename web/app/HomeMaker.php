<?php

namespace TiffinService;

use Illuminate\Database\Eloquent\Model;

class HomeMaker extends Model
{
    
	 protected $table = 'homemaker';
      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'UserId','HMFoodLicense','HMLicenseExpiryDate','HMMaxSubscCount'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
      
    ];}
