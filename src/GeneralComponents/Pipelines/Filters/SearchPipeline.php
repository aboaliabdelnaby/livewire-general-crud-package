<?php

namespace App\Http\GeneralComponents\Pipelines\Filters;

use App\Http\GeneralComponents\Pipelines\PipelineFactory;

class SearchPipeline extends PipelineFactory
{

    public function __construct(
        private array  $columns,
        private string $search
    )
    {
    }

    protected function apply($builder)
    {
        if (isset($this->search) && !empty($this->columns)) {
            $builder->where(function ($q) {
                foreach ($this->columns as $index => $column) {
                    if ($index == 0) {
                        $q->where($column, 'like', '%' . $this->search . '%');
                    } else {
                        $q->orWhere($column, 'like', '%' . $this->search . '%');
                    }
                }
            });
        }
        return $builder;
    }
}
