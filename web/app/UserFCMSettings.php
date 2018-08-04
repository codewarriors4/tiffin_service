<?php

namespace TiffinService;

use Illuminate\Database\Eloquent\Model;

class UserFCMSettings extends Model
{
    
	 protected $table = 'UserFCMSettings';
     protected $primaryKey = 'UFCMSId';

     

      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'UFCMSId','MFCMSIdFk','UserIdFk'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
      
    ];


}
