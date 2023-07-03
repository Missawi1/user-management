// Fetch users data from the microservice
function fetchUsers() {
    fetch('/index.php')
      .then(response => response.json())
      .then(users => {
        const tbody = document.querySelector('#usersTable tbody');
        tbody.innerHTML = '';
  
        users.forEach(user => {
          const row = document.createElement('tr');
          row.innerHTML = `
            <td>${user.id}</td>
            <td>${user.name}</td>
            <td>${user.email}</td>
          `;
          tbody.appendChild(row);
        });
      })
      .catch(error => console.error('Error:', error));
  }
  
  // Handle form submission to create a new user
  document.querySelector('#createUserForm').addEventListener('submit', event => {
    event.preventDefault();
  
    const form = event.target;
    const formData = new FormData(form);
  
    fetch('/index.php', {
      method: 'POST',
      body: formData
    })
      .then(response => response.text())
      .then(message => {
        console.log('Success:', message);
        form.reset();
        fetchUsers();
      })
      .catch(error => console.error('Error:', error));
  });
  
  // Fetch users data on page load
  fetchUsers();
  