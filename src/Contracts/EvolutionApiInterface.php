<?php

declare(strict_types=1);

namespace Kalezao\EvolutionApi\Contracts;

interface EvolutionApiInterface
{
    /**
     * Send a text message
     */
    public function sendText(string $instance, string $number, string $text, array $options = []): array;

    /**
     * Send a media message
     */
    public function sendMedia(string $instance, string $number, string $mediaType, string $media, array $options = []): array;

    /**
     * Send a status message
     */
    public function sendStatus(string $instance, array $statusData): array;

    /**
     * Create a new instance
     */
    public function createInstance(array $instanceData): array;

    /**
     * Get instance information
     */
    public function getInstance(string $instance): array;

    /**
     * Get instance QR code
     */
    public function getQrCode(string $instance): array;

    /**
     * Disconnect instance
     */
    public function disconnectInstance(string $instance): array;

    /**
     * Delete instance
     */
    public function deleteInstance(string $instance): array;

    /**
     * Get all instances
     */
    public function getInstances(): array;
}
