<?php

declare(strict_types=1);

namespace WyriHaximus\Tests\PSR3\ContextLogger;

use Exception;
use Psr\Log\LoggerInterface;
use WyriHaximus\PSR3\ContextLogger\ContextLogger;
use WyriHaximus\TestUtilities\TestCase;

/**
 * @internal
 */
final class ContextLoggerTest extends TestCase
{
    /**
     * @test
     */
    public function contextAndPrefix(): void
    {
        $logger = $this->prophesize(LoggerInterface::class);
        $logger->log('error', '[FeatureName] fOo', ['z' => 26, 's' => 1])->shouldBeCalled();
        $logger->log('error', '[FeatureName] bar', ['z' => 26, 's' => 2])->shouldBeCalled();
        $logger->log('info', '[FeatureName] faa bor', ['z' => 26, 's' => 3])->shouldBeCalled();

        $contextLogger = new ContextLogger($logger->reveal(), ['z' => 26], 'FeatureName');
        $contextLogger->log('error', 'fOo', ['s' => 1]);
        $contextLogger->log('error', 'bar', ['s' => 2]);
        $contextLogger->log('info', 'faa bor', ['s' => 3]);
    }

    /**
     * @test
     */
    public function contextAndNoPrefix(): void
    {
        $logger = $this->prophesize(LoggerInterface::class);
        $logger->log('error', 'fOo', ['z' => 26, 's' => 1])->shouldBeCalled();
        $logger->log('error', 'bar', ['z' => 26, 's' => 2])->shouldBeCalled();
        $logger->log('info', 'faa bor', ['z' => 26, 's' => 3])->shouldBeCalled();

        $contextLogger = new ContextLogger($logger->reveal(), ['z' => 26]);
        $contextLogger->log('error', 'fOo', ['s' => 1]);
        $contextLogger->log('error', 'bar', ['s' => 2]);
        $contextLogger->log('info', 'faa bor', ['s' => 3]);
    }

    /**
     * @test
     */
    public function exception(): void
    {
        $exception = new Exception('Oeps!');
        $logger    = $this->prophesize(LoggerInterface::class);
        $logger->log('error', 'fOo', ['z' => 26, 's' => 1, 'exception' => $exception])->shouldBeCalled();
        $logger->log('error', 'bar', ['z' => 26, 's' => 2, 'exception' => $exception])->shouldBeCalled();
        $logger->log('info', 'faa bor', ['z' => 26, 's' => 3, 'exception' => $exception])->shouldBeCalled();

        $contextLogger = new ContextLogger($logger->reveal(), ['z' => 26]);
        $contextLogger->log('error', 'fOo', ['s' => 1, 'exception' => $exception]);
        $contextLogger->log('error', 'bar', ['s' => 2, 'exception' => $exception]);
        $contextLogger->log('info', 'faa bor', ['s' => 3, 'exception' => $exception]);
    }
}
