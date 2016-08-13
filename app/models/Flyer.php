<?php

Class Flyer{


	private $title;
	private $created;
	private $modificated;
	private $description;
	private $backgroundImg;
	private $products;

	public function getTittle()
	{
	    return $this->tittle;
	}
	
	public function setTittle($tittle)
	{
	    $this->tittle = $tittle;
	    return $this;
	}


	public function getCreated()
	{
	    return $this->created;
	}
	
	public function setCreated($created)
	{
	    $this->created = $created;
	    return $this;
	}

	public function getModificated()
	{
	    return $this->modificated;
	}
	
	public function setModificated($modificated)
	{
	    $this->modificated = $modificated;
	    return $this;
	}

	public function getDescription()
	{
	    return $this->description;
	}
	
	public function setDescription($description)
	{
	    $this->description = $description;
	    return $this;
	}

	public function getBackgroundImg()
	{
	    return $this->backgroundImg;
	}
	
	public function setBackgroundImg($backgroundImg)
	{
	    $this->backgroundImg = $backgroundImg;
	    return $this;
	}

	public function getProducts()
	{
	    return $this->products;
	}
	
	public function setProducts($products)
	{
	    $this->products = $products;
	    return $this;
	}

}