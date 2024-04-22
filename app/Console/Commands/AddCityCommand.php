<?php

namespace App\Console\Commands;

use App\Models\City;
use Illuminate\Console\Command;
use GuzzleHttp\Client;

class AddCityCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:add-city-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Adiciona todos os estados do Brasil
        $client = new Client();
        $response = $client->get('http://servicodados.ibge.gov.br/api/v1/localidades/estados');
        $ibgeStates = json_decode($response->getBody());

        // Adiciona todas as cidades dos estados
        foreach ($ibgeStates as $state) {
            $response = $client->get("http://servicodados.ibge.gov.br/api/v1/localidades/estados/{$state->sigla}/municipios");
            $ibgeCities = json_decode($response->getBody());

            foreach ($ibgeCities as $ibgeCity) {
                $city = City::find($ibgeCity->id);

                if (empty($city)) {
                    City::create([
                        'id' => $ibgeCity->id,
                        'description' => $ibgeCity->nome,
                        'uf' => $state->sigla,
                    ]);
                }
            }
        }

        $this->info('Cidades adicionadas com sucesso!');
    }
}
