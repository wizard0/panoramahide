<?php

namespace Tests\Unit\Controllers\Admin;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Request;
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
}
