<?php

namespace Database\Factories;

use App\Models\Account;
use App\Models\Invoice;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class InvoiceFactory extends Factory
{
    protected $model = Invoice::class;

    public function definition()
    {
        return [
            'status' => $this->faker->randomNumber(),
            'description' => $this->faker->text(),
            'type' => $this->faker->word(),
            'card_last_digits' => $this->faker->word(),
            'amount' => $this->faker->randomNumber(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'account_id' => Account::factory(),
        ];
    }
}
