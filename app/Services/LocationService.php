<?php

namespace App\Services;

use App\Models\Contact;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Spatie\Geocoder\Facades\Geocoder;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class LocationService
{
    /**
     * Consulta um cep no viacep e retorna os dados
     * 
     * @param string $cep
     * @return array
     * 
     * @throws \Exception
     */
    public function queryCep(string $cep): array
    {
        if (strlen($cep) != 8) {
            return false;
        }

        // cache key
        $cacheKey = "cep:{$cep}";

        // Verifica se os dados estão em cache
        if (Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }

        // Consulta o cep na api viacep
        $url = "https://viacep.com.br/ws/{$cep}/json/";
        $response = Http::get($url);

        if ($response->failed() || array_key_exists('erro', $response->json())) {
            throw new BadRequestException('CEP não encontrado');
        }

        $zipCode = $response->json();

        // Armazena os dados em cache por 1 hora
        Cache::put($cacheKey, $zipCode, now()->addHour());

        return $zipCode;
    }

    /**
     * Retorna as coordenadas de um endereço
     * 
     * @param Contact $contact
     * @return array
     * 
     * @throws \Exception
     */
    public function getCoordinatesByAddress(Contact $contact)
    {
        $address = "{$contact->address}, {$contact->number} - {$contact->district}, {$contact->city->description} - {$contact->city->uf}, {$contact->zipcode}";
        $geocoder = $this->getLatitudeAndLongitude($address);

        $newData['latitude'] = $geocoder["lat"];
        $newData['longitude'] = $geocoder["lng"];

        return $newData;
    }

    /**
     * Consulta as coordenadas de um endereço no geocoder
     * 
     * @param string $address
     * 
     * @return array
     * 
     * @throws \Exception
     */
    public function getLatitudeAndLongitude($address)
    {
        $geocoder = Geocoder::getCoordinatesForAddress($address);
        return $geocoder;
    }
}
