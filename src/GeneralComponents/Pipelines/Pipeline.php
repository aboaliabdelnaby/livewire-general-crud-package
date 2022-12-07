<?php

namespace App\Http\GeneralComponents\Pipelines;

use \Illuminate\Pipeline\Pipeline as Pipe;

class Pipeline
{
    private $model;
    private array $pipelines = [];

    public function setModel($model)
    {
        $this->model = app($model);

        $this->resetPipelines();

        return $this;
    }

    public function pushPipeline($pipelines)
    {
        if (is_array($pipelines)) {
            foreach ($pipelines as $pipeline) {
                if ($pipeline instanceof PipelineFactory) {
                    array_push($this->pipelines, $pipeline);
                }
            }
        } else {
            if ($pipelines instanceof PipelineFactory) {
                array_push($this->pipelines, $pipelines);
            }
        }
        return $this;
    }

    public function resetPipelines()
    {
        $this->pipelines = [];
    }

    public function then()
    {
        return app(Pipe::class)
            ->send($this->model->query())
            ->through($this->pipelines)
            ->thenReturn();
    }

    public function __call(string $name, array $arguments)
    {
        $result = $this->then()
            ->$name(...$arguments);

        $this->resetPipelines();
        return $result;
    }

}
