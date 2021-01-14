<?php

namespace Database\Factories;

use App\Models\Payment; 
use App\Models\UserRole; 
use App\Models\Member;
use Illuminate\Database\Eloquent\Factories\Factory;

class PaymentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Payment::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {   
        $user = UserRole::WhereIn('role_id', [6, 7, 8])->pluck('user_id')->toArray(); 
        return [
            //  
            'amount_billed'=>$this->faker->randomFloat(2, 50, 300), 
            'amount_payed'=>$this->faker->randomFloat(2, 50, 300),
            'to_chapter'=>$this->faker->randomFloat(2, 50, 300), 
            'to_demolay'=>$this->faker->randomFloat(2, 50, 300),
            'member_id'=>Member::factory(), 
            'description'=>'Member payment', 
            'advisor_id'=>$this->faker->randomElement($user), 
            'payment_date'=>$this->faker->dateTimeBetween('-5 years'), 

        ];
    }
}
