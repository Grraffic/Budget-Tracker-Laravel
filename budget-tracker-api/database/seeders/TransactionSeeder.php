<?php

namespace Database\Seeders;

use App\Models\Transaction;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Sample transaction Data
        $data = [
            [
                "title"=> "Starbucks Coffee",
                "amount"=> 180.00,
                "type"=> "expense",
                "category"=> "Foods & Drinks",
                "transaction_date"=> "2026-06-30"
            ],
            [
                 "title"=> "Freelance graphic design",
                "amount"=> 180.00,
                "type"=> "income",
                "category"=> "Freelance",
                "transaction_date"=> "2026-06-30"
            ],
            [
                 "title"=> "Internet Bill",
                "amount"=> 1500.00,
                "type"=> "expense",
                "category"=> "Utilities",
                "transaction_date"=> "2026-06-30"
            ]
        ];

        foreach ($data as $item) {
            Transaction::create($item);
        }
    }
}
