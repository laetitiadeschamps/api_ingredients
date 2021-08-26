<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\Controller\ImageController;
use App\Repository\IngredientRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\Valid;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @UniqueEntity("name", message="Ce nom est déjà utilisé")
 * @Vich\Uploadable()
 * @ApiResource(
    * normalizationContext={"groups"={"read:ingredients"}, "openapi_definition_name"="Liste des ingredients"}, 
    * denormalizationContext={"groups"={"write:ingredients"}, "openapi_definition_name"="Ecriture des ingredients"},
    * paginationItemsPerPage= 100,
    * paginationMaximumItemsPerPage= 100,
    * paginationClientItemsPerPage= true,
    * itemOperations = {
        * "get",
        * "put",
        * "delete",
        * "patch",
        * "image" = {
                * "method" = "POST",
                * "path" = "/ingredients/{id}/image ",
                * "controller"=ImageController::class,
                * "deserialize"= false,
                * "openapi_context"= {
                *      "summary"="Adds an image to an ingredient",
                *      "requestBody"= {
                *              "content"= {
                *                  "multipart/form-data" = {
                *                      "schema" = {
                *                          "type" = "object", 
                *                          "properties"= {
                *                              "file"= {"type"="string", "format"="binary"}
                *                          }
                *                       }
                *                    }
                *                }
                *        }
                *  }
        * }
            
    * }
 * )
 * @ApiFilter(SearchFilter::class, properties= {
 * "id"="exact", "name"= "partial"
 * })
 * @ApiFilter(
 * OrderFilter::class, properties={
 * "id", "name"="asc"}, arguments={"orderParameterName"="order"})
 * 
 * @ORM\Entity(repositoryClass=IngredientRepository::class)
 */
class Ingredient
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"read:ingredients", "read:category"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"read:ingredients", "write:ingredients", "read:category"})
     * @Assert\Length(     
     *      min = 2,
     *      minMessage = "Le nom doit faire moins de {{ limit }} caractères.")
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"read:ingredients", "write:ingredients", "read:category"})
     * @Assert\NotBlank(message="Une photo doit être renseignée.")
     */
    private $picture;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"read:ingredients", "read:category", "write:ingredients"})
     */
    private $slug;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="ingredients", cascade={"persist"})
     * @Groups({"read:ingredients", "write:ingredients"})
     * @Valid()
     */
    private $category;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updated_at;

    /**
     * @var File|null
     * @Vich\UploadableField(mapping="ingredient_image", fileNameProperty="picture")
     */
    private $imageFile;

    /**
     * @var string|null
     * @Groups({"read:ingredients", "write:ingredients", "read:category"})
     */
    private $imageUrl;

    public function __construct()
    {
        $this->created_at = new DateTime();
        $this->updated_at = new DateTime();
       
    }

    public function getId(): ?int
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

    public function getPicture()
    {
        return $this->picture;
    }

    public function setPicture($picture): self
    {
        $this->picture = $picture;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTimeInterface $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    /**
     * @return File|null
     */
    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    /**
     * @param File $file
     * @return Ingredient
     */
    public function setImageFile(File $file) : Ingredient
    {
        $this->imageFile = $file;
        return $this;
    }
    /**
     * @return string|null
     */
    public function getImageUrl(): ?string
    {
        return $this->imageUrl;
    }

    /**
     * @param string $url
     * @return Ingredient
     */
    public function setImageUrl(string $url) : Ingredient
    {
        $this->imageUrl = $url;
        return $this;
    }
   
}
