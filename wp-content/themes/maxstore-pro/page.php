<?php get_header(); ?>

<?php get_template_part( 'templates/template-part', get_theme_mod( 'header-style', 'head' ) ); ?>

<!-- start content container -->
<?php get_template_part( 'content', 'page' ); ?>
<!-- end content container -->

<?php get_footer(); ?>
