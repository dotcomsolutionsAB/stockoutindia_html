<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Test Add Product</title>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
</head>
<body style="font-family: sans-serif; padding: 20px;">

  <a href="#" id="addProductBtn" style="font-size: 24px; color: red;">
    <i class="fas fa-plus-circle"></i> Add Product
  </a>

  <script>
    document.addEventListener("DOMContentLoaded", function () {
      const addBtn = document.getElementById("addProductBtn");

      addBtn.addEventListener("click", async function () {
        const dummyUnits = ["KG", "LTS", "UNIT"];
        const dummyIndustries = [{ id: 1, name: "Construction" }];
        const dummySubIndustries = [{ id: 1, name: "Machinery", slug: "1_machinery" }];

        let subIndustryOptions = '';

        function updateSubIndustryOptions(selectedIndustryId) {
          const filtered = dummySubIndustries.filter(si =>
            si.slug.startsWith(`${selectedIndustryId}_`)
          );
          subIndustryOptions = filtered
            .map(si => `<option value="${si.id}">${si.name}</option>`)
            .join('');
          const subIndustrySelect = document.getElementById('sub_industry');
          subIndustrySelect.innerHTML = `<option value="">Select Sub-Industry</option>` + subIndustryOptions;
          subIndustrySelect.disabled = filtered.length === 0;
        }

        const formHtml = `
          <form id="addProductForm" class="swal2-form" style="text-align:left">
            <div style="display: flex; flex-wrap: wrap; gap: 10px;">
              <input name="product_name" class="swal2-input" placeholder="Product Name" required>
              <input name="original_price" class="swal2-input" type="number" step="0.01" placeholder="Original Price" required>
              <select name="unit" class="swal2-input">
                ${dummyUnits.map(u => `<option value="${u}">${u}</option>`).join('')}
              </select>
              <select name="industry" id="industry" class="swal2-input">
                ${dummyIndustries.map(i => `<option value="${i.id}">${i.name}</option>`).join('')}
              </select>
              <select name="sub_industry" id="sub_industry" class="swal2-input" disabled>
                <option value="">Select Sub-Industry</option>
              </select>
            </div>
          </form>
        `;

        await Swal.fire({
          title: 'Add Product',
          html: formHtml,
          confirmButtonText: 'Submit',
          showCancelButton: true,
          confirmButtonColor: '#e3342f',
          didOpen: () => {
            document.getElementById('industry').addEventListener('change', function () {
              updateSubIndustryOptions(this.value);
            });
          },
          preConfirm: () => {
            const name = document.querySelector('[name="product_name"]').value;
            const price = document.querySelector('[name="original_price"]').value;
            if (!name || !price) {
              Swal.showValidationMessage('Fill all fields!');
              return false;
            }
            return { name, price };
          }
        }).then(result => {
          if (result.isConfirmed) {
            console.log("Product added:", result.value);
            Swal.fire("Added!", "Product has been added.", "success");
          }
        });
      });
    });
  </script>
</body>
</html>
