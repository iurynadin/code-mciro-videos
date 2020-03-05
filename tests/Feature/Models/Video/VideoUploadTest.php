<?php

namespace Tests\Feature\Models\Video;

use App\Models\Genre;
use App\Models\Video;
use App\Models\Category;
use Illuminate\Http\UploadedFile;
use Tests\Exceptions\TestException;
use Illuminate\Database\QueryException;
use Illuminate\Database\Events\TransactionCommitted;

class VideoUploadTest extends BaseVideoTestCase
{

    public function testCreateWithFiles()
    {
        \Storage::fake();
        $video = Video::create(
            $this->data + [
                'thumb_file' => UploadedFile::fake()->image('thumb.jpg'),
                'video_file' => UploadedFile::fake()->image('video.mp4'),
            ]
        );
        \Storage::assertExists("{$video->id}/{$video->thumb_file}");
        \Storage::assertExists("{$video->id}/{$video->video_file}");
    }

    public function testCreateIfRollbackFiles()
    {
        \Storage::fake();
        \Event::listen(TransactionCommitted::class, function() {
            throw new TestException();
        });
        $hasError = false;

        try{
            Video::create(
                $this->data + [
                    'video_file' => UploadedFile::fake()->image('video.mp4'),
                    'thumb_file' => UploadedFile::fake()->image('thumb.jpg')
                ]
            );
        } catch (TestException $e){
            $this->assertCount(0, \Storage::allFiles());
            $hasError = true;
        }

        // dd($hasError);

        $this->assertTrue($hasError);
    }

    public function testUpdateWithFiles()
    {
        \Storage::fake();
        $video = factory(Video::class)->create();
        $thumbFile = UploadedFile::fake()->image('thumb.jpg');
        $videoFile = UploadedFile::fake()->image('video.mp4');
        $video->update($this->data + [
            'video_file' => $videoFile,
        ]);
        \Storage::assertExists("{$video->id}/{$video->thumb_file}");
        \Storage::assertExists("{$video->id}/{$video->video_file}");


        $newVideoFile = UploadedFile::fake()->image('video.mp4');
        $video->update($this->data + [
            'video_file' => $newVideoFile,
        ]);

        dd($thumbFile->hashName());
        \Storage::assertExists("{$video->id}/{$newVideoFile->hashName()}");
        // \Storage::assertExists("{$video->id}/{$thumbFile->hashName()}");
        \Storage::assertMissing("{$video->id}/{$videoFile->hashName()}");
    }

    public function testUpdateIfRollbackFiles()
    {
        \Storage::fake();
        $video = factory(Video::class)->create();
        \Event::listen(TransactionCommitted::class, function () {
            throw new TestException();
        });
        $hasError = false;

        try {
            $video->update(
                $this->data + [
                    'video_file' => UploadedFile::fake()->create('video.mp4'),
                    'thumb_file' => UploadedFile::fake()->create('thumb.jpg')
                ]
            );
        } catch (TestException $e) {
            $this->assertCount(0, \Storage::allFiles());
            $hasError = true;
        }

        $this->assertTrue($hasError);
    }

}