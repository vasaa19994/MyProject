<?php
 
 namespace Maincast\App\classes;
 
 
 abstract class abstractMaincast

 {
    protected $id;
    protected $title;
    protected $category;
    protected $stage;
    protected $pool;
    protected $live;
    protected $beginning;
    protected $ending;
    protected $description;
    protected $url;

    public function setId($id)
    {
        $this->id = $id;
    }
    public function setTitle($title)
    {
        $this->title = $title;
    }
    public function setCategory($category)
    {
        $this->category = $category;
    }
    public function setStage($stage)
    {
        $this->stage = $stage;
    }
    public function setPool($pool)
    {
        $this->pool = $pool;
    }
    public function setLive($live)
    {
        $this->live = $live;
    }
    public function setBeginning($beginning)
    {
        $this->beginning = $beginning;
    }
    public function setEnding($ending)
    {
        $this->ending = $ending;
    }
    public function setDecription($description)
    {
        $this->description = $description;
    }
    public function setUrl($url)
    {
        $this->url = $url;
    }
    public function getId()
    {
        return $this->id;
    }
    public function getTitle()
    {
        return $this->title;
    }
    public function getCategory()
    {
        return $this->category;
    }
    public function getStage()
    {
        return $this->stage;
    }
    public function getPool()
    {
        return $this->pool;
    }
    public function getLive()
    {
        return $this->live;
    }
    public function getBeginning()
    {
        return $this->beginning;
    }
    public function getEnding()
    {
        return $this->ending;
    }
    public function getDecription()
    {
        return $this->description;
    }
    public function getUrl()
    {
        return $this->url;
    }
    
 }