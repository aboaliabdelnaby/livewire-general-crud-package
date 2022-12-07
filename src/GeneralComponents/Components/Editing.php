<?php

namespace App\Http\GeneralComponents\Components;

use App\Http\GeneralComponents\Pipelines\Pipeline;
use App\Http\GeneralComponents\Validation\Validation;
use Livewire\Component;

abstract class Editing extends Component
{
    protected string $model;
    protected string $viewPath;
    protected string $routePath;
    protected string $repository;
    protected string $message;
    protected Validation $updateValidation;
    protected $query;
    public int $editId;


    public function __construct($id = null)
    {
        parent::__construct($id);
        $this->query = app(Pipeline::class)->setModel($this->model);
    }

    protected function rules(): array
    {
        return $this->updateValidation::rules();
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function update()
    {
        $validatedData = $this->validate();
        try {
            $this->updateRow($validatedData, $this->editId);
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

    protected function updateRow($data, $id)
    {
        return $this->query->where('id', $id)->update($data);
    }
}
