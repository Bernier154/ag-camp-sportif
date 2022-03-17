

//importe le hook addfilter et la localisation
const { addFilter } = wp.hooks;
const { __ } = wp.i18n;

const { createHigherOrderComponent } = wp.compose;
const { Fragment } = wp.element;
const { InspectorControls } = wp.blockEditor;
const { PanelBody, SelectControl } = wp.components;


/**
 * Ajoute un props au block
 */
const addColAnimation = ( props, name ) => {
	
	if(name == 'core/column'){
		// on ajoute l'attribut et on ajoute une valeur par défaut
		props.attributes = Object.assign( props.attributes, {
			addAnimation: {
				type: 'string',
				default: '',
			},
		} );
	}
	return props;
};addFilter( 'blocks.registerBlockType', 'addTitleborder/attribute/addTitleborder', addColAnimation);
/**
 * Ajoute un controle dans la sidebar pour le plugin 
 *
 */
const withAnimation = createHigherOrderComponent( ( BlockEdit ) => {
	return ( props ) => {
		if ( props.name != 'core/column' ) { return  ( <BlockEdit { ...props } /> ) ; }
		return (
			<Fragment>
				<BlockEdit { ...props } className={ props.attributes.imgClass }  />
				<InspectorControls>
						<PanelBody>
                        <h3>Animation</h3>
						<SelectControl
							label={ "Type d'animation" }
							value={ props.attributes.addAnimation }
							options={ [
								{label:'Aucune animation',value:''},
								{label:'Fade in',value:' animate__fadeIn toAnimate'},
								{label:'Fade in de droite',value:' animate__fadeInRight toAnimate'},
								{label:'Fade in de gauche',value:' animate__fadeInLeft toAnimate'},
								{label:'Fade in de top',value:' animate__fadeInUp toAnimate'},
							] }
							onChange={ ( newVal) => {
								props.setAttributes( {
									addAnimation: newVal
								} );
							} }
						/>
						</PanelBody>
				</InspectorControls>
			</Fragment>
		);
	};
}, 'withAnimation' );
addFilter( 'editor.BlockEdit', 'withAnimation/with-animation', withAnimation);

const saveAnimation = ( saveElementProps, blockType, attributes ) => {
    if ( blockType.name == 'core/column' ) { 
        Object.assign( saveElementProps, { className:  saveElementProps.className + attributes.addAnimation  } );
    }
	return saveElementProps;
};addFilter( 'blocks.getSaveContent.extraProps', 'saveAnimation/get-save-content/saveAnimation', saveAnimation );



