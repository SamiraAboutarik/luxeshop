<?php
namespace Database\Seeders;
use App\Models\{User, Product, Category};
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder {
    public function run(): void {
        // Admin user
        User::create([
            'name'     => 'Admin',
            'email'    => 'admin@shop.com',
            'password' => Hash::make('password'),
            'role'     => 'admin',
        ]);
        // Regular user
        User::create([
            'name'     => 'Client Test',
            'email'    => 'user@shop.com',
            'password' => Hash::make('password'),
            'role'     => 'user',
        ]);

        $this->call(CategorySeeder::class);

        // Sample products
        $categories = Category::all();
        $products = [
            ['name' => 'iPhone 15 Pro', 'price' => 12999, 'stock' => 20],
            ['name' => 'MacBook Air M3', 'price' => 15999, 'stock' => 10],
            ['name' => 'Samsung Galaxy S24', 'price' => 9999, 'stock' => 15],
            ['name' => 'Casque Sony WH-1000XM5', 'price' => 3999, 'stock' => 30],
            ['name' => 'Nike Air Max 270', 'price' => 1299, 'stock' => 50],
            ['name' => 'T-shirt Premium', 'price' => 199, 'stock' => 100],
            ['name' => 'Lampe LED Design', 'price' => 449, 'stock' => 25],
            ['name' => 'Tapis de Yoga', 'price' => 299, 'stock' => 40],
        ];
        foreach ($products as $i => $p) {
            Product::create([
                'category_id' => $categories[$i % $categories->count()]->id,
                'name'        => $p['name'],
                'slug'        => Str::slug($p['name']),
                'description' => 'Description de ' . $p['name'] . '. Produit de haute qualité.',
                'price'       => $p['price'],
                'stock'       => $p['stock'],
                'is_active'   => true,
            ]);
        }
    }
}
