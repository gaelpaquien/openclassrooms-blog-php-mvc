<?php
namespace App\Models\Comments;

class CommentsModel extends CommentsManager
{

    protected int $id;
    protected int $author_id;
    protected string $content;
    protected int $validate;
    protected int $validate_by;
    protected int $article_id;
    protected $created_at;

    public function __construct()
    {
        $this->table = 'comments';
    }

    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of author_id
     */ 
    public function getAuthor_id()
    {
        return $this->author_id;
    }

    /**
     * Set the value of author_id
     *
     * @return  self
     */ 
    public function setAuthor_id($author_id)
    {
        $this->author_id = $author_id;

        return $this;
    }

    /**
     * Get the value of content
     */ 
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set the value of content
     *
     * @return  self
     */ 
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get the value of validate
     */ 
    public function getValidate()
    {
        return $this->validate;
    }

    /**
     * Set the value of validate
     *
     * @return  self
     */ 
    public function setValidate($validate)
    {
        $this->validate = $validate;

        return $this;
    }

    /**
     * Get the value of validate_by
     */ 
    public function getValidate_by()
    {
        return $this->validate_by;
    }

    /**
     * Set the value of validate_by
     *
     * @return  self
     */ 
    public function setValidate_by($validate_by)
    {
        $this->validate_by = $validate_by;

        return $this;
    }

    /**
     * Get the value of article_id
     */ 
    public function getArticle_id()
    {
        return $this->article_id;
    }

    /**
     * Set the value of article_id
     *
     * @return  self
     */ 
    public function setArticle_id($article_id)
    {
        $this->article_id = $article_id;

        return $this;
    }

    /**
     * Get the value of created_at
     */ 
    public function getCreated_at()
    {
        return $this->created_at;
    }

    /**
     * Set the value of created_at
     *
     * @return  self
     */ 
    public function setCreated_at($created_at)
    {
        $this->created_at = $created_at;

        return $this;
    }
    
}