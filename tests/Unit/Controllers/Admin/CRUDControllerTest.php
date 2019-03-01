<?php

namespace Tests\Unit\Controllers\Admin;

use App\Order;
use App\OrderLegalUser;
use App\OrderPhysUser;
use App\Paysystem;
use Mockery\Exception;
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

    public function isTranslatable() {
        return false;
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

class CategoryControllerMock extends App\Http\Controllers\Admin\CategoryController
{
    protected $displayAttributes = ['id', 'name', 'code', 'updated_at'];
    protected $attributeTypes = [
        'active' => self::TYPE_BOOL,
        'sort' => self::TYPE_STRING,
        'created_at' => self::TYPE_DATE,
        'updated_at' => self::TYPE_DATE,
        'name' => self::TYPE_STRING,
        'code' => 'неизвестный тип',
        'image' => self::TYPE_IMAGE,
        'description' => self::TYPE_TEXT,
        'journals' => self::TYPE_REL_BELONGS_TO_MANY,
        'articles' => self::TYPE_REL_BELONGS_TO_MANY
    ];

    protected $relatedModelName = [
        'journals' => Journal::class
    ];

    protected $slug = 'categories';

    protected $modelName = '\\App\\Category';
}

class OrderControllerMock extends App\Http\Controllers\Admin\OrderController
{
    protected $displayAttributes = ['id', 'status', 'totalPrice'];
    protected $attributeTypes = [
        'phys_user_id' => self::TYPE_REL_BELONGS_TO,
        'legal_user_id' => self::TYPE_REL_BELONGS_TO,
        'status' => self::TYPE_SELECT,
        'orderList' => self::TYPE_STRING,
        'locale' => self::TYPE_SELECT,
        'totalPrice' => self::TYPE_PRICE,
        'payed' => self::TYPE_PRICE,
        'left_to_pay' => self::TYPE_PRICE,
        'paysystem_id' => self::TYPE_REL_BELONGS_TO
    ];

    protected $select = [
        'atatatus' => [
            Order::STATUS_WAIT => 'Wait',
            Order::STATUS_CANCELLED => 'Cancelled',
            Order::STATUS_PAYED => 'Payed',
            Order::STATUS_COMPLETED => 'Completed'
        ]
    ];

    protected $relatedModelName = [
        'phys_user_id' => OrderPhysUser::class,
        'legal_user_id' => OrderLegalUser::class,
        'paysystems_id' => Paysystem::class
    ];

    protected $modelName = '\\App\\Order';
}

class NewsControllerMock extends App\Http\Controllers\Admin\NewsController
{
    protected $displayAttributes = ['id', 'name', 'code', 'updated_at'];
    protected $attributeTypes = [
        'active' => self::TYPE_BOOL,
        'publishing_date' => self::TYPE_DATE,
        'created_at' => self::TYPE_DATE,
        'updated_at' => self::TYPE_DATE,
        'name' => self::TYPE_STRING,
        'code' => self::TYPE_STRING,
        'description' => self::TYPE_TEXT,
        'image' => self::TYPE_IMAGE,
        'preview' => self::TYPE_TEXT,
        'preview_image' => self::TYPE_STRING,
        'publishings' => self::TYPE_REL_BELONGS_TO_MANY
    ];

    protected $relatedModelName = [
        'publishings' => Publishing::class
    ];

    protected $modelName = 'asd';
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
