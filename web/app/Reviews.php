<?php

namespace TiffinService;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reviews extends Model
{
    
  
    protected $table = 'review';
    protected $primaryKey = 'ReveiwId';

      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'HomeMakerID','TiffinSeekerId','ReviewDesc','ReviewCount','created_at','updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
      
    ];

}
