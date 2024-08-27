// Log In Form //

const form = document.getElementById('login-form');
const logMessage = document.getElementById('subtitle');

logMessage.style.color = 'red';

form.addEventListener('submit', async (event) => {
  event.preventDefault();

  clearErrors();

  if (!validateFields()) {
    return;
  }

  try {
    const response = await fetch('http://localhost/super-reminder/user/lv', {
        method: 'POST',
        body: new FormData(form)
    });
    if (!response.ok) {
        throw new Error('Network response was not OK');
    }
        const data = await response.json();
        const message = data.message;
    if (data.success) {
        logMessage.style.color = 'green';
        window.location = "http://localhost/super-reminder/user/p"; // If the subscription is done, we're being redirected to the login page
    } else {
        logMessage.style.color = 'red';
    }
        logMessage.textContent = message;
    } catch (error) {
        console.error('Error:', error);
        logMessage.textContent = 'Erreur survenue côté serveur.';
    }
});

function clearErrors() {
  logMessage.textContent = '';
}

function validateFields() {
  const loginValue = document.getElementById('login').value.trim();
  const passwordValue = document.getElementById('password').value;

  if (loginValue === '' || passwordValue === '') {
    logMessage.textContent = 'Les champs doivent être remplis';
    return false;
  } else {
    logMessage.textContent = '';
    return true;
  }
}
