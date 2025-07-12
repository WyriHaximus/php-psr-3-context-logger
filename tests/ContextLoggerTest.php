<?php

declare(strict_types=1);

namespace WyriHaximus\Tests\PSR3\ContextLogger;

use Exception;
use Mockery;
use PHPUnit\Framework\Attributes\Test;
use Psr\Log\LoggerInterface;
use WyriHaximus\PSR3\ContextLogger\ContextLogger;
use WyriHaximus\TestUtilities\TestCase;

/** @internal */
final class ContextLoggerTest extends TestCase
{
    #[Test]
    public function contextAndPrefix(): void
    {
        $logger = Mockery::mock(LoggerInterface::class);
        $logger->expects('log')->with('error', '[FeatureName] fOo', ['z' => 26, 's' => 1])->atLeast()->once();
        $logger->expects('log')->with('error', '[FeatureName] bar', ['z' => 26, 's' => 2])->atLeast()->once();
        $logger->expects('log')->with('info', '[FeatureName] faa bor', ['z' => 26, 's' => 3])->atLeast()->once();

        $contextLogger = new ContextLogger($logger, ['z' => 26], 'FeatureName');
        $contextLogger->log('error', 'fOo', ['s' => 1]);
        $contextLogger->log('error', 'bar', ['s' => 2]);
        $contextLogger->log('info', 'faa bor', ['s' => 3]);
    }

    #[Test]
    public function contextAndNoPrefix(): void
    {
        $logger = Mockery::mock(LoggerInterface::class);
        $logger->expects('log')->with('error', 'fOo', ['z' => 26, 's' => 1])->atLeast()->once();
        $logger->expects('log')->with('error', 'bar', ['z' => 26, 's' => 2])->atLeast()->once();
        $logger->expects('log')->with('info', 'faa bor', ['z' => 26, 's' => 3])->atLeast()->once();

        $contextLogger = new ContextLogger($logger, ['z' => 26]);
        $contextLogger->log('error', 'fOo', ['s' => 1]);
        $contextLogger->log('error', 'bar', ['s' => 2]);
        $contextLogger->log('info', 'faa bor', ['s' => 3]);
    }

    #[Test]
    public function exception(): void
    {
        $exception = new Exception('Oeps!');
        $logger    = Mockery::mock(LoggerInterface::class);
        $logger->expects('log')->with('error', 'fOo', ['z' => 26, 's' => 1, 'exception' => $exception])->atLeast()->once();
        $logger->expects('log')->with('error', 'bar', ['z' => 26, 's' => 2, 'exception' => $exception])->atLeast()->once();
        $logger->expects('log')->with('info', 'faa bor', ['z' => 26, 's' => 3, 'exception' => $exception])->atLeast()->once();

        $contextLogger = new ContextLogger($logger, ['z' => 26]);
        $contextLogger->log('error', 'fOo', ['s' => 1, 'exception' => $exception]);
        $contextLogger->log('error', 'bar', ['s' => 2, 'exception' => $exception]);
        $contextLogger->log('info', 'faa bor', ['s' => 3, 'exception' => $exception]);
    }
}
