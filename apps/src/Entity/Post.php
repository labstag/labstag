<?php

namespace Labstag\Entity;

<<<<<<< HEAD
=======
use Labstag\CollectionResolver\TrashCollectionResolver;
>>>>>>> 70eef9d9de7dd17df3a3addf58c7c49623b0f58b
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use DateTime;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Blameable\Traits\BlameableEntity;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Gedmo\Translatable\Translatable;
use Labstag\Controller\Api\PostApi;
use Labstag\Entity\Traits\Tag;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ApiFilter(SearchFilter::class, properties={
 *     "id": "exact",
 *     "name": "partial",
 *     "content": "partial",
 *     "slug": "partial",
 *     "enable": "exact"
 * })
 * @ApiFilter(OrderFilter::class, properties={"id", "name"}, arguments={"orderParameterName": "order"})
 * @ApiResource(
<<<<<<< HEAD
 *     itemOperations={
 *         "get",
 *         "put",
 *         "delete",
 *         "api_posttrash": {
 *             "method": "GET",
 *             "path": "/posts/trash",
 *             "access_control": "is_granted('ROLE_SUPER_ADMIN')",
=======
 *     graphql={
 *       "trashCollection"={
 *            "collection_query"=TrashCollectionResolver::class
 *       }
 *     },
 *     itemOperations={
 *         "get": {
 *             "access_control": "is_granted('ROLE_ADMIN')"
 *          },
 *         "put": {
 *             "access_control": "is_granted('ROLE_ADMIN')"
 *          },
 *         "delete": {
 *             "access_control": "is_granted('ROLE_ADMIN')"
 *          },
 *         "api_posttrash": {
 *             "method": "GET",
 *             "path": "/posts/trash",
>>>>>>> 70eef9d9de7dd17df3a3addf58c7c49623b0f58b
 *             "controller": PostApi::class,
 *             "read": false,
 *             "swagger_context": {
 *                 "summary": "Corbeille",
 *                 "parameters": {}
 *             }
 *         },
 *         "api_posttrashdelete": {
 *             "method": "DELETE",
 *             "path": "/posts/trash",
<<<<<<< HEAD
 *             "access_control": "is_granted('ROLE_SUPER_ADMIN')",
=======
>>>>>>> 70eef9d9de7dd17df3a3addf58c7c49623b0f58b
 *             "controller": PostApi::class,
 *             "read": false,
 *             "swagger_context": {
 *                 "summary": "Remove",
 *                 "parameters": {}
 *             }
 *         },
 *         "api_postrestore": {
 *             "method": "POST",
 *             "path": "/posts/restore",
<<<<<<< HEAD
 *             "access_control": "is_granted('ROLE_SUPER_ADMIN')",
=======
>>>>>>> 70eef9d9de7dd17df3a3addf58c7c49623b0f58b
 *             "controller": PostApi::class,
 *             "read": false,
 *             "swagger_context": {
 *                 "summary": "Restore",
 *                 "parameters": {}
 *             }
 *         },
 *         "api_postempty": {
 *             "method": "POST",
 *             "path": "/posts/empty",
<<<<<<< HEAD
 *             "access_control": "is_granted('ROLE_SUPER_ADMIN')",
=======
>>>>>>> 70eef9d9de7dd17df3a3addf58c7c49623b0f58b
 *             "controller": PostApi::class,
 *             "read": false,
 *             "swagger_context": {
 *                 "summary": "Empty",
 *                 "parameters": {}
 *             }
 *         }
 *     }
 * )
 * @ORM\Entity(repositoryClass="Labstag\Repository\PostRepository")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 * @Gedmo\Loggable
 * @Vich\Uploadable
 */
class Post implements Translatable
{
    use BlameableEntity;
    use SoftDeleteableEntity;
    use TimestampableEntity;
    use Tag;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     * @ORM\Column(type="guid", unique=true)
     * @ApiProperty(iri="https://schema.org/identifier")
     *
     * @var string
     */
    private $id;

    /**
     * @Gedmo\Versioned
     * @ORM\Column(type="string", length=255, unique=true)
     *
     * @var string
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @var string|null
     */
    private $file;

    /**
     * @Vich\UploadableField(mapping="upload_file", fileNameProperty="file")
     * @Assert\File(mimeTypes={"image/*"})
     *
     * @var File|null
     */
    private $imageFile;

    /**
     * @Gedmo\Versioned
     * @ORM\Column(type="text")
     *
     * @var string
     */
    private $content;

    /**
     * @ORM\ManyToOne(targetEntity="Labstag\Entity\User", inversedBy="posts")
     *
     * @var User
     */
    private $refuser;

    /**
     * @ORM\ManyToOne(targetEntity="Labstag\Entity\Category", inversedBy="posts")
     * @ORM\JoinColumn(nullable=false)
     *
     * @var Category
     */
    private $refcategory;

    /**
     * @ORM\ManyToMany(targetEntity="Labstag\Entity\Tag", inversedBy="posts")
     */
    private $tags;

    /**
     * @Gedmo\Slug(fields={"name"})
     * @ORM\Column(type="string",   length=255, nullable=true)
     *
     * @var string|null
     */
    private $slug;

    /**
     * @ORM\Column(type="boolean", options={"default": true}))
     *
     * @var bool
     */
    private $enable;

    /**
     * @Gedmo\Locale
     * Used locale to override Translation listener`s locale
     * this is not a mapped field of entity metadata, just a simple property
     *
     * @var string
     */
    private $locale;

    public function __construct()
    {
        $this->enable = true;
        $this->tags   = new ArrayCollection();
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getFile(): ?string
    {
        return $this->file;
    }

    public function setFile(?string $file): self
    {
        $this->file = $file;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getRefuser(): ?User
    {
        return $this->refuser;
    }

    public function setRefuser(User $refuser): self
    {
        $this->refuser = $refuser;

        return $this;
    }

    public function getRefcategory(): ?Category
    {
        return $this->refcategory;
    }

    public function setRefcategory(Category $refcategory): self
    {
        $this->refcategory = $refcategory;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(?string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function setImageFile(File $image = null): self
    {
        $this->imageFile = $image;
        if ($image) {
            $dateTimeImmutable = new DateTimeImmutable();
            $dateTime          = new DateTime();
            $dateTime->setTimestamp($dateTimeImmutable->getTimestamp());
            $this->updatedAt = $dateTime;
        }

        return $this;
    }

    /**
     * @return File|null
     */
    public function getImageFile()
    {
        return $this->imageFile;
    }

    public function isEnable(): ?bool
    {
        return $this->enable;
    }

    public function setEnable(bool $enable): self
    {
        $this->enable = $enable;

        return $this;
    }

    public function setTranslatableLocale(string $locale): void
    {
        $this->locale = $locale;
    }
}
