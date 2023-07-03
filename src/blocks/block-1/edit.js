import { TextControl } 				from '@wordpress/components';
import { useBlockProps } 			from '@wordpress/block-editor';

export default function Edit( { attributes, setAttributes } ) {
	const blockProps = useBlockProps();

	return (
		<div {...useBlockProps()}>
			<TextControl
				{ ...blockProps }
				value={ attributes.message }
				onChange={ ( val ) => setAttributes( { message: val } ) }
				placeholder='Type something and publish'
			/>
		</div>
	);
}
