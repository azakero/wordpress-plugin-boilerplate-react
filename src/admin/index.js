import { render }                   from '@wordpress/element';
import App                          from './components/App/App';

window.addEventListener(
    'load',
    function () {
        render(
            <App />,
            document.querySelector( '#wordpress-plugin-boilerplate' )
        );
    },
    false
);