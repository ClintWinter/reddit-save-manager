import '@fortawesome/fontawesome-free';
import 'alpinejs';

document.body.addEventListener('keyup', function (event) {
    if (event.key === '/') {
        let searchFocusEvent = new CustomEvent('searchfocus', {foo:'bar'});

        document.querySelector('#search').dispatchEvent(searchFocusEvent);
    }
});

document.querySelector('#search').addEventListener('searchfocus', function (event) {
    event.target.focus();
});
