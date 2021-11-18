<?php

namespace App\Entity;

use App\Repository\ArticleRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ArticleRepository::class)
 */
class Article
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(
     *      message = "Ce champs ne peut pas rester vide"
     * )
     * @Assert\Length(
     *      min=2,
     *      max=255,
     *      minMessage="Le titre d'un article doit comporter au moins {{ limit }} caractères",
     *      maxMessage="Let titre d'un article doit comporter au plus {{ limit }} caractères"
     * )
     */
    private $titre;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(
     *      message = "Ce champs ne peut pas rester vide"
     * )
     * @Assert\Length(
     *      min=2,
     *      max=255,
     *      minMessage="Le contenu d'un article doit comporter au moins {{ limit }} caractères",
     *      maxMessage="Let contenu d'un article doit comporter au plus {{ limit }} caractères"
     * )
     */
    private $contenu;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_de_creation;

    /**
     * @ORM\Column(type="integer")
     */
    private $votes = 0;

    /**
     * @ORM\Column(type="integer")
     */
    private $votes_up = 0;

    /**
     * @ORM\Column(type="integer")
     */
    private $votes_down = 0;

    /**
     * @ORM\Column(type="integer")
     */
    private $votes_total = 0;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="articles")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank(
     *      message = "Ce champs ne peut pas rester vide"
     * )
     *
     */
    private $category;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getContenu(): ?string
    {
        return $this->contenu;
    }

    public function setContenu(string $contenu): self
    {
        $this->contenu = $contenu;

        return $this;
    }

    public function getDateDeCreation(): ?DateTime
    {
        return $this->date_de_creation;
    }

    public function setDateDeCreation(DateTime $date_de_creation): self
    {
        $this->date_de_creation = $date_de_creation;

        return $this;
    }

    public function getVotes(): ?int
    {
        return $this->votes;
    }

    public function setVotes(int $votes): self
    {
        $this->votes = $votes;

        return $this;
    }

    
    

    public function getVotesUp(): ?int
    {
        return $this->votes_up;
    }

    public function setVotesUp(int $votes_up): self
    {
        $this->votes_up = $votes_up;

        return $this;
    }

    public function getVotesDown(): ?int
    {
        return $this->votes_down;
    }

    public function setVotesDown(int $votes_down): self
    {
        $this->votes_down = $votes_down;

        return $this;
    }

    public function getVotesTotal(): ?int
    {
        return $this->votes_total;
    }

    public function setVotesTotal(int $votes_total): self
    {
        $this->votes_total = $votes_total;

        return $this;
    }

    //Votes String
    public function getVotesString(): string 
    {
        $prefix = $this -> getVotes() >= 0 ? "+" : "-";
        return $prefix." ".abs($this -> getVotes());
    }

    //up / down vote
    //diff votes
    public function upVote()
    {
        return $this -> setVotes($this -> getVotes() + 1);
    }
    public function downVote()
    {
        return $this -> setVotes($this -> getVotes() - 1);
    }
    //nombre votes up
    public function nombreVotesUp()
    {
        return $this -> setVotesUp($this -> getVotesUp() + 1);
    }
    public function nombreVotesDown()
    {
        return $this -> setVotesDown($this -> getVotesDown() + 1);
    }
    //nombre votes total
    public function nombreVotesTotal()
    {
        return $this -> setVotesTotal($this -> getVotesTotal() + 1);
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
}
