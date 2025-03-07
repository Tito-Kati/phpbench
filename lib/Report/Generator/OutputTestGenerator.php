<?php

namespace PhpBench\Report\Generator;

use function array_combine;
use PhpBench\Expression\Ast\BooleanNode;
use PhpBench\Expression\Ast\DisplayAsNode;
use PhpBench\Expression\Ast\FloatNode;
use PhpBench\Expression\Ast\IntegerNode;
use PhpBench\Expression\Ast\ListNode;
use PhpBench\Expression\Ast\NullNode;
use PhpBench\Expression\Ast\ParameterNode;
use PhpBench\Expression\Ast\PercentDifferenceNode;
use PhpBench\Expression\Ast\RelativeDeviationNode;
use PhpBench\Expression\Ast\StringNode;
use PhpBench\Expression\Ast\UnitNode;
use PhpBench\Expression\Ast\VariableNode;
use PhpBench\Model\SuiteCollection;
use PhpBench\Registry\Config;
use PhpBench\Report\GeneratorInterface;
use PhpBench\Report\Model\Report;
use PhpBench\Report\Model\Reports;
use PhpBench\Report\Model\Table;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OutputTestGenerator implements GeneratorInterface
{
    /**
     * {@inheritDoc}
     */
    public function configure(OptionsResolver $options): void
    {
    }

    /**
     * {@inheritDoc}
     */
    public function generate(SuiteCollection $collection, Config $config): Reports
    {
        return Reports::fromReport(Report::fromTables([
                Table::fromRowArray([
                        [
                            'string' => new StringNode('one'),
                            'int' => new IntegerNode(123),
                            'float' => new FloatNode(12.2),
                            'bool' => new ListNode([new BooleanNode(true), new BooleanNode(false)]),
                            'null' => new NullNode(),
                            'parameter' => new ParameterNode([new VariableNode('foo'), new VariableNode('bar')]),
                        ]
                ], 'Values'),
                Table::fromRowArray([
                    (function (array $percents): array {
                        return (array)array_combine($percents, array_map(function (float $percent) {
                            return new PercentDifferenceNode($percent);
                        }, $percents));
                    })(range(-100, 100, 10)),
                ], 'Percent Difference'),
                Table::fromRowArray([
                    (function (array $percents): array {
                        return (array)array_combine($percents, array_map(function (float $percent) {
                            return new RelativeDeviationNode(new FloatNode($percent));
                        }, $percents));
                    })(range(0, 100, 10)),
                ], 'Relative Deviation'),
                Table::fromRowArray([
                    [
                        'time' => new DisplayAsNode(new IntegerNode(10000), new UnitNode(new StringNode('ms')), new IntegerNode(1))
                    ]
                ], 'Time'),
            ],
            'Output Test Report',
            'This report demonstrates output'
        ));
    }
}
