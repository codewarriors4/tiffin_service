<?php

namespace TiffinService;

use Illuminate\Database\Eloquent\Model;

class TiffinSeeker extends Model
{


	 protected $table = 'tiffinseeker';
    protected $primaryKey = 'TSId';

      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'TSId','UserId',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
      
    ];
}
