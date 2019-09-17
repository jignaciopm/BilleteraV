<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Deudor extends Model
{
    protected $table = 'deudores';

    protected $fillable = ['id_user', 'concepto', 'monto', 'deudor'];

    public function user()
    {
        return $this->belongsTo('App\User', 'id_user');
    }

    /**
     * Get the deudor decrypted.
     *
     * @param  string  $value
     * @return string
     */

    public function getDeudorAttribute($value)
    {
        return decrypt($value);
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
        return doubleval(decrypt($value));
    }

    /**
     * Set the deudor encrypt.
     *
     * @param  string  $value
     * @return void
     */
    public function setDeudorAttribute($value)
    {
        $this->attributes['deudor'] = encrypt($value);
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

}
