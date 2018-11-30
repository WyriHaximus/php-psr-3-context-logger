<?php declare(strict_types=1);

namespace WyriHaximus\PSR3\ContextLogger;

use Psr\Log\AbstractLogger;
use Psr\Log\LoggerInterface;

final class ContextLogger extends AbstractLogger
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var array
     */
    private $context;

    /**
     * @var string
     */
    private $prefix;

    /**
     * @param LoggerInterface $logger
     * @param array           $context
     * @param string          $prefix
     */
    public function __construct(LoggerInterface $logger, array $context, string $prefix = null)
    {
        $this->logger = $logger;
        $this->context = $context;

        if ($prefix !== null) {
            $prefix = '[' . $prefix . '] ';
        }
        $this->prefix = $prefix;
    }

    public function log($level, $message, array $context = []): void
    {
        $this->logger->log($level, $this->prefix . $message, $this->context + $context);
    }
}
