<?php

namespace Tests\Unit\Controllers\Admin;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App;

class CRUDControllerTest extends TestCase
{
    use DatabaseTransactions;

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

        // Paysystem editing. The model has not translated attributes
        $oCRUDController = new App\Http\Controllers\Admin\PaysystemController();
        $oCRUDController->update((new Request())->merge([
            'name' => 'new_paysystem_name'
        ]), 1);

        $this->assertDatabaseHas('paysystems', [
            'id' => 1,
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
}
