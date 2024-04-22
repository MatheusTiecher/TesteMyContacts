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

    // 0 - Pessoal
    // 1 - Profissional
    // 3 - Familiar
    // 4 - Outros

    protected $appends = ['full_address', 'type_description'];

    public function setCpfAttribute($value)
    {
        $this->attributes['cpf'] = preg_replace('/[^0-9]/', '', $value);
    }

    public function setZipcodeAttribute($value)
    {
        $this->attributes['zipcode'] = preg_replace('/[^0-9]/', '', $value);
    }

    public function getFullAddressAttribute()
    {
        return "{$this->address}, {$this->number} - {$this->district}, {$this->city->description} - {$this->city->uf}";
    }

    public function getTypeDescriptionAttribute()
    {
        $types = [
            0 => 'Pessoal',
            1 => 'Profissional',
            2 => 'Familiar',
            3 => 'Outros',
        ];

        return $types[$this->type];
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
