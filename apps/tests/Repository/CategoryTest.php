<?php

namespace Labstag\Tests\Repository;

use Doctrine\ORM\QueryBuilder;
use Labstag\Entity\Category;
use Labstag\Lib\RepositoryTestLib;
use Labstag\Repository\CategoryRepository;

/**
 * @internal
 * @coversNothing
 */
class CategoryTest extends RepositoryTestLib
{

    /**
     * @var CategoryRepository
     */
    private $repository;

    public function setUp(): void
    {
        parent::setUp();
        /** @var CategoryRepository $repository */
        $repository       = $this->entityManager->getRepository(
            Category::class
        );
        $this->repository = $repository;
    }

    public function testFindAll(): void
    {
        $all = $this->repository->findAll();
        $this->assertTrue(is_array($all));
    }

    public function testfindOneRandom(): void
    {
        $all = $this->repository->findAll();
        if (0 != count($all)) {
            $random = $this->repository->findOneRandom();
            $this->assertSame(get_class($random), Category::class);

            return;
        }

        $this->assertTrue(true);
    }

    public function testfindForForm(): void
    {
        $entities = $this->repository->findForForm();
        $this->assertSame(get_class($entities), QueryBuilder::class);
    }
}
