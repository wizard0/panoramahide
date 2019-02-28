<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

trait IndexPageTrait
{
    /**
     * @var array of model attributes which should be displayed at index CRUD action
     */
    protected $displayAttributes;

    private $tableBody = [];
    private $collection;

    /**
     * Display a listing of the resource.
     * TODO. sorting
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request && $request->has('sort_by')) {
            $data = $this->getTableData($request->get('sort_by'));
        } else {
            $data = $this->getTableData();
        }
        $slug = $this->getSlug();

        return view('admin.content.index', compact('data', 'slug'));
    }

    protected function getTableData($sort = null)
    {
        $this->prepareTableData();

        return [
            'head' => $this->displayAttributes,
            'body' => $this->tableBody
        ];
    }

    private function prepareTableData()
    {
        if ($this->getModelCollection()) {
            $this->prepareTableBodyData();
        }

        return $this;
    }

    private function getModelCollection()
    {
        if (isset($this->modelName)) {
            $modelName = $this->modelName;

            if ($this->isTranslatable()) {
                $this->collection = $modelName::withTranslation()->get();
            } else {
                $this->collection = $modelName::all();
            }

            return $this;
        }
    }

    private function prepareTableBodyData()
    {
        foreach ($this->collection as $model) { // row
            $row = [];
            foreach ($this->displayAttributes as $attribute) { // item
                $value = $model->$attribute;
                if (is_numeric($value)) {
                    $html = (object)[
                        'class' => 'text-right'
                    ];
                } else {
                    $html = false;
                }
                $row[] = (object)[
                    'html' => $html,
                    'value' => $value
                ];

            }
            $this->tableBody[$model->id] = $row;
        }
        return $this;
    }
}
