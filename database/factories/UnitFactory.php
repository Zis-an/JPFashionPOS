<?php

//namespace Database\Factories;
//
//use App\Models\Unit;
//use Illuminate\Database\Eloquent\Factories\Factory;
//
///**
// * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Unit>
// */
//class UnitFactory extends Factory
//{
//    protected $model = Unit::class;
//
//    public function definition()
//    {
//        // Initialize a variable to hold the generated code
//        $code = '';
//        $sl = 0;
//
//        // Ensure uniqueness with a do-while loop for the 'code' column
//        do {
//            if ($sl) {
//                $code = $this->faker->word . $sl;  // Append a number if it already exists
//            } else {
//                $code = $this->faker->word;  // Generate a random word
//            }
//            $sl++;
//        } while (Unit::where('code', $code)->exists());  // Check if 'code' exists
//
//        return [
//            'code' => $code,  // Generate a unique code
//            'name' => $this->faker->word,  // Generate a random name
//        ];
//    }
//}

namespace Database\Factories;

use App\Models\Unit;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Unit>
 */
class UnitFactory extends Factory
{
    protected $model = Unit::class;

    public function definition()
    {
        return [
            'code' => $this->faker->unique()->uuid,  // Ensure the code is unique
            'name' => $this->faker->word,  // Generate a random name
        ];
    }
}
