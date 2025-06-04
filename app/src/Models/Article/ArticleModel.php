<?php
namespace App\Models\Article;

class ArticleModel extends ArticleManager
{

    protected int $id;
    protected string $title;
    protected string $slug;
    protected string $content;
    protected string $caption;
    protected int $author_id;
    protected $created_at;
    protected $updated_at;
    protected $image;

    protected $table = 'articles';
    protected $db;

    public function __construct()
    {}

    /**
     * Get the value of id
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Set the value of id
     */
    public function setId($id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of title
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * Set the value of title
     */
    public function setTitle($title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get the value of slug
     */
    public function getSlug(): string
    {
        return $this->slug;
    }

    /**
     * Set the value of slug
     */
    public function setSlug($slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get the value of content
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * Set the value of content
     */
    public function setContent($content): self
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get the value of caption
     */
    public function getCaption(): string
    {
        return $this->caption;
    }

    /**
     * Set the value of caption
     */
    public function setCaption($caption): self
    {
        $this->caption = $caption;

        return $this;
    }

    /**
     * Get the value of author_id
     */
    public function getAuthor_id(): int
    {
        return $this->author_id;
    }

    /**
     * Set the value of author_id
     */
    public function setAuthor_id($author_id): self
    {
        $this->author_id = $author_id;

        return $this;
    }

    /**
     * Get the value of created_at
     */
    public function getCreated_at(): string
    {
        return $this->created_at;
    }

    /**
     * Set the value of created_at
     */
    public function setCreated_at($created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    /**
     * Get the value of updated_at
     */
    public function getUpdated_at():? string
    {
        return $this->updated_at;
    }

    /**
     * Set the value of updated_at
     */
    public function setUpdated_at($updated_at):? self
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    /**
     * Get the value of image
     */
    public function getImage():? string
    {
        return $this->image;
    }

    /**
     * Set the value of image
     */
    public function setImage($image):? self
    {
        $this->image = $image;

        return $this;
    }
    
}
