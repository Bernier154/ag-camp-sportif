

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
const addSpecialBgLogoCol = ( props, name ) => {
 
	if(name == 'core/column'){
		// on ajoute l'attribut et on ajoute une valeur par défaut
		props.attributes = Object.assign( props.attributes, {
			specialBgLogoCol: {
				type: 'string',
				default: '',
			},
		} );
	}
	return props;
};addFilter( 'blocks.registerBlockType', 'addSpecialBgLogoCol/attribute/addSpecialBgLogoCol', addSpecialBgLogoCol);
/**
 * Ajoute un controle dans la sidebar pour le plugin 
 *
 */
const withSpecialBgCol = createHigherOrderComponent( ( BlockEdit ) => {
	return ( props ) => {
		if ( props.name != 'core/column' ) { return  ( <BlockEdit { ...props } /> ) ; }
		return (
			<Fragment>
				<BlockEdit { ...props } className={ props.attributes.imgClass }  />
				<InspectorControls>
						<PanelBody>
                        <h3>Background col</h3>
						<SelectControl
							label={ 'Type de bg' }
							value={ props.attributes.specialBgLogoCol }
							options={ [
								{label:'Aucune bg',value:''},
								{label:'Logo un',value:' logo-un-bromont'},
								{label:'Logo triange',value:' logo-triangle'},
							] }
							onChange={ ( newVal) => {
								props.setAttributes( {
									specialBgLogoCol: newVal
								} );
							} }
						/>
						</PanelBody>
				</InspectorControls>
			</Fragment>
		);
	};
}, 'withSpecialTitleBorder' );
addFilter( 'editor.BlockEdit', 'specialTitleBorder/with-specialTitleVorder-control', withSpecialBgCol );

const specialColBgLogoSave = ( saveElementProps, blockType, attributes ) => {
    if ( blockType.name == 'core/column' ) { 
        Object.assign( saveElementProps, { className:  saveElementProps.className + attributes.specialBgLogoCol } );
    }
	return saveElementProps;
};addFilter( 'blocks.getSaveContent.extraProps', 'specialColBgLogoSave/get-save-content/specialColBgLogoSave', specialColBgLogoSave );


