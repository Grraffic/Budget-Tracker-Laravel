<?php

namespace Tests\Feature;

use App\Models\Transaction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TransactionApiTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test retrieving all transactions.
     */
    public function test_can_retrieve_all_transactions(): void
    {
        // Ensure at least one transaction exists
        Transaction::create([
            'title' => 'Test Transaction',
            'amount' => 100.00,
            'type' => 'income',
            'category' => 'Salary',
            'transaction_date' => '2026-07-01',
        ]);

        $response = $this->getJson('/api/transaction');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'message',
                'data' => [
                    '*' => [
                        'id',
                        'title',
                        'amount',
                        'type',
                        'category',
                        'transaction_date',
                        'created_at',
                        'updated_at',
                    ]
                ]
            ]);
    }

    /**
     * Test creating a transaction.
     */
    public function test_can_create_transaction(): void
    {
        $payload = [
            'title' => 'Starbucks Coffee',
            'amount' => 180.00,
            'type' => 'expense',
            'category' => 'Foods & Drinks',
            'transaction_date' => '2026-06-30',
        ];

        $response = $this->postJson('/api/transaction', $payload);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'message',
                'data' => [
                    'id',
                    'title',
                    'amount',
                    'type',
                    'category',
                    'transaction_date',
                    'created_at',
                    'updated_at',
                ]
            ])
            ->assertJson([
                'data' => [
                    'title' => 'Starbucks Coffee',
                    'amount' => 180.00,
                    'type' => 'expense',
                    'category' => 'Foods & Drinks',
                    'transaction_date' => '2026-06-30',
                ]
            ]);
    }

    /**
     * Test updating a transaction.
     */
    public function test_can_update_transaction(): void
    {
        $transaction = Transaction::create([
            'title' => 'Starbucks Coffee',
            'amount' => 180.00,
            'type' => 'expense',
            'category' => 'Foods & Drinks',
            'transaction_date' => '2026-06-30',
        ]);

        $payload = [
            'title' => 'Starbucks Coffee Updated',
            'amount' => 150.00,
            'type' => 'expense',
            'category' => 'Foods & Drinks',
            'transaction_date' => '2026-06-30',
        ];

        $response = $this->putJson("/api/transaction/{$transaction->id}", $payload);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'message',
                'data' => [
                    'id',
                    'title',
                    'amount',
                    'type',
                    'category',
                    'transaction_date',
                    'created_at',
                    'updated_at',
                ]
            ])
            ->assertJson([
                'data' => [
                    'title' => 'Starbucks Coffee Updated',
                    'amount' => 150.00,
                    'type' => 'expense',
                    'category' => 'Foods & Drinks',
                    'transaction_date' => '2026-06-30',
                ]
            ]);
    }

    /**
     * Test deleting a transaction.
     */
    public function test_can_delete_transaction(): void
    {
        $transaction = Transaction::create([
            'title' => 'Temporary Transaction',
            'amount' => 50.00,
            'type' => 'expense',
            'category' => 'Misc',
            'transaction_date' => '2026-07-01',
        ]);

        $response = $this->deleteJson("/api/transaction/{$transaction->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('transactions', ['id' => $transaction->id]);
    }
}
