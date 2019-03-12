<?php

namespace Tests\Feature;

use App\Http\Controllers\Admin\JournalController;
use App\Models\Journal;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Request;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminValidationTest extends TestCase
{
    use DatabaseTransactions;

    public function testValidationPassed()
    {
        // Journal editing
        $journal = factory(Journal::class)->create();

        $oCRUDController = new JournalController();
        $oCRUDController->update((new Request())->merge([
            'name' => 'new_journal_test_name_no_more_such_names',
            'code' => 'nice'
        ]), $journal->id);

        $this->assertDatabaseHas('journal_translations', [
            'journal_id' => $journal->id,
            'name' => 'new_journal_test_name_no_more_such_names',
            'code' => 'nice'
        ]);
    }

    public function testValidationFails()
    {
        // Journal editing
        $journal = factory(Journal::class)->create();

        $oCRUDController = new JournalController();
        $oCRUDController->update((new Request())->merge([
            'name' => 'new_journal_test_name_no_more_such_names',
            'code' => ''
        ]), $journal->id);

        $this->assertDatabaseMissing('journal_translations', [
            'journal_id' => $journal->id,
            'name' => 'new_journal_test_name_no_more_such_names',
        ]);
    }
}
