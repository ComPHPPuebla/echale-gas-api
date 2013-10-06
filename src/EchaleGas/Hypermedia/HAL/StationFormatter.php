<?php
namespace EchaleGas\Hypermedia\HAL;

use \EchaleGas\Hypermedia\Formatter;

class StationFormatter extends Formatter
{
    /**
     * @param array $station
     * @return array
     */
    public function format(array $station)
    {
        $halResource = ['links' => []];

        $halResource['links']['self'] = $this->urlHelper->site(
            $this->urlHelper->urlFor('station', ['id' => $station['station_id']])
        );

        $halResource['data'] = $station;

        return $halResource;
    }
}