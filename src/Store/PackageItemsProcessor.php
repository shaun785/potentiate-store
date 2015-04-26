<?php 

/**
 * Package Item Processor 
 *
 * Used to store items into different packages
 * Rules 
 *   1) Total Price of Package cannot exceede $250
 *   2) Total Weight must be even distributed
 *
 * @package Store
 * @author Shaunak Deshmukh
 * @since 26/04/2015
 */

class PackageItemsProcessor {

	// stores the selected items
	protected $items;
	protected $packages;
	const MAX_TOTAL_PACKAGE_PRICE = 250;

	public function __construct(Array $items) {
		$this->items 	   = $items;
		$this->packages    = array(); //initialise with one package
		$this->sortItemsByWeight();		
	}

	/*
	* This method will process items into different packages
	* Logic used is as follows 
	* @return Array packages 
	*/
	public function processPackages() {
		//get the total no. of packages needed for this order, by Price constraint
		$totalPackages = $this->getTotalPackages(); 

		$this->initPackages($totalPackages);

		//used to determine how evenly the total weight must be split
		$totalWeight = $this->getTotalWeight();
		$weightSplit = $totalWeight/count($this->packages); 

		foreach($this->items as $key => $item) {
			foreach($this->packages as $package) {
				//only add an item to a package if it fits the price constraint and is less than the weight split (to keep the package weights even)
				if($package->canAddNewItem($item) && ($package->getTotalWeight() + $item->getWeight()) <= $weightSplit) { 
					$package->addItem($item);					
					unset($this->items[$key]);
					break;
				}
			}
		}

		//any remaining items that didn't fit because of even weight distribution will be added to packages based on the price constraints
		foreach($this->items as $key => $item) {
			$potentials = array();
			foreach($this->packages as $packageKey => $package) { //get all the potential packages this item can be added to
				if($package->canAddNewItem($item)) {

					$potentials[$packageKey] = $package;
				}
			} 

			if($potentials) { //get the package with the minimum weight
				uasort($potentials, function($a, $b) { 
					if($a->getTotalWeight() < $b->getTotalWeight())
						return -1;
					else if($a->getTotalWeight() == $b->getTotalWeight() && $a->getTotalPrice() < $b->getTotalPrice())
						return -1;
					else 
						return 1;
				});

				$packageKey = key($potentials);

				$this->packages[$packageKey]->addItem($item);
			}
		}

		return $this->packages;
	}

	/*
	* This method will initialise package object and add it to an array
	* @param int totalPackages the number of packages to initialise
	* @return void 
	*/
	protected function initPackages($totalPackages = 1) {
		for($i = 0; $i < $totalPackages; $i++) {
			$package = new Package();
			$this->packages[] = $package;
		}
	}

	/*
	* This method will sort items based on weight in DESC order. 
	* If two items with same weight are found, then price will be taken into account
	* @return void 
	*/	
	protected function sortItemsByWeight() {
		usort($this->items, function($a, $b) {
			if($a->getWeight() > $b->getWeight())
				return -1;
			else if($a->getWeight() == $b->getWeight() && $a->getPrice() > $b->getPrice())
				return -1;
			else 
				return 1;
		});		
	}

	/*
	* This method will return the number of packages required to package these items
	* @return int totalPackages 
	*/	
	protected function getTotalPackages() {
		$totalPrice = array_reduce($this->items, function($total, $current) {
			$total += $current->getPrice();

			return $total;
		});

		$totalPackages = ceil($totalPrice/self::MAX_TOTAL_PACKAGE_PRICE);

		return $totalPackages;
	}

	/*
	* This method will return the total weight of all items 
	* @return int totalWeight 
	*/	
	protected function getTotalWeight() {
		$totalWeight = array_reduce($this->items, function($total, $current) {
			$total += $current->getWeight();

			return $total;
		});

		return $totalWeight;
	}
}