<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\CompanyProfile;
use App\Models\Origin;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CoffeeShopSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Company Profile
        CompanyProfile::updateOrCreate(
            ['id' => 1],
            [
                'name' => 'Circle Concordia Coffee',
                'short_name' => 'C3',
                'tagline' => 'Harmony in Every Bean, Circle in Every Cup',
                'about' => 'Circle Concordia Coffee (C3) lahir dari kecintaan mendalam pada kekayaan cita rasa kopi nusantara. Kami mempertemukan kehangatan komunitas pecinta kopi dengan dedikasi para petani lokal melalui biji kopi pilihan berstandar specialty.',
                'vision' => 'Menjadi lingkaran penghubung harmoni antara petani kopi nusantara dan penikmat kopi dunia melalui sajian biji kopi berkualitas tinggi yang berkelanjutan dan adil.',
                'mission' => [
                    'Menjalin kemitraan direct trade yang etis dan memberdayakan petani lokal nusantara.',
                    'Melakukan proses kurasi dan pemanggangan (roasting) berstandar presisi tinggi untuk menjaga karakter rasa unik setiap origin.',
                    'Menghadirkan pengalaman menikmati kopi spesialti yang ramah, inklusif, dan mengedukasi masyarakat.',
                ],
                'phone' => '+62 812-3456-7890',
                'email' => 'hello@circleconcordiacoffee.com',
                'address' => 'Jl. Harmoni Kopi No. 3, Bandung, Jawa Barat, Indonesia',
                'instagram' => '@circleconcordia.coffee',
            ]
        );

        // 2. Categories
        $catArabica = Category::updateOrCreate(
            ['slug' => 'arabika'],
            ['name' => 'Arabika', 'description' => 'Biji kopi dengan karakter asam kompleks, aroma floral, dan rasa buah yang manis lembut.']
        );

        $catRobusta = Category::updateOrCreate(
            ['slug' => 'robusta'],
            ['name' => 'Robusta', 'description' => 'Biji kopi berbadan tebal (full body), kafein tinggi, dengan notes dark chocolate dan nutty.']
        );

        $catBlend = Category::updateOrCreate(
            ['slug' => 'house-blend'],
            ['name' => 'House Blend', 'description' => 'Perpaduan seimbang antara varietas pilihan untuk pengalaman rasa kopi susu dan espresso yang harmonis.']
        );

        // 3. Origins
        $originGayo = Origin::updateOrCreate(
            ['name' => 'Takengon, Aceh Gayo'],
            [
                'province' => 'Aceh',
                'altitude' => '1.300 - 1.600 mdpl',
                'description' => 'Dataran tinggi Gayo terkenal dengan tanah vulkanik yang subur dan iklim sejuk, menghasilkan biji kopi beraroma floral segar dengan body lembut.',
                'image_url' => 'https://images.unsplash.com/photo-1511497584788-87676104235f?q=80&w=900&auto=format&fit=crop',
            ]
        );

        $originBali = Origin::updateOrCreate(
            ['name' => 'Kintamani, Bali'],
            [
                'province' => 'Bali',
                'altitude' => '1.200 - 1.500 mdpl',
                'description' => 'Ditanam bersanding dengan perkebunan jeruk di lereng Gunung Batur, menghasilkan profil rasa citrus alami yang segar dan manis.',
                'image_url' => 'https://images.unsplash.com/photo-1514432324607-a09d9b4aefdd?q=80&w=900&auto=format&fit=crop',
            ]
        );

        $originFlores = Origin::updateOrCreate(
            ['name' => 'Bajawa, Flores'],
            [
                'province' => 'Nusa Tenggara Timur',
                'altitude' => '1.200 - 1.700 mdpl',
                'description' => 'Ditanam di lereng Gunung Inerie dengan tanah andosol kaya mineral. Karakter rasanya terkenal dominan cokelat susu dan karamel gurih.',
                'image_url' => 'https://images.unsplash.com/photo-1501339847302-ac426a4a7cbb?q=80&w=900&auto=format&fit=crop',
            ]
        );

        $originToraja = Origin::updateOrCreate(
            ['name' => 'Sapan, Tana Toraja'],
            [
                'province' => 'Sulawesi Selatan',
                'altitude' => '1.500 - 1.800 mdpl',
                'description' => 'Kawasan pegunungan karst terpencil yang memproduksi salah satu biji kopi paling dicari dunia dengan sentuhan herbal, spice, dan aftertaste manis.',
                'image_url' => 'https://images.unsplash.com/photo-1447933601403-0c6688de566e?q=80&w=900&auto=format&fit=crop',
            ]
        );

        $originDampit = Origin::updateOrCreate(
            ['name' => 'Dampit, Malang'],
            [
                'province' => 'Jawa Timur',
                'altitude' => '800 - 1.000 mdpl',
                'description' => 'Pusat robusta legendaris di kaki Gunung Semeru. Body sangat mantap dengan tingkat keasaman rendah dan aroma cokelat hitam pekat.',
                'image_url' => 'https://images.unsplash.com/photo-1498804103079-a6351b050096?q=80&w=900&auto=format&fit=crop',
            ]
        );

        // 4. Products
        $products = [
            [
                'name' => 'C3 Gayo Peach Blossom',
                'origin_id' => $originGayo->id,
                'category_id' => $catArabica->id,
                'roast_level' => 'Light-Medium',
                'process_method' => 'Washed',
                'price' => 95000,
                'weight_grams' => 250,
                'stock' => 45,
                'flavor_notes' => 'White Peach, Jasmine, Lemon Blossom, Honeycomb',
                'description' => 'Biji kopi pilihan dari petani Takengon dengan pengolahan basah higienis. Memberikan seduhan yang sangat bersih, aroma semerbak bunga melati, dan manis buah persik yang tahan lama.',
                'is_popular' => true,
                'main_image' => 'https://images.unsplash.com/photo-1587734195503-904fca47e0e9?q=80&w=800&auto=format&fit=crop',
            ],
            [
                'name' => 'C3 Bali Kintamani Sweet Orange',
                'origin_id' => $originBali->id,
                'category_id' => $catArabica->id,
                'roast_level' => 'Medium',
                'process_method' => 'Yellow Honey',
                'price' => 90000,
                'weight_grams' => 250,
                'stock' => 50,
                'flavor_notes' => 'Mandarin Orange, Brown Sugar, Milk Chocolate, Black Tea',
                'description' => 'Biji kopi bernuansa tropis dengan metode pengolahan madu (honey process). Lapisan lendir manis buah kopi menyerap ke dalam biji, menghasilkan keasaman manis seperti jeruk keprok segar.',
                'is_popular' => true,
                'main_image' => 'https://images.unsplash.com/photo-1610632380989-680fe40816c6?q=80&w=800&auto=format&fit=crop',
            ],
            [
                'name' => 'C3 Flores Bajawa Chocolate Velvet',
                'origin_id' => $originFlores->id,
                'category_id' => $catArabica->id,
                'roast_level' => 'Medium',
                'process_method' => 'Natural',
                'price' => 88000,
                'weight_grams' => 250,
                'stock' => 38,
                'flavor_notes' => 'Creamy Cocoa, Roasted Almond, Caramel, Red Apple',
                'description' => 'Diproses kering bersama kulit ceri utuh di bawah sinar matahari Bajawa. Sensasi rasa cokelat beludru yang lembut dan ramah bagi lambung, cocok untuk manual brew maupun tubruk berkelas.',
                'is_popular' => true,
                'main_image' => 'https://images.unsplash.com/photo-1559056199-641a0ac8b55e?q=80&w=800&auto=format&fit=crop',
            ],
            [
                'name' => 'C3 Toraja Sapan Heritage Reserve',
                'origin_id' => $originToraja->id,
                'category_id' => $catArabica->id,
                'roast_level' => 'Medium-Dark',
                'process_method' => 'Semi-Washed (Giling Basah)',
                'price' => 110000,
                'weight_grams' => 250,
                'stock' => 25,
                'flavor_notes' => 'Dark Cherry, Cedarwood, Cinnamon, Dark Chocolate',
                'description' => 'Kopi legendaris dari perkebunan dataran tertinggi Tana Toraja. Menghasilkan rasa yang dalam, pekat, dengan wangi rempah kayu manis dan rempah hutan yang menawan.',
                'is_popular' => true,
                'main_image' => 'https://images.unsplash.com/photo-1514432324607-a09d9b4aefdd?q=80&w=800&auto=format&fit=crop',
            ],
            [
                'name' => 'C3 Dampit Robusta Royal Crema',
                'origin_id' => $originDampit->id,
                'category_id' => $catRobusta->id,
                'roast_level' => 'Dark',
                'process_method' => 'Natural',
                'price' => 65000,
                'weight_grams' => 250,
                'stock' => 60,
                'flavor_notes' => 'Dark Cacao, Toasted Hazelnut, Cane Molasses, Bold Body',
                'description' => 'Robusta pilihan berkualitas tinggi dari Dampit, Malang. Tanpa rasa langu, sangat pekat dengan krema tebal, sangat sempurna untuk penikmat es kopi susu kekinian atau espresso shot.',
                'is_popular' => false,
                'main_image' => 'https://images.unsplash.com/photo-1587734195503-904fca47e0e9?q=80&w=800&auto=format&fit=crop',
            ],
            [
                'name' => 'C3 Concordia Harmony Espresso Blend',
                'origin_id' => $originGayo->id,
                'category_id' => $catBlend->id,
                'roast_level' => 'Medium-Dark',
                'process_method' => 'Special Blend',
                'price' => 85000,
                'weight_grams' => 250,
                'stock' => 70,
                'flavor_notes' => 'Caramel Macchiato, Roasted Walnut, Sweet Chocolate, Orange Peel',
                'description' => 'Racikan rahasia C3 memadukan 70% Arabika Gayo & Bajawa dengan 30% Fine Robusta Dampit. Keseimbangan harmoni mutlak antara crema melimpah, aroma harum, dan rasa manis legit saat dipadu susu.',
                'is_popular' => true,
                'main_image' => 'https://images.unsplash.com/photo-1518832553480-cd0e625ed3e6?q=80&w=800&auto=format&fit=crop',
            ],
        ];

        foreach ($products as $item) {
            Product::updateOrCreate(
                ['slug' => Str::slug($item['name'])],
                array_merge($item, ['slug' => Str::slug($item['name'])])
            );
        }
    }
}
