<?php

namespace App\Services;

use App\Interfaces\Services\TariffsServiceInterface;

use App\Models\Tariff;
use Illuminate\Database\Eloquent\Collection;

class TariffsService implements TariffsServiceInterface
{
    /**
     * @return Collection<Tariff>
     */
    public function getTariffs(): Collection
    {
        $tariffs = Tariff::all();

        return $tariffs;
    }

    public function getTariff(int $id): ?Tariff
    {
        $tariff = Tariff::find($id);

        return $tariff;
    }

    public function addTariff(array $fields): Tariff
    {
        $tariff = new Tariff($fields);
        $tariff->save();

        return $tariff;
    }

    public function updateTariff(int $id, array $fields): ?Tariff
    {
        $tariff = $this->getTariff($id);
        if (!$tariff) {
            return null;
        }

        $tariff->fill($fields);
        $tariff->save();

        return $tariff;
    }

    public function removeTariff(int $id): ?Tariff
    {
        $tariff = $this->getTariff($id);
        if (!$tariff) {
            return null;
        }

        $tariff->delete();

        return $tariff;
    }
}
