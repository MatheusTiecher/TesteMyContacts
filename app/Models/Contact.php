<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'cpf',
        'type',
        'cellphone',
        'address',
        'number',
        'district',
        'zipcode',
        'complement',
        'city_id',
        'latitude',
        'longitude',
    ];

    public function setCpfAttribute($value)
    {
        $this->attributes['cpf'] = preg_replace('/[^0-9]/', '', $value);
    }

    public function setZipcodeAttribute($value)
    {
        $this->attributes['zipcode'] = preg_replace('/[^0-9]/', '', $value);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }
}
