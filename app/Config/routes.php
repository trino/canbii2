<?php
/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different URLs to chosen controllers and their actions (functions).
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Config
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
/**
 * Here, we are connecting '/' (base path) to controller called 'Pages',
 * its action called 'display', and we pass a param to select the view file
 * to use (in this case, /app/View/Pages/home.ctp)...
 */
	Router::connect('/', array('controller' => 'pages', 'action' => 'index'));

	//  Router::connect('/pages/:slug',array('controller'=>'pages', 'action'=>'pages'),array('pass' => array('slug')));
 
/**
 * ...and connect the rest of 'Pages' controller's URLs.
 */
    Router::connect('/strains/ajax_search/*', array('controller' => 'strains', 'action' => 'ajax_search'));
    Router::connect('/strains/getEffect/*', array('controller' => 'strains', 'action' => 'getEffect'));
    Router::connect('/strains/getFlavor/*', array('controller' => 'strains', 'action' => 'getFlavor'));
    Router::connect('/strains/getcolors/*', array('controller' => 'strains', 'action' => 'getcolors'));
    
    Router::connect('/strains/getSymptom/*', array('controller' => 'strains', 'action' => 'getSymptom'));
    Router::connect('/strains/getPosEff/*', array('controller' => 'strains', 'action' => 'getPosEff'));
    Router::connect('/strains/getUserName/*', array('controller' => 'strains', 'action' => 'getUserName'));
    Router::connect('/strains/helpful/*', array('controller' => 'strains', 'action' => 'helpful'));
    Router::connect('/strains/all/*', array('controller' => 'strains', 'action' => 'all'));
    Router::connect('/strains/showAll', array('controller' => 'strains', 'action' => 'showAll'));
    Router::connect('/strains/search/*', array('controller' => 'strains', 'action' => 'search'));
    Router::connect('/strains/review/*', array('controller' => 'strains', 'action' => 'review'));
    Router::connect('/strains/review_filter/*', array('controller' => 'strains', 'action' => 'review_filter'));
    Router::connect('/strains/filter/*', array('controller' => 'strains', 'action' => 'filter'));
    Router::connect('/strains/getEffectRate/*', array('controller' => 'strains', 'action' => 'getEffectRate'));
    Router::connect('/strains/getSymptomRate/*', array('controller' => 'strains', 'action' => 'getSymptomRate'));
    //Router::connect('/strains/generateImage/*', array('controller' => 'strains', 'action' => 'generateImage'));
    Router::connect('/strains/getEffectReview/*', array('controller' => 'strains', 'action' => 'getEffectReview'));
	Router::connect('/strains/*', array('controller' => 'strains', 'action' => 'index'));
    Router::connect('/pages/getEff',array('controller'=>'pages', 'action'=>'getEff'));
    Router::connect('/pages/getSym',array('controller'=>'pages', 'action'=>'getSym'));
 //   Router::connect('/pages/*',array('controller'=>'pages', 'action'=>'view_page'));
/**
 * Load all plugin routes. See the CakePlugin documentation on
 * how to customize the loading of plugin routes.
 */
	CakePlugin::routes();

/**
 * Load the CakePHP default routes. Only remove this if you do not want to use
 * the built-in default routes.
 */
	require CAKE . 'Config' . DS . 'routes.php';
