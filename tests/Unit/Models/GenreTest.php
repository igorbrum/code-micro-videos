<?php

namespace Unit\Models;

use App\Models\Genre;
use App\Models\Traits\Uuid;
use Illuminate\Database\Eloquent\SoftDeletes;
use PHPUnit\Framework\TestCase;

class GenreTest extends TestCase
{
    private $genre;

    protected function setUp(): void
    {
        parent::setUp();
        $this->genre = new Genre();
    }

    public function test_fillable()
    {
        $fillable = ['name', 'is_active'];
        $this->assertEquals($fillable, $this->genre->getFillable());
    }

    public function test_if_use_traits()
    {
        $traits = [SoftDeletes::class, Uuid::class];
        $genreTraits = class_uses(Genre::class);
        $this->assertEqualsCanonicalizing($traits, $genreTraits);
    }
}
