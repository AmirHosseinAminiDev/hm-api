<?php

use App\Http\Controllers\AnswerController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\HomePageController;
use App\Http\Controllers\SingleQuestion;
use App\Http\Controllers\VoteController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
//=============
//HOMEPAGE APIS
//=============
Route::get('/home-page', [HomePageController::class, 'index']);
Route::get('/most-liked-questions', [HomePageController::class, 'mostLikedQuestions']);
Route::get('/most-view-questions', [HomePageController::class, 'getMostViewedQuestions']);
Route::get('/get-active-users', [HomePageController::class, 'getActiveUsers']);
Route::get('/get-statistics', [HomePageController::class, 'getStatistics']);
//=============
//QUESTION APIS
//=============
Route::prefix('/questions/question')->group(function () {
    Route::get('{slug}', [SingleQuestion::class, 'getSingleQuestion']);
    Route::post('create', [SingleQuestion::class, 'createQuestion']);
    Route::delete('delete/{slug}', [SingleQuestion::class, 'deleteSingleQuestion']);
    Route::post('/{slug}', [SingleQuestion::class, 'updateSingleQuestion']);
    Route::post('/pin/{slug}', [SingleQuestion::class, 'pinSingleQuestion']);
    Route::post('/unpin/{slug}', [SingleQuestion::class, 'unpinSingleQuestion']);
});
//=============
//COMMENT APIS
//=============
Route::prefix('/questions/comment')->group(function () {
    Route::get('/{id}', [CommentController::class, 'getSpecificComment']);
    Route::post('create', [CommentController::class, 'createComment']);
    Route::post('update/{id}', [CommentController::class, 'updateComment']);
    Route::delete('delete/{id}', [CommentController::class, 'deleteComment']);
});
//=============
//ANSWERS APIS
//=============
Route::prefix('/questions/answer')->group(function () {
    Route::get('/{id}',[AnswerController::class,'getSpecificAnswer']);
    Route::post('/create', [AnswerController::class, 'createAnswer']);
    Route::post('/update/{id}', [AnswerController::class, 'updateAnswer']);
    Route::post('/update-status/{id}', [AnswerController::class, 'updateAnswerStatus']);
    Route::delete('/delete/{id}', [AnswerController::class, 'deleteAnswer']);
});
//=============
//VOTES APIS
//=============
Route::prefix('/questions/vote')->group(function () {
    Route::post('/create', [VoteController::class, 'createVote']);
});
