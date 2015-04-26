<?php 


/**
 * Item class
 *
 * Used to store information about individual items
 *
 * @package Store
 * @author Shaunak Deshmukh
 * @since 23/04/2015
 */

class Item {
	
	protected $name;
	protected $price;
	protected $weight; 

	public function __construct($name = null, $price = 0, $weight = 0) {
		$this->name = $name;
		$this->price = $price;
		$this->weight = $weight;
	}

	public function setName($name) {
		$this->name = $name;
	}

	public function setPrice($price) {
		$this->price = $price;
	}

	public function setWeight($weight) {
		$this->weight = $weight;
	}

	public function getName() {
		return $this->name;
	}

	public function getPrice() {
		return $this->price;		
	}

	public function getWeight() {
		return $this->weight;
	}
}