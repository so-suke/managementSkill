<?php

use Illuminate\Http\Request;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/getSkills', 'API\SkillController@getSkills');
Route::get('/getEmails', 'API\EmployeeController@getEmails');
Route::post('/isUniqEmail', 'API\EmployeeController@isUniqEmail');

// Route::post('/login', 'AuthController@login');

// Route::group(['middleware' => 'auth:api'], function () {
//     Route::get('/me', 'AuthController@me');
//     Route::post('/logout', 'AuthController@logout');
// });

Route::group(["middleware" => "guest:api"], function () {
    Route::post("login", "API\AuthController@login");
});

Route::group(["middleware" => "auth:api"], function () {
    Route::post('logout', 'API\AuthController@logout');
    Route::post('refresh', 'API\AuthController@refresh');
    Route::post('me', 'API\AuthController@me');
});

Route::apiResource('jobTitles', 'API\JobTitleController');
Route::apiResource('employees', 'API\EmployeeController');
Route::apiResource('languages', 'API\LanguageController');
Route::apiResource('frameworks', 'API\FrameworkController');
Route::apiResource('otherTools', 'API\OtherToolController');
Route::apiResource('experiencePeriods', 'API\ExperiencePeriodController');
Route::apiResource('languageExperiences', 'API\LanguageExperienceController');
Route::apiResource('frameworkExperiences', 'API\FrameworkExperienceController');
Route::apiResource('otherToolExperiences', 'API\OtherToolExperienceController');
// Route::apiResource('otherTools', 'API\FrameworkExperienceController');
// Route::apiResource('otherTools', 'API\OtherToolExperienceController');
