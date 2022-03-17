<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <meta class="foundation-mq">
    <script src="https://kit.fontawesome.com/f9f39dab54.js" crossorigin="anonymous"></script>
    	<style>.toAnimate{opacity: 0;}html{line-height:1.15;-webkit-text-size-adjust:100%;font-size:62.5%}body{margin:0}h1{font-size:2em;margin:.67em 0}hr{-webkit-box-sizing:content-box;box-sizing:content-box;height:0;overflow:visible}pre{font-family:monospace,monospace;font-size:1em}a{background-color:transparent}abbr[title]{border-bottom:none;text-decoration:underline;-webkit-text-decoration:underline dotted;text-decoration:underline dotted}b,strong{font-weight:bolder}code,kbd,samp{font-family:monospace,monospace;font-size:1em}small{font-size:80%}sub,sup{font-size:75%;line-height:0;position:relative;vertical-align:baseline}sub{bottom:-.25em}sup{top:-.5em}img{border-style:none}button,input,optgroup,select,textarea{font-family:inherit;font-size:100%;line-height:1.15;margin:0}button,input{overflow:visible}button,select{text-transform:none}[type=button],[type=reset],[type=submit],button{-webkit-appearance:button}[type=button]::-moz-focus-inner,[type=reset]::-moz-focus-inner,[type=submit]::-moz-focus-inner,button::-moz-focus-inner{border-style:none;padding:0}[type=button]:-moz-focusring,[type=reset]:-moz-focusring,[type=submit]:-moz-focusring,button:-moz-focusring{outline:1px dotted ButtonText}fieldset{padding:.35em .75em .625em}legend{-webkit-box-sizing:border-box;box-sizing:border-box;color:inherit;display:table;max-width:100%;padding:0;white-space:normal}progress{vertical-align:baseline}textarea{overflow:auto}[type=checkbox],[type=radio]{-webkit-box-sizing:border-box;box-sizing:border-box;padding:0}[type=number]::-webkit-inner-spin-button,[type=number]::-webkit-outer-spin-button{height:auto}[type=search]{-webkit-appearance:textfield;outline-offset:-2px}[type=search]::-webkit-search-decoration{-webkit-appearance:none}::-webkit-file-upload-button{-webkit-appearance:button;font:inherit}details{display:block}summary{display:list-item}[hidden],template{display:none}body{font-size:1.6rem}html.preload.js body{-webkit-animation:-cdm-preload 8s steps(1) 0s 1 normal both;animation:-cdm-preload 8s steps(1) 0s 1 normal both;overflow-x:hidden}html.preload.js #cdm-loader{-webkit-animation:-cdm-loader-preload 8s steps(1) 0s 1 normal both;animation:-cdm-loader-preload 8s steps(1) 0s 1 normal both;display:none}html.preload.js *{-webkit-transition:none!important;transition:none!important}#page{visibility:hidden}html.no-js #cdm-loader{display:none}html.js .toAnimate{opacity:0}.content,.wp-block-group__inner-container{max-width:1200px}.alignwide,.content,.wp-block-group__inner-container{width:100%;padding-left:15px;padding-right:15px;display:block;margin-left:auto;margin-right:auto}.alignwide{max-width:1700px}.alignfull{width:100%;padding-left:15px;padding-right:15px}#cdm-loader{display:inline-block;position:fixed;top:50%;left:50%;-webkit-transform:translate(-50%,-50%);transform:translate(-50%,-50%);width:6.4rem;height:6.4rem;visibility:hidden;z-index:99999}#cdm-loader div{position:absolute;top:2.7rem;width:1.1rem;height:1.1rem;border-radius:50%;background:#000;-webkit-animation-timing-function:cubic-bezier(0,1,1,0);animation-timing-function:cubic-bezier(0,1,1,0)}#cdm-loader div:first-child{left:.6rem;-webkit-animation:lds-ellipsis1 .6s infinite;animation:lds-ellipsis1 .6s infinite}#cdm-loader div:nth-child(2){left:.6rem}#cdm-loader div:nth-child(2),#cdm-loader div:nth-child(3){-webkit-animation:lds-ellipsis2 .6s infinite;animation:lds-ellipsis2 .6s infinite}#cdm-loader div:nth-child(3){left:2.6rem}#cdm-loader div:nth-child(4){left:4.5rem;-webkit-animation:lds-ellipsis3 .6s infinite;animation:lds-ellipsis3 .6s infinite}@-webkit-keyframes lds-ellipsis1{0%{-webkit-transform:scale(0);transform:scale(0)}to{-webkit-transform:scale(1);transform:scale(1)}}@keyframes lds-ellipsis1{0%{-webkit-transform:scale(0);transform:scale(0)}to{-webkit-transform:scale(1);transform:scale(1)}}@-webkit-keyframes lds-ellipsis3{0%{-webkit-transform:scale(1);transform:scale(1)}to{-webkit-transform:scale(0);transform:scale(0)}}@keyframes lds-ellipsis3{0%{-webkit-transform:scale(1);transform:scale(1)}to{-webkit-transform:scale(0);transform:scale(0)}}@-webkit-keyframes lds-ellipsis2{0%{-webkit-transform:translate(0);transform:translate(0)}to{-webkit-transform:translate(19px);transform:translate(19px)}}@keyframes lds-ellipsis2{0%{-webkit-transform:translate(0);transform:translate(0)}to{-webkit-transform:translate(19px);transform:translate(19px)}}@-webkit-keyframes -cdm-preload{0%{visibility:hidden}to{visibility:visible}}@keyframes -cdm-preload{0%{visibility:hidden}to{visibility:visible}}@-webkit-keyframes -cdm-loader-preload{0%{visibility:visible}to{visibility:hidden}}@keyframes -cdm-loader-preload{0%{visibility:visible}to{visibility:hidden}}
</style>
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div class="site-wrapper">

    <header class="main-header">
        <div class="navbar-wrapper">
            <div class="content">
                <div class="logo-wrapper">
                        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" class="site-logo"><img src="<?= get_stylesheet_directory_uri() ?>/images/logo_200.png" alt="Logo AG Camps Sportif" /></a>
                </div><!-- .site-branding -->
                <nav class="main-nav">
                <?php
                    wp_nav_menu( array(
                        'theme_location' => 'menu-1',
                        'menu_id'        => 'primary-menu',
                    ) );
                    ?>
                </nav>
                <div class="burger-toggle" id="menu-toggle" class="menu-toggle" ><i class="fas fa-bars"></i></.>           
            </div>
    </header>
    <div class="site-content">