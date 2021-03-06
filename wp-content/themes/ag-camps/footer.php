        </div>
        <footer class="main-footer">
            <div class="link">
                <a rel="noopener" href="https://goo.gl/maps/UGSodDEP1TEz1YAq7">15005 Chemin Dupuis, Mirabel, QC J7N 1M6</a>
            </div>
            <div class="link">
                <a href="tel:450-675-4944">450-675-4944</a>
            </div>
            <ul class="link sociaux">
                <li><a rel="noopener" href="https://www.facebook.com/campsportifAG"><i class="fab fa-facebook-square"></i></a></li>
                <li><a rel="noopener" href="https://www.instagram.com/ag_campsportif/?hl=fr"><i class="fab fa-instagram"></i></a></li>
            </ul>
            <div class="footer-nav">
                <?php 
                wp_nav_menu( array(
                    'theme_location' => 'menu-footer',
                    'menu_id'        => 'footer-menu',
                ) );
                ?>
            </div>
            <div class="legal-wrapper">
                <span>&copy; Camp Sportif AG , <?php echo date('Y'); ?>. Tous droits réservés</span>
            </div>
        </footer>
    </div>
    <?php wp_footer();?>
</body>
</html>