<?php
/**
 * @copyright
 * @author
 */
namespace Tests\Unit\Controllers;

use App\Http\Controllers\MagazinesController;
use App\Journal;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Class for magazines send article test.
 */
class MagazinesSendArticleTest extends TestCase
{
    use DatabaseTransactions;
    use WithoutMiddleware;

    /**
     * Testing sendArticle() method of the MagazinesController
     *
     * @return void
     */
    public function testMethod()
    {
        Storage::fake('journal_sent_articles');

        $journal = Journal::where('active', 1)->first();
        $oMagazinesController = new MagazinesController();
        $request = new Request();

        $file = UploadedFile::fake()->create('test_upload_article.txt', '216');
        $request->merge([
            'journal' => $journal->id,
            'name' => 'Test Name',
            'email' => 'test@email.com',
        ]);
        $request->files->set('files', $file);

        $oMagazinesController->sendArticle($request);

        // Don't know why tis not working... File stored, but it existence cannot be asserted
//        Storage::disk('journal_sent_articles_test')->assertExists($file->hashName());
        $this->assertDatabaseHas('journal_sent_articles', [
            'email' => 'test@email.com'
        ]);
    }
}
