<?

/**
 * Returns all quotes ordered
 * ordered by descending post time
 */
function tn_quotes() {
    // Define post arguments
	$args = [
		'post_type' => 'quote',
		'order' => 'desc'
	];
    // Get posts with arguments
	$posts = get_posts($args);
    // Variables
	$data = [];
	$i = 0;
    // Loop through quote posts
	foreach($posts as $post) {
	    // Assign values to keys
		$data[$i]['id'] = $i;
        $data[$i]['quote'] = get_field('quote', $post->ID);
        $data[$i]['author'] = get_field('author', $post->ID);
		$i++;
	}
    // Return quotes
	return $data;
}

/**
 * Returns the last posted quote
 */
function tn_quote_current() {
    // Define post arguments
	$args = [
		'post_type' => 'quote'
	];
    // Get posts with arguments
	$posts = get_posts($args);
    // Variables
	$data = [];
	// Return last post or error message
	if ($posts[0] != null) {
	// Assign values of the latest post to keys
    $data['quote'] = get_field('quote', $posts[0]->ID);
    $data['author'] = get_field('author', $posts[0]->ID);
    // Return quote
    return $data;
	} else {
	    return 'Error: Could not get the latest quote';
	}
}

/**
 * Register routes
 */ 
add_action('rest_api_init', function() {
    // Get all quotes
    register_rest_route('tn', '/quotes', [
		'methods' => 'GET',
		'callback' => 'tn_quotes',
	]);
	// Get current quote
    register_rest_route('tn', '/quotes/current', [
		'methods' => 'GET',
		'callback' => 'tn_quote_current',
	]);
});

?>