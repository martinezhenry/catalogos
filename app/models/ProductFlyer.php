<?php


Class ProductFlyer {

	private $name;
	private $noPart;
	private $alias;
	private $xref;
	private $smp;
	private $tomco;
	private $oem;
	private $priceNameOne;
	private $priceNameTwo;
	private $priceNameThree;
	private $priceOne;
	private $priceTwo;
	private $priceThree;
	private $image;
	private $flyerId;

	public function getName()
	{
	    return $this->name;
	}
	
	public function setName($name)
	{
	    $this->name = $name;
	    return $this;
	}

	public function getNoPart()
	{
	    return $this->noPart;
	}
	
	public function setNoPart($noPart)
	{
	    $this->noPart = $noPart;
	    return $this;
	}

	public function getAlias()
	{
	    return $this->alias;
	}
	
	public function setAlias($alias)
	{
	    $this->alias = $alias;
	    return $this;
	}

	public function getXref()
	{
	    return $this->xref;
	}
	
	public function setXref($xref)
	{
	    $this->xref = $xref;
	    return $this;
	}

	public function getSmp()
	{
	    return $this->smp;
	}
	
	public function setSmp($smp)
	{
	    $this->smp = $smp;
	    return $this;
	}

	public function getTomco()
	{
	    return $this->tomco;
	}
	
	public function setTomco($tomco)
	{
	    $this->tomco = $tomco;
	    return $this;
	}


	public function getOem()
	{
	    return $this->oem;
	}
	
	public function setOem($oem)
	{
	    $this->oem = $oem;
	    return $this;
	}

	public function getPriceNameOne()
	{
	    return $this->priceNameOne;
	}
	
	public function setPriceNameOne($priceNameOne)
	{
	    $this->priceNameOne = $priceNameOne;
	    return $this;
	}

	public function getPriceNameTwo()
	{
	    return $this->priceNameTwo;
	}
	
	public function setPriceNameTwo($priceNameTwo)
	{
	    $this->priceNameTwo = $priceNameTwo;
	    return $this;
	}

	public function getPriceNameThree()
	{
	    return $this->priceNameThree;
	}
	
	public function setPriceNameThree($priceNameThree)
	{
	    $this->priceNameThree = $priceNameThree;
	    return $this;
	}

	public function getPriceOne()
	{
	    return $this->priceOne;
	}
	
	public function setPriceOne($priceOne)
	{
	    $this->priceOne = $priceOne;
	    return $this;
	}

	public function getPriceTwo()
	{
	    return $this->priceTwo;
	}
	
	public function setPriceTwo($priceTwo)
	{
	    $this->priceTwo = $priceTwo;
	    return $this;
	}

	public function getPriceThree()
	{
	    return $this->priceThree;
	}
	
	public function setPriceThree($priceThree)
	{
	    $this->priceThree = $priceThree;
	    return $this;
	}

	public function getImage()
	{
	    return $this->image;
	}
	
	public function setImage($image)
	{
	    $this->image = $image;
	    return $this;
	}

	public function getFlyerId()
	{
	    return $this->flyerId;
	}
	
	public function setFlyerId($flyerId)
	{
	    $this->flyerId = $flyerId;
	    return $this;
	}


}