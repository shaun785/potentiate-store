<?php 

class StoreAppPage {

	public function createPage($args = array()) {
		$loader = new Twig_Loader_Filesystem('src/Store/templates');
		$twig 	= new Twig_Environment($loader);

		$items = getItemsFromCSV();

		$args['items'] = $items;

		echo $twig->render('index.html', $args);
	}
}