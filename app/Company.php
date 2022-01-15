<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = [
      'name',
      'email',
      'logo',
      'website_url'
    ];


    public function employees()
    {
        return $this->hasMany('App\Employee','company_id','id');
    }
  
}
