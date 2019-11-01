<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function movimientos($filters = array())
    {
        $movimientos = $this->hasMany('App\Movimiento', 'id_user');

        foreach ($filters as $column => $value) {
            $movimientos = $movimientos->where($column, $value);
        }

        return $movimientos;
    }

    public function cash($type = null)
    {
        $cash = $this->movimientos()->where('medio','efectivo');
        
        if($type != null && ($type == '+' || $type == '-'))
            $cash = $cash->where('tipo',$type);

        return $cash;
    }

    public function transfer($type = null, $bank = null)
    {
        $transfer = $this->movimientos()->where('medio','transferencia');
        
        if($type != null && ($type == '+' || $type == '-'))
            $transfer = $transfer->where('tipo',$type);

        if($bank != null && ($bank == 'Chase' || $bank == 'BofA' || $bank == 'BanPan'))
            $transfer = $transfer->where('banco',$bank);

        return $transfer;
    }

    public function conjuntos()
    {
        return $this->belongsToMany('App\User', 'conjuntos', 'id_user', 'id_conjunto');
    }

    public function deudores()
    {
        return $this->hasMany('App\Deudor', 'id_user');
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
