<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Hambúrgueres',
            'Cachorro-quentes',
            'Pizzas',
            'Sanduíches',
            'Salgados',
            'Acompanhamentos',
            'Bebidas',
            'Sobremesas',
            'Combos',
            'Outros',
        ];

        foreach ($categories as $category) {
            DB::table('product_categories')->insert([
                'name' => $category,
                'slug' => Str::slug($category),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
