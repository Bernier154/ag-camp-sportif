<?php
namespace Agcsi\Endpoints;

use Agcsi\CPT\Camp;

class CampFicheEndpoint {
		
	public static function add_sitemap_query_var($query_vars){
		$query_vars[] = 'campsid';
		$query_vars[] = 'date';
		return $query_vars;
	}

	public static function ficheContent($template){
		if ( get_query_var( 'campsid' ) && get_query_var( 'date' ) ) {
            return AGCSI_TEMPLATES . '/fiche-camp.php';
		}
		return $template;
	}


	static function register(){
        add_rewrite_rule( '^camps/fiche/(\d+)/([^/]+)/?$','index.php?campsid=$matches[1]&date=$matches[2]','top');
		add_filter( 'query_vars', __NAMESPACE__.'\CampFicheEndpoint::add_sitemap_query_var');
		add_action( 'template_include',  __NAMESPACE__.'\CampFicheEndpoint::ficheContent');
	}
	

	
}