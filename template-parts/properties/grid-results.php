<?php
/**
 * Component: Properties Grid Results
 * Renders the main grid of property cards.
 * @var array $args
 */
$properties = $args['properties'] ?? [];
?>

<div class="grid grid-cols-1 md:grid-cols-3 gap-8 lg:gap-10">
    <?php
    if ( is_array($properties) ) :
        foreach ( $properties as $property ) :
            get_template_part('template-parts/properties/property', 'card', ['property' => $property]);
        endforeach;
    endif;
    ?>
</div>
