<?php

namespace Database\Factories;

use App\Models\Post;
use Encore\Admin\Grid\Displayers\Upload;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;
use App\Models\User;
use Illuminate\http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class PostFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Post::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        //// UploadedFile
        //$fileName = date('YmdHis') . '_test.jpg';
        ////$fileName = '_test.jpg';
        //$file = UploadedFile::fake()->image($fileName);
        //File::move($file, storage_path('app/public/images/posts/' . $fileName));

        //Faker
        $file = $this->faker->image();
        $fileName = basename($file);
        File::move($file, storage_path('app/public/images/posts/' . $fileName));

        //ファイルアップロードでのやり方
        //Storage::putFileAs('images/posts',$file,$fileName);
        //File::delete($file);

        return [
            'title' => $this->faker->word(),
            'body' => $this->faker->paragraph(),
            'image' => $fileName,
            'user_id' => Arr::random(Arr::pluck(User::all(), 'id')),
        ];
    }
}

