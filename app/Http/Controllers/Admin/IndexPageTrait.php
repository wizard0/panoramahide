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
        $data = $this->getTableData($request->get('sort'));
        $slug = $this->getSlug();

        return view('admin.content.index', compact('data', 'slug'));
    }

    protected function getTableData($sort = null)
    {
        $result = false;

        if ($this->prepareTableData()) {
            $result = [
                'head' => $this->displayAttributes,
                'body' => $this->tableBody
            ];
        }

        return $result;
    }

    private function prepareTableData()
    {
        try {
            $this->getModelCollection()
                ->prepareTableBodyData();
        } catch (\Exception $e) {

            return false;
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

        return false;
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
//                    'id' => $model->id,
                    'html' => $html,
                    'value' => $value
                ];

            }
            $this->tableBody[$model->id] = $row;
        }
        return $this;
    }
}
