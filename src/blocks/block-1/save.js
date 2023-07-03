import { useBlockProps } 			from '@wordpress/block-editor';

export default function Save( { attributes } ) {
	const blockProps = useBlockProps.save();

	return (
		<div { ...blockProps }>
			<h1 className='header'>{ attributes.message }</h1>
		</div>
	);
}
