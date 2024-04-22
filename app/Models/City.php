<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    // O próprio id da tabela é o id do ibge
    // com isso é possível fazer a integração com a api do ibge
    // e realizar as integrações com API de terceiros ex: ViaCEP 

    protected $table = 'cities';

    protected $fillable = [
        'id', // id do ibge
        'description',
        'uf',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    protected $filterable = [
        'description',
    ];

    public function setUfAttribute($uf)
    {
        $this->attributes['uf'] = strtoupper($uf);
    }
}
