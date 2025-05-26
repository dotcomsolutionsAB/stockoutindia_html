
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
      <label class="upload-box" id="customUploadBox">
        <i class="fas fa-upload"></i><br>
        Click to upload Product Image
      </label>
      <input type="file" name="files[]" id="stockout_image_upload" accept="image/*" style="display:none" multiple>
      <!-- <span id="fileNamePreview" style="display:block; font-size: 13px; color: #555;"></span> -->
       <span id="fileNamePreview" style="display: flex; flex-wrap: wrap; gap: 10px; margin-top: 10px;"></span>
    </div>

    <br>
    <button type="submit" class="btn btn-danger subss">Submit</button>
  </form>
</section>

<style>
  .image-modal-overlay {
    position: fixed;
    z-index: 1000;
    top: 0; left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.7);
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .image-modal-content {
    position: relative;
    background: #fff;
    padding: 10px;
    border-radius: 8px;
    max-width: 90%;
    max-height: 90%;
    overflow: auto;
    box-shadow: 0 0 15px rgba(0,0,0,0.3);
  }

  .image-modal-content img {
    max-width: 100%;
    max-height: 80vh;
    display: block;
    margin: auto;
    border-radius: 6px;
  }

  .image-modal-close {
    position: absolute;
    top: 10px;
    right: 12px;
    font-size: 28px;
    font-weight: bold;
    color: #333;
    cursor: pointer;
  }

  #fileNamePreview {
    display: flex;
    flex-wrap: wrap;
    gap: 12px;
    margin-top: 10px;
  }

  .image-preview-wrapper {
    width: 120px;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 8px;
    background-color: #f9f9f9;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: flex-start;
    box-shadow: 0 1px 3px rgba(0,0,0,0.05);
  }

  .image-preview-img {
    max-width: 100%;
    max-height: 100px;
    object-fit: contain;
    margin-bottom: 6px;
    border-radius: 4px;
  }

  .image-preview-name {
    font-size: 12px;
    text-align: center;
    word-break: break-word;
    color: #555;
  }

</style>

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

    // Image upload - custom trigger
    document.getElementById("customUploadBox").addEventListener("click", () => {
      document.getElementById("stockout_image_upload").click();
    });

    // Show selected file name(s)
    document.getElementById("stockout_image_upload").addEventListener("change", function () {
      const fileNameDisplay = document.getElementById("fileNamePreview");
      const files = Array.from(this.files);
      fileNameDisplay.innerHTML = ""; // Clear previous previews

      if (files.length > 0) {
        files.forEach(file => {
          const reader = new FileReader();

          reader.onload = function (e) {
            const wrapper = document.createElement("div");
            wrapper.className = "image-preview-wrapper";

            const img = document.createElement("img");
            img.src = e.target.result;
            img.alt = file.name;
            img.className = "image-preview-img";

            // 👇 Add click event to open full preview modal
            img.addEventListener("click", () => {
              showImagePreviewModal(e.target.result, file.name);
            });

            const label = document.createElement("div");
            label.className = "image-preview-name";
            label.textContent = file.name;

            wrapper.appendChild(img);
            wrapper.appendChild(label);
            fileNameDisplay.appendChild(wrapper);
          };

          reader.readAsDataURL(file);
        });
      }
    });

    function showImagePreviewModal(src, filename) {
      const modalOverlay = document.createElement("div");
      modalOverlay.className = "image-modal-overlay";

      const modalContent = document.createElement("div");
      modalContent.className = "image-modal-content";

      const modalImg = document.createElement("img");
      modalImg.src = src;
      modalImg.alt = filename;

      const closeButton = document.createElement("span");
      closeButton.className = "image-modal-close";
      closeButton.innerHTML = "&times;";
      closeButton.onclick = () => document.body.removeChild(modalOverlay);

      modalContent.appendChild(closeButton);
      modalContent.appendChild(modalImg);
      modalOverlay.appendChild(modalContent);
      document.body.appendChild(modalOverlay);

      // ✅ Close modal when clicking outside the image (on overlay)
      modalOverlay.addEventListener("click", function (e) {
        if (e.target === modalOverlay) {
          document.body.removeChild(modalOverlay);
        }
      });

    }


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
        alert("❌ Selling Price must be lesser than Original Price.");
        return;
      }

      if (offer_quantity < minimum_quantity) {
        alert("❌ Offer Quantity must be greater than Minimum Quantity.");
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

        if (res.success && res.data?.id) {
          const productId = res.data.id;

          // ✅ Upload image now
          const fileInput = document.getElementById("stockout_image_upload");
          const files = fileInput.files;

          if (files.length > 0) {
            const formData = new FormData();
            for (let i = 0; i < files.length; i++) {
              formData.append("files[]", files[i]); // ✅ Correct key name
            }

            const imageUpload = await fetch(`${stockout_base_url}/product/images/${productId}`, {
              method: "POST",
              headers: {
                Authorization: `Bearer ${stockout_token}`, // ✅ only this, no content-type!
              },
              body: formData,
            });

            const imageRes = await imageUpload.json();
            console.log("Image Upload Response:", imageRes);

            if (imageRes.success) {
              // alert("✅ Product & Image uploaded successfully!");
              window.location.href = `pages/make-payment?product_id=${productId}`;
              // window.location.reload();
            } else {
              alert("⚠️ Product added but image upload failed: " + imageRes.message);
              window.location.href = `pages/make-payment?product_id=${productId}`;
            }
          } else {
            alert("✅ Product added (No image uploaded)");
            // window.location.reload();
            window.location.href = `pages/make-payment?product_id=${productId}`;
          }
        } else {
          alert("❌ Error: " + res.message);
        }
      } catch (err) {
        alert("❌ Submission failed: " + err.message);
      }
    });

  });
</script>
