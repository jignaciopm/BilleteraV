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

    public function movimientos()
    {
        return $this->hasMany('App\Movimiento', 'id_user');
    }

    public function cash()
    {
        return $this->movimientos()->where('medio','efectivo');
    }

    public function transfers()
    {
        return $this->movimientos()->where('medio','transferencia');
    }

    public function incomes()
    {
        return $this->movimientos()->where('tipo','+');
    }

    public function expenses()
    {
        return $this->movimientos()->where('tipo','-');
    }

    public function totalByType($type = '+')
    {
        $movimientos = $this->movimientos()->where('tipo',$type)->get();

        return array(
            "value" => $movimientos->sum('monto'),
			"value_con" => [
				"es_mensualidad" => $movimientos->where('es_mensualidad',"1")->sum('monto')
            ],
            "value_sin" => [
				"cambios" => $movimientos->whereNotIn('gasto',["Cambios"])->sum('monto')
			],
        	"transferencia" => $movimientos->where('medio','transferencia')->sum('monto'),
        	"efectivo" => $movimientos->where('medio','efectivo')->sum('monto'),
        	"chase" => $movimientos->where('medio','transferencia')->where('banco','Chase')->sum('monto'),
        	"banpan" => $movimientos->where('medio','transferencia')->where('banco','BanPan')->sum('monto'),
        	"bofa" => $movimientos->where('medio','transferencia')->where('banco','bofa')->sum('monto')
        );
    }

    public function total()
    {
        $totalIncomes = $this->totalByType();
        $totalExpenses = $this->totalByType('-');

        $subtracted = array_map(function ($x, $y) { 
            return doubleval($x) - doubleval($y); 
        }, $totalIncomes, $totalExpenses);

        return array_combine(array_keys($totalIncomes), $subtracted);
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
     * Set the user's password bcrypted.
     *
     * @param  string  $value
     * @return void
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
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
