document.getElementById('registration-form').addEventListener('submit', function (event) {
    event.preventDefault();
  
    const nameInput = document.getElementById('name');
    const emailInput = document.getElementById('email');
    const passwordInput = document.getElementById('password');
  
    let isValid = true;
      
    if (nameInput.value.trim() === '') {
      isValid = false;
      displayError('name', 'Name is required.');
    } else {
      hideError('name');
    }
  
    if (emailInput.value.trim() === '') {
      isValid = false;
      displayError('email', 'Email is required.');
    } else if (!isValidEmail(emailInput.value)) {
      isValid = false;
      displayError('email', 'Invalid email format.');
    } else {
      hideError('email');
    }
  
    if (passwordInput.value.trim() === '') {
      isValid = false;
      displayError('password', 'Password is required.');
    } else if (!isValidPassword(passwordInput.value)) {
      isValid = false;
      displayError('password', 'Password must be between 6 and 21 characters and contain at least one uppercase letter, one lowercase letter, and one digit.');
    } else {
      hideError('password');
    }
  
    if (isValid) {
      event.target.submit();
    }
  
    function displayError(inputId, errorMessage) {
      const errorElement = document.getElementById(inputId + '-error');
      errorElement.textContent = errorMessage;
      errorElement.style.display = 'block';
    }
  
    function hideError(inputId) {
      const errorElement = document.getElementById(inputId + '-error');
      errorElement.textContent = '';
      errorElement.style.display = 'none';
    }
  
    function isValidEmail(email) {
      const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      return emailRegex.test(email);
    }
  
    function isValidPassword(password) {
      const passwordRegex = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,21}$/;
      return passwordRegex.test(password);
    }
  });
  