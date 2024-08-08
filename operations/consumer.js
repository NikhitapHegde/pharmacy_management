window.onload = function() {
    const medicineList = document.getElementById('medicineList');
    medicineList.innerHTML = ""; // Clear previous content
  
    // Fetch customer list using AJAX
    fetch('consumer.php')
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                console.error(data.error);
                medicineList.innerHTML = "Error: " + data.error;
                return;
            }

            if (data.length > 0) {
                let html = "<table><thead><tr><th>Customer ID</th><th>Customer Name</th><th>Mobile No</th><th>Address</th><th>Date of Purchase</th></tr></thead><tbody>";
                for (const customer of data) {
                    html += `<tr>
                        <td>${customer.id}</td>
                        <td>${customer.name || '-'}</td>
                        <td>${customer.mobile_number}</td>
                        <td>${customer.address || '-'}</td>
                        <td>${customer.purchase_date}</td>
                    </tr>`;
                }
                html += "</tbody></table>";
                medicineList.innerHTML = html;
            } else {
                medicineList.innerHTML = "No customers found.";
            }
        })
        .catch(error => {
            console.error('Error fetching customer list:', error);
            medicineList.innerHTML = "Error fetching customer list.";
        });
};
