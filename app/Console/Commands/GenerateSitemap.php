<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
use App\Models\Post;
use App\Models\Book;

class GenerateSitemap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sitemap:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate the sitemap.xml file';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Generating sitemap...');

        $sitemap = Sitemap::create()
            ->add(Url::create('/'))
            ->add(Url::create('/blog'))
            ->add(Url::create('/testimonials'))
            ->add(Url::create('/books'))
            ->add(Url::create('/alumni'))
            ->add(Url::create('/contact'))
            ->add(Url::create('/faq'))
            ->add(Url::create('/daftar'))
            ->add(Url::create('/programs-test'));

        // Add Blog Posts
        $posts = Post::where('status', 'published')->get();
        foreach ($posts as $post) {
            $sitemap->add(Url::create("/blog/{$post->slug}")
                ->setLastModificationDate($post->updated_at));
        }

        // Add Books
        $books = Book::all();
        foreach ($books as $book) {
            $sitemap->add(Url::create("/books/{$book->id}")
                ->setLastModificationDate($book->updated_at));
        }

        $sitemap->writeToFile(public_path('sitemap.xml'));

        $this->info('Sitemap generated successfully at public/sitemap.xml');
    }
}
