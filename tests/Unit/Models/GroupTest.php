<?php
/**
 * @copyright Copyright (c) 2018-2019 "ИД Панорама"
 * @author    Денис Парыгин (dyp2000@mail.ru)
 */
namespace Tests\Unit\Models;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Promocode;
use App\Models\Group;
use Tests\FactoryTrait;

class GroupTest extends TestCase
{
    use FactoryTrait;

    private $promocode;
    private $journal;
    private $group;

    public function setUp()
    {
        parent::setUp();
        $this->promocode = factory(Promocode::class)->create();
        $this->journal = factory(\App\Models\Journal::class)->create();
        $this->group = $this->factoryGroup([
            'promocode_id' => $this->promocode->id,
            'active' => true
        ]);
    }

    public function tearDown()
    {
        //
    }

    public function testStore()
    {
        $this->group->journals()->attach($this->journal->id);
        $res = Group::store(['name' => 'test-group', 'journals' => [$this->journal->id]], $this->promocode->id);
        $this->assertEquals($this->promocode->id, $res->promocode_id);
    }
}
