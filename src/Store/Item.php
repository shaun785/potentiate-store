<?php 
/**
 * Item class
 *
 * Used to store information about individual items
 *
 * @package Store
 * @author Shaunak Deshmukh
 * @since 26/04/2015
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

	/*
	* Set item name
	* @param String $name
	* @return void
	*/
	public function setName($name) {
		$this->name = $name;
	}

	/*
	* Set item price
	* @param Float $price
	* @return void
	*/
	public function setPrice($price) {
		$this->price = $price;
	}

	/*
	* Set item weight
	* @param Float $weight
	* @return void
	*/
	public function setWeight($weight) {
		$this->weight = $weight;
	}

	/*
	* Returns the item name
	* @return String name
	*/
	public function getName() {
		return $this->name;
	}

	/*
	* Returns the item price
	* @return Float price
	*/
	public function getPrice() {
		return $this->price;		
	}

	/*
	* Returns the item weight
	* @return Float weight
	*/
	public function getWeight() {
		return $this->weight;
	}
}