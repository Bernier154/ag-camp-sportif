/**
 * Permet de modifier les classes des blocks.
 * @param {string} className 
 * @param {string} blockName 
 */
function addCustomClasses( className, blockName ) {
    if(blockName === 'core/column'){
        className = className + ' toAnimate animate__fadeIn';
    }

    return className;
}
 
/*wp.hooks.addFilter(
    'blocks.getBlockDefaultClassName',
    'theme_client/block-filters',
    addCustomClasses
);*/
