<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Post;
use App\Repository\TagsRepository;
use App\Repository\UserRepository;
use App\Repository\CategoryRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class PostFixtures extends Fixture implements DependentFixtureInterface
{

    public function __construct(
        UserRepository $userRepository,
        CategoryRepository $categoryRepository,
        TagsRepository $tagsRepository
    ) {
        $this->userRepository     = $userRepository;
        $this->categoryRepository = $categoryRepository;
        $this->tagsRepository     = $tagsRepository;
    }

    public function load(ObjectManager $manager)
    {
        $users      = $this->userRepository->findAll();
        $categories = $this->categoryRepository->findAll();
        $tags       = $this->tagsRepository->findAll();
        $faker      = Factory::create('fr_FR');
        for ($i = 0; $i < 10; ++$i) {
            $post = new Post();
            $post->setName($faker->unique()->text(255));
            $post->setContent($faker->unique()->paragraphs(4, true));
            $post->setRefuser($users[array_rand($users)]);
            $post->setRefcategory($categories[array_rand($categories)]);
            $nbr = rand(0, count($tags));
            if ($nbr !== 0) {
                $tabIndex = array_rand(
                    $tags,
                    $nbr
                );
                if (is_array($tabIndex)) {
                    foreach ($tabIndex as $j) {
                        $post->addTag($tags[$j]);
                    }
                }else{
                    $post->addTag($tags[$tabIndex]);
                }
            }
            
            $addImage = rand(0, 1);
            if ($addImage === 1) {
                $image   = $faker->unique()->imageUrl;
                $content = file_get_contents($image);
                $tmpfile = tmpfile();
                $data = stream_get_meta_data($tmpfile);
                file_put_contents($data['uri'], $content);
                $file = new UploadedFile(
                    $data['uri'],
                    'image.jpg',
                    filesize($data['uri']),
                    null,
                    true
                );

                $post->setImageFile($file);
            }

            $manager->persist($post);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
        TagsFixtures::class,
        CategoryFixtures::class,
        UserFixtures::class,
        );
    }
}