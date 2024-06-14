window.onload = function() {
    const medicineList = document.getElementById('medicineList');
    medicineList.innerHTML = ""; // Clear previous content
  
    // Fetch in-stock medicines using AJAX (replace with your actual logic)
    fetch('instack.php')
      .then(response => response.json())
      .then(data => {
        if (data.length > 0) {
          let html = "<table ><thead><tr><th >Medicine Name &nbsp; </th><th>Quantity &nbsp;   &nbsp;  </th><th>    Price &nbsp;&nbsp;&nbsp;    </th><th>Expiry_Date</th></tr></thead><tbody>";
          for (const medicine of data) {
            html += `<tr>
                        <td>${medicine.name}</td>
                        <td>${medicine.qty || '-'}</td>  <td>${medicine.price ? `${medicine.price}` : '-'}</td>  <td>${medicine.expiry_date || '-'}</td>  </tr>`;
          }
          html += "</tbody></table>";
          medicineList.innerHTML = html;
        } else {
          medicineList.innerHTML = "No in-stock medicines found.";
        }
      })
      .catch(error => {
        console.error(error); // Handle errors
        medicineList.innerHTML = "Error fetching medicine list.";
      });
  };
  