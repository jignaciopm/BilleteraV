<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Conjunto extends Model
{
    protected $table = 'conjuntos';

    protected $fillable = ['id_user', 'id_conjunto'];

    public function users()
    {
        return $this->hasMany('App\User', 'id');
    }
}
