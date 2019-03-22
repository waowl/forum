<?php

namespace App\Filters;


use Illuminate\Http\Request;

abstract class Filters
{

    /**
     * @var Request
     */
    protected $request;
    protected $builder;
    protected $filters = [];

    public function __construct(Request $request)
    {

        $this->request = $request;
    }

    public function apply($builder)
    {
        $this->builder = $builder;

        foreach ($this->getFilters() as $filter => $value) {
            if ($this->hasFilter($filter)) {
                $this->$filter($value);
            }

            return $this->builder;

        }

    }

    protected function getFilters()
    {
        return $this->request->only($this->filters);
    }
    /**
     * @param $filter
     * @return bool
     */
    private function hasFilter($filter): bool
    {
        return method_exists($this, $filter) && $this->request->has($filter);
    }
}
