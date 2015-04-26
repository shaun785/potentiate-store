<?php 
/**
 * Store App
 *
 * Application class
 *
 * @package Store
 * @author Shaunak Deshmukh
 * @since 26/04/2015
 */
class StoreApp 
{
	/*
	* Application class
	*/
	public function main() {
		$args 	= array();

		$error  = '';

		if($_POST && $_POST['place_order'] == 'submit') {

			if(empty($_POST['items']['id']) ) {
				$error = 'No Items Selected!';
			} else {
				$selectedItems = $_POST['items']['id'];				

				$args['selectedItems'] = $selectedItems;

				$items = $this->getItems($selectedItems); //get selected items

				if($items) {
					$processor = new PackageItemsProcessor($items);
					$packages  = $processor->processPackages();

					$args['packages'] = $packages;
				}
			}
		}

		$args['error'] = $error;
		
		$page = new StoreAppPage();
		$page->createPage($args);
	}

	/*
	* Returns whether the passed item can be ad
	* @param Item $testItem
	* @return boolean
	*/
	public function getItems($selectedItems) {				
		$data 	= getItemsFromCSV();
		$items  = array();

		foreach($selectedItems as $id) {
			if($temp = $data[$id]) {

				$item 	 = new Item($temp['Name'], $temp['Price'], $temp['Weight']);				
				$items[] = $item;
			}
		}
		return $items;		
	}
}