<?php

namespace App\Http\GeneralComponents\Traits;

trait WithSorting
{

    public function sortBy($field): void
    {
        $this->sortType = ($this->sortField === $field) ? $this->reverseSort() : 'asc';
        $this->sortField = $field;
    }

    public function reverseSort(): string
    {
        return $this->sortType === 'asc'
            ? 'desc'
            : 'asc';
    }

}
