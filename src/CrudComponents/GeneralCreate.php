<?php

namespace App\Http\CrudComponents;

use Livewire\Component;

class GeneralCreate extends Component
{
    protected string $repository;
    protected string $module;
    protected string $store;
    protected string $parent;

    protected function rules(): array
    {
        return $this->store::rules();
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function create()
    {
        $validatedData = $this->validate();
        try {
            app($this->repository)->create($this->validatedData($validatedData));
        } catch (\Exception) {
            $this->emit('error', 'something error');
        }
        session()->flash('success', $this->module . ' created successfully');
        return redirect()->route($this->parent . '.index');

    }

    protected function validatedData($validatedData)
    {
        return $validatedData;
    }

    public function render()
    {
        return view('livewire.' . $this->parent . '.create');
    }
}
