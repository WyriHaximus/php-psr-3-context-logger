<?php

declare(strict_types=1);

namespace WyriHaximus\PSR3\ContextLogger;

use Psr\Log\LoggerInterface;
use Psr\Log\LoggerTrait;
use Stringable;

final readonly class ContextLogger implements LoggerInterface
{
    use LoggerTrait;

    private string $prefix;

    /**
     * @param array<mixed> $context
     *
     * @phpstan-ignore ergebnis.noConstructorParameterWithDefaultValue
     */
    public function __construct(private LoggerInterface $logger, private array $context, string $prefix = '')
    {
        if ($prefix !== '') {
            $prefix = '[' . $prefix . '] ';
        }

        $this->prefix = $prefix;
    }

    /**
     * @inheritdoc
     * @phpstan-ignore typeCoverage.paramTypeCoverage
     */
    public function log($level, string|Stringable $message, array $context = []): void
    {
        /** @phpstan-ignore psr3.interpolated */
        $this->logger->log($level, $this->prefix . $message, $this->context + $context);
    }
}
