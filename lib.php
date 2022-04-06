<?php

/**
 * Insert a link to index.php on the site front page navigation menu.
 *
 * @param navigation_node $frontpage Node representing the front page in the navigation tree.
 */
function local_newwaves_extend_navigation(global_navigation $root) {
    // $nav->add(get_string('pluginname', 'local_newwaves'),
    //     new moodle_url('/local/newwaves/newwaves_dashboard.php')
    // );
    $node = navigation_node::create(
      get_string('pluginname', 'local_newwaves'),
      new moodle_url('/local/newwaves/newwaves_dashboard.php'),
      navigation_node::TYPE_CUSTOM,
      null,
      null,
      new pix_icon('t/message', '')
    );
    $node->showinflatnavigation = true;
    $root->add_node($node);
}

//



 ?>
