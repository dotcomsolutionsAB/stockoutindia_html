
<section class="product-form-container">
  <h2 class="acc-user-title">Add Product</h2>
  <form id="productFormStockout">
    <div class="add-product-grid">
      <input name="product_name" placeholder="Product Name" required>
      <input name="original_price" type="number" step="0.01" placeholder="Original Price" required>
      <input name="selling_price" type="number" step="0.01" placeholder="Selling Price" required>

      <input name="offer_quantity" type="number" placeholder="Offer Quantity" required>
      <input name="minimum_quantity" type="number" placeholder="Minimum Quantity" required>

      <select name="unit" id="stockout_unit" required>
        <option value="">Loading Units...</option>
      </select>

      <select name="industry" id="stockout_industry" required>
        <option value="">Loading Industries...</option>
      </select>

      <select name="sub_industry" id="stockout_sub_industry" disabled required>
        <option value="">Select Sub-Industry</option>
      </select>

      <select name="state_id" id="stockout_state" required>
        <option value="">Loading States...</option>
      </select>

      <select name="city" id="stockout_city" disabled required>
        <option value="">Select City</option>
      </select>

      <input name="dimensions" placeholder="Dimensions (e.g., 50mm x 20mm x 35mm)">
    </div>

    <div class="alert_box_footer">
      <textarea name="description" rows="3" placeholder="Product Description"></textarea>
      <label for="stockout_image_upload" class="upload-box">
        <i class="fas fa-upload"></i><br>
        Click to upload Product Image
        <input type="file" name="image" accept="image/*" id="stockout_image_upload" style="display:none">
      </label>
    </div>

    <br>
    <button type="submit" class="btn btn-danger">Submit</button>
  </form>
</section>

<script>
  document.addEventListener("DOMContentLoaded", async function () {
    const stockout_base_url = "<?php echo BASE_URL; ?>";
    const stockout_token = localStorage.getItem("authToken");

    const unitSelect = document.getElementById("stockout_unit");
    const industrySelect = document.getElementById("stockout_industry");
    const subIndustrySelect = document.getElementById("stockout_sub_industry");
    const stateSelect = document.getElementById("stockout_state");
    const citySelect = document.getElementById("stockout_city");

    let stockout_industry_data = [];
    let stockout_cities_data = [];

    // Image upload click
    document.querySelector(".upload-box").addEventListener("click", () => {
      document.getElementById("stockout_image_upload").click();
    });

    // Load Units
    try {
      const res = await fetch(`${stockout_base_url}/product/get_units`, {
        headers: { Authorization: `Bearer ${stockout_token}` },
      });
      const units = (await res.json()).data || [];
      unitSelect.innerHTML =
        '<option value="">Select Unit</option>' +
        units.map((u) => `<option value="${u}">${u}</option>`).join("");
    } catch {
      unitSelect.innerHTML = '<option value="">Failed to load</option>';
    }

    // Load Industries with Sub-Industries
    try {
      const res = await fetch(`${stockout_base_url}/industry`, {
        headers: {
          Authorization: `Bearer ${stockout_token}`,
          Accept: "application/json",
        },
      });
      const resJson = await res.json();
      stockout_industry_data = resJson.data || [];

      industrySelect.innerHTML =
        '<option value="">Select Industry</option>' +
        stockout_industry_data
          .map((i) => `<option value="${i.id}">${i.name}</option>`)
          .join("");
    } catch (err) {
      console.error("❌ Industry fetch failed:", err);
      industrySelect.innerHTML = '<option value="">Failed to load</option>';
    }

    // Industry → Sub-Industry
    industrySelect.addEventListener("change", function () {
      const selectedIndustryId = parseInt(this.value);
      const industry = stockout_industry_data.find((i) => i.id === selectedIndustryId);

      if (industry && Array.isArray(industry.sub_industries)) {
        const subs = industry.sub_industries;
        subIndustrySelect.disabled = subs.length === 0;
        subIndustrySelect.innerHTML =
          '<option value="">Select Sub-Industry</option>' +
          subs.map((s) => `<option value="${s.id}">${s.name}</option>`).join("");
      } else {
        subIndustrySelect.disabled = true;
        subIndustrySelect.innerHTML = '<option value="">No Sub-Industries</option>';
      }
    });

    // Load States
    try {
      const res = await fetch(`${stockout_base_url}/states`, {
        headers: { Authorization: `Bearer ${stockout_token}` },
      });
      const states = (await res.json()).data || [];
      stateSelect.innerHTML =
        '<option value="">Select State</option>' +
        states.map((s) => `<option value="${s.id}">${s.name}</option>`).join("");
    } catch {
      stateSelect.innerHTML = '<option value="">Failed to load</option>';
    }

    // Load Cities
    try {
      const res = await fetch(`${stockout_base_url}/cities`, {
        headers: { Authorization: `Bearer ${stockout_token}` },
      });
      stockout_cities_data = (await res.json()).data || [];
    } catch {
      console.error("❌ Cities fetch failed");
    }

    // State → City
    stateSelect.addEventListener("change", function () {
      const selectedStateName = this.options[this.selectedIndex].text;
      const filteredCities = stockout_cities_data.filter(
        (c) => c.state_name === selectedStateName
      );
      citySelect.disabled = filteredCities.length === 0;
      citySelect.innerHTML =
        '<option value="">Select City</option>' +
        filteredCities.map((c) => `<option value="${c.name}">${c.name}</option>`).join("");
    });

    // Submit Handler
    document.getElementById("productFormStockout").addEventListener("submit", async function (e) {
      e.preventDefault();
      const form = e.target;
      const getVal = (name) => form[name]?.value?.trim() || "";

      const original_price = parseFloat(getVal("original_price"));
      const selling_price = parseFloat(getVal("selling_price"));
      const offer_quantity = parseInt(getVal("offer_quantity"));
      const minimum_quantity = parseInt(getVal("minimum_quantity"));

      // ✅ Custom Validations
      if (selling_price >= original_price) {
        alert("❌ Selling Price must be less than Original Price.");
        return;
      }

      if (offer_quantity >= minimum_quantity) {
        alert("❌ Offer Quantity must be less than Minimum Quantity.");
        return;
      }

      const body = {
        product_name: getVal("product_name"),
        original_price,
        selling_price,
        offer_quantity,
        minimum_quantity,
        unit: getVal("unit"),
        industry: parseInt(getVal("industry")),
        sub_industry: parseInt(getVal("sub_industry")),
        state_id: parseInt(getVal("state_id")),
        city: getVal("city"),
        description: getVal("description"),
        dimensions: getVal("dimensions"),
      };

      try {
        const response = await fetch(`${stockout_base_url}/product`, {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
            Authorization: `Bearer ${stockout_token}`,
          },
          body: JSON.stringify(body),
        });

        const res = await response.json();
        if (res.success) {
          alert("✅ Product added successfully!");
          window.location.href = "pages/account.php";
        } else {
          alert("❌ Error: " + res.message);
        }
      } catch (err) {
        alert("❌ Submission failed: " + err.message);
      }
    });
  });
</script>
