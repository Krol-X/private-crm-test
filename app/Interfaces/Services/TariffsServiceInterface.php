<?php

namespace App\Interfaces\Services;

interface TariffsServiceInterface
{
    function getTariffs();
    function getTariff(int $id);
    function addTariff(array $fields);
    function updateTariff(int $id, array $fields);
    function removeTariff(int $id);
}
