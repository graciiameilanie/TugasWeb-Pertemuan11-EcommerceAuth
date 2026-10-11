<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ShopSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('role', 'admin')->first();

        $tags = collect(['Terlaris', 'Diskon', 'Baru', 'Garansi Resmi', 'Stok Terbatas'])
    ->map(fn ($name) => Tag::firstOrCreate(['name' => $name]));

        $catalog = [
            'Elektronik' => [
                ['Smartphone Xiaomi Redmi Note 13', 2899000],
                ['Headset Bluetooth JBL Tune 520BT', 549000],
                ['Power Bank Anker 10000mAh', 329000],
                ['Smartwatch Amazfit Bip 5', 899000],
                ['Mouse Wireless Logitech M331', 249000],
                ['Keyboard Mekanik Rexus Legionare', 399000],
                ['Speaker Bluetooth Xiaomi Mini', 289000],
                ['Webcam Logitech C270 HD', 429000],
                ['Flashdisk Sandisk 64GB', 89000],
                ['Router TP-Link Archer C6', 599000],
                ['Monitor LED Samsung 24 Inci', 1850000],
            ],
            'Fashion' => [
                ['Kaos Polos Cotton Combed 30s', 59000],
                ['Kemeja Flanel Lengan Panjang', 149000],
                ['Celana Jeans Slim Fit Pria', 219000],
                ['Jaket Hoodie Fleece', 189000],
                ['Sneakers Canvas Putih', 259000],
                ['Tas Ransel Laptop Anti Air', 179000],
                ['Topi Baseball Polos', 49000],
                ['Dress Midi Katun Wanita', 199000],
                ['Sandal Jepit Premium', 69000],
                ['Hijab Segi Empat Voal Premium', 39000],
                ['Jam Tangan Analog Kulit', 229000],
            ],
            'Peralatan Rumah' => [
                ['Rice Cooker Miyako 1,8 Liter', 369000],
                ['Blender Philips 2 Liter', 599000],
                ['Teflon Anti Lengket 26 cm', 129000],
                ['Set Pisau Dapur Stainless 5 Pcs', 159000],
                ['Dispenser Air Miyako', 459000],
                ['Setrika Uap Philips', 389000],
                ['Lampu LED Philips 14 Watt', 49000],
                ['Sapu dan Pengki Set', 45000],
                ['Rak Sepatu 4 Susun', 119000],
                ['Kipas Angin Berdiri Cosmos 16 Inci', 329000],
                ['Termos Stainless 1 Liter', 135000],
            ],
            'Buku' => [
                ['Atomic Habits', 98000],
                ['Filosofi Teras', 98000],
                ['Laskar Pelangi', 85000],
                ['Bumi Manusia', 125000],
                ['Clean Code', 450000],
                ['Belajar PHP dan MySQL untuk Pemula', 89000],
                ['Dasar Algoritma dan Pemrograman', 95000],
                ['Sapiens', 149000],
                ['Rich Dad Poor Dad', 95000],
                ['Kamus Inggris Indonesia', 110000],
                ['Buku Tulis Sinar Dunia isi 10', 35000],
            ],
            'Olahraga' => [
                ['Matras Yoga 6 mm', 99000],
                ['Dumbbell Set 10 Kg', 249000],
                ['Sepatu Lari Pria Ortuseight', 429000],
                ['Bola Futsal Molten', 189000],
                ['Raket Badminton Yonex Astrox 01', 549000],
                ['Tali Skipping Speed Rope', 35000],
                ['Botol Minum Olahraga 1 Liter', 49000],
                ['Resistance Band Set', 79000],
                ['Sarung Tangan Gym', 59000],
                ['Jersey Sepak Bola Dri-Fit', 129000],
                ['Tenda Camping Kapasitas 4 Orang', 450000],
            ],
        ];

        foreach ($catalog as $categoryName => $items) {
            $category = Category::firstOrCreate(
    ['name' => $categoryName],
    ['slug' => Str::slug($categoryName)]
    );

            foreach ($items as [$name, $price]) {
                $product = Product::factory()->create([
                    'category_id' => $category->id,
                    'user_id' => $admin->id,
                    'name' => $name,
                    'description' => "$name kondisi baru, kualitas terjamin, dan siap dikirim.",
                    'price' => $price,
                    'stock' => rand(0, 50),
                ]);

                $product->tags()->attach($tags->random(rand(1, 2))->pluck('id'));
            }
        }

        // Pesanan contoh untuk para pembeli
        $products = Product::all();

        User::where('role', 'user')->get()->each(function ($buyer) use ($products) {
            Order::factory(2)->create(['user_id' => $buyer->id])->each(function ($order) use ($products) {
                $products->random(3)->each(function ($product) use ($order) {
                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $product->id,
                        'qty' => rand(1, 3),
                        'price' => $product->price,
                    ]);
                });
            });
        });
    }
}