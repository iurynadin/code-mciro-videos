<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Models\Genre;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidFactory;

class GenreTest extends TestCase
{
    
    use DatabaseMigrations;

    // public function mockUuid()
    // {
    //     $stringUuid = Uuid::uuid4()->toString();
    //     $uuid = Uuid::fromString($stringUuid);
    //     $factoryMock = \Mockery::mock(UuidFactory::class . '[uuid4]', [
    //         'uuid4' => $uuid,
    //     ]);
    //     Uuid::setFactory($factoryMock);
    //     return $uuid;
    // }


    public function testList()
    {
        factory(Genre::class)->create();
        $genres = Genre::all();
        $this->assertCount(1, $genres);
        
        $genreKey = array_keys($genres->first()->getAttributes());
        $this->assertEqualsCanonicalizing(
            ['id','name','is_active','created_at','updated_at','deleted_at'],
            $genreKey
        );
    }


    public function testCreate()
    {
        $genre = Genre::create([
            'name' => 'Test1',
            'is_active' => true
        ]);
        $genre->refresh();

        $this->assertEquals(36, strlen($genre->id));
        $this->assertEquals('Test1', $genre->name);
        $this->assertTrue($genre->is_active);
    }

    /**
     * update a category
     *
     * @return void
     */
    public function testUpdate()
    {
        $genre = factory(Genre::class)->create([
            'is_active' => false
        ])->first();

        $data = [
            'name' => 'genre_name_updated',
            'is_active' => true
        ];
        $genre->update($data);

        foreach ($data as $key => $value) {
            $this->assertEquals($value, $genre->{$key});
        }
    }


    public function testDelete()
    {
        $genre = factory(Genre::class)->create()->first();
        $genre->delete();
        $this->assertTrue($genre->deleted_at != null);
    }


}
