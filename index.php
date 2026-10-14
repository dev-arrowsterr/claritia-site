<?php
// The blog list, search results, archives and any page without its own template.
// The front page never lands here: functions.php sends it to pages/home/home.php.
get_header();
get_template_part('blog/list');
get_footer();
