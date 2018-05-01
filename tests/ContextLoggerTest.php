<?php declare(strict_types=1);

namespace WyriHaximus\Tests\PSR3\ContextLogger;

use Prophecy\Argument;
use Psr\Log\LoggerInterface;
use Psr\Log\Test\LoggerInterfaceTest;
use WyriHaximus\PSR3\ContextLogger\ContextLogger;
use function WyriHaximus\PSR3\checkCorrectLogLevel;
use function WyriHaximus\PSR3\processPlaceHolders;

final class ContextLoggerTest extends LoggerInterfaceTest
{
    /**
     * @var array
     */
    public $logs = [];

    public function getLogger()
    {
        $that = $this;
        $logger = $this->prophesize(LoggerInterface::class);
        $logger->log(
            Argument::any(),
            Argument::any(),
            Argument::any()
        )->will(function ($args) use ($that) {
            list($level, $message, $context) = $args;
            $message = (string)$message;
            checkCorrectLogLevel($level);
            $message = processPlaceHolders($message, $context);
            $that->logs[] = $level . ' ' . substr($message, 14);

            return true;
        });

        return new ContextLogger($logger->reveal(), [], 'FeatureName');
    }

    public function getLogs()
    {
        return $this->logs;
    }

    public function testTestContextAndPrefix()
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

    public function testTestContextAndNoPrefix()
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
}
