<?php

namespace Database\Factories;

use App\Models\Jurisdiction;
use App\Models\Member;
use Illuminate\Database\Eloquent\Factories\Factory;

class MemberFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Member::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            // 
            'first_name'=> $this->faker->firstname, 
            'last_name'=>$this->faker->lastName,
            'middle_name'=>$this->faker->lastName,
            'preferred_name'=>$this->faker->lastName, 
            'address'=>$this->faker->address, 
            'email'=>$this->faker->unique()->safeEmail,
            'home_phone'=>$this->faker->phoneNumber,
            'work_phone'=>$this->faker->phoneNumber,
            'mobile_phone'=>$this->faker->phoneNumber, 
            'country'=>'Canada',  
            'father_name'=>$this->faker->firstName.' '.$this->faker->lastName,  
            'mother_name'=>$this->faker->firstName.' '.$this->faker->lastName, 
            'guardian_one_name'=>$this->faker->firstName.' '.$this->faker->lastName,
            'guardian_two_name'=>$this->faker->firstName.' '.$this->faker->lastName,
            'birthdate'=>$this->faker->dateTimeBetween('-17 years', '-9 years'), 
            'province'=>'Alberta',  
            'city'=>$this->faker->city, 
            'postal_code'=>$this->faker->regexify('[A-Z][0-9][A-Z] [0-9][A-Z][0-9]'), 
            'jurisdiction_id'=> $this->faker->randomElement([1, 2, 3]), 
            'chapter_id'=>$this->faker->randomElement([1, 2]),  
            'initiatory_date'=>$this->faker->dateTimeBetween('-5 years', '-1 years'),
            'senior_demolay_date'=>$this->faker->dateTimeBetween('-5 years', '-1 years'), 
            'demolay_degree_date'=>$this->faker->dateTimeBetween('-5 years', '-1 years'), 
            'father_senior_status'=>$this->faker->boolean(50), 
            'father_mason_status'=>$this->faker->boolean(50),
            'father_senior_location'=>$this->faker->city, 
            'father_mason_location'=>$this->faker->city,
            'mother_mason_other'=>$this->faker->city,
            'guardian_one_senior_Status'=>$this->faker->boolean(50), 
            'guardian_one_mason_status'=>$this->faker->boolean(50), 
            'guardian_one_mason_location'=>$this->faker->city, 
            'guardian_one_senior_location'=>$this->faker->city,
            'guardian_one_mason_other'=>$this->faker->city,
            'guardian_two_senior_Status'=>$this->faker->boolean(50), 
            'guardian_two_mason_status'=>$this->faker->boolean(50), 
            'guardian_two_mason_location'=>$this->faker->city, 
            'guardian_two_senior_location'=>$this->faker->city,
            'guardian_two_mason_other'=>$this->faker->city,
            'sponsor_id'=>$this->faker->randomDigit, 
            'sponsor_name'=>$this->faker->name(),
            'home_phone'=>$this->faker->regexify('[1-9][0-9][0-9][-][0-9][0-9][0-9][-][0-9][0-9][0-9][0-9]'),
            'work_phone'=>$this->faker->regexify('[1-9][0-9][0-9][-][0-9][0-9][0-9][-][0-9][0-9][0-9][0-9]'),
            'mobile_phone'=>$this->faker->regexify('[1-9][0-9][0-9][-][0-9][0-9][0-9][-][0-9][0-9][0-9][0-9]'),
            'position_id'=>$this->faker->randomElement([1,2,3,4,5,6,7,8,9,10,11]),
            'status'=>$this->faker->randomElement(['applicant', 'approved', 'active', 'accepted', 'abandoned', 'inactive']),
        ];
    }
}
