<?php

namespace PhpBench\Tests\Unit\Report\Generator;

use PhpBench\DependencyInjection\Container;
use PhpBench\Expression\ExpressionEvaluator;
use PhpBench\Expression\Printer\EvaluatingPrinter;
use PhpBench\Report\Generator\ExpressionGenerator;
use PhpBench\Report\GeneratorInterface;
use PhpBench\Report\Transform\SuiteCollectionTransformer;
use Symfony\Component\Console\Logger\ConsoleLogger;
use Symfony\Component\Console\Output\ConsoleOutput;

class ExpressionGeneratorTest extends GeneratorTestCase
{
    protected function acceptanceSubPath(): string
    {
        return 'expression';
    }

    protected function createGenerator(Container $container): GeneratorInterface
    {
        return new ExpressionGenerator(
            $container->get(ExpressionEvaluator::class),
            $container->get(EvaluatingPrinter::class),
            new SuiteCollectionTransformer(),
            new ConsoleLogger(new ConsoleOutput())
        );
    }
}
