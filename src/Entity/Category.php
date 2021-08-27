<?php

namespace App\Entity;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\CategoryRepository;
use App\Controller\CategoryImageController;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
/**
 * @UniqueEntity("name", message="Ce nom est déjà utilisé")
 * @Vich\Uploadable()
 * @ApiResource(normalizationContext={"groups"={"read:categories"}}, denormalizationContext={"groups"={"write:categories"}}, 
 * paginationEnabled=false,
 * itemOperations= {
    * "get" = {
    * "normalization_context" = {"groups"={"read:category"}, "openapi_definition_name"="Details"}
    * },
    * "put",
    * "image" = {
                    * "method" = "POST",
                    * "path" = "/categories/{id}/image ",
                    * "controller"=CategoryImageController::class,
                    * "deserialize"= false,
                    * "openapi_context"= {
                    *      "summary"="posts an image and links it to a category",
                    *      "requestBody"= {
                    *              "content"= {
                    *                  "multipart/form-data" = {
                    *                      "schema" = {
                    *                          "type" = "object", 
                    *                          "properties"= {
                    *                              "file"= {"type"="string", "format"="binary"}
                    *                           }
                    *                       }
                    *                       }
                    *                  }
                            *  }
                    *     }
     *  }
*  }
    
 
 * )
 * @ApiFilter(SearchFilter::class, properties= {
 * "id"="exact", "name"= "partial"
 * })
 * @ApiFilter(
 * OrderFilter::class, properties={
 * "id", "name"="asc"}, arguments={"orderParameterName"="order"})
 * 
 * @ORM\Entity(repositoryClass=CategoryRepository::class)
 */
class Category
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"read:ingredients", "read:category", "read:categories"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"read:ingredients", "read:category", "read:categories", "write:categories"})
     * @Assert\Length(     
     *      min = 2,
     *      minMessage = "Le nom doit faire moins de {{ limit }} caractères.")
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"read:ingredients", "read:category", "read:categories"})
     */
    private $picture;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"read:ingredients", "read:category", "read:categories"})
     */
    private $slug;

    /**
     * @ORM\OneToMany(targetEntity=Ingredient::class, mappedBy="category")
     * @Groups({"read:category"})
     */
    private $ingredients;

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
     * @Vich\UploadableField(mapping="category_image", fileNameProperty="picture")
     */
    private $imageFile;

    /**
     * @var string|null
     * @Groups({"read:ingredients", "read:category", "read:categories"})
     */
    private $imageUrl;


    public function __construct()
    {
        $this->ingredients = new ArrayCollection();
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

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(?string $picture): self
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

    /**
     * @return Collection|Ingredient[]
     */
    public function getIngredients(): Collection
    {
        return $this->ingredients;
    }

    public function addIngredient(Ingredient $ingredient): self
    {
        if (!$this->ingredients->contains($ingredient)) {
            $this->ingredients[] = $ingredient;
            $ingredient->setCategory($this);
        }

        return $this;
    }

    public function removeIngredient(Ingredient $ingredient): self
    {
        if ($this->ingredients->removeElement($ingredient)) {
            // set the owning side to null (unless already changed)
            if ($ingredient->getCategory() === $this) {
                $ingredient->setCategory(null);
            }
        }

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
     * @return Category
     */
    public function setImageFile(File $file) : Category
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
     * @return Category
     */
    public function setImageUrl(string $url) : Category
    {
        $this->imageUrl = $url;
        return $this;
    }
}
