<?php

get_template_part('template-parts/about/about-hero');
get_template_part('template-parts/about/about-story');
get_template_part('template-parts/about/strategic-philosophy');
get_template_part('template-parts/about/leadership');
get_template_part('template-parts/about/how-we-work');

// Dynamic FAQ Section
get_template_part('template-parts/common/faq-section', null, ['perspective' => 'about']);