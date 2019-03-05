<?php
/**
 * @copyright
 * @author
 */
namespace Tests\Unit\Controllers;

use App\Journal;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\FactoryTrait;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Class for magazines ajax get page test.
 */
class MagazinesAjaxGetPageTest extends TestCase
{
    use DatabaseTransactions;
    use FactoryTrait;

    public function testMethod()
    {
        $this->factoryJournal([
            'active' => 1,
        ]);

        $journal = Journal::where('active', 1)->first();
        foreach (['magazine', 'numbers', 'fresh_number',
                  'articles', 'subscribe', 'send_article', 'info'] as $tab) {
            $response = $this->get('/magazines/ajax-get-page?' . serialize([
                    'code' => $journal->code,
                    'tab' => $tab
                ]), ['HTTP_X-Requested-With' => 'XMLHttpRequest']);

            $response->assertOk();
        }
    }
}
