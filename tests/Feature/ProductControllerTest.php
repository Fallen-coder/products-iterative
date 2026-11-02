
<?php


use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductControllerTest extends TestCase
{
    use RefreshDatabase;

    private function createProduct(int $quantity = 5): Product
    {
        return Product::create([
            'name' => 'Test Product',
            'quantity' => $quantity,
            'description' => 'Test description',
            'price' => 10.00,
            'expiration_date' => null,
            'status' => 'active',
        ]);
    }

    public function test_can_increase_product_quantity(): void
    {
        $product = $this->createProduct(5);

        $response = $this->post(
            route('products.increase', $product)
        );

        $response->assertRedirect(
            route('products.show', $product)
        );

        $response->assertSessionHas('success');

        $this->assertEquals(6, $product->fresh()->quantity);
    }

    public function test_can_decrease_product_quantity(): void
    {
        $product = $this->createProduct(5);

        $response = $this->post(
            route('products.decrease', $product)
        );

        $response->assertRedirect(
            route('products.show', $product)
        );

        $response->assertSessionHas('success');

        $this->assertEquals(4, $product->fresh()->quantity);
    }

    public function test_cannot_decrease_quantity_below_zero(): void
    {
        $product = $this->createProduct(0);

        $response = $this->post(
            route('products.decrease', $product)
        );

        $response->assertRedirect(
            route('products.show', $product)
        );

        $response->assertSessionHas('error');

        $this->assertEquals(0, $product->fresh()->quantity);
    }

    public function test_increase_route_returns_404_for_missing_product(): void
    {
        $response = $this->post('/products/99999/increase');

        $response->assertNotFound();
    }

    public function test_decrease_route_returns_404_for_missing_product(): void
    {
        $response = $this->post('/products/99999/decrease');

        $response->assertNotFound();
    }

    public function test_user_can_create_product(): void
    {
        $response = $this->post(route('products.store'), [
            'name' => 'New Product',
            'quantity' => 10,
            'description' => 'New product description',
            'price' => "15.50",
            'expiration_date' => '2027-12-31',
            'status' => 'active',
        ]);

        $response->assertRedirect(route('products.index'));

        $this->assertDatabaseHas('products', [
            'name' => 'New Product',
            'quantity' => 10,
            'price' => "15.50",
        ]);
    }

    public function test_user_can_update_product(): void
    {
        $product = $this->createProduct(5);

        $response = $this->put(
            route('products.update', $product),
            [
                'name' => 'Updated Product',
                'quantity' => 20,
                'description' => 'Updated description',
                'price' => '25.00',
                'expiration_date' => '2027-12-31',
                'status' => 'active',
            ]
        );

        $response->assertRedirect(route('products.index'));

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'name' => 'Updated Product',
            'quantity' => 20,
            'price' =>'25.00',
        ]);
    }

    public function test_user_can_view_product(): void
    {
        $product = $this->createProduct(5);

        $response = $this->get(
            route('products.show', $product)
        );

        $response->assertOk();

        $response->assertSee('Test Product');
        $response->assertSee('5');
    }
}
