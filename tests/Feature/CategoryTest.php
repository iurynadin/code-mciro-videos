<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Models\Category;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidFactory;

class CategoryTest extends TestCase
{

    use DatabaseMigrations;

    public function mockUuid()
    {
        $stringUuid = Uuid::uuid4()->toString();
        $uuid = Uuid::fromString($stringUuid);
        $factoryMock = \Mockery::mock(UuidFactory::class . '[uuid4]', [
            'uuid4' => $uuid,
        ]);
        Uuid::setFactory($factoryMock);
        return $uuid;
    }

    /**
     * Test list categories
     *
     * @return void
     */
    public function testList()
    {
        factory(Category::class, 1)->create();
        $categories = Category::all();
        $this->assertCount(1,$categories);
        $categoryKey = array_keys($categories->first()->getAttributes());
        $this->assertEqualsCanonicalizing(
            ['id', 'name','description','is_active','created_at','updated_at','deleted_at'],
            $categoryKey
        );

    }

    /**
     * create a category
     *
     * @return void
     */
    public function testCreate()
    {
        $category = Category::create([
            'name' => 'Test1',
            'is_active' => true
        ]);
        
        $category->refresh();

        $this->assertEquals(36, strlen($category->id));
        $this->assertEquals('Test1', $category->name);
        $this->assertNull($category->description);
        $this->assertTrue($category->is_active);

        $category = Category::create([
            'name' => 'Test1',
            'description' => null
        ]);
        $this->assertNull($category->description);

        $category = Category::create([
            'name' => 'Test1',
            'description' => 'test description'
        ]);
        $this->assertEquals('test description', $category->description);

        $category = Category::create([
            'name' => 'Test1',
            'is_active' => false
        ]);
        $this->assertFalse($category->is_active);

        $category = Category::create([
            'name' => 'Test1',
            'is_active' => true
        ]);
        $this->assertTrue($category->is_active);

    }

    public function testCreateWithValidUuid()
    {
        $uuid = $this->mockUuid();
        $this->assertTrue(Uuid::isValid($uuid));

        $category = Category::create([
            'name' => 'Test1',
            'is_active' => true,
            'uuid' => $uuid->toString()
        ]);
        $category->refresh();
        $this->assertEquals($uuid->toString(), $category->id);
    }

    /**
     * update a category
     *
     * @return void
     */
    public function testUpdate()
    {
        $category = factory(Category::class)->create([
            'description' => 'test description',
            'is_active' => false
        ]);

        $data = [
            'name' => 'test_name_updated',
            'description' => 'test_description_updated',
            'is_active' => true
        ];
        $category->update($data);

        foreach ($data as $key => $value) {
            $this->assertEquals($value, $category->{$key});
        }
    }

    /**
     * delete category
     *
     * @return void
     */
    public function testDelete()
    {
        $category = factory(Category::class)->create();
        $category->delete();
        $this->assertNull(Category::find($category->id));
        $this->assertTrue($category->deleted_at != null);

        //testando o restore
        $category->restore();
        $this->assertNotNull(Category::find($category->id));
    }



}
