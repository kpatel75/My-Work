<?php

namespace Database\Factories;

use App\Models\MemberActivity;
use App\Models\UserRole; 
use App\Models\Member;
use App\Models\TypeOfActivity;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\Factory;

class MemberActivityFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = MemberActivity::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {   
        $user = UserRole::WhereIn('role_id', [6, 7, 8])->pluck('user_id')->toArray();  
        $member = Member::WhereIn('id', [1, 2, 3, 4, 5, 6, 7, 8])->pluck('id')->toArray(); 
        $activity = DB::table('activity_categories')->pluck('id')->toArray();
        return [
            // 
            'memberid'=>$this->faker->randomElement($member), 
            'advisorid'=>$this->faker->randomElement($user), 
            'type_of_activityid'=>$this->faker->randomElement($activity),
            'note'=>$this->faker->regexify('[A-Za-z0-9]{20}'), 
            'date'=>$this->faker->dateTimeBetween('-5 years'), 
        ];
    }
}
