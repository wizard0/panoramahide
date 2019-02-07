<?php

namespace Tests\Unit\Controllers;

use App\Journal;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MagazinesAjaxGetPageTest extends TestCase
{
    public function testMethod()
    {
        $journal = Journal::where('active', 1)->first();
        foreach ([
                     'magazine',
                     'numbers',
                     'fresh_number',
                     'articles',
                     'subscribe',
                     'send_article',
                     'info'
                 ] as $tab)
        {
            $response = $this->get('/magazines/ajax-get-page?' . serialize([
                    'code' => $journal->code,
                    'tab' => $tab
                ]), ['HTTP_X-Requested-With' => 'XMLHttpRequest']);

            $response->assertOk();
        }
    }
}
