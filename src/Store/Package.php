<?php 


/**
 * Package class
 *
 * Used to store items
 *
 * @package Store
 * @author Shaunak Deshmukh
 * @since 26/04/2015
 */

class Package {
	
	const MAX_TOTAL_PRICE = 250;

	protected static $courierCharges = array(5 => array('from' 	=> 0, 'to' => 200),
											  10 => array('from' 	=> 201, 'to' => 500),
											  15 => array('from' 	=> 501, 'to' => 1000),
											  20 => array('from'    => 1001, 'to' => 5000));

	protected $items;

	public function __construct() {
		$this->items 		= array();
	}

	/*
	* Adds items to a package
	* @param Item $item 
	* @return void
	*/
	public function addItem(Item $item) {
		$this->items[] = $item;
	}

	/*
	* Returns items
	* @return Array items
	*/
	public function getItems() {
		return $this->items;
	}

	/*
	* Returns total price of all items in a package
	* @return int totalPrice
	*/
	public function getTotalPrice() {
		$totalPrice = array_reduce($this->items, function($total, $current) {
			$total += $current->getPrice();
			return $total;
		});

		return $totalPrice;
	}

	/*
	* Returns total weight of all items in a package
	* @return int totalWeight
	*/
	public function getTotalWeight() {
		$totalWeight = array_reduce($this->items, function($total, $current) {
			$total += $current->getWeight();
			return $total;
		});


		return $totalWeight;
	}

	/*
	* Returns whether the passed item can be added to this package
	* @param Item $testItem
	* @return boolean
	*/
	public function canAddNewItem(Item $testItem) {
		$price = $this->getTotalPrice() + $testItem->getPrice();
		if($price > self::MAX_TOTAL_PRICE) {
			return false;
		}

		return true;
	}

	/*
	* Returns courier charges
	* @return int Price
	*/
	public function getCourierCharges() {
		$totalWeight = $this->getTotalWeight();

		foreach(self::$courierCharges as $price => $range) {
			if($totalWeight >= $range['from'] && $totalWeight <= $range['to'])
				return $price;
		}		
	}
}