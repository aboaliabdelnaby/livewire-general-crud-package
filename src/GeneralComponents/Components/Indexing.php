<?php

namespace App\Http\GeneralComponents\Components;

use App\Http\GeneralComponents\Pipelines\Filters\SearchPipeline;
use App\Http\GeneralComponents\Pipelines\Filters\SortPipeline;
use App\Http\GeneralComponents\Pipelines\Pipeline;
use App\Http\GeneralComponents\Traits\WithSorting;
use Livewire\Component;
use Livewire\WithPagination;

abstract class Indexing extends Component
{
    use WithPagination, WithSorting;

    protected string $paginationTheme = 'bootstrap'; //Using The Bootstrap Pagination Theme
    public string $search = '';
    public string $sortField = 'created_at';
    public string $sortType = 'asc'; // default sort direction
    protected $listeners = ['delete'];
    protected int $paginate = 10;
    protected array $filters;
    protected string $model;
    protected string $viewPath;
    protected string $message;
    protected array $searchColumns;
    protected $query;


    public function __construct($id = null)
    {
        parent::__construct($id);
        $this->query = app(Pipeline::class)->setModel($this->model);
    }

    public function updatingSearch()      // Resetting Pagination After Filtering Data
    {
        $this->resetPage();
    }

    public function render()
    {
        $data = null;
        try {
            $data = $this->getData();
        } catch (\Exception) {
            $this->emit('error', 'something error');
        }
        return view('livewire.' . $this->viewPath, ['data' => $data]);

    }

    public function delete($id)
    {
        try {
            $this->deleteRow($id);
            $this->emit('success', $this->message);
        } catch (\Exception) {
            $this->emit('error', 'something error');
        }
    }

    protected function filters(): array
    {
        return [
            new SearchPipeline($this->searchColumns, $this->search),
            new SortPipeline($this->sortField, $this->sortType)
        ];
    }

    protected function getData()
    {
        return $this->query->pushPipeline($this->filters())->paginate($this->paginate);
    }

    protected function deleteRow($id)
    {
        return $this->query->where('id', $id)->delete();
    }

}
