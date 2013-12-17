<?php
use \ApiGuy;
use \ComPHPPuebla\Doctrine\DBAL\Fixture\Loader\YamlLoader;
use \ComPHPPuebla\Doctrine\DBAL\Fixture\Persister\ConnectionPersister;
use \Doctrine\DBAL\DriverManager;

class GasStationsCest
{
    protected $connection;

    public function __construct()
    {
        $params = require __DIR__ . '/../../config/connection.config.php';
        $this->connection = DriverManager::getConnection($params);
    }

    public function _before()
    {
        $this->connection->exec('DELETE FROM stations');
        $loader = new YamlLoader(__DIR__ . '/../../fixtures/stations.yml');
        $persister = new ConnectionPersister($this->connection);
        $persister->persist($loader->load());
    }

    public function _after()
    {
    }

    // tests
    public function testListOfStationsIsShown(ApiGuy $i)
    {
        $expectedStations = '{
    "_links": {
        "self": {
            "href": "http:\/\/api.echalegas.dev\/gas-stations"
        }
    },
    "_embedded": {
        "stations": [
            {
                "_links": {
                    "self": {
                        "href": "http:\/\/api.echalegas.dev\/gas-stations\/1"
                    }
                },
                "station_id": 1,
                "name": "CASMEN GASOL",
                "social_reason": "CASMEN SA CV",
                "address_line_1": "23 PTE NO 711",
                "address_line_2": "EL CARMEN",
                "location": "PUEBLA PUE",
                "latitude": 19.03817,
                "longitude": -98.20737,
                "created_at": "2013-10-06 00:00:00",
                "last_updated_at": "2013-10-06 00:00:00"
            },
            {
                "_links": {
                    "self": {
                        "href": "http:\/\/api.echalegas.dev\/gas-stations\/2"
                    }
                },
                "station_id": 2,
                "name": "COMBUSTIBLES JV",
                "social_reason": "COMBUSTIBLES JV SA CV",
                "address_line_1": "24 SUR NO 507",
                "address_line_2": "CENTRO",
                "location": "PUEBLA PUE",
                "latitude": 19.03492,
                "longitude": -98.18554,
                "created_at": "2013-10-06 00:00:00",
                "last_updated_at": "2013-10-06 00:00:00"
            },
            {
                "_links": {
                    "self": {
                        "href": "http:\/\/api.echalegas.dev\/gas-stations\/3"
                    }
                },
                "station_id": 3,
                "name": "GAS LA POBLANITA",
                "social_reason": "GASOLINERA LA POBLANITA SA CV",
                "address_line_1": "2 PTE NO 1902",
                "address_line_2": "SAN ALEJANDRO",
                "location": "PUEBLA PUE",
                "latitude": 19.05226,
                "longitude": -98.21158,
                "created_at": "2013-10-06 00:00:00",
                "last_updated_at": "2013-10-06 00:00:00"
            },
            {
                "_links": {
                    "self": {
                        "href": "http:\/\/api.echalegas.dev\/gas-stations\/4"
                    }
                },
                "station_id": 4,
                "name": "GASOL ECOLOGIC POBLANO",
                "social_reason": "GASOL ECOLOGICO POBLANO SA CV",
                "address_line_1": "C 26 SUR NO  709",
                "address_line_2": "AZCARATE",
                "location": "PUEBLA PUE",
                "latitude": 19.03348,
                "longitude": -98.18496,
                "created_at": "2013-10-06 00:00:00",
                "last_updated_at": "2013-10-06 00:00:00"
            },
            {
                "_links": {
                    "self": {
                        "href": "http:\/\/api.echalegas.dev\/gas-stations\/5"
                    }
                },
                "station_id": 5,
                "name": "GASOL LA CAMIONERA",
                "social_reason": "SERV LA CAMIONERA PUEBLA SA CV",
                "address_line_1": "BLVD NTE NO 4210",
                "address_line_2": "LAS CUARTILLAS",
                "location": "PUEBLA PUE",
                "latitude": 19.07248,
                "longitude": -98.2044,
                "created_at": "2013-10-06 00:00:00",
                "last_updated_at": "2013-10-06 00:00:00"
            },
            {
                "_links": {
                    "self": {
                        "href": "http:\/\/api.echalegas.dev\/gas-stations\/6"
                    }
                },
                "station_id": 6,
                "name": "GASOL LOS ANGELES",
                "social_reason": "GASOLINERA LOS ANGELES SA CV",
                "address_line_1": "AV 16 DE SEPTIEMBRE NO 4322",
                "address_line_2": "HUEXOTITLA",
                "location": "PUEBLA PUE",
                "latitude": 19.0265,
                "longitude": -98.20896,
                "created_at": "2013-10-06 00:00:00",
                "last_updated_at": "2013-10-06 00:00:00"
            }
        ]
    }
}
';
        $i->wantTo('List all the available stations in JSON format');
        $i->haveHttpHeader('Accept','application/json');
        $i->sendGET('/gas-stations');
        $i->seeResponseCodeIs(200);
        $i->seeResponseIsJson();
        $i->seeResponseContains($expectedStations);
    }
}
