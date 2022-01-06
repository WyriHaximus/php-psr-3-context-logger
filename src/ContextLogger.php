<?php

declare(strict_types=1);

namespace WyriHaximus\PSR3\ContextLogger;

use Psr\Log\AbstractLogger;
use Psr\Log\LoggerInterface;

final class ContextLogger extends AbstractLogger
{
    private LoggerInterface $logger;

    /** @var array<mixed> */
    private array $context;

    private string $prefix = '';

    /**
     * @param array<mixed> $context
     *
     * @phpstan-ignore-next-line
     */
    public function __construct(LoggerInterface $logger, array $context, ?string $prefix = null)
    {
        $this->logger  = $logger;
        $this->context = $context;

        if ($prefix === null) {
            return;
        }

        $this->prefix = '[' . $prefix . '] ';
    }

    /**
     * @inheritDoc
     * @phpstan-ignore-next-line
     */
    public function log($level, $message, array $context = []): void
    {
        $this->logger->log($level, $this->prefix . $message, $this->context + $context);
    }
}
