<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //campos que quiero que se puedan llenar
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description',
    ];
    
    //protected $table = 'categories'; //category
    
    //protected $primary_key = 'id'; //category_id
    
    public function listProducts(){
        return $this->hasMany(Product::class);
    }

}
