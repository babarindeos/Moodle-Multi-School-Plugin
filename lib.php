<?php

/**
 * Insert a link to index.php on the site front page navigation menu.
 *
 * @param navigation_node $frontpage Node representing the front page in the navigation tree.
 */
function newwaves_extend_navigation_frontpage(navigation_node $frontpage) {
    $frontpage->add('newwaves',
        new moodle_url('/local/newwaves/newwaves_dashboard.php')
    );
}

//



 ?>
