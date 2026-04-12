    <footer id="colophon" class="site-footer">
        <div class="container mx-auto px-4">
            <p>&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. 
                <?php echo esc_html( t('footer.copyright') ); ?>
            </p>
        </div>
    </footer>
    <?php wp_footer(); ?>
</body>
</html>
