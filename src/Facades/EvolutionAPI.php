<?php

declare(strict_types=1);

namespace Kalezao\EvolutionApi\Facades;

use Illuminate\Support\Facades\Facade;
use Kalezao\EvolutionApi\Contracts\EvolutionApiInterface;

/**
 * @method static array sendText(string $instance, string $number, string $text, array $options = [])
 * @method static array sendMedia(string $instance, string $number, string $mediaType, string $media, array $options = [])
 * @method static array sendStatus(string $instance, array $statusData)
 * @method static array createInstance(array $instanceData)
 * @method static array getInstance(string $instance)
 * @method static array getQrCode(string $instance)
 * @method static array disconnectInstance(string $instance)
 * @method static array deleteInstance(string $instance)
 * @method static array getInstances()
 * @method static array getGroups(string $instance, bool $withParticipants = false)
 */
final class EvolutionAPI extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return EvolutionApiInterface::class;
    }
}
