<?php
/**
 * @copyright
 * @author
 */
namespace Tests\Unit\Controllers\Admin;

use App;
use Mockery\Exception;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Http\Controllers\Admin\CRUDController;

class CRUDControllerTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp()
    {
        parent::setUp();
        (new \PaysystemSeeder())->run();
    }

    public function testEdit()
    {
        // Journal editing
        $journal = factory(App\Journal::class)->create();

        $oCRUDController = new App\Http\Controllers\Admin\JournalController();
        $oCRUDController->update((new Request())->merge([
            'name' => 'new_journal_test_name_no_more_such_names',
            'code' => $journal->code
        ]), $journal->id);

        $this->assertDatabaseHas('journal_translations', [
            'journal_id' => $journal->id,
            'name' => 'new_journal_test_name_no_more_such_names'
        ]);

        // Category editing
        $category = factory(App\Category::class)->create();
//        $categoryControllerStub = $this->createMock(App\Http\Controllers\Admin\CategoryController::class);
//        $categoryControllerStub->
        $oCRUDController = new App\Http\Controllers\Admin\CategoryController(
            (new Request())->merge([App\Http\Controllers\Admin\CRUDController::LOCALE_VAR => 'fr'])
        );

        $oCRUDController->update((new Request())->merge([
            App\Http\Controllers\Admin\CRUDController::LOCALE_VAR => 'fr',
            'name' => 'new_category_test_name_no_more_such_names_fr',
            'code' => 'and_code_ofc_fr'
        ]), $category->id);

        $this->assertDatabaseHas('category_translations', [
            'category_id' => $category->id,
            'name' => 'new_category_test_name_no_more_such_names_fr',
            'code' => 'and_code_ofc_fr',
            'locale' => 'fr'
        ]);

        $oPaysystem = App\Paysystem::first();

        // Paysystem editing. The model has not translated attributes
        $oCRUDController = new App\Http\Controllers\Admin\PaysystemController();
        $oCRUDController->update((new Request())->merge([
            'name' => 'new_paysystem_name'
        ]), $oPaysystem->id);

        $this->assertDatabaseHas('paysystems', [
            'id' => $oPaysystem->id,
            'name' => 'new_paysystem_name'
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
            'code' => $journal->code,
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
            'code' => $journal->code
        ]);
        $image = UploadedFile::fake()->image('journal.png');
        $request->files->set('image', $image);
        $oCRUDController->update($request, $journal->id);

        $this->assertTrue(App\Journal::find($journal->id)->image !== '');
    }

    public function testWithParentController()
    {
        // Journal editing
        $journal = factory(App\Journal::class)->create();
        $oCRUDController = new App\Http\Controllers\Admin\CRUDController();
        try {
            $oCRUDController->update((new Request())->merge([
                'name' => 'new_journal_test_name_no_more_such_names',
                'code' => $journal->code
            ]), $journal->id);
        } catch (\Exception $e) {
            $this->assertTrue(true);
        }
        $this->assertDatabaseMissing('journal_translations', [
            'journal_id' => $journal->id,
            'name' => 'new_journal_test_name_no_more_such_names'
        ]);

        // index
        $oCRUDController = new App\Http\Controllers\Admin\CRUDController();
        try {
            $oCRUDController->index(new Request());
        } catch (\Exception $e) {
            $this->assertTrue(true);
        }

        // destroy
        $oCRUDController = new App\Http\Controllers\Admin\CRUDController();
        try {
            $oCRUDController->destroy(148);
        } catch (\Exception $e) {
            $this->assertTrue(true);
        }
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

    public function testWrongConfiguredClass()
    {
        $categoryMock = new CategoryControllerMock();
        $category = factory(App\Category::class)->create();
        $categoryMock->edit((new Request())->merge([
            'name' => 'catname',
            'code' => 'catcode',
            'journals' => [1,2,3],
            'articles' => [1,2,3]
        ]), $category->id);

        $this->assertDatabaseMissing('category_translations', [
            'name' => 'catname',
            'code' => 'catcode'
        ]);
    }

    public function testShowMethodWrongSelectionConfiguredController()
    {
        $orderMock = new OrderControllerMock();
        $response = $orderMock->create();
        $this->assertTrue(class_basename($response) == 'View');
    }

    public function testTranslatableWrongConfiguredController()
    {
        $newsMock = new NewsControllerMock();
        $response = $newsMock->create();
        $this->assertTrue($response->status() == 403);
    }
}
