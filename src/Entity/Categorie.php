<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CategorieRepository")
 */
class Categorie
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\BlogSpot", mappedBy="categorie")
     */
    private $blogspot_id;

    public function __construct()
    {
        $this->blogspot_id = new ArrayCollection();
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

    /**
     * @return Collection|BlogSpot[]
     */
    public function getBlogspotId(): Collection
    {
        return $this->blogspot_id;
    }

    public function addBlogspotId(BlogSpot $blogspotId): self
    {
        if (!$this->blogspot_id->contains($blogspotId)) {
            $this->blogspot_id[] = $blogspotId;
            $blogspotId->setCategorie($this);
        }

        return $this;
    }

    public function removeBlogspotId(BlogSpot $blogspotId): self
    {
        if ($this->blogspot_id->contains($blogspotId)) {
            $this->blogspot_id->removeElement($blogspotId);
            // set the owning side to null (unless already changed)
            if ($blogspotId->getCategorie() === $this) {
                $blogspotId->setCategorie(null);
            }
        }

        return $this;
    }

    public function __toString(){
        return $this->name;
    }
}
