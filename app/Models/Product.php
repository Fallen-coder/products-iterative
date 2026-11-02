<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'quantity',
        'description',
        'price',
        'expiration_date',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'quantity' => 'integer',
            'price' => 'decimal:2',
            'expiration_date' => 'date',
        ];
    }

    public function changeQuantity(int $amount): void
{
    $newQuantity = $this->quantity + $amount;

    if ($newQuantity < 0) {
        throw new \Exception('Produkta daudzums nevar būt mazāks par 0!');
    }

    $this->update([
        'quantity' => $newQuantity
    ]);
}
}