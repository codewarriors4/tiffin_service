<?php

namespace TiffinService;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
    
  
	protected $softDelete = true;

    protected $dates = ['deleted_at'];

    protected $table = 'payment';
    protected $primaryKey = 'PId';

      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'PTransacID','PAmt','PStatus','PCardNumber','PCardExpiry','SubscID'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
      
    ];

}
