<?php

namespace CrudComponents\Pipelines\Filters;



use CrudComponents\Pipelines\PipelineFactory;

class SortPipeline extends PipelineFactory
{
    public function __construct(
        private string $sortBy,
        private string $sorType
    )
    {
    }

    protected function apply($builder)
    {
        if (isset($this->sortBy) && isset($this->sorType)) {
            $builder->orderBy($this->sortBy, $this->sorType);
        }
        return $builder;
    }
}
