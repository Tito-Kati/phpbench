<?php

namespace PhpBench\Report\Model;

use PhpBench\Report\ComponentInterface;

final class Report implements ComponentInterface
{
    /**
     * @var string|null
     */
    private $title;

    /**
     * @var string|null
     */
    private $description;

    /**
     * @var object[]
     */
    private $objects;

    /**
     * @param ComponentInterface[] $objects
     */
    public function __construct(array $objects, ?string $title, ?string $description)
    {
        $this->objects = $objects;
        $this->title = $title;
        $this->description = $description;
    }

    /**
     * @deprecated use objects() to be removed in 2.0. Use ReportBuilder
     *
     * @param Object[] $objects
     */
    public static function fromTables(array $objects, ?string $title = null, ?string $description = null): self
    {
        return new self($objects, $title, $description);
    }

    /**
     * @deprecated use objects() to be removed in 2.0. Use ReportBuilder
     */
    public static function fromTable(object $object, ?string $title = null, ?string $description = null): self
    {
        return new self([$object], $title, $description);
    }

    public function title(): ?string
    {
        return $this->title;
    }

    public function description(): ?string
    {
        return $this->description;
    }

    /**
     * @return object[]
     */
    public function objects(): array
    {
        return $this->objects;
    }

    /**
     * @deprecated use objects() to be removed in 2.0
     *
     * @return Table[]
     */
    public function tables(): array
    {
        return array_filter($this->objects, function (object $object) {
            return $object instanceof Table;
        });
    }
}
