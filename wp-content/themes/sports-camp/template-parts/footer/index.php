<footer class="footer" role="contentinfo">
    <section class="section footer-section footer-contact-wrapper">
        <div class="footer-contact">
            <?php dynamic_sidebar('contact-us'); ?>
        </div>
    </section>
    <section class="section footer-section footer-content-wrapper">
        <div class="footer-content">
            <?php foreach (['logo', 'main-menu', 'social-menu', 'contact-info'] as $part): ?>
                <div class="footer-col footer-<?= $part ?>">
                    <?php get_template_part('template-parts/footer/' . $part); ?>
                </div>
            <?php endforeach; ?>
            <div class="footer-copyrights">
                <p class="copyrights">&copy; <?= get_bloginfo('name'); ?>, <?= date('Y') ?>.
                    <?= __('Tous droits réservés', 'sports_camp') ?></p>
            </div>
        </div>
    </section>
</footer>
