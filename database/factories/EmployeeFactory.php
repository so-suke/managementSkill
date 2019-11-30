<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Employee;
use App\JobTitle;
use Faker\Generator as Faker;

$jobTitles = JobTitle::get();

$last_names = [
    ['chinese' => '佐藤', 'kana' => 'サトウ'],
    ['chinese' => '鈴木', 'kana' => 'スズキ'],
    ['chinese' => '高橋', 'kana' => 'タカハシ'],
    ['chinese' => '田中', 'kana' => 'タナカ'],
    ['chinese' => '渡辺', 'kana' => 'ワタナベ'],
    ['chinese' => '伊藤', 'kana' => 'イトウ'],
    ['chinese' => '山本', 'kana' => 'ヤマモト'],
    ['chinese' => '中村', 'kana' => 'ナカムラ'],
];

$first_names = [
    ['chinese' => '実', 'kana' => 'ミノル', 'gender' => 'male', 'image' => 'male_0.png'],
    ['chinese' => '真一', 'kana' => 'シンイチ', 'gender' => 'male', 'image' => 'male_1.png'],
    ['chinese' => '浩二', 'kana' => 'コウジ', 'gender' => 'male', 'image' => 'male_2.png'],
    ['chinese' => '学', 'kana' => 'マナブ', 'gender' => 'male', 'image' => 'male_3.png'],
    ['chinese' => '浩之', 'kana' => 'ヒロユキ', 'gender' => 'male', 'image' => 'male_4.png'],
    ['chinese' => '久美子', 'kana' => 'クミコ', 'gender' => 'female', 'image' => 'female_0.png'],
    ['chinese' => '啓子', 'kana' => 'ケイコ', 'gender' => 'female', 'image' => 'female_1.png'],
    ['chinese' => '恵美子', 'kana' => 'エミコ', 'gender' => 'female', 'image' => 'female_2.png'],
    ['chinese' => '絵美', 'kana' => 'エミ', 'gender' => 'female', 'image' => 'female_3.png'],
    ['chinese' => '悦子', 'kana' => 'エツコ', 'gender' => 'female', 'image' => 'female_4.png'],
    ['chinese' => '節子', 'kana' => 'セツコ', 'gender' => 'female', 'image' => 'female_5.png'],
    ['chinese' => '美加子', 'kana' => 'ミカコ', 'gender' => 'female', 'image' => 'female_6.png'],
];

$factory->define(Employee::class, function (Faker $faker) use ($jobTitles, $last_names, $first_names) {
    $jobTitle = $jobTitles->random();
    $last_name = $last_names[array_rand($last_names)];
    $first_name = $first_names[array_rand($first_names)];

    return [
        'is_admin' => rand(0, 1),
        'job_title_id' => $jobTitle->id,
        'last_name' => $last_name['chinese'],
        'first_name' => $first_name['chinese'],
        'last_name_kana' => $last_name['kana'],
        'first_name_kana' => $first_name['kana'],
        'profile_image_path' => '/images/' . $first_name['image'],
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        // 'password' => bcrypt($faker->password(6, 10)),
        'password' => bcrypt('password'),
        'gender' => $first_name['gender'],
        'hired_at' => $faker->dateTimeBetween('-3 years', 'now')->format("Y-m-d"),
        'birth_at' => $faker->dateTimeBetween('-35 years', '-24 years')->format("Y-m-d"),
        'remarks' => '',
        'remember_token' => Str::random(10),
    ];
});
