<?php

namespace Success\CategoryBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;

/**
 * @Gedmo\Tree(type="nested")
 * @ORM\Table(name="success_categories")
 * @ORM\Entity(repositoryClass="Success\CategoryBundle\Entity\Repository\CategoryRepository")
 * @Gedmo\TranslationEntity(class="Success\CategoryBundle\Entity\CategoryTranslation")
 */
class Category {

  /**
   * @ORM\Column(type="integer")
   * @ORM\Id
   * @ORM\GeneratedValue
   */
  private $id;

  /**
   * @Gedmo\Translatable
   * @ORM\Column(length=64)
   */
  private $title;

  /**
   * @Gedmo\Translatable
   * @ORM\Column(type="text", nullable=true)
   */
  private $description;

  /**
   * @Gedmo\Translatable
   * @Gedmo\Slug(fields={"title"})
   * @ORM\Column(length=64, unique=true)
   */
  private $slug;

  /**
   * @Gedmo\TreeLeft
   * @ORM\Column(type="integer")
   */
  private $lft;

  /**
   * @Gedmo\TreeRight
   * @ORM\Column(type="integer")
   */
  private $rgt;

  /**
   * @Gedmo\TreeParent
   * @ORM\ManyToOne(targetEntity="Category", inversedBy="children")
   * @ORM\JoinColumn(name="parent_id", referencedColumnName="id", onDelete="SET NULL")
   */
  private $parent;

  /**
   * @Gedmo\TreeRoot
   * @ORM\Column(type="integer", nullable=true)
   */
  private $root;

  /**
   * @Gedmo\TreeLevel
   * @ORM\Column(name="lvl", type="integer")
   */
  private $level;

  /**
   * @ORM\OneToMany(targetEntity="Category", mappedBy="parent")
   */
  private $children;

  /**
   * @ORM\Column(name="position", type="integer", nullable=true)
   */
  private $position;

  /**
   * @Gedmo\Timestampable(on="create")
   * @ORM\Column(type="datetime")
   */
  private $created;

  /**
   * @Gedmo\Timestampable(on="update")
   * @ORM\Column(type="datetime")
   */
  private $updated;

  /**
   * @ORM\OneToMany(
   *   targetEntity="CategoryTranslation",
   *   mappedBy="object",
   *   cascade={"persist", "remove"}
   * )
   */
  private $translations;

  public function __construct() {
    $this->children = new ArrayCollection();
    $this->translations = new ArrayCollection();
  }

  public function getTranslations() {
    return $this->translations;
  }

  public function setTranslations($translations) {
    foreach ($translations as $translation) {
      $translation->setObject($this);
    }

    $this->translations = $translations;
    return $this;
  }

  public function getSlug() {
    return $this->slug;
  }

  public function getId() {
    return $this->id;
  }

  public function setTitle($title) {
    $this->title = $title;
  }

  public function getTitle() {
    return $this->title;
  }

  public function setDescription($description) {
    $this->description = $description;
  }

  public function getDescription() {
    return $this->description;
  }

  public function setParent($parent) {
    $this->parent = $parent;
  }

  public function getParent() {
    return $this->parent;
  }

  public function getRoot() {
    return $this->root;
  }

  public function getLevel() {
    return $this->level;
  }

  public function getChildren() {
    return $this->children;
  }

  public function getLeft() {
    return $this->lft;
  }

  public function getRight() {
    return $this->rgt;
  }

  public function getCreated() {
    return $this->created;
  }

  public function getUpdated() {
    return $this->updated;
  }

  public function __toString() {
    return (string)$this->getTitle();
  }


    /**
     * Set slug
     *
     * @param string $slug
     * @return Category
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
    
        return $this;
    }

    /**
     * Set root
     *
     * @param integer $root
     * @return Category
     */
    public function setRoot($root)
    {
        $this->root = $root;
    
        return $this;
    }

    /**
     * Set level
     *
     * @param integer $level
     * @return Category
     */
    public function setLevel($level)
    {
        $this->level = $level;
    
        return $this;
    }

    /**
     * Set position
     *
     * @param integer $position
     * @return Category
     */
    public function setPosition($position)
    {
        $this->position = $position;
    
        return $this;
    }

    /**
     * Get position
     *
     * @return integer 
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return Category
     */
    public function setCreated($created)
    {
        $this->created = $created;
    
        return $this;
    }

    /**
     * Set updated
     *
     * @param \DateTime $updated
     * @return Category
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;
    
        return $this;
    }

    /**
     * Add children
     *
     * @param \Success\CategoryBundle\Entity\Category $children
     * @return Category
     */
    public function addChildren(\Success\CategoryBundle\Entity\Category $children)
    {
        $this->children[] = $children;
    
        return $this;
    }

    /**
     * Remove children
     *
     * @param \Success\CategoryBundle\Entity\Category $children
     */
    public function removeChildren(\Success\CategoryBundle\Entity\Category $children)
    {
        $this->children->removeElement($children);
    }

    /**
     * Add translations
     *
     * @param \Success\CategoryBundle\Entity\CategoryTranslation $translations
     * @return Category
     */
    public function addTranslation(\Success\CategoryBundle\Entity\CategoryTranslation $translations)
    {
        $this->translations[] = $translations;
    
        return $this;
    }

    /**
     * Remove translations
     *
     * @param \Success\CategoryBundle\Entity\CategoryTranslation $translations
     */
    public function removeTranslation(\Success\CategoryBundle\Entity\CategoryTranslation $translations)
    {
        $this->translations->removeElement($translations);
    }
    
    public function getIndentedTitle()
    {
        return str_repeat(
            html_entity_decode('-', ENT_QUOTES, 'UTF-8'),
            ($this->getLevel()) * 2
        ) . ' ' . $this->getTitle();
    }
}