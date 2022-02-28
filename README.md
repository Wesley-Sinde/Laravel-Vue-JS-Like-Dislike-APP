<p align="center"><a href="https://wesley.io.ke" target="_blank"><img src="https://laratutorials.com/wp-content/uploads/2022/02/Laravel-9-Vue-JS-Like-Dislike-Example-1024x499.jpg" width="400"></a></p>

# Laravel 9 Vue JS Like Dislike Example
Larave 9 vue js like dislike system example; Through this tutorial, i am going to show you how to make like dislike system with Vue js in laravel 9 apps.


# Laravel 9 Vue JS Like Dislike Example
Use the below given steps to make like and dislike system in laravel vue js apps:

Step 1: Install Laravel 9 App
Step 2: Configure App to Database
Step 3: Run Make auth Command
Step 4: Create Model And Migration
Step 5: NPM Configuration
Step 6: Add Routes
Step 7: Create Controller By Command
Step 8: Create Vue Component
Step 9: Create Blade Views And Initialize Vue Components
Step 10: Run Development Server

# Step 1: Install Laravel 9 App
Run the following command on command prompt to install laravel apps:
```php
 composer create-project --prefer-dist laravel/laravel blog 
 ```
# Step 2: Configure App to Database
Visit to project root directory and open .env file. Then set up database credential in .env file as follow:

```php
 DB_CONNECTION=mysql 
 DB_HOST=127.0.0.1 
 DB_PORT=3306 
 DB_DATABASE=here your database name here
 DB_USERNAME=here database username here
 DB_PASSWORD=here database password here
```
# Step 3: Run Make auth Command
Run the following commands on command prompt to make auth in laravel app:
```php
cd blog
composer require laravel/ui --dev
php artisan ui vue --auth
```
This laravel laravel/ui package provides a quick way to scaffold all of the routes, controller and views with authentication.

# Step 4: Create Model And Migration
Run the following command on command prompt to create model and factory:
```php

php artisan make:model Post -fm
```
This command will create one model name post.php and also create one migration file for the posts table.

Now open create_postss_table.php migration file from database>migrations and replace up() function with following code:
```php
<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::create('posts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->string('slug');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('like')->default(0);
            $table->unsignedBigInteger('dislike')->default(0);
            $table->timestamps();
      });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
```
Next, migrate the table using the below command:

```php
php artisan migrate
```
Visit to app/Models/Post.php and update the following code into your Post.php model as follow:
```php
<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Post extends Model
{
    use HasFactory;
    protected $fillable = [
        'title', 'description'
    ];
    public function getRouteKeyName()
    {
    	return 'slug';
    }
}
```
Visit to database/factories and open PostFactory.php. Then update the following code into it as follow:
```php
/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Models\Post;
use Faker\Generator as Faker;
$factory->define(Post::class, function (Faker $faker) {
    return [
       'title' => $faker->sentence,
       'slug' => \Str::slug($faker->sentence),
       'user_id' => 1
    ];
});
```
and then execute the following command on terminal to generate fake data using faker as follow:
```php
php artisan tinker
//and then
factory(\App\Models\Post::class,20)->create()
exit
```
# Step 5: NPM Configuration
Run the following command on command prompt to install Vue dependencies using NPM:
```php
composer require laravel/ui
php artisan ui laravel
```
Install all Vue dependencies:
```php
npm install
```
# Step 6: Add Routes
Visit to routes folder and open web.php file and add the following routes into your file:
```php
use App\Http\Controllers\PostController;
Route::get('post', [PostController::class, 'index']);
Route::get('post/{slug?}', [PostController::class, 'show'])->name('post');
Route::post('like', [PostController::class, 'getlike']);
Route::post('like/{id}', [PostController::class, 'like']);
Route::post('dislike', [PostController::class, 'getDislike']);
Route::post('dislike/{id}', [PostController::class, 'dislike']);
```
# Step 7: Create Controller By Command
Run the following command on command prompt to make a controller by an artisan:
```php
php artisan make:controller PostController
```
Visit to app\Http\Controllers and open PostController.php file. Then update the following code into your PostController.php file:
```php

<?php
namespace App\Http\Controllers;
use App\Models\Post;
use Facades\App\Repository\Posts;
use Illuminate\Http\Request;
class PostController extends Controller
{
    public function index()
    {
        $posts = Post::latest()->get();
        return view('posts',['posts' => $posts ]);
    }
    public function show(Post $slug)
    {
        return view('single-post',['post' => $slug ]);
    }
    public function getlike(Request $request)
    {
        $post = Post::find($request->post);
        return response()->json([
            'post'=>$post,
        ]);
    }
    public function like(Request $request)
    {
        $post = Post::find($request->post);
        $value = $post->like;
        $post->like = $value+1;
        $post->save();
        return response()->json([
            'message'=>'Thanks',
        ]);
    }    
    public function getDislike(Request $request)
    {
        $post = Post::find($request->post);
        return response()->json([
            'post'=>$post,
        ]);
    }
    public function dislike(Request $request)
    {
        $post = Post::find($request->post);
        $value = $post->dislike;
        $post->dislike = $value+1;
        $post->save();
        return response()->json([
            'message'=>'Thanks',
        ]);
    }
}
```
# Step 8: Create Vue Component
Visit to resources/assets/js/components folder and create a files called LikeComponent.vue and DisLikeComponent.vue.

