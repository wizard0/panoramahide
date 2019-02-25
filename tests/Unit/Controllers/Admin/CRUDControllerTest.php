<?php

namespace Tests\Unit\Controllers\Admin;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App;
use App\Http\Controllers\Admin\CRUDController;

class CRUDControllerMock extends CRUDController
{
    protected $modelName = null;
    // protected $model = 'MockModel';

    public function __construct(Request $request = null)
    {
        parent::__construct($request);
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

class CRUDControllerTest extends TestCase
{

    use DatabaseTransactions;

    public function testEdit()
    {
        // Journal editing
        $journal = factory(App\Journal::class)->create();

        $oCRUDController = new App\Http\Controllers\Admin\JournalController();
        $oCRUDController->update((new Request())->merge([
            'name' => 'new_journal_test_name_no_more_such_names'
        ]), $journal->id);

        $this->assertDatabaseHas('journal_translations', [
            'journal_id' => $journal->id,
            'name' => 'new_journal_test_name_no_more_such_names'
        ]);

        // Category editing
        $category = factory(App\Category::class)->create();

        $oCRUDController = new App\Http\Controllers\Admin\CategoryController();
        $oCRUDController->update((new Request())->merge([
            'name' => 'new_category_test_name_no_more_such_names'
        ]), $category->id);

        $this->assertDatabaseHas('category_translations', [
            'category_id' => $category->id,
            'name' => 'new_category_test_name_no_more_such_names'
        ]);
    }

    public function testDelete()
    {
        // Journal deleting
        $journal = factory(App\Journal::class)->create();

        $oCRUDController = new App\Http\Controllers\Admin\JournalController();
        $oCRUDController->destroy($journal->id);

        $this->assertDatabaseMissing('journals', ['id' => $journal->id]);
        $this->assertDatabaseMissing('journal_translations', ['journal_id' => $journal->id]);

        // Category deleting
        $category = factory(App\Category::class)->create();

        $oCRUDController = new App\Http\Controllers\Admin\CategoryController();
        $oCRUDController->destroy($category->id);

        $this->assertDatabaseMissing('categories', ['id' => $category->id]);
        $this->assertDatabaseMissing('category_translations', ['category_id' => $category->id]);
    }

    public function testRelation()
    {
        $category = factory(App\Category::class)->create();
        $journal = factory(App\Journal::class)->create();

        $oCRUDController = new App\Http\Controllers\Admin\JournalController();
        $oCRUDController->update((new Request())->merge([
            'name' => 'new_journal_test_name_no_more_such_names2',
            'categories' => [$category->id]
        ]), $journal->id);

        $this->assertDatabaseHas('journal_category', [
            'journal_id' => $journal->id,
            'category_id' => $category->id
        ]);
    }

    public function testImageUpload()
    {
        Storage::fake('journal_images_test');
        $journal = factory(App\Journal::class)->create();

        $oCRUDController = new App\Http\Controllers\Admin\JournalController();
        $request = new Request();
        $request->merge([
            'name' => 'new_journal_test_name_no_more_such_names2',
        ]);
        $image = UploadedFile::fake()->image('journal.png');
        $request->files->set('image', $image);
        $oCRUDController->update($request, $journal->id);

        $this->assertTrue(App\Journal::find($journal->id)->image !== '');
    }

    public function testDefineLocale()
    {
        $request = new Request();
        $this->assertNotNull($request);
        $request->merge([
            CRUDController::LOCALE_VAR => 'ru'
        ]);
        $crud = new CRUDController($request);
        $this->assertNotNull($crud);
    }

    public function testIsTranslatable()
    {
        $crudMock = new CRUDControllerMock();
        $this->assertFalse($crudMock->assertNotTranslatable());
    }

    public function testGetModel()
    {
        $crudMock = new CRUDControllerMock();
        $this->assertNull($crudMock->assertCreateModel());
    }
}
