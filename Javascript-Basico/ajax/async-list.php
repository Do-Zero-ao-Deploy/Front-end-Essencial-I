<?php
if (!isset($_SESSION)) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>async-list.php</title>
    <style>
        table {
            min-width: 45%;
            /* margin-left: auto; */
            /* margin-right: auto; */
        }
    </style>
</head>
<body>
    <div>
        <form action="sync-put-session.php">
            <input type="hidden" name="_key" value="pessoas">
            <input type="hidden" name="_type" value="push">

            <div><input type="text" name="name" placeholder="Name" required></div>
            <div>
                <select name="city">
                    <option value="Porto Velho">Porto Velho</option>
                    <option value="Curitiba">Curitiba</option>
                    <option value="Manaus">Manaus</option>
                    <option value="Comodoro">Comodoro</option>
                </select>
            </div>

            <div><button type="submit">Cadastrar</button></div>
        </form>
    </div>
    <div>
        <table border="1">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>City</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>

    <script>
        function showRows(pessoas) {
            if (!pessoas || !(typeof pessoas === 'object') || !Array.isArray(pessoas)) {
                return;
            }

            let template = `
                <td>#_UID#</td>
                <td>#NAME#</td>
                <td>#CITY#</td>
                <td>
                    <button type="button" onclick="deleteItem('#_UID#')">Remover</button>
                </td>
            `;
            let tableBody = document.querySelector('table tbody');

            if (!tableBody) {
                return;
            }

            tableBody.innerHTML = '';

            for (let pessoa of pessoas) {
                let content = `${template}`;
                let tableRow = document.createElement('tr');
                for (let [key, value] of Object.entries(pessoa)) {
                    let upperKey = (`#${key}#`).toUpperCase();
                    content = `${content}`.replace(new RegExp(upperKey, 'ig'), value);
                }

                tableRow.innerHTML = content;
                tableBody.appendChild(tableRow);
            }
        }

        function getFormData(formElement) {
            let content = {
                withErrors: [],
                data: {}
            }

            if (!formElement || !('elements' in formElement)) {
                return content
            }

            let formElements = formElement.elements || []

            if (!formElements || !formElements.length) {
                return content
            }

            for (let i = 0; i < formElements.length; i++) {
                if (formElements[i].name && !['submit'].includes(formElements[i].type)) {
                content.data[formElements[i].name] = formElements[i].value

                if (!formElements[i].validity.valid) {
                    content.withErrors.push(formElements[i])
                    // formElements[i].validationMessage;
                }
                }
            }

            return content
        }

        function deleteItem(itemUID) {
            if (!itemUID) {
                return;
            }

            let url = `/Javascript-Basico/ajax/sync-put-session.php?_key=pessoas&_type=removeItem&_uid=${itemUID}`

            fetch(url)
                .then(res => res.json())
                .then(data => showRows(Object.values(data)))
                .catch(error => console.error(error));
        }

        window.addEventListener('load', (event) => {
            let formElement = document.querySelector('form');

            if (formElement) {
                formElement.addEventListener('submit', event => {
                    event.preventDefault();
                    event.stopImmediatePropagation();

                    let formData = getFormData(event.target);

                    if (!formData || formData.withErrors?.length) {
                        console.log('formData.withErrors', formData.withErrors);
                        return;
                    }

                    let method = (event.target?.method || 'get').toLowerCase();

                    let payload = formData.data || {};

                    queryString = (method === 'get') ? new URLSearchParams(payload).toString() : '';

                    let params = {
                        method,
                    };

                    if (method !== 'get') {
                        params['body'] = JSON.stringify(payload);
                    }

                    fetch(`/Javascript-Basico/ajax/sync-put-session.php?${queryString}`, params)
                        .then(res => res.json())
                        .then(data => showRows(Object.values(data)))
                        .catch(error => console.error(error));

                    if (formElement.querySelector('[name="name"]')) {
                        formElement.querySelector('[name="name"]').value = '';
                    }
                })
            }

            fetch('/Javascript-Basico/ajax/sync-put-session.php?_key=pessoas')
                .then(res => res.json())
                .then(data => showRows(Object.values(data)))
                .catch(error => console.error(error));
        });
    </script>
</body>
</html>
