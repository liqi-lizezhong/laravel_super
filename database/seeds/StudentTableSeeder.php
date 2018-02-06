<?php

use Illuminate\Database\Seeder;

class StudentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //可以使用任何你想插入的数据
        //1·查询构造器添加
                DB::table('students')->insert([
                    ['name'=>'sean','age' =>'18'],
                    ['name'=>'LZZ','age' =>'18'],
                ]);
        //2·批量填充  只需要在DatabaseSeeder.php中执行即可。

    }
}
