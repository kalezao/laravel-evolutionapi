<?php

declare(strict_types=1);

namespace Kalezao\EvolutionApi\Facades;

use Illuminate\Support\Facades\Facade;
use Kalezao\EvolutionApi\Contracts\EvolutionApiInterface;

final class EvolutionAPI extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return EvolutionApiInterface::class;
    }
}
