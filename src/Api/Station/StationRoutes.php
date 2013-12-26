<?php
namespace Api\Station;

use Slim\Slim;

/**
 * @SWG\Resource(
 *   apiVersion="0.1",
 *   swaggerVersion="1.2",
 *   resourcePath="/gas-stations",
 *   description="Operations about gas stations",
 *   produces="['application/json','application/xml']",
 *   basePath="http://api.echalegas.dev"
 * )
 */
class StationRoutes
{
    /**
     * @var Slim
     */
    protected $app;

    /**
     * @param Slim $app
     */
    public function __construct(Slim $app)
    {
        $this->app = $app;
    }

    /**
     * Register gas-stations routes
     */
	public function register()
	{
	    $this->listStations();
	    $this->findStation();
	    $this->newStation();
        $this->editStation();
        $this->deleteStation();
        $this->optionsStations();
        $this->optionsStation();
	}

	/**
	 * @SWG\Api(
	 *   path="/gas-stations",
	 *   @SWG\Operation(
	 *     method="GET",
	 *     summary="Find all the available gas stations",
	 *     notes="Find all available gas stations. The result can be paginated and filtered by geolocation",
	 *     type="array[GasStation]",
	 *     nickname="getGasStations",
	 *     @SWG\Parameters(
	 *       @SWG\Parameter(
	 *         name="Accept",
	 *         description="The type of response that the web service client expects",
	 *         paramType="header",
	 *         required=true,
	 *         type="string",
	 *         enum="['application/json', 'application/xml']"
	 *       ),
	 *       @SWG\Parameter(
	 *         name="page",
	 *         description="The page number of gas stations to be retrieved",
	 *         paramType="query",
	 *         required=false,
	 *         type="integer"
	 *       ),
	 *       @SWG\Parameter(
	 *         name="page_size",
	 *         description="Defines the number of gas stations to be retrieved by page. This parameter is ignored if the page parameter is not present. The default is 10",
	 *         paramType="query",
	 *         required=false,
	 *         type="integer"
	 *       ),
	 *       @SWG\Parameter(
	 *         name="latitude",
	 *         description="This parameter will filter the results retrieving the nearer gas stations first. This parameter will be ignored if parameter longitude is not provided",
	 *         paramType="query",
	 *         required=false,
	 *         type="integer"
	 *       ),
	 *       @SWG\Parameter(
	 *         name="longitude",
	 *         description="This parameter will filter the results retrieving the nearer gas stations first. This parameter will be ignored if parameter latitude is not provided",
	 *         paramType="query",
	 *         required=false,
	 *         type="integer"
	 *       )
	 *     ),
	 *     @SWG\ResponseMessages(
	 *       @SWG\ResponseMessage(
	 *         code=404,
	 *         message="Invalid page number provided. Stations not found"
	 *       )
	 *     )
	 *   )
	 * )
	 */
	protected function listStations()
	{
	    $this->app->get('/gas-stations', function() {

	        $this->app->stationsController->getList();

	    })->name('stations');
	}

	/**
	 * @SWG\Api(
	 *   path="/gas-stations/{gasStationId}",
	 *   @SWG\Operation(
	 *     method="GET",
	 *     summary="Find a gas station by ID",
	 *     notes="Returns a gas station based on ID",
	 *     type="GasStation",
	 *     nickname="getGasStationById",
	 *     @SWG\Parameters(
	 *       @SWG\Parameter(
	 *         name="Accept",
	 *         description="The type of response that the web service client expects",
	 *         paramType="header",
	 *         required=true,
	 *         type="string",
	 *         enum="['application/json', 'application/xml']"
	 *       ),
	 *       @SWG\Parameter(
	 *         name="gasStationId",
	 *         description="ID of gas station that needs to be fetched",
	 *         paramType="path",
	 *         required=true,
	 *         type="integer"
	 *       )
	 *     ),
	 *     @SWG\ResponseMessages(
	 *       @SWG\ResponseMessage(
	 *         code=404,
	 *         message="Gas station not found"
	 *       )
	 *     )
	 *   )
	 * )
	 */
	protected function findStation()
	{
	    $this->app->get('/gas-stations/:id', function($id) {

	        $this->app->stationController->get($id);

	    })->name('station');
	}

	/**
	 * @SWG\Api(
	 *   path="/gas-stations",
	 *   @SWG\Operation(
	 *     method="POST",
	 *     summary="Register a new gas station",
	 *     type="GasStation",
	 *     nickname="newGasStation",
	 *     @SWG\Parameters(
	 *       @SWG\Parameter(
	 *         name="Accept",
	 *         description="The type of response that the web service client expects",
	 *         paramType="header",
	 *         required=true,
	 *         type="string",
	 *         enum="['application/json', 'application/xml']"
	 *       ),
	 *       @SWG\Parameter(
	 *         name="name",
	 *         description="The name of the new gas station",
	 *         paramType="form",
	 *         required=true,
	 *         type="string"
	 *       ),
	 *       @SWG\Parameter(
	 *         name="social_reason",
	 *         description="The legal name of the new gas station",
	 *         paramType="form",
	 *         required=true,
	 *         type="string"
	 *       ),
	 *       @SWG\Parameter(
	 *         name="address_line_1",
	 *         description="Street name and number of the gas station",
	 *         paramType="form",
	 *         required=true,
	 *         type="string"
	 *       ),
	 *       @SWG\Parameter(
	 *         name="address_line_2",
	 *         description="Name of the gas station neighborhood",
	 *         paramType="form",
	 *         required=true,
	 *         type="string"
	 *       ),
	 *       @SWG\Parameter(
	 *         name="location",
	 *         description="State and city name where the gas station is located",
	 *         paramType="form",
	 *         required=true,
	 *         type="string"
	 *       ),
	 *       @SWG\Parameter(
	 *         name="latitude",
	 *         description="Latitude coordinate",
	 *         paramType="form",
	 *         required=true,
	 *         type="double"
	 *       ),
	 *       @SWG\Parameter(
	 *         name="longitude",
	 *         description="Longitude coordinate",
	 *         paramType="form",
	 *         required=true,
	 *         type="double"
	 *       )
	 *     ),
	 *     @SWG\ResponseMessage(
	 *       code=400,
	 *       message="Gas station data did not pass validation"
	 *     )
	 *   )
	 * )
	 */
	protected function newStation()
	{
	    $this->app->post('/gas-stations', function() {

	        $this->app->stationController->post();
	    });
	}

