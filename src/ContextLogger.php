<?php

declare(strict_types=1);

namespace WyriHaximus\PSR3\ContextLogger;

use Psr\Log\AbstractLogger;
use Psr\Log\LoggerInterface;

final class ContextLogger extends AbstractLogger
{
    private readonly string $prefix;

    /**
     * @param array<mixed> $context
     *
     * @phpstan-ignore-next-line
     */
    public function __construct(private readonly LoggerInterface $logger, private readonly array $context, string $prefix = '')
    {
        if ($prefix !== '') {
            $prefix = '[' . $prefix . '] ';
        }

        $this->prefix = $prefix;
    }

    /**
     * @inheritDoc
     * @phpstan-ignore-next-line
     */
    public function log($level, $message, array $context = []): void
    {
        /** @phpstan-ignore psr3.interpolated */
        $this->logger->log($level, $this->prefix . $message, $this->context + $context);
    }
}
