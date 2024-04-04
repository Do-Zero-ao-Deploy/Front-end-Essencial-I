<?php
if (!isset($_SESSION)) {
    session_start();
}
$sessionGetAndForget = function (string $key, mixed $default = null) {
    $value = $_SESSION[$key] ?? $default;
    unset($_SESSION[$key]);
    return $value;
};

$error = $sessionGetAndForget('error');
$success = $sessionGetAndForget('success');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact form</title>
    <style>
        .d-none {
            display: none !important;
        }

        form > div {
            padding-bottom: 1rem;
        }

        .messages .message {
            padding: 0.2rem 0.5rem;
            width: 100%;
            display: block;
            margin-bottom: 0.1rem;
        }

        .messages .message.error {
            background: #efd5d5;
            color: red;
        }

        .messages .message.success {
            background: #efdf;
            color: green;
        }
    </style>
</head>
<body>
    <div class="messages">
        <span
            class="message error <?= ($error ?? null) ? '' : 'd-none' ?>"
        ><?= $error ?? null ?></span>
        <span
            class="message success <?= ($success ?? null) ? '' : 'd-none' ?>"
        ><?= $success ?? '' ?></span>
    </div>
<form action="/Javascript-Basico/ajax/contact-form/request.php" method="post">
    <h4>Contact Form</h4>
    <div>
        <button type="reset">Reset all</button>
        <button type="button" make-async="">Make form as async</button>
    </div>
    <div><input type="text" name="name" value="John Doe" placeholder="Name" required></div>
    <div><input _type="email" name="email" value="john.doe@mail.com" placeholder="e-mail" required></div>
    <div><input type="text" name="subject" value="Test of message" placeholder="Subject" required></div>
    <div><textarea name="message" cols="30" rows="10" placeholder="Your message" required>My message</textarea></div>
    <div><button type="submit">Submit</button></div>
</form>

<script>
function makeFormAsAsync() {
    document.querySelector('button[make-async]')?.remove();

    let form = document.querySelector('form');

    if (!form) {
        return;
    }

    form.addEventListener('submit', event => {
        event.preventDefault();
        event.stopImmediatePropagation();

        let formData = {};
        for (input of form.elements) {
            let name = input.getAttribute('name')

            if (name) {
                formData[name] = input.value;
            }
        }

        clearForm = () => {
            for (input of form.elements) {
                if (input.getAttribute('name')) {
                    input.value = '';
                }
            }
        };

        showMessage = (type, message) => {
            if (!type) {
                return;
            }

            let element = document.querySelector(`.messages .message.${type}`);

            if (!element) {
                return;
            }

            element.classList.remove('d-none');

            element.innerHTML = message;
        }

        query = (new URLSearchParams(formData)).toString();

        fetch(`${form.action}?${query}`, {
            method: form.method,
        })
        .then(response => {
            if (!response.ok) {
                return;
            }

            clearForm();
            showMessage('success', 'Formulário enviado com sucesso!');
        })
        .catch(error => console.error(error));
    })
}

document.querySelector('button[make-async]')?.addEventListener('click', makeFormAsAsync)
</script>
</body>
</html>
