<?php

use App\Models\Genre;
use App\Models\Video;
use Illuminate\Database\Seeder;
use Illuminate\Http\UploadedFile;
use Illuminate\Database\Eloquent\Model;

class VideoTableSeeder extends Seeder
{

    private $allGenres;
    private $relations = [
        'genres_id' => [],
        'categories_id' => []
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $dir = \Storage::getDriver()->getAdapter()->getPathPrefix();
        \File::deleteDirectory($dir, true); //excluir o conteudo e manter o diretório

        $self = $this;
        $this->allGenres = Genre::all();
        Model::reguard(); //ativar o mass assignment, ja que a seeder nao tem 
        factory(\App\Models\Video::class, 100)
            ->make() //gera instância do vídeo
            ->each(function(Video $video) use ($self){
                $self->fetchRelations(); //método(abaixo) p atribui os relacionamentos
                \App\Models\Video::create(
                    array_merge(
                        $video->toArray(),
                        [
                            'thumb_file' => $self->getImageFile(),
                            'banner_file' => $self->getImageFile(),
                            'trailes_file' => $self->getVideoFile(),
                            'video_file' => $self->getVideoFile(),
                        ],
                        $this->relations
                    )
                );
                
            });
        Model::unguard();
    }

    public function fetchRelations()
    {
        $subGenres = $this->allGenres->random(5)->load('categories');
        $categoriesId = [];
        foreach ($subGenres as $genre) {
            array_push($categoriesId, ...$genre->categories->pluck('id')->toArray());
        }
        $categoriesId = array_unique($categoriesId);
        $genresId = $subGenres->pluck('id')->toArray();
        $this->relations['categories_id'] = $categoriesId;
        $this->relations['genres_id'] = $genresId;
    }

    public function getImageFile()
    {
        return new UploadedFile(
            storage_path('faker/thumbs/logo.png'), 'logo.png'
        );
    }

    public function getVideoFile()
    {
        return new UploadedFile(
            storage_path('faker/videos/1. Flash Chat.mp4'), '1. Flash Chat.mp4'
        );
    }
}
