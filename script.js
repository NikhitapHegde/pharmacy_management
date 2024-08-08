const customerForm = document.getElementById('customerForm');
const customerId = document.getElementById('customerId');
const mobileNumber = document.getElementById('mobileNumber');
const mobileError = document.getElementById('mobileError');
const addMedicineBtn = document.getElementById('addMedicineBtn');
const otherItemName = document.getElementById('otherItemName');
const addOtherItemBtn = document.getElementById('addOtherItemBtn');

// Generate random 4-digit customer ID on page load
customerId.value = Math.floor(Math.random() * 10000).toString().padStart(4, '0');

// Mobile number validation
mobileNumber.addEventListener('input', function() {
  const pattern = /^\d{10}$/;
  if (!pattern.test(mobileNumber.value)) {
    mobileError.textContent = 'Invalid mobile number. Please enter 10 digits.';
  } else {
    mobileError.textContent = '';
  }
});

// Add more medicine functionality (replace with actual data fetching)
addMedicineBtn.addEventListener('click', function() {
    const medicineRow = document.createElement('div');
    medicineRow.classList.add('medicine-row');
    medicineRow.innerHTML = `
      <select id="medicineName" name="medicineName[]"></select>
      <input type="number" id="medicineQuantity" name="medicineQuantity[]" min="1" value="1">
      <span class="inStockStatus">In Stock</span>
      <button type="button" class="removeMedicineBtn">Remove</button>
    `;
    // Replace with your logic to populate the medicine name dropdown
    // (e.g., fetch data from database using AJAX)
    const medicineSelect = medicineRow.querySelector('#medicineName');
    // ... populate medicine options here ...
  
    document.querySelector('.medicine-section').appendChild(medicineRow);
  
    // Add event listener for remove button
    const removeBtn = medicineRow.querySelector('.removeMedicineBtn');
    removeBtn.addEventListener('click', function() {
      medicineRow.remove();
    });
  });
  
  // Similar logic for adding other items with appropriate dropdown population
  
  // Form submission with validation (replace with your actual database connection and insertion logic)
  customerForm.addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent default form submission
  
    if (mobileNumber.value.length !== 10) {
      mobileError.textContent = 'Invalid mobile number. Please enter 10 digits.';
      return;
    }
  
    // Replace with your logic to send form data to a PHP script for database insertion
  
    alert('Customer added successfully!'); // Replace with a success message or redirection
  });
  const medicineForm = document.getElementById('medicineForm');

// Handle form submission (replace with your actual database connection and insertion logic)
medicineForm.addEventListener('submit', function(event) {
  event.preventDefault(); // Prevent default form submission

  const medicineName = document.getElementById('medicineName').value;
  const quantity = document.getElementById('quantity').value;
  const price = document.getElementById('price').value;
  const expiryDate = document.getElementById('expiryDate').value;

  // Replace with your logic to send form data to a PHP script for database insertion

  alert('Medicine added successfully!'); // Replace with a success message or redirection
});
const inStockBtn = document.getElementById('inStockBtn');
const medicineList = document.getElementById('medicineList');

inStockBtn.addEventListener('click', function() {
  medicineList.innerHTML = ""; // Clear previous content

  // Fetch in-stock medicines using AJAX (replace with your actual logic)
  fetch('instack.php')
    .then(response => response.json())
    .then(data => {
      if (data.length > 0) {
        let html = "";
        for (const medicine of data) {
          html += `<div class="medicine-row">
                      <span class="name">${medicine.medicine_name}</span>
                  </div>`;
        }
        medicineList.innerHTML = html;
      } else {
        medicineList.innerHTML = "No in-stock medicines found.";
      }
    })
    .catch(error => {
      console.error(error); // Handle errors
      medicineList.innerHTML = "Error fetching medicine list.";
    });
});
