<?php

namespace Feature\Models;

use App\Models\Genre;
use Exception;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class GenreTest extends TestCase
{
    use DatabaseMigrations;

    public function test_are_fields_equals()
    {
        factory(Genre::class, 1)->create();
        $genres = Genre::all();
        $genreKey = array_keys($genres->first()->getAttributes());
        $this->assertEqualsCanonicalizing([
            'id', 'name', 'is_active', 'created_at', 'updated_at', 'deleted_at'
        ], $genreKey);
    }

    public function test_genre_has_valid_uuid()
    {
        /** @var Genre $genre */
        $genre = factory(Genre::class)->create();
        $pattern = '/^[0-9A-F]{8}-[0-9A-F]{4}-4[0-9A-F]{3}-[89AB][0-9A-F]{3}-[0-9A-F]{12}$/i';
        $this->assertRegExp($pattern, (string)$genre->id);
    }

    public function test_list_genre()
    {
        $genre = factory(Genre::class, 1)->create();
        $this->assertCount(1, $genre);
    }

    public function test_create_genre_with_name()
    {
        $genre = Genre::create(['name' => 'test1']);
        $this->assertEquals('test1', $genre->name);
    }

    public function test_create_genre_with_is_active_false()
    {
        $genre = Genre::create(['name' => 'test1', 'is_active' => false]);
        $this->assertNotNull($genre->is_active);
    }

    public function test_update_genre_name(){
        $genre = factory(Genre::class, 1)->create()->first();
        $genre->update(['name' => 'new_name_test']);
        $this->assertEquals('new_name_test', $genre->name);
    }

    public function test_update_genre_is_active(){
        $genre = factory(Genre::class, 1)->create()->first();
        $genre->update(['is_active' => false]);
        $this->assertNotTrue($genre->is_active);
    }

    /**
     * @throws Exception
     */
    public function test_delete_genre()
    {
        /** @var Genre $genre */
        $genre = factory(Genre::class)->create();
        $genre->delete();
        $this->assertNull(Genre::find($genre->id));
    }

    public function test_force_delete_category()
    {
        /** @var Genre $genre */
        $genre = factory(Genre::class)->create();
        $genre->forceDelete();
        $this->assertNull(Genre::find($genre->id));
    }
}
