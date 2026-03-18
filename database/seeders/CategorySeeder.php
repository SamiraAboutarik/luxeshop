<?php
namespace Database\Seeders;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder {
    public function run(): void {
        $categories = ['Électronique', 'Vêtements', 'Maison & Jardin', 'Sports', 'Beauté', 'Livres'];
        foreach ($categories as $name) {
            Category::create(['name' => $name, 'slug' => Str::slug($name)]);
        }
    }
}