	/**
	 * @SWG\Api(
	 *   path="/gas-stations/{gasStationId}",
	 *   @SWG\Operation(
	 *     method="PUT",
	 *     summary="Edit the information of a gas station",
	 *     type="GasStation",
	 *     nickname="editGasStation",
	 *     @SWG\Parameters(
	 *       @SWG\Parameter(
	 *         name="Accept",
	 *         description="The type of response that the web service client expects",
	 *         paramType="header",
	 *         required=true,
	 *         type="string",
	 *         enum="['application/json', 'application/xml']"
	 *       ),
	 *       @SWG\Parameter(
	 *         name="gasStationId",
	 *         description="ID of gas station that needs to be edited",
	 *         paramType="path",
	 *         required=true,
	 *         type="integer"
	 *       ),
	 *       @SWG\Parameter(
	 *         name="name",
	 *         description="The name of the gas station",
	 *         paramType="form",
	 *         required=false,
	 *         type="string"
	 *       ),
	 *       @SWG\Parameter(
	 *         name="social_reason",
	 *         description="The legal name of the gas station",
	 *         paramType="form",
	 *         required=false,
	 *         type="string"
	 *       ),
	 *       @SWG\Parameter(
	 *         name="address_line_1",
	 *         description="Street name and number of the gas station",
	 *         paramType="form",
	 *         required=false,
	 *         type="string"
	 *       ),
	 *       @SWG\Parameter(
	 *         name="address_line_2",
	 *         description="Name of the gas station neighborhood",
	 *         paramType="form",
	 *         required=false,
	 *         type="string"
	 *       ),
	 *       @SWG\Parameter(
	 *         name="location",
	 *         description="State and city name where the gas station is located",
	 *         paramType="form",
	 *         required=false,
	 *         type="string"
	 *       ),
	 *       @SWG\Parameter(
	 *         name="latitude",
	 *         description="Latitude coordinate",
	 *         paramType="form",
	 *         required=false,
	 *         type="double"
	 *       ),
	 *       @SWG\Parameter(
	 *         name="longitude",
	 *         description="Longitude coordinate",
	 *         paramType="form",
	 *         required=false,
	 *         type="double"
	 *       )
	 *     ),
	 *     @SWG\ResponseMessages(
	 *       @SWG\ResponseMessage(
	 *         code=400,
	 *         message="Gas station data did not pass validation"
	 *       ),
	 *       @SWG\ResponseMessage(
	 *         code=404,
	 *         message="Gas station data not found"
	 *       )
	 *     )
	 *   )
	 * )
	 */
	protected function editStation()
	{
	    $this->app->put('/gas-stations/:id', function($id) {

	        $this->app->stationController->put($id);
	    });
	}

	/**
	 * @SWG\Api(
	 *   path="/gas-stations/{gasStationId}",
	 *   @SWG\Operation(
	 *     method="DELETE",
	 *     summary="Delete the information of a gas station",
	 *     nickname="deleteGasStation",
	 *     @SWG\Parameters(
	 *       @SWG\Parameter(
	 *         name="Accept",
	 *         description="The type of response that the web service client expects",
	 *         paramType="header",
	 *         required=true,
	 *         type="string",
	 *         enum="['application/json', 'application/xml']"
	 *       ),
	 *       @SWG\Parameter(
	 *         name="gasStationId",
	 *         description="ID of gas station that needs to be deleted",
	 *         paramType="path",
	 *         required=true,
	 *         type="integer"
	 *       )
	 *     ),
	 *     @SWG\ResponseMessage(
	 *       code=404,
	 *       message="Gas station not found"
	 *     )
	 *   )
	 * )
	 */
	protected function deleteStation()
	{
	    $this->app->delete('/gas-stations/:id', function($id) {

	        $this->app->stationController->delete($id);
	    });
	}

	/**
	 * @SWG\Api(
	 *   path="/gas-stations",
	 *   @SWG\Operation(
	 *     method="OPTIONS",
	 *     summary="Get the valid options of gas stations",
	 *     nickname="optionsGasStations"
	 *   )
	 * )
	 */
	protected function optionsStations()
	{
	    $this->app->options('/gas-stations', function() {

	        $this->app->stationController->optionsList();
	    });
	}

	/**
	 * @SWG\Api(
	 *   path="/gas-stations/{gasStationId}",
	 *   @SWG\Operation(
	 *     method="OPTIONS",
	 *     summary="Get the valid options of a gas station",
	 *     nickname="optionsGasStation",
	 *     @SWG\Parameter(
	 *       name="gasStationId",
	 *       description="ID of gas station",
	 *       paramType="path",
	 *       required=true,
	 *       type="integer"
	 *     ),
	 *     @SWG\ResponseMessage(
	 *       code=404,
	 *       message="Gas station not found"
	 *     )
	 *   )
	 * )
	 */
	protected function optionsStation()
	{
	    $this->app->options('/gas-stations/:id', function($id) {

	        $this->app->stationController->options();
	    });
	}
}
