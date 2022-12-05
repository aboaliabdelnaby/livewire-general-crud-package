<?php

namespace LivewireComponents\GeneralComponents\CrudComponents;

use Livewire\Component;

class GeneralEdit extends Component
{
    protected string $parent;
    protected string $repository;
    protected string $module;
    protected string $update;
    public int $modelId;

    protected function rules(): array
    {
        return $this->update::rules($this->modelId);
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function update()
    {
        $validatedData = $this->validate();
        try {
            app($this->repository)->update($this->validatedData($validatedData), $this->modelId);
        } catch (\Exception) {
            $this->emit('error', 'something error');
        }
        session()->flash('success', $this->module . ' updated successfully');
        return redirect()->route($this->parent . '.index');
    }

    protected function validatedData($validatedData)
    {
        return $validatedData;
    }

    public function render()
    {
        return view('livewire.' . $this->parent . '.edit');
    }
}
