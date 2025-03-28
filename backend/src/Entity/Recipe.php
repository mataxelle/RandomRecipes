<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\RecipeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource()]
#[ORM\Entity(repositoryClass: RecipeRepository::class)]
class Recipe
{
    use TimestampableEntity;
    
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["recipe:read"])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Groups(["recipe:read"])]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(["recipe:read"])]
    private ?string $image = null;

    #[ORM\ManyToOne(inversedBy: 'recipes')]
    #[Groups(["recipe:read"])]
    private ?Country $country = null;

    #[ORM\ManyToOne(inversedBy: 'recipes')]
    #[Groups(["recipe:read"])]
    private ?Category $category = null;

    #[ORM\ManyToOne(inversedBy: 'recipes')]
    #[Groups(["recipe:read"])]
    private ?Diet $diet = null;

    /**
     * @var Collection<int, Season>
     */
    #[ORM\ManyToMany(targetEntity: Season::class, inversedBy: 'recipes')]
    #[Groups(["recipe:read"])]
    private Collection $season;

    /**
     * @var Collection<int, Ingredient>
     */
    #[ORM\ManyToMany(targetEntity: Ingredient::class, inversedBy: 'recipes')]
    #[Groups(["recipe:read"])]
    private Collection $ingredients;

    /**
     * @var Collection<int, Step>
     */
    #[ORM\OneToMany(targetEntity: Step::class, mappedBy: 'recipe', orphanRemoval: true)]
    #[Groups(["recipe:read"])]
    private Collection $steps;

    public function __construct()
    {
        $this->season = new ArrayCollection();
        $this->ingredients = new ArrayCollection();
        $this->steps = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): static
    {
        $this->image = $image;

        return $this;
    }

    public function getCountry(): ?Country
    {
        return $this->country;
    }

    public function setCountry(?Country $country): static
    {
        $this->country = $country;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): static
    {
        $this->category = $category;

        return $this;
    }

    public function getDiet(): ?Diet
    {
        return $this->diet;
    }

    public function setDiet(?Diet $diet): static
    {
        $this->diet = $diet;

        return $this;
    }

    /**
     * @return Collection<int, Season>
     */
    public function getSeason(): Collection
    {
        return $this->season;
    }

    public function addSeason(Season $season): static
    {
        if (!$this->season->contains($season)) {
            $this->season->add($season);
        }

        return $this;
    }

    public function removeSeason(Season $season): static
    {
        $this->season->removeElement($season);

        return $this;
    }

    /**
     * @return Collection<int, Ingredient>
     */
    public function getIngredients(): Collection
    {
        return $this->ingredients;
    }

    public function addIngredient(Ingredient $ingredient): static
    {
        if (!$this->ingredients->contains($ingredient)) {
            $this->ingredients->add($ingredient);
        }

        return $this;
    }

    public function removeIngredient(Ingredient $ingredient): static
    {
        $this->ingredients->removeElement($ingredient);

        return $this;
    }

    /**
     * @return Collection<int, Step>
     */
    public function getSteps(): Collection
    {
        return $this->steps;
    }

    public function addStep(Step $step): static
    {
        if (!$this->steps->contains($step)) {
            $this->steps->add($step);
            $step->setRecipe($this);
        }

        return $this;
    }

    public function removeStep(Step $step): static
    {
        if ($this->steps->removeElement($step)) {
            // set the owning side to null (unless already changed)
            if ($step->getRecipe() === $this) {
                $step->setRecipe(null);
            }
        }

        return $this;
    }
}
