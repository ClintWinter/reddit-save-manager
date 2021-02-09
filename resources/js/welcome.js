document.querySelector('#subscribe').addEventListener('click', function (event) {
    event.preventDefault();

    let url = '/subscribe?_token='+document.querySelector('[name="_token"]').value;

    let body = {
        email: document.querySelector('[name="email"]').value,
    };

    fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json;charset=utf-8'
        },
        body: JSON.stringify(body),
    })
    .then(response => {
        if (response.ok) {
            return response.text();
        }

        throw response;
    })
    .then(message => {
        let elStatus = document.querySelector('#subscribe-status');
        let elError = document.querySelector('#subscribe-error');

        elError.classList.add('hidden');
        elStatus.textContent = JSON.parse(message);
        elStatus.classList.remove('hidden');
    })
    .catch(error => {
        error.text().then(message => {
            let elStatus = document.querySelector('#subscribe-status');
            let elError = document.querySelector('#subscribe-error');

            elStatus.classList.add('hidden');
            elError.textContent = JSON.parse(message);
            elError.classList.remove('hidden');
        });
    });
});
