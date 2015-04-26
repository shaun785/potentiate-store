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

	public function addItem(Item $item) {
		$this->items[] = $item;
	}

	public function getItems() {
		return $this->items;
	}

	public function getTotalPrice() {
		$totalPrice = array_reduce($this->items, function($total, $current) {
			$total += $current->getPrice();
			return $total;
		});

		return $totalPrice;
	}

	public function getTotalWeight() {
		$totalWeight = array_reduce($this->items, function($total, $current) {
			$total += $current->getWeight();
			return $total;
		});


		return $totalWeight;
	}

	public function canAddNewItem(Item $testItem) {
		$price = $this->getTotalPrice() + $testItem->getPrice();
		if($price > self::MAX_TOTAL_PRICE) {
			return false;
		}

		return true;
	}

	public function getCourierCharges() {
		$totalWeight = $this->getTotalWeight();

		foreach(self::$courierCharges as $price => $range) {
			if($totalWeight >= $range['from'] && $totalWeight <= $range['to'])
				return $price;
		}		
	}
}