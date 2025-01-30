<?php

namespace App\Interfaces\Services;

interface RationsServiceInterface
{
    function getRations();
    function getRation(int $id);
    function addRation(array $fields);
    function addRations(array $fields);
}
