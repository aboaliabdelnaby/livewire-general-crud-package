<?php

namespace LivewireComponents\GeneralComponents\CrudComponents;

use App\Http\Traits\WithSorting;
use Livewire\Component;
use Livewire\WithPagination;

class GeneralIndex extends Component
{
    use WithPagination, WithSorting;

    protected string $paginationTheme = 'bootstrap'; //Using The Bootstrap Pagination Theme
    public string $search = '';
    public string $sortField = 'created_at';
    protected $listeners = ['delete'];
    protected int $paginate = 10;
    protected string $parent;
    protected string $module;
    protected string $repository;
    protected array $columns;

    public function updatingSearch()      // Resetting Pagination After Filtering Data
    {
        $this->resetPage();
    }

    public function render()
    {
        $data = null;
        try {
            $data = app($this->repository)->index($this->paginate, ['search' => $this->search, 'columns' => $this->columns],
                ['by' => $this->sortField, 'type' => $this->sortType]);
        } catch (\Exception) {
            $this->emit('error', 'something error');
        }
        return view('livewire.' . $this->parent . '.index', ['data' => $data]);

    }

    public function delete($id)
    {
        try {
            app($this->repository)->destroy($id);
            $this->emit('success', $this->module . ' deleted successfully');
        } catch (\Exception) {
            $this->emit('error', 'something error');
        }
    }

}
