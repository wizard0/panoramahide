<?php

namespace Tests\Unit;

use App\Journal;
use App\Subscription;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class JournalGetSubscribeInfoTest extends TestCase
{
    /**
     * Electronic subscriptions has to have January as first month at any cases
     */
    public function testElectronicFirstMonth()
    {
        $testPassed = true;
        $journals = Journal::where('active', 1)->limit(10)->get();

        foreach ($journals as $journal) {
            $subscriptions = $journal->getSubscribeInfo();
            foreach ($subscriptions['prices'][Subscription::TYPE_ELECTRONIC] as $terms => $yearsAndMonths) {
                foreach ($yearsAndMonths as $startYear => $startMonths) {
                    if (!array_key_exists(1, $startMonths)) {
                        $testPassed = false;
                    }
                }
            }
        }

        return $this->assertTrue($testPassed);
    }
}
