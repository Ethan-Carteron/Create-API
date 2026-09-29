<?php

namespace App\State\City;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Entity\City;
use App\Service\CityService;

final class CityCollectionProvider implements ProviderInterface
{
    public function __construct(
        private readonly CityService $cityService,
    ) {
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): array
    {
        $query = $context['filters']['q'] ?? null;
        $limit = (int) ($context['filters']['limit'] ?? $this->cityService::DEFAULT_LIMIT);

        $cities = $this->cityService->searchByName($query, $limit);

        return array_map($this->cityService->toList(...), $cities);
    }
}
