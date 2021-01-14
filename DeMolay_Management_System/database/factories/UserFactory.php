<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Jurisdiction;
use App\Models\Chapter;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {    
        $jurisdiction = Jurisdiction::Where('id', [1, 2, 3])->pluck('id')->toArray(); 
        $chapter = Chapter::pluck('id')->toArray();
        return [
            'first_name' => $this->faker->firstName, 
            'last_name' => $this->faker->lastName, 
            'email' => $this->faker->unique()->safeEmail,
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10), 
            'jurisdiction_id'=>$this->faker->randomElement($jurisdiction), 
            'chapter_id'=>$this->faker->randomElement($chapter)
        ];
    }
}
