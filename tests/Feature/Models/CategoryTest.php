<?php

namespace Feature\Models;

use App\Models\Category;
use Exception;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use DatabaseMigrations;

    public function test_are_fields_equals()
    {
        factory(Category::class, 1)->create();
        $categories = Category::all();
        $categoryKey = array_keys($categories->first()->getAttributes());
        $this->assertEqualsCanonicalizing([
            'id', 'name', 'description', 'is_active', 'created_at', 'updated_at', 'deleted_at'
        ], $categoryKey);
    }

    public function test_category_has_valid_uuid()
    {
        /** @var Category $category */
        $category = factory(Category::class)->create();
        $pattern = '/^[0-9A-F]{8}-[0-9A-F]{4}-4[0-9A-F]{3}-[89AB][0-9A-F]{3}-[0-9A-F]{12}$/i';
        $this->assertRegExp($pattern, (string)$category->id);
    }

    public function test_list_category()
    {
        $categories = factory(Category::class, 1)->create();
        $this->assertCount(1, $categories);
    }

    public function test_create_category_with_name()
    {
        $category = Category::create(['name' => 'test1']);
        $this->assertEquals('test1', $category->name);
    }

    public function test_create_category_with_description()
    {
        $category = Category::create(['name' => 'test1', 'description' => 'desc_test1']);
        $this->assertEquals('desc_test1', $category->description);
    }

    public function test_create_category_with_is_active_false()
    {
        $category = Category::create(['name' => 'test1', 'is_active' => false]);
        $this->assertNotNull($category->is_active);
    }

    public function test_update_category_name(){
        $category = factory(Category::class, 1)->create(['description' => 'desc_test'])->first();
        $category->update(['name' => 'new_name_test']);
        $this->assertEquals('new_name_test', $category->name);
    }

    public function test_update_category_description(){
        $category = factory(Category::class, 1)->create(['description' => 'desc_test'])->first();
        $category->update(['description' => 'new_description_test']);
        $this->assertEquals('new_description_test', $category->description);
    }

    public function test_update_category_is_active(){
        $category = factory(Category::class, 1)->create(['description' => 'desc_test'])->first();
        $category->update(['is_active' => false]);
        $this->assertNotTrue($category->is_active);
    }

    /**
     * @throws Exception
     */
    public function test_delete_category()
    {
        /** @var Category $category */
        $category = factory(Category::class)->create();
        $category->delete();
        $this->assertNull(Category::find($category->id));
    }

    public function test_force_delete_category()
    {
        /** @var Category $category */
        $category = factory(Category::class)->create();
        $category->forceDelete();
        $this->assertNull(Category::find($category->id));
    }
}
