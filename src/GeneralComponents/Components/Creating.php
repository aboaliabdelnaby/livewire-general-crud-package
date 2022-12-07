<?php

namespace App\Http\GeneralComponents\Components;

use App\Http\GeneralComponents\Pipelines\Pipeline;
use App\Http\GeneralComponents\Validation\Validation;
use Livewire\Component;

abstract class Creating extends Component
{
    protected string $model;
    protected string $message;
    protected Validation $storeValidation;
    protected string $viewPath;
    protected string $routePath;

    protected $query;

    public function __construct($id = null)
    {
        parent::__construct($id);
        $this->query = app(Pipeline::class)->setModel($this->model);
    }

    protected function rules(): array
    {
        return $this->storeValidation::rules();
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function create()
    {
        $validatedData = $this->validate();
        try {
            $this->createRow($validatedData);
        } catch (\Exception) {
            $this->emit('error', 'something error');
        }
        session()->flash('success', $this->message);
        return redirect()->route($this->routePath);

    }

    public function render()
    {
        return view('livewire.' . $this->viewPath);
    }

    protected function createRow($data)
    {
        return $this->query->create($data);
    }
}
