// Reg Form //

const form = document.getElementById('reg-form');
const Message = document.getElementById('subtitle');

Message.style.color = 'red';

form.addEventListener('submit', async (event) => {
  event.preventDefault();

  clearErrors();

  if (!validateFields() || !isValidPassword()) {
    return;
  }

  try {
    const response = await fetch('http://localhost/super-reminder/user/rv', {
        method: 'POST',
        body: new FormData(form)
});
    if (!response.ok) {
        throw new Error('Network response was not OK');
    }
        const data = await response.json();
        const message = data.message;
    if (data.success) {
        Message.style.color = 'green';
        window.location = "http://localhost/super-reminder/user/l"; // If the subscription is done, we're being redirected to the login page
    } else {
        Message.style.color = 'red';
    }
        Message.textContent = message;
    } catch (error) {
        console.error('Error:', error);
        Message.textContent = 'Erreur survenue côté serveur.';
    }
});

function clearErrors() {
  Message.textContent = '';
}

function validateFields() {
    const lastnameValue = document.getElementById('lastname').value;
    const firstnameValue = document.getElementById('firstname').value;
    const loginValue = document.getElementById('login').value.trim();
    const passwordValue = document.getElementById('password').value;
  
    if (lastnameValue === '' || firstnameValue === '' || loginValue === '' || passwordValue === '') {
      Message.textContent = 'Les champs doivent être remplis';
      return false;
    } else {
      Message.textContent = '';
      return true;
    }
  }


function isValidPassword() {
  const passwordValue = document.getElementById('password').value;

  if (passwordValue.length < 8) {
    Message.textContent = "Le mot de passe doit faire plus de 8 caractères";
    return false;
  }

  if (!/[A-Z]/.test(passwordValue)) {
    Message.textContent = "Le mot de passe doit avoir une majuscule";
    return false;
  }

  if (!/[!@#$%^&*()_+{}\[\]:;<>,.?~\\-]/.test(passwordValue)) {
    Message.textContent = "Le mot de passe doit avoir un caractère spécial";
    return false;
  }

  return true;
}

