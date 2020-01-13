<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

use App\Category;
use App\Tag;

class Event extends Model
{
    use Searchable;
    
    protected $fillable = ['name', 'description', 'image', 'creator_id', 'creator_email', 'starts_at'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function tags() {
        return  $this->belongsToMany(Tag::class);
    }

    public function categories() {
        return $this->belongsToMany(Category::class);
    }

    public function addCategories($categories) {
        foreach ($categories as $categoryName) {
                $foundCategory = Category::where('name', $categoryName)->first();
                
                if($foundCategory) {
                    $this->categories()->attach($foundCategory);
                    continue;
                }

                $this->categories()->attach(Category::create(['name' => $categoryName]));
        }
    }

    public function addTags($tags) {
        foreach ($tags as $tagName) {
                $foundTag = Tag::where('name', $tagName)->first();
                
                if($foundTag) {
                    $this->tags()->attach($foundTag);
                    continue;
                }

                $this->tags()->attach(Tag::create(['name' => $tagName]));
        }
    }

}
