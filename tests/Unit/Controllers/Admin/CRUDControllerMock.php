<?php
/**
 * @copyright
 * @author
 */
namespace Tests\Unit\Controllers\Admin;

class CRUDControllerMock extends \App\Http\Controllers\Admin\CRUDController
{
    protected $modelName = null;
    // protected $model = 'MockModel';

    public function __construct(Request $request = null)
    {
        parent::__construct($request);
    }

    public function isTranslatable()
    {
        return false;
    }

    public function assertNotTranslatable()
    {
        return $this->isTranslatable();
    }

    public function assertCreateModel()
    {
        $this->modelName = 'Journal';
        $this->model = null;
        $this->getModel(-1);
    }
}
