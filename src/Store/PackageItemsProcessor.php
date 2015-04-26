<?php 

class PackageItemsProcessor {
	protected $items;
	protected $packages;
	const MAX_TOTAL_PACKAGE_PRICE = 250;

	public function __construct(Array $items) {
		$this->items 	   = $items;
		$this->packages    = array(); //initialise with one package
		$this->sortItemsByWeight();		
	}

	public function processPackages() {
		$totalPackages = $this->getTotalPackages(); //get the total no. of packages needed for this order, by Price constraint

		$this->initPackages($totalPackages);

		$totalWeight = $this->getTotalWeight();

		$weightSplit = $totalWeight/count($this->packages);

		foreach($this->items as $key => $item) {
			foreach($this->packages as $package) {
				if($package->canAddNewItem($item) && ($package->getTotalWeight() + $item->getWeight()) <= $weightSplit) {
					$package->addItem($item);					
					unset($this->items[$key]);
					break;
				}
			}
		}

		//any remaining items 
		foreach($this->items as $key => $item) {
			foreach($this->packages as $package) {
				if($package->canAddNewItem($item)) {
					$package->addItem($item);					
					break;
				}
			}
		}

		return $this->packages;
	}

	protected function initPackages($totalPackages = 1) {
		for($i = 0; $i < $totalPackages; $i++) {
			$package = new Package();
			$this->packages[] = $package;
		}
	}

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

	protected function getTotalPackages() {
		$totalPrice = array_reduce($this->items, function($total, $current) {
			$total += $current->getPrice();

			return $total;
		});

		$totalPackages = ceil($totalPrice/self::MAX_TOTAL_PACKAGE_PRICE);

		return $totalPackages;
	}

	protected function getTotalWeight() {
		$totalWeight = array_reduce($this->items, function($total, $current) {
			$total += $current->getWeight();

			return $total;
		});

		return $totalWeight;
	}
}