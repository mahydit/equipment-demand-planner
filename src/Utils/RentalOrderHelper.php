<?php

namespace App\Utils;

use App\Repository\PortableEqipmentTypeRepository;
use App\Repository\StationRepository;

class RentalOrderHelper
{
    /**
     * @var array
     */
    public $stations;

    /**
     * @var array
     */
    public $types;

    public function __construct(
        StationRepository $stationRepository,
        PortableEqipmentTypeRepository $typeRepository
    ){
        $this->stations = array_column($stationRepository->findAllStationNames(), 'name');
        $this->types = array_column($typeRepository->findAllTypes(), 'type');
    }

    public static function mapEquipmentsCountByStation($items)
    {
        if(!$items) return [];

        $mapped = [];
        foreach ($items as $item)
        {
            $station = $item['station'];
            unset($item['station']);
            $mapped[$station][] = $item;
        }

        return $mapped;
    }

    public function calculateAvailableEquipments($availableNow, $leaving, $returned)
    {
        $availableNow = $this->mapCountByStationAndType($availableNow);
        $leaving = $this->mapCountByStationAndType($leaving);
        $returned = $this->mapCountByStationAndType($returned);

        $count = [];
        foreach ($this->stations as $station) {
            foreach ($this->types as $type) {
                $count[$station.'-'.$type] = 0;
                if(isset($availableNow[$station.'-'.$type])) $count[$station.'-'.$type] +=  $availableNow[$station.'-'.$type];
                if(isset($leaving[$station.'-'.$type])) $count[$station.'-'.$type] -=  $leaving[$station.'-'.$type];
                if(isset($returned[$station.'-'.$type])) $count[$station.'-'.$type] +=  $returned[$station.'-'.$type];
                if($count[$station.'-'.$type] == 0 ) unset($count[$station.'-'.$type]);
            }
        }
        return $count;
    }

    private function mapCountByStationAndType($items)
    {
        if(!$items) return [];

        $mapped = [];
        foreach ($items as $item)
        {
            $station = $item['station'];
            $type = $item['type'];
            $mapped[$station.'-'.$type] = $item['count'];
        }

        return $mapped;
    }
}