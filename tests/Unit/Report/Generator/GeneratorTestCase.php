<?php

/*
 * This file is part of the PHPBench package
 *
 * (c) Daniel Leech <daniel@dantleech.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 */

namespace PhpBench\Tests\Unit\Report\Generator;

use Generator;
use PhpBench\DependencyInjection\Container;
use PhpBench\Extension\ConsoleExtension;
use PhpBench\Model\SuiteCollection;
use PhpBench\Registry\Config;
use PhpBench\Report\GeneratorInterface;
use PhpBench\Report\Renderer\ConsoleRenderer;
use PhpBench\Tests\IntegrationTestCase;
use PhpBench\Tests\Util\Approval;
use PhpBench\Tests\Util\TestUtil;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Throwable;

abstract class GeneratorTestCase extends IntegrationTestCase
{
    /**
     * @dataProvider provideGenerate
     */
    public function testGenerate(string $path): void
    {
        $approval = Approval::create($path,3);

        $container = $this->container();
        $generator = $this->createGenerator($container);
        $options = new OptionsResolver();
        $generator->configure($options);

        try {
            $document = $generator->generate(
                new SuiteCollection([TestUtil::createSuite(array_merge([
                    'output_time_precision' => 3,
                ], $approval->getConfig(0)))]),
                new Config('asd', $options->resolve($approval->getConfig(1)))
            );
            $this->container([
                ConsoleExtension::PARAM_OUTPUT_STREAM => $this->workspace()->path('out')
            ])->get(ConsoleRenderer::class)->render($document, new Config('test', []));
            $actual = $this->workspace()->getContents('out');
        } catch (Throwable $e) {
            $actual = $e->getMessage();
        }

        $approval->approve($actual);
    }

    /**
     * @return Generator<mixed>
     */
    public function provideGenerate(): Generator
    {
        foreach (glob(sprintf('%s/%s/*', __DIR__, $this->acceptanceSubPath())) as $path) {
            yield [
                $path
            ];
        }
    }

    abstract protected function acceptanceSubPath(): string;

    abstract protected function createGenerator(Container $container): GeneratorInterface;
}
