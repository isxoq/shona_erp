<?php

namespace common\traits;
trait UserTrait
{
    public function getRegion()
    {
        return $this->hasOne(\common\models\Regions::class, ['id' => 'province_id']);
    }

    public function getDistrict()
    {
        return $this->hasOne(\common\models\Districts::class, ['id' => 'region_id']);
    }

    public function getHalfAddress()
    {
        return $this->region->name . " " . $this->district->name;
    }

    public function getAllQueueCount()
    {
        return 25;
    }

    public function getAllAcceptedMoney()
    {
        return as_sum(25000000);
    }
}