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
     * @var string
     */
    private $prefix;

    /**
     * @var array
     */
    private $context;

    /**
     * @param LoggerInterface $logger
     * @param string          $prefix
     * @param array           $context
     */
    public function __construct(LoggerInterface $logger, string $prefix, array $context)
    {
        $this->logger = $logger;
        $this->prefix = $prefix;
        $this->context = $context;
    }

    public function log($level, $message, array $context = [])
    {
        $this->logger->log($level, '[' . $this->prefix . '] ' . $message, $this->context + $context);
    }
}
