<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App;

class CRUDController extends Controller
{
    use IndexPageTrait;
    use EditCreatePageTrait;
    use ShowPageTrait;

    protected $modelName;
    protected $model;
    protected $relatedModelName;
    protected $slug;
    protected $locale;
    protected $relations;

    const TYPE_STRING = 'string';
    const TYPE_TEXT = 'text';
    const TYPE_HTML = 'html';
    const TYPE_SELECT = 'select';
    const TYPE_IMAGE = 'image';
    const TYPE_BOOL = 'bool';
    const TYPE_REL_BELONGS_TO = 'relation-belongs-to';
    const TYPE_REL_BELONGS_TO_MANY = 'relation-belongs-to-many';
    const TYPE_DATE = 'date';
    const TYPE_PRICE = 'price';

    const LOCALE_VAR = 'translate_locale';

    /**
     * CRUDController constructor.
     * Auto defining model name for CRUD operations
     *
     * @param \Illuminate\Http\Request $request
     */
    public function __construct(Request $request = null)
    {
        $this->defineModelNameAndSlug()
            ->defineLocale($request);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->getModel($id)->deleteModel();

        return redirect()->back();
    }

    /**
     * To define correct model name controller which extends this feature should be named like:
     *     <Model_Name>Controller
     *
     * @return $this
     */
    private function defineModelNameAndSlug()
    {
        if (!isset($this->modelName)) {
            $className = get_class($this);
            if (preg_match('/\\\\([a-zA-Z]*)Controller$/', $className, $matches)) {
                $modelName = '\\App\\' . $matches[1];
                if (class_exists($modelName)) {
                    $this->modelName = $modelName;
                    if (!isset($this->slug) || $this->slug == '') {
                        $this->slug = str_plural(strtolower($matches[1]));
                    }
                } else {
                    $this->modelName = null;
                    $this->slug = null;
                }
            }
        }

        return $this;
    }

    private function defineLocale(Request $request = null)
    {
        $this->locale = ($request != null && $request->has(self::LOCALE_VAR))
            ? $request->get(self::LOCALE_VAR)
            : App::getLocale();

        return $this;
    }

    private function isTranslatable($modelName = null)
    {
        if (!$modelName && isset($this->modelName)) {
            $modelName = $this->modelName;
        }

        return in_array('Dimsav\Translatable\Translatable', class_uses($modelName));
    }

    private function getModel($id)
    {
        if (!isset($this->model) && isset($this->modelName)) {
            $this->model = $this->modelName::find($id);
        }

        return $this;
    }

    private function deleteModel()
    {
        if ($this->model) {
            $this->model->delete();
        }

        return $this;
    }

    public function getSlug()
    {
        return $this->slug;
    }
}
