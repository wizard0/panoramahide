<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

trait EditCreatePageTrait
{
    protected $attributeTypes = [];
    protected $select = [];
    private $formData;

    public function edit(Request $request, $id)
    {
        $this->getModel($id)
             ->prepareEditData();

        return view('admin.content.edit', [
            'data' => $this->formData,
            'slug' => $this->getSlug(),
            'id' => $id,
            'translatable' => $this->isTranslatable(),
            self::LOCALE_VAR => $this->locale
        ]);
    }

    public function create()
    {
        $this->createModel();
        if (!$this->model) {
            return response()->json(['error' => 'Cant get model'], 403);
        }

        $this->prepareEditData();

        return view('admin.content.edit', [
            'data' => $this->formData,
            'slug' => $this->getSlug(),
            'id' => $this->model->id,
            'translatable' => $this->isTranslatable(),
            self::LOCALE_VAR => $this->locale
        ]);
    }

    public function update(Request $request, $id)
    {
        $this->getModel($id);
        $validator = $this->validateRequest($request);
        if (isset($validator) && $validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $this->updateModel($request);
        return redirect()->route($this->slug . '.show', ['id' => $id]);
    }

    private function prepareEditData()
    {
        if (!isset($this->formData) && isset($this->model)) {
            $model = $this->model;
            foreach ($this->attributeTypes as $attribute => $type) {
                switch ($type) {
                    case self::TYPE_IMAGE:
                    case self::TYPE_TEXT:
                    case self::TYPE_HTML:
                    case self::TYPE_STRING:
                    case self::TYPE_DATE:
                    case self::TYPE_BOOL:
                    case self::TYPE_PRICE:
                        if ($this->isTranslatable()
                            && in_array($attribute, $model->translatedAttributes) // this attribute is translatable
                            && $model->translate($this->locale) // this model has translation to locale
                        ) {
                            $value = $model->translate($this->locale, true)->$attribute;
                        } else {
                            $value = $model->$attribute;
                        }
                        break;
                    case self::TYPE_SELECT:
                        $value = $this->getSelectionData($attribute);
                        break;
                    case self::TYPE_REL_BELONGS_TO_MANY:
                    case self::TYPE_REL_BELONGS_TO:
                        $value = $this->getRelationData($attribute);
                        break;
                    default:
                        return false;
                }
                $this->formData[] = (object)[
                    'name' => $attribute,
                    'type' => $type,
                    'value' => $value
                ];
            }
        }

        return $this;
    }

    private function updateModel(Request $request)
    {
        if (isset($this->model)) {
            foreach ($this->attributeTypes as $attribute => $type) {
                if ($request->has($attribute)) {
                    $value = $request->get($attribute);
                    if ($type == self::TYPE_REL_BELONGS_TO_MANY) {
                        $this->model->save();
                        $this->model->$attribute()->sync($value);
                        continue;
                    }
                    if ($type == self::TYPE_IMAGE) {
                        $filePath = $this->slug . '/' . $this->model->id;
                        $value = '/storage/' . Storage::disk('public')
                                ->putFile($filePath, $request->file($attribute));
                    }
                    if ($this->isTranslatable() && in_array($attribute, $this->model->translatedAttributes)) {
                        $this->model
                            ->translateOrNew($this->locale)
                            ->$attribute = $value;
                    } else {
                        $this->model
                            ->$attribute = $value;
                    }
                }
            }
            $this->model->save();
        }
        return $this;
    }

    private function getSelectionData($attribute)
    {
        if (array_key_exists($attribute, $this->select)) {
            return (object)$this->select[$attribute];
        }
    }

    protected function getRelationData($relation)
    {
        $data = [];
        switch ($this->attributeTypes[$relation]) {
            case self::TYPE_REL_BELONGS_TO:
                $data['available'] = $this->getAvailableRelationData($relation);
                $relation = substr($relation, 0, strpos($relation, '_id'));
                $related = $this->model->$relation;
                $data['slug'] = str_plural($relation);
                if (!is_null($related)) {
                    $data['value'] = $related->id;
                }
                break;

            case self::TYPE_REL_BELONGS_TO_MANY:
                $related = $this->model->$relation;
                $data['slug'] = $relation;
                foreach ($related as $rValue) {
                    $data['value'][] = $rValue->id;
                }
                $relatedCollection = ($this->isTranslatable(get_class($this->model->$relation()->getRelated())))
                    ? get_class($this->model->$relation()->getRelated())::withPresetTranslation($this->locale)->get()
                    : get_class($this->model->$relation()->getRelated())::all();
                foreach ($relatedCollection as $r) {
                    $data['available'][] = [
                        'name' => $r->name,
                        'id' => $r->id
                    ];
                }
                break;
        }
        return $data;
    }

    private function getAvailableRelationData($relation)
    {
        $available = [];
        if (array_key_exists($relation, $this->relatedModelName)) {
            $relatedCollection = ($this->isTranslatable($this->relatedModelName[$relation]))
                ? $this->relatedModelName[$relation]::withPresetTranslation($this->locale)->get()
                : $this->relatedModelName[$relation]::all();
            foreach ($relatedCollection as $r) {
                $available[] = [
                    'name' => $r->name,
                    'id' => $r->id
                ];
            }
        }
        return $available;
    }

    private function validateRequest(Request $request)
    {
        if (isset($this->model) && isset($this->model->rules)) {
            return Validator::make($request->all(), $this->model->rules);
        }
    }
}
