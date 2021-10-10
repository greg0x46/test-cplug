<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function syncCategories(array $categories)
    {
        DB::table('customer_categories')
            ->where('customer_id', $this->id)
            ->whereNotIn('category_name', $categories)
            ->delete();

        $this->addCategories($categories);
    }

    public function addCategories(array $categories)
    {
        $categories = array_unique($categories);

        $insert = [];
        array_map(function ($category) use (&$insert) {
            $insert[] = ['category_name' => $category, 'customer_id' => $this->id, 'created_at' => now(), 'updated_at' => now()];
        }, $categories);

        DB::table('customer_categories')
            ->upsert($insert, ['customer_id', 'category_name'], []);
    }


}
