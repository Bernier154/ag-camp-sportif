$(() =>{
    'use strict';

    const closedClass = 'burger-close';
    const $menu = $('.menu');
    const $burgerMenu = $('.burger-menu');

    $burgerMenu.click(() => {
        $menu.toggleClass(closedClass);
    });
});
