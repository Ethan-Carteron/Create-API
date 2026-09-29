<?php

namespace App\Service;

use App\Dto\City\CityListOutput;
use App\Entity\City;
use App\Repository\CityRepository;

class CityService
{
    private const int MAX_RESULT = 100;
    public const int DEFAULT_LIMIT = 20;

    public function __construct
    (
        private readonly CityRepository $cityRepository,
    )
    {
    }

    public function searchByName(?string $query = null, ?int $limit = null): array
    {
        if (trim($query) === '') {
            $query = null;
        }

        $limit = min(self::MAX_RESULT, max(1, $limit ?? self::DEFAULT_LIMIT));

        return $this->cityRepository->searchByName($query, $limit);
    }

    public function toList(?City $city = null): CityListOutput
    {
        return new CityListOutput(
            id: $city->getId(),
            name: $city->getName(),
        );
    }
}
