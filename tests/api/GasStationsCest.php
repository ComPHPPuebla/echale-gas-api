<?php
use \ApiGuy;
use \ComPHPPuebla\Doctrine\DBAL\Fixture\Loader\YamlLoader;
use \ComPHPPuebla\Doctrine\DBAL\Fixture\Persister\ConnectionPersister;
use \Doctrine\DBAL\DriverManager;

class GasStationsCest
{
    /**
     * @var \Doctrine\DBAL\Connection
     */
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

    public function testSendRequestWithoutAcceptHeaderReturnsNotAcceptableStatusJson(ApiGuy $i)
    {
        $i->wantTo('Send a request without an "Accept" header');
        $i->sendGET('/gas-stations');
        $i->seeResponseCodeIs(406);
    }

    public function testCanSeeFullListOfStationsJson(ApiGuy $i)
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
        $i->wantTo('List all the available stations (JSON format)');
        $i->haveHttpHeader('Accept','application/json');
        $i->sendGET('/gas-stations');
        $i->seeResponseCodeIs(200);
        $i->seeResponseIsJson();
        $i->seeResponseContains($expectedStations);
    }

    public function testCanSeeFullListOfStationsXml(ApiGuy $i)
    {
        $expectedStations = '<?xml version="1.0"?>
<resource href="http://api.echalegas.dev/gas-stations">
  <resource href="http://api.echalegas.dev/gas-stations/1" rel="stations">
    <station_id>1</station_id>
    <name>CASMEN GASOL</name>
    <social_reason>CASMEN SA CV</social_reason>
    <address_line_1>23 PTE NO 711</address_line_1>
    <address_line_2>EL CARMEN</address_line_2>
    <location>PUEBLA PUE</location>
    <latitude>19.03817</latitude>
    <longitude>-98.20737</longitude>
    <created_at>2013-10-06 00:00:00</created_at>
    <last_updated_at>2013-10-06 00:00:00</last_updated_at>
  </resource>
  <resource href="http://api.echalegas.dev/gas-stations/2" rel="stations">
    <station_id>2</station_id>
    <name>COMBUSTIBLES JV</name>
    <social_reason>COMBUSTIBLES JV SA CV</social_reason>
    <address_line_1>24 SUR NO 507</address_line_1>
    <address_line_2>CENTRO</address_line_2>
    <location>PUEBLA PUE</location>
    <latitude>19.03492</latitude>
    <longitude>-98.18554</longitude>
    <created_at>2013-10-06 00:00:00</created_at>
    <last_updated_at>2013-10-06 00:00:00</last_updated_at>
  </resource>
  <resource href="http://api.echalegas.dev/gas-stations/3" rel="stations">
    <station_id>3</station_id>
    <name>GAS LA POBLANITA</name>
    <social_reason>GASOLINERA LA POBLANITA SA CV</social_reason>
    <address_line_1>2 PTE NO 1902</address_line_1>
    <address_line_2>SAN ALEJANDRO</address_line_2>
    <location>PUEBLA PUE</location>
    <latitude>19.05226</latitude>
    <longitude>-98.21158</longitude>
    <created_at>2013-10-06 00:00:00</created_at>
    <last_updated_at>2013-10-06 00:00:00</last_updated_at>
  </resource>
  <resource href="http://api.echalegas.dev/gas-stations/4" rel="stations">
    <station_id>4</station_id>
    <name>GASOL ECOLOGIC POBLANO</name>
    <social_reason>GASOL ECOLOGICO POBLANO SA CV</social_reason>
    <address_line_1>C 26 SUR NO  709</address_line_1>
    <address_line_2>AZCARATE</address_line_2>
    <location>PUEBLA PUE</location>
    <latitude>19.03348</latitude>
    <longitude>-98.18496</longitude>
    <created_at>2013-10-06 00:00:00</created_at>
    <last_updated_at>2013-10-06 00:00:00</last_updated_at>
  </resource>
  <resource href="http://api.echalegas.dev/gas-stations/5" rel="stations">
    <station_id>5</station_id>
    <name>GASOL LA CAMIONERA</name>
    <social_reason>SERV LA CAMIONERA PUEBLA SA CV</social_reason>
    <address_line_1>BLVD NTE NO 4210</address_line_1>
    <address_line_2>LAS CUARTILLAS</address_line_2>
    <location>PUEBLA PUE</location>
    <latitude>19.07248</latitude>
    <longitude>-98.2044</longitude>
    <created_at>2013-10-06 00:00:00</created_at>
    <last_updated_at>2013-10-06 00:00:00</last_updated_at>
  </resource>
  <resource href="http://api.echalegas.dev/gas-stations/6" rel="stations">
    <station_id>6</station_id>
    <name>GASOL LOS ANGELES</name>
    <social_reason>GASOLINERA LOS ANGELES SA CV</social_reason>
    <address_line_1>AV 16 DE SEPTIEMBRE NO 4322</address_line_1>
    <address_line_2>HUEXOTITLA</address_line_2>
    <location>PUEBLA PUE</location>
    <latitude>19.0265</latitude>
    <longitude>-98.20896</longitude>
    <created_at>2013-10-06 00:00:00</created_at>
    <last_updated_at>2013-10-06 00:00:00</last_updated_at>
  </resource>
</resource>
';
        $i->wantTo('List all the available stations (XML format)');
        $i->haveHttpHeader('Accept','application/xml');
        $i->sendGET('/gas-stations');
        $i->seeResponseCodeIs(200);
        $i->seeResponseIsXml();
        $i->seeResponseContains($expectedStations);
    }

    public function testCanSeeSecondPageOfStationsJson(ApiGuy $i)
    {
        $expectedStations = '{
    "_links": {
        "self": {
            "href": "http:\/\/api.echalegas.dev\/gas-stations?page=2&page_size=3"
        },
        "first": {
            "href": "http:\/\/api.echalegas.dev\/gas-stations?page=1&page_size=3"
        },
        "prev": {
            "href": "http:\/\/api.echalegas.dev\/gas-stations?page=1&page_size=3"
        }
    },
    "_embedded": {
        "stations": [
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
        $i->wantTo('List the second page of stations with a page size of 3 (JSON format)');
        $i->haveHttpHeader('Accept','application/json');
        $i->sendGET('/gas-stations?page=2&page_size=3');
        $i->seeResponseCodeIs(200);
        $i->seeResponseIsJson();
        $i->seeResponseContains($expectedStations);
    }

    public function testCanSeeSecondPageOfStationsXml(ApiGuy $i)
    {
        $expectedStations = '<?xml version="1.0"?>
<resource href="http://api.echalegas.dev/gas-stations?page=2&amp;page_size=3">
  <link href="http://api.echalegas.dev/gas-stations?page=1&amp;page_size=3" rel="first"/>
  <link href="http://api.echalegas.dev/gas-stations?page=1&amp;page_size=3" rel="prev"/>
  <resource href="http://api.echalegas.dev/gas-stations/4" rel="stations">
    <station_id>4</station_id>
    <name>GASOL ECOLOGIC POBLANO</name>
    <social_reason>GASOL ECOLOGICO POBLANO SA CV</social_reason>
    <address_line_1>C 26 SUR NO  709</address_line_1>
    <address_line_2>AZCARATE</address_line_2>
    <location>PUEBLA PUE</location>
    <latitude>19.03348</latitude>
    <longitude>-98.18496</longitude>
    <created_at>2013-10-06 00:00:00</created_at>
    <last_updated_at>2013-10-06 00:00:00</last_updated_at>
  </resource>
  <resource href="http://api.echalegas.dev/gas-stations/5" rel="stations">
    <station_id>5</station_id>
    <name>GASOL LA CAMIONERA</name>
    <social_reason>SERV LA CAMIONERA PUEBLA SA CV</social_reason>
    <address_line_1>BLVD NTE NO 4210</address_line_1>
    <address_line_2>LAS CUARTILLAS</address_line_2>
    <location>PUEBLA PUE</location>
    <latitude>19.07248</latitude>
    <longitude>-98.2044</longitude>
    <created_at>2013-10-06 00:00:00</created_at>
    <last_updated_at>2013-10-06 00:00:00</last_updated_at>
  </resource>
  <resource href="http://api.echalegas.dev/gas-stations/6" rel="stations">
    <station_id>6</station_id>
    <name>GASOL LOS ANGELES</name>
    <social_reason>GASOLINERA LOS ANGELES SA CV</social_reason>
    <address_line_1>AV 16 DE SEPTIEMBRE NO 4322</address_line_1>
    <address_line_2>HUEXOTITLA</address_line_2>
    <location>PUEBLA PUE</location>
    <latitude>19.0265</latitude>
    <longitude>-98.20896</longitude>
    <created_at>2013-10-06 00:00:00</created_at>
    <last_updated_at>2013-10-06 00:00:00</last_updated_at>
  </resource>
</resource>
';
        $i->wantTo('List the second page of stations with a page size of 3 (XML format)');
        $i->haveHttpHeader('Accept','application/xml');
        $i->sendGET('/gas-stations?page=2&page_size=3');
        $i->seeResponseCodeIs(200);
        $i->seeResponseIsXml();
        $i->seeResponseContains($expectedStations);
    }

    public function testGettingANonExistingPageOfStationsReturnsNotFoundStatusJson(ApiGuy $i)
    {
        $i->wantTo('Get a stations page that does not exist (JSON format)');
        $i->haveHttpHeader('Accept','application/json');
        $i->sendGET('/gas-stations?page=6&page_size=3');
        $i->seeResponseCodeIs(404);
    }

    public function testGettingANonExistingPageOfStationsReturnsNotFoundStatusXml(ApiGuy $i)
    {
        $i->wantTo('Get a stations page that does not exist (XML format)');
        $i->haveHttpHeader('Accept','application/xml');
        $i->sendGET('/gas-stations?page=6&page_size=3');
        $i->seeResponseCodeIs(404);
    }

    public function testCanSeeSpecificStationJson(ApiGuy $i)
    {
        $expectedStations = '{
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
}
';
        $i->wantTo('Retrieve a specific station (JSON format)');
        $i->haveHttpHeader('Accept','application/json');
        $i->sendGET('/gas-stations/2');
        $i->seeResponseCodeIs(200);
        $i->seeResponseIsJson();
        $i->seeResponseContains($expectedStations);
    }

    public function testCanSeeSpecificStationXml(ApiGuy $i)
    {
        $expectedStations = '<?xml version="1.0"?>
<resource href="http://api.echalegas.dev/gas-stations/2">
  <station_id>2</station_id>
  <name>COMBUSTIBLES JV</name>
  <social_reason>COMBUSTIBLES JV SA CV</social_reason>
  <address_line_1>24 SUR NO 507</address_line_1>
  <address_line_2>CENTRO</address_line_2>
  <location>PUEBLA PUE</location>
  <latitude>19.03492</latitude>
  <longitude>-98.18554</longitude>
  <created_at>2013-10-06 00:00:00</created_at>
  <last_updated_at>2013-10-06 00:00:00</last_updated_at>
</resource>
';
        $i->wantTo('Retrieve a specific station (XML format)');
        $i->haveHttpHeader('Accept','application/xml');
        $i->sendGET('/gas-stations/2');
        $i->seeResponseCodeIs(200);
        $i->seeResponseIsXml();
        $i->seeResponseContains($expectedStations);
    }

    public function testCanSeeSpecificStationJsonP(ApiGuy $i)
    {
        $expectedStations = 'awesome_callback({
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
}
)';
        $i->wantTo('Retrieve a specific station (JSONP format)');
        $i->haveHttpHeader('Accept','application/json');
        $i->sendGET('/gas-stations/2?callback=awesome_callback');
        $i->seeResponseCodeIs(200);
        $i->seeHttpHeader('Content-Type', 'application/javascript');
        $i->seeResponseContains($expectedStations);
    }

    public function testGettingANonExistingStationReturnsNotFoundStatusJson(ApiGuy $i)
    {
        $i->wantTo('Retrieve a non existing station (JSON format)');
        $i->haveHttpHeader('Accept','application/json');
        $i->sendGET('/gas-stations/120');
        $i->seeResponseCodeIs(404);
        $i->seeResponseIsJson();
    }

    public function testGettingANonExistingStationReturnsNotFoundStatusXml(ApiGuy $i)
    {
        $i->wantTo('Retrieve a non existing station (XML format)');
        $i->haveHttpHeader('Accept','application/xml');
        $i->sendGET('/gas-stations/120');
        $i->seeResponseCodeIs(404);
        $i->seeResponseIsJson();
    }

    public function testCanCreateAStationJson(ApiGuy $i)
    {
        $newStation = [
            'name' => 'GASOLINERA LA 105',
            'social_reason' => 'GASOLINERA LA 105 SA DE CV.',
            'address_line_1' => '105 PTE. SN.',
            'address_line_2' => 'LA POPULAR',
            'location' => 'PUEBLA, PUEBLA',
            'latitude' => 19.03348,
            'longitude' => -98.18496,
        ];
        $i->wantTo('Create a new gas station entry (JSON format)');
        $i->haveHttpHeader('Accept','application/json');
        $i->haveHttpHeader('Content-Type','application/x-www-form-urlencoded');
        $i->sendPOST('/gas-stations', $newStation);
        $i->seeResponseCodeIs(201);
        $i->seeResponseIsJson();
        $i->seeResponseContainsJson($newStation);
    }

    public function testCanCreateAStationXml(ApiGuy $i)
    {
        $newStation = [
            'name' => 'GASOLINERA LA 105',
            'social_reason' => 'GASOLINERA LA 105 SA DE CV.',
            'address_line_1' => '105 PTE. SN.',
            'address_line_2' => 'LA POPULAR',
            'location' => 'PUEBLA, PUEBLA',
            'latitude' => 19.03348,
            'longitude' => -98.18496,
        ];
        $i->wantTo('Create a new gas station entry (XML format)');
        $i->haveHttpHeader('Accept','application/xml');
        $i->haveHttpHeader('Content-Type','application/x-www-form-urlencoded');
        $i->sendPOST('/gas-stations', $newStation);
        $i->seeResponseCodeIs(201);
        $i->seeResponseIsXml();
    }

    public function testValidationFailsWhenDataIsIncompleteOnAnewStationJson(ApiGuy $i)
    {
        $newStation = [
            'name' => 'GASOLINERA LA 105',
            'address_line_1' => '105 PTE. SN.',
            'address_line_2' => 'LA POPULAR',
            'location' => 'PUEBLA, PUEBLA',
            'latitude' => 19.03348,
            'longitude' => -98.18496,
        ];
        $errorResponse = '{
    "messages": {
        "social_reason": [
            "Social Reason is required",
            "Social Reason length must be between 1 and 100"
        ]
    }
}';
        $i->wantTo('Create a new gas station entry with incomplete data (JSON Format)');
        $i->haveHttpHeader('Accept','application/json');
        $i->haveHttpHeader('Content-Type','application/x-www-form-urlencoded');
        $i->sendPOST('/gas-stations', $newStation);
        $i->seeResponseCodeIs(400);
        $i->seeResponseIsJson();
        $i->seeResponseContains($errorResponse);
    }

    public function testValidationFailsWhenDataIsIncompleteOnAnewStationXml(ApiGuy $i)
    {
        $newStation = [
            'name' => 'GASOLINERA LA 105',
            'address_line_1' => '105 PTE. SN.',
            'address_line_2' => 'LA POPULAR',
            'location' => 'PUEBLA, PUEBLA',
            'latitude' => 19.03348,
            'longitude' => -98.18496,
        ];
        $errorResponse = '<?xml version="1.0"?>
<messages>
    <social_reason>
            <message>Social Reason is required</message>
            <message>Social Reason length must be between 1 and 100</message>
        </social_reason>
</messages>
';
        $i->wantTo('Create a new gas station entry with incomplete data (XML Format)');
        $i->haveHttpHeader('Accept','application/xml');
        $i->haveHttpHeader('Content-Type','application/x-www-form-urlencoded');
        $i->sendPOST('/gas-stations', $newStation);
        $i->seeResponseCodeIs(400);
        $i->seeResponseIsXml();
        $i->seeResponseContains($errorResponse);
    }

    public function testCanUpdateAStationInformationJson(ApiGuy $i)
    {
        $newInformation = [
            'name' => 'GASOLINERA NUEVA',
        ];
        $i->wantTo('Update a gas station entry (JSON format)');
        $i->haveHttpHeader('Accept','application/json');
        $i->haveHttpHeader('Content-Type','application/x-www-form-urlencoded');
        $i->sendPUT('/gas-stations/3', $newInformation);
        $i->seeResponseCodeIs(200);
        $i->seeResponseIsJson();
        $i->seeResponseContainsJson($newInformation);
    }

    public function testCanUpdateAStationInformationXml(ApiGuy $i)
    {
        $newInformation = [
            'name' => 'GASOLINERA NUEVA',
        ];
        $i->wantTo('Update a gas station entry (XML format)');
        $i->haveHttpHeader('Accept','application/xml');
        $i->haveHttpHeader('Content-Type','application/x-www-form-urlencoded');
        $i->sendPUT('/gas-stations/3', $newInformation);
        $i->seeResponseCodeIs(200);
        $i->seeResponseIsXml();
    }

    public function testValidationFailsWhenDataIsInvalidEditingAStationJson(ApiGuy $i)
    {
        $newInformation = [
            'latitude' => 'foo',
            'longitude' => -98.18495,
        ];
        $errorResponse = '{
    "messages": {
        "latitude": [
            "Latitude must be numeric"
        ]
    }
}';
        $i->wantTo('Edit a gas station entry with invalid data (JSON format)');
        $i->haveHttpHeader('Accept','application/json');
        $i->haveHttpHeader('Content-Type','application/x-www-form-urlencoded');
        $i->sendPUT('/gas-stations/3', $newInformation);
        $i->seeResponseCodeIs(400);
        $i->seeResponseIsJson();
        $i->seeResponseContains($errorResponse);
    }

    public function testValidationFailsWhenDataIsInvalidEditingAStationJXml(ApiGuy $i)
    {
        $newInformation = [
            'latitude' => 'foo',
            'longitude' => -98.18495,
        ];
        $errorResponse = '<?xml version="1.0"?>
<messages>
    <latitude>
            <message>Latitude must be numeric</message>
        </latitude>
</messages>
';
        $i->wantTo('Edit a gas station entry with invalid data (XML format)');
        $i->haveHttpHeader('Accept','application/xml');
        $i->haveHttpHeader('Content-Type','application/x-www-form-urlencoded');
        $i->sendPUT('/gas-stations/3', $newInformation);
        $i->seeResponseCodeIs(400);
        $i->seeResponseIsXml();
        $i->seeResponseContains($errorResponse);
    }

    public function testEditingANonExistingStationReturnsNotFoundStatusJson(ApiGuy $i)
    {
        $i->wantTo('Edit a non existing gas station (JSON format)');
        $i->haveHttpHeader('Accept','application/json');
        $i->haveHttpHeader('Content-Type','application/x-www-form-urlencoded');
        $i->sendPUT('/gas-stations/22', []);
        $i->seeResponseCodeIs(404);
    }

    public function testEditingANonExistingStationReturnsNotFoundStatusXml(ApiGuy $i)
    {
        $i->wantTo('Edit a non existing gas station (XML format)');
        $i->haveHttpHeader('Accept','application/xml');
        $i->haveHttpHeader('Content-Type','application/x-www-form-urlencoded');
        $i->sendPUT('/gas-stations/22', []);
        $i->seeResponseCodeIs(404);
    }

    public function testDeletingStationReturnsNoContentStatusJson(ApiGuy $i)
    {
        $i->wantTo('Delete a gas station entry  (JSON format)');
        $i->haveHttpHeader('Accept','application/json');
        $i->sendDELETE('/gas-stations/4');
        $i->seeResponseCodeIs(204);
    }

    public function testDeletingStationReturnsNoContentStatusXml(ApiGuy $i)
    {
        $i->wantTo('Delete a gas station entry  (XML format)');
        $i->haveHttpHeader('Accept','application/xml');
        $i->sendDELETE('/gas-stations/4');
        $i->seeResponseCodeIs(204);
    }

    public function testDeletingANonExistingStationReturnsNotFoundStatusJson(ApiGuy $i)
    {
        $i->wantTo('Delete a non existing gas station entry (JSON format)');
        $i->haveHttpHeader('Accept','application/json');
        $i->sendDELETE('/gas-stations/22', []);
        $i->seeResponseCodeIs(404);
    }

    public function testDeletingANonExistingStationReturnsNotFoundStatusXml(ApiGuy $i)
    {
        $i->wantTo('Delete a non existing gas station entry (XML format)');
        $i->haveHttpHeader('Accept','application/xml');
        $i->sendDELETE('/gas-stations/22', []);
        $i->seeResponseCodeIs(404);
    }

    public function testCanSeeOptionsForStationsCollectionJson(ApiGuy $i)
    {
        $i->wantTo('Retrieve the OPTIONS for the list of stations (JSON format)');
        $i->haveHttpHeader('Accept','application/json');
        $i->sendOPTIONS('/gas-stations');
        $i->seeResponseCodeIs(200);
        $i->seeHttpHeader('Allow', 'GET,POST,OPTIONS');
    }

    public function testCanSeeOptionsForStationsCollectionXml(ApiGuy $i)
    {
        $i->wantTo('Retrieve the OPTIONS for the list of stations (XML format)');
        $i->haveHttpHeader('Accept','application/xml');
        $i->sendOPTIONS('/gas-stations');
        $i->seeResponseCodeIs(200);
        $i->seeHttpHeader('Allow', 'GET,POST,OPTIONS');
    }

    public function testCanSeeOptionsForASingleStationJson(ApiGuy $i)
    {
        $i->wantTo('Retrieve the OPTIONS for a single station (JSON format)');
        $i->haveHttpHeader('Accept','application/json');
        $i->sendOPTIONS('/gas-stations/2');
        $i->seeResponseCodeIs(200);
        $i->seeHttpHeader('Allow', 'GET,POST,PUT,DELETE,OPTIONS,HEAD');
    }

    public function testCanSeeOptionsForASingleStationXml(ApiGuy $i)
    {
        $i->wantTo('Retrieve the OPTIONS for a single station (XML format)');
        $i->haveHttpHeader('Accept','application/xml');
        $i->sendOPTIONS('/gas-stations/2');
        $i->seeResponseCodeIs(200);
        $i->seeHttpHeader('Allow', 'GET,POST,PUT,DELETE,OPTIONS,HEAD');
    }
}
