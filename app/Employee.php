<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'company_id',
        'email',
        'phone',
        'linkedin_url'
      ];

      //protected $guarded = [];

      public function company()
      {
          return $this->belongsTo('App\Company','company_id','id');
      }
}
