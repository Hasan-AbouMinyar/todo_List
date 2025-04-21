<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| هذا الملف يستخدم لتعريف مسارات (Routes) الـ API.
| أي Route هنا يتم الوصول له عبر الرابط الذي يبدأ بـ /api
| مثلاً: http://localhost:8000/api/tasks
|
*/

// المسار الرئيسي لتعامل مع CRUD للمهام

Route::get('/tasks', [TaskController::class, 'index']); // ✅ عرض المهام
Route::post('/tasks', [TaskController::class, 'store']); // ➕ إضافة مهمة

Route::apiResource('tasks', TaskController::class);
