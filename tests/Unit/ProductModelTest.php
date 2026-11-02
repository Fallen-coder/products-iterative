
<?php


use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductModelTest extends TestCase
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

        $product->changeQuantity(1);

        $this->assertEquals(6, $product->fresh()->quantity);
    }

    public function test_can_decrease_product_quantity(): void
    {
        $product = $this->createProduct(5);

        $product->changeQuantity(-1);

        $this->assertEquals(4, $product->fresh()->quantity);
    }

    public function test_quantity_can_be_zero(): void
    {
        $product = $this->createProduct(1);

        $product->changeQuantity(-1);

        $this->assertEquals(0, $product->fresh()->quantity);
    }

    public function test_quantity_cannot_be_negative(): void
    {
        $product = $this->createProduct(0);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage(
            'Produkta daudzums nevar būt mazāks par 0!'
        );

        $product->changeQuantity(-1);
    }

    public function test_can_increase_quantity_by_multiple_units(): void
    {
        $product = $this->createProduct(5);

        $product->changeQuantity(10);

        $this->assertEquals(15, $product->fresh()->quantity);
    }
}
