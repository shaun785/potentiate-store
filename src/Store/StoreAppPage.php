<?php 
/**
 * StoreApp Page 
 *
 * Page class - used to output html using Twig
 *
 * @package Store
 * @author Shaunak Deshmukh
 * @since 26/04/2015
 */

class StoreAppPage {

	public function createPage($args = array()) {
		$loader = new Twig_Loader_Filesystem('src/Store/templates');
		$twig 	= new Twig_Environment($loader);

		$items = getItemsFromCSV();

		$args['items'] = $items;

		echo $twig->render('index.html', $args);
	}
}