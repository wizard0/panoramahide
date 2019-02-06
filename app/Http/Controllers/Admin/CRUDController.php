<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CRUDController extends Controller
{
    /**
     * @var array of model attributes which should be displayed at index CRUD action
     */
    protected $displayAttributes;

    protected $modelName;

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

        return view('admin.content.index', compact('data'));
    }

    private function getModelCollection()
    {
        if (isset($this->modelName)) {
            $modelName = $this->modelName;

            if (in_array('Dimsav\Translatable\Translatable', class_uses($modelName))) {
                $this->collection = $modelName::withTranslation()->get();
            } else {
                $this->collection = $modelName::all();
            }

            return $this;
        }

        return false;
    }

    private function defineModelName()
    {
        if (!isset($this->modelName)) {
            $className = get_class($this);
            if (preg_match('/\\\\([a-zA-Z]*)Controller$/', $className, $matches)) {
                $this->modelName = '\\App\\' . $matches[1];
            }
        }

        return $this;
    }

    protected function getTableData($sort = null)
    {
        if ($this->prepareTableData()) {
            return [
                'head' => $this->displayAttributes,
                'body' => $this->tableBody
            ];
        } else {
            return false;
        }
    }

    private function prepareTableData()
    {
        try {
            $this->defineModelName()
                ->getModelCollection()
                ->prepareTableBodyData();
        } catch (\Exception $e) {
            return false;
        }

        return $this;
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
            $this->tableBody[] = $row;
        }
        return $this;
    }
}
