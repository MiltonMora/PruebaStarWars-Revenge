<?php

namespace App\Service\StarWars;

use GuzzleHttp\Client;

class StarWarsInfoClient
{

    private Client $client;

    public function __construct()
    {
        $this->client = new Client();
    }

    public function getPeopleInfo(int $page): array
    {
        $people = $this->client->request('GET', 'https://swapi.dev/api/people/?page='.$page);

        return json_decode($people->getBody()->getContents(), true);
    }

    public function getFilmsInfoByUrl(string $url): array
    {
        $films = $this->client->request('GET', $url);
        return json_decode($films->getBody()->getContents(), true);
    }
}