Now, update the following code into your LikeComponent.vue components file:
```php
<template>
    <div class="container">
        <p id="success"></p>
       <a href="http://"><i @click.prevent="likePost" class="fa fa-thumbs-up" aria-hidden="true"></i>({{ totallike }})</a>
    </div>
</template>
<script>
    export default {
        props:['post'],
        data(){
            return {
                totallike:'',
            }
        },
        methods:{
            likePost(){
                axios.post('/like/'+this.post,{post:this.post})
                .then(response =>{
                    this.getlike()
                    $('#success').html(response.data.message)
                })
                .catch()
            },
            getlike(){
                axios.post('/like',{post:this.post})
                .then(response =>{
                    console.log(response.data.post.like)
                    this.totallike = response.data.post.like
                })
            }
        },
        mounted() {
            this.getlike()
        }
    }
</script> 
```
Next, update the following code into DisLikeComponent.vue file as follow:
```php

<template>
    <div class="container">
        <p id="success"></p>
       <a href="http://"><i @click.prevent="disLikePost" class="fa fa-thumbs-down" aria-hidden="true"></i>({{ totalDislike }})</a>
    </div>
</template>
<script>
    export default {
        props:['post'],
        data(){
            return {
                totalDislike:'',
            }
        },
        methods:{
            disLikePost(){
                axios.post('/dislike/'+this.post,{post:this.post})
                .then(response =>{
                    this.getDislike()
                    $('#success').html(response.data.message)
                })
                .catch()
            },
            getDislike(){
                axios.post('/dislike',{post:this.post})
                .then(response =>{
                    console.log(response.data.post.dislike)
                    this.totalDislike = response.data.post.dislike
                })
            }
        },
        mounted() {
            this.getDislike()
        }
    }
</script> 
```
Now open resources/assets/js/app.js and include the LikeComponent.vue and DisLikeComponent.vue component as follow:
```php
require('./bootstrap');
window.Vue = require('vue');
Vue.component('like-component', require('./components/LikeComponent.vue').default);
Vue.component('dis-like-component', require('./components/DisLikeComponent.vue'));
const app = new Vue({
    el: '#app',
});
```
# Step 9: Create Blade Views And Initialize Vue Components
Go to resources/views and create one folder named layouts. Inside this folder create one blade view file named app.blade.php file.

Go to resources/views/layouts and open app.blade.php file. Then update the following code into your app.blade.php file as follow:
```html
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Laravel 9 Vue JS Like Dislike Example - Laratutorials.com</title>
    <script src="{{ asset('js/app.js') }}" defer></script>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @stack('fontawesome')
</head>
<body>
    <div id="app">
        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>
 ```
Go to resources/views/ and create one file name posts.blade.php. Then update the following code into your posts.blade.php file as follow:
```php
@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Post Lists</div>
                <div class="card-body">
                    <ul>
                        @foreach ($posts as $item)
                         <a href="{{ route('post',$item->slug) }}"><li>{{ $item->title }}</li></a>
                        @endforeach
                    </ul>
                </div>
                
            </div>
        </div>
    </div>
</div>
@endsection 
```
Go to resources/views/ and create one file name single-post.blade.php. Then update the following code into your single-post.blade.php file as follow:
```php
@extends('layouts.app')
@push('fontawesome')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
@endpush
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Post Detail</div>
                <div class="card-body">
                    <ul>
                      
                         <li>{{ $post->title }}</li>
                         <like-component :post="{{ $post->id }}"></like-component>
                         <dis-like-component :post="{{ $post->id }}"></dis-like-component>
                         
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 
```
# Step 10: Run Development Server
Run the following command on terminal to start the development server:
```php
npm run dev
or 
npm run watch

php artisan serve
```
If you will expience while running the the above command please try running the following command
```php
npm update vue-loader
``
should do the work just fine if the vue-loader package is already installed.
# Conclusion
In this like dislike Vue js with laravel example tutorial, you have learned how to implement like dislike system with Vue js in laravel apps.