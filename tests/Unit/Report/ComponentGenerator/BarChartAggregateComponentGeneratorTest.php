<?php

namespace PhpBench\Tests\Unit\Report\ComponentGenerator;

use PhpBench\Data\DataFrame;
use PhpBench\Expression\ExpressionEvaluator;
use PhpBench\Report\ComponentGenerator\BarChartAggregateComponentGenerator;
use PhpBench\Report\ComponentGeneratorInterface;
use PhpBench\Report\Model\BarChart;

class BarChartAggregateComponentGeneratorTest extends ComponentGeneratorTestCase
{
    public function createGenerator(): ComponentGeneratorInterface
    {
        return new BarChartAggregateComponentGenerator($this->container()->get(ExpressionEvaluator::class));
    }

    public function testMinimalConfiguration(): void
    {
        $barChart = $this->generate(DataFrame::empty(), [
            BarChartAggregateComponentGenerator::PARAM_Y_EXPR => '"hello"',
            BarChartAggregateComponentGenerator::PARAM_Y_ERROR_MARGIN => '12',
        ]);
        assert($barChart instanceof BarChart);
        self::assertInstanceOf(BarChart::class, $barChart);
        self::assertCount(0, $barChart->dataSets);
    }

    public function testGeneratesSeries(): void
    {
        $frame = DataFrame::fromRowSeries([
            ['hello',   12, 33],
            ['goodbye', 23, 44],
        ], ['name', 'value', 'error']);

        $barChart = $this->generate($frame, [
            BarChartAggregateComponentGenerator::PARAM_X_PARTITION => ['name'],
            BarChartAggregateComponentGenerator::PARAM_Y_EXPR => 'first(partition["value"])',
            BarChartAggregateComponentGenerator::PARAM_Y_ERROR_MARGIN => 'first(partition["error"])',
        ]);
        assert($barChart instanceof BarChart);
        self::assertInstanceOf(BarChart::class, $barChart);
        self::assertCount(1, $barChart->dataSets);
        self::assertEquals([12, 23], $barChart->dataSets[0]->ySeries);
        self::assertEquals([33, 44], $barChart->dataSets[0]->errorMargins);
    }

    public function testGeneratesMultipleDataSetes(): void
    {
        $frame = DataFrame::fromRowSeries([
            [1, 'hello',   12, 33],
            [1, 'goodbye', 23, 44],
            [2, 'hello',   22, 33],
            [2, 'goodbye', 43, 54],
        ], ['group', 'name', 'value', 'error']);

        $barChart = $this->generate($frame, [
            BarChartAggregateComponentGenerator::PARAM_X_PARTITION => ['name'],
            BarChartAggregateComponentGenerator::PARAM_SET_PARTITION => ['group'],
            BarChartAggregateComponentGenerator::PARAM_Y_EXPR => 'first(partition["value"])',
            BarChartAggregateComponentGenerator::PARAM_Y_ERROR_MARGIN => 'first(partition["error"])',
        ]);
        assert($barChart instanceof BarChart);
        self::assertInstanceOf(BarChart::class, $barChart);
        self::assertCount(2, $barChart->dataSets);
        self::assertEquals([12, 23], $barChart->dataSets[0]->ySeries);
        self::assertEquals([33, 44], $barChart->dataSets[0]->errorMargins);
        self::assertEquals([22, 43], $barChart->dataSets[1]->ySeries);
        self::assertEquals([33, 54], $barChart->dataSets[1]->errorMargins);
    }
}
