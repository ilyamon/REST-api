<?php

namespace Tests\Controllers;

use App\Models\Product;
use Illuminate\Http\Response;
use Tests\TestCase;

class ProductControllerTests extends TestCase {

    public function testIndexReturnsDataInValidFormat() {

        $this->json('get', 'api/products')
            ->assertStatus( Response::HTTP_OK)
            ->assertJsonStructure(
                [
                    'data' => [
                        '*' => [
                            'id',
                            'name',
                            'price',
                            'img',
                            'created_at',
                            'updated_at'
                        ]
                    ]
                ]
            );
    }

    public function testProductIsDestroyed() {

        $productData =
            [
                'name'  => 'p_1',
                'price' => 10,
                'img'   => 'image.jpg'
            ];
        $product = Product::create($productData);

        $this->json('delete', "api/products/$product->id")
            ->assertStatus(200);
        $this->assertDatabaseMissing('products', $productData);
    }


}
