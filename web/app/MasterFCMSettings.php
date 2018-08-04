<?php

namespace TiffinService;

use Illuminate\Database\Eloquent\Model;

class MasterFCMSettings extends Model
{
    
	 protected $table = 'masterfcmsettings';
     protected $primaryKey = 'MFCMSId';

     

      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'FCMFeature'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
      
    ];


}
