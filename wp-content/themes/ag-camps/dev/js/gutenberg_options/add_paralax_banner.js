

//importe le hook addfilter et la localisation
const { addFilter } = wp.hooks;
const { __ } = wp.i18n;
const { registerBlockType } = wp.blocks;
const { createHigherOrderComponent } = wp.compose;
const { Fragment } = wp.element;
const { InspectorControls } = wp.blockEditor;
const { PanelBody,ToggleControl } = wp.components;


/**
 * Ajoute un props au block
 */
const addCoverParallax = ( props, name ) => {
    
	if(name == 'core/cover'){
		// on ajoute l'attribut et on ajoute une valeur par défaut
		props.attributes = Object.assign( props.attributes, {
			specialAddParalax: {
				type: 'boolean',
				default: false,
			},
		} );
	}
	return props;
};addFilter( 'blocks.registerBlockType', 'addColMargin/attribute/addColMargin', addCoverParallax);
/**
 * Ajoute un controle dans la sidebar pour le plugin 
 *
 */
const withSpecialColMargin = createHigherOrderComponent( ( BlockEdit ) => {
	return ( props ) => {
		if ( props.name != 'core/cover' ) { return  ( <BlockEdit { ...props } /> ) ; }
		return (
			<Fragment>
				<BlockEdit { ...props }  />
                <InspectorControls>
                    <PanelBody>
                        <ToggleControl
                            label="Ajouter du parallax"
                            checked={ props.attributes.specialAddParalax }
                            onChange={ (val) => {
                                props.setAttributes({specialAddParalax:val})
                            } }
                        />
                    </PanelBody>
                </InspectorControls>
			</Fragment>
		);
	};
}, 'withSpecialColMargin' );
addFilter( 'editor.BlockEdit', 'withSpecialColMargin/with-special-col-margin', withSpecialColMargin );

const specialAddColMargin= ( saveElementProps, blockType, attributes ) => {
    if ( blockType.name == 'core/cover' ) { 
        if(attributes.specialAddParalax){
            Object.assign( saveElementProps, { className:  saveElementProps.className + ' '+'cols-special-margin' } );
        }
    }
	return saveElementProps;
};addFilter( 'blocks.getSaveContent.extraProps', 'specialAddColMargin/get-save-content/specialAddColMargin', specialAddColMargin );



