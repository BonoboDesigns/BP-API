<?php

class BP_API_Groups extends WP_REST_Controller {


	public function __construct() {

	}


	/**
	 * register_routes function.
	 *
	 * Register the routes for the objects of the controller.
	 * 
	 * @access public
	 * @return void
	 */
	public function register_routes() {
	
		register_rest_route( BP_API_SLUG, '/groups', array(
			'methods'         => WP_REST_Server::READABLE,
			'callback'        => array( $this, 'get_items' )
		) );
		register_rest_route( BP_API_SLUG, '/group/(?P<id>\d+)', array(
			'methods'         => WP_REST_Server::READABLE,
			'callback'        => array( $this, 'get_item' )
		) );
		
	}


	/**
	 * get_items function.
	 * 
	 * @access public
	 * @param array $filter (default: array())
	 * @return void
	 */
	public function get_items( $filter = array() ) {

		$response = $this->get_group( $filter['filter'] );

		return $response;

	}

	
	/**
	 * get_item function.
	 * 
	 * @access public
	 * @param mixed $request
	 * @return void
	 */
	public function get_item( $request ) {

		$response = 'a single group item';

		return $response;

	}


	
	/**
	 * get_group function.
	 * 
	 * @access public
	 * @param mixed $filter
	 * @return void
	 */
	public function get_group( $filter ) {

		$args = $filter;

		if ( bp_has_groups( $args ) ) {

			while ( bp_groups() ) {

				bp_the_group();
					ob_start();
					bp_get_group_avatar('html=false&url=true&type=full');
					$groAvatar = ob_get_clean();
					$groDoc = new DOMDocument();
					$groDoc->loadHTML($groAvatar);
					$groImageTags = $groDoc->getElementsByTagName('img');
				    foreach($groImageTags as $grotag) {
				        $groParsedAvatar = $grotag->getAttribute('src');
				    }

					if ($groParsedAvatar != null) {
						$groAvatar = $groParsedAvatar;
					} else {
						$groAvatar = $groAvatar;
					} 
				$group = array(
					'abe_desc' => bp_get_group_description_excerpt(),
					'abe_last' => bp_get_group_last_active(),
					'abe_permalink' => bp_get_group_permalink(),
					'abe_type' => bp_get_group_type(),
					'excerpt' => bp_get_group_member_count(),
					'featured_image' => $groAvatar,
					'ID' => bp_get_group_id(),
					'title' => bp_get_group_name()
				);

				$group = apply_filters( 'bp_json_prepare_group', $group );

				$groupees[] = $group;

			}

			$data = array(
				'groups' => $groupees
			);

			$data = apply_filters( 'bp_json_prepare_groupees', $data );

		} else {
			return new WP_Error( 'bp_json_group', __( 'No group Found.', 'buddypress' ), array( 'status' => 200 ) );
		}

		$response = new WP_REST_Response();
		$response->set_data( $data );
		$response = rest_ensure_response( $response );

		return $response;

	}

	
	/**
	 * add_group function.
	 * 
	 * @access public
	 * @return void
	 */
	public function add_group() {

		//add group code here

	}

	
	/**
	 * edit_group function.
	 * 
	 * @access public
	 * @return void
	 */
	public function edit_group() {

		//edit group code here

	}

	
	/**
	 * remove_group function.
	 * 
	 * @access public
	 * @return void
	 */
	public function remove_group() {

		//remove group code here

	}
	
	
	/**
	 * bp_group_permission function.
	 *
	 * allow permission to access data
	 * 
	 * @access public
	 * @return void
	 */
	public function bp_group_permission() {
	
		// $response = apply_filters( 'bp_group_permission', true );
		
		// return $response;
	
	}

	

}
