<?php

use Illuminate\Database\Seeder;

class TasksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create('ne_NP');

        for ($i=0; $i<100; $i++)
        {
            $date = \Carbon\Carbon::now();
            $flag = $faker->randomElement([0,1,-1]);

            if($flag == 0){
                $date = $date->format('Y-m-d');
            }elseif($flag == 1){
                $date = $date->addDays($faker->numberBetween(1,25))->format('Y-m-d');
            }else{
                $date = $date->subDays($faker->numberBetween(1,25))->format('Y-m-d');
            }

            $task = new \App\Task();
            $task->title = $faker->sentence;
            $task->date = $date;
            $task->is_completed = $faker->randomElement([true, false]);
            $task->save();
        }
    }
}
