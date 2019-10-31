<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Movimiento extends Model
{
    protected $table = 'movimientos';

    protected $fillable = ['id_user', 'fecha', 'concepto', 'monto', 'tipo', 'medio', 'gasto', 'banco', 'es_mensualidad'];

    public function user()
    {
        return $this->belongsTo('App\User', 'id_user');
    }

    /**
     * Get the concepto decrypted.
     *
     * @param  string  $value
     * @return string
     */

    public function getConceptoAttribute($value)
    {
        return decrypt($value);
    }

    /**
     * Get the monto decrypted.
     *
     * @param  string  $value
     * @return string
     */

    public function getMontoAttribute($value)
    {
        $monto = doubleval(decrypt($value));
        
        return $monto;
    }

    /**
     * Get the es_mensualidad in boolean.
     *
     * @param  string  $value
     * @return string
     */

    public function getEsMensualidadAttribute($value)
    {
        if($value != null)
        {
            if($value == "0")
                return false;
            elseif($value == "1")
                return true;
        }
        else
            return null;
    }

    /**
     * Set the concepto encrypt.
     *
     * @param  string  $value
     * @return void
     */
    public function setConceptoAttribute($value)
    {
        $this->attributes['concepto'] = encrypt($value);
    }

    /**
     * Set the monto encrypt.
     *
     * @param  string  $value
     * @return void
     */
    public function setMontoAttribute($value)
    {
        $this->attributes['monto'] = encrypt($value);
    }

    /**
     * Set the es_mensualidad in enum [0,1].
     *
     * @param  string  $value
     * @return void
     */
    public function setEsMensualidadAttribute($value)
    {
        if(!$value || $value == 0 || $value == "0")
            $this->attributes['es_mensualidad'] = "0";
        elseif($value || $value == 1 || $value == "1")
            $this->attributes['es_mensualidad'] = "1";
    }
}
