<base href="../">
<?php include("../header.php") ?>
<?php include("../configs/config_static_data.php"); ?> 
<?php include("../configs/auth_check.php"); ?>
		<main class="main">
            <section class="account_page">
                <div class="acc-sidebar">
                    <h2 class="acc-title">Account</h2>
                    <button id="tab-profile" class="acc-btn" onclick="showAccTab('profile')">Profile</button>
                    <button id="tab-products" class="acc-btn" onclick="showAccTab('products')">My Products</button>
                    <button id="tab-addProducts" class="acc-btn" onclick="showAccTab('addProducts')">Add Products</button>
                    <button id="tab-configurations" class="acc-btn" onclick="showAccTab('configurations')">Configurations</button>
                    <a href="#" class="header_icon" id="addProductBtn">
                        <i class="fas fa-plus-circle"></i>
                    </a> 
                    <button class="acc-btn acc-logout" onclick="accLogout()">Logout</button>
                </div>

                <div class="acc-main">
                    <div id="acc-profileTab" class="acc-tab-content acc-active">
                        <?php include("profile.php"); ?>
                    </div>

                    <div id="acc-productsTab" class="acc-tab-content">
                        <?php include("my-product.php"); ?>
                    </div>
                    <div id="acc-addProducts" class="acc-tab-content">

                    </div>

                    <div id="acc-configurationsTab" class="acc-tab-content">
                        <h3>Configure Your Datas</h3>
                    </div>
                </div>
            </section>

		</main><!-- End .main -->
<script>
    function showAccTab(tabId) {
        // Hide all tab contents
        document.querySelectorAll('.acc-tab-content').forEach(tab => tab.classList.remove('acc-active'));
        document.getElementById('acc-' + tabId + 'Tab').classList.add('acc-active');

        // Remove active styling from all buttons
        document.querySelectorAll('.acc-btn').forEach(btn => btn.classList.remove('acc-tab-active'));

        // Add active styling to clicked tab
        document.getElementById('tab-' + tabId).classList.add('acc-tab-active');
    }
    // Set default tab on load
    document.addEventListener("DOMContentLoaded", function () {
        showAccTab('profile');
    });
  function accLogout() {
    localStorage.removeItem("authToken");
    localStorage.removeItem("user_id");
    localStorage.removeItem("role");
    localStorage.removeItem("username");
    localStorage.removeItem("name");

    window.location.href = "login.php";
  }
</script>

<script>
  // Auto-fill inputs from localStorage on page load
  document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('name').value = localStorage.getItem('name') || '';
    document.getElementById('id').value = localStorage.getItem('user_id') || '';
    document.getElementById('role').value = localStorage.getItem('role') || '';
    document.getElementById('username').value = localStorage.getItem('username') || '';
    document.getElementById('token').value = localStorage.getItem('token') || '';
  });

  // Update localStorage from input values
  function updateAccountInfo() {
    localStorage.setItem('name', document.getElementById('name').value);
    localStorage.setItem('id', document.getElementById('user_id').value);
    localStorage.setItem('role', document.getElementById('role').value);
    localStorage.setItem('username', document.getElementById('username').value);
    localStorage.setItem('token', document.getElementById('token').value);
    alert('Account information updated successfully!');
  }
</script>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const BASE_URL = "https://api.stockoutindia.com/api"; 
        const authToken = localStorage.getItem("authToken");

        const addBtn = document.getElementById("addProductBtn");
        if (!addBtn || !authToken) return;

        addBtn.addEventListener("click", async function () {
            const formHtml = `
            <style>
                .alert_box_footer{
                    display: flex    ;
                    justify-content: space-between;
                    gap: 10px;
                }
                .alert_box_footer textarea{
                    width: 66%;
                    margin-top: 15px;
                    border: 1px solid #cccccc;
                    border-radius: 5px;
                    padding: 10px;
                }
                .alert_box_footer textarea{
                    margin-top: 15px;
                    margin-right: 30px;
                }
                .swal2-popup { width: 900px !important; }
                .swal2-form-grid {
                    display: grid;
                    grid-template-columns: repeat(3, 1fr);
                    gap: 15px;
                }
                .swal2-form-grid input,
                .swal2-form-grid select,
                .swal2-form-grid textarea {
                    width: 100% !important;
                    font-size: 14px !important;
                    padding: 8px 10px;
                    border-radius: 5px;
                    border: 1px solid #ccc;
                }
                .upload-box {
                    border: 2px dashed #ccc;
                    padding: 15px;
                    border-radius: 8px;
                    text-align: center;
                    cursor: pointer;
                    background: #fafafa;
                    transition: border-color 0.3s;
                }
                .upload-box:hover {
                    border-color: #e3342f;
                }
                .upload-box i {
                    font-size: 28px;
                    margin-bottom: 5px;
                    color: #e3342f;
                }
            </style>

            <form id="addProductForm" class="swal2-form">
                <div class="swal2-form-grid">
                    <input name="product_name" placeholder="Product Name" required>
                    <input name="original_price" type="number" step="0.01" placeholder="Original Price" required>
                    <input name="selling_price" type="number" step="0.01" placeholder="Selling Price" required>
                    
                    <input name="offer_quantity" type="number" placeholder="Offer Quantity" required>
                    <input name="minimum_quantity" type="number" placeholder="Minimum Quantity" required>
                    <select name="unit" id="unit" required>
                        <option value="">Loading Units...</option>
                    </select>

                    <select name="industry" id="industry" required>
                        <option value="">Loading Industries...</option>
                    </select>

                    <select name="sub_industry" id="sub_industry" disabled required>
                        <option value="">Select Sub-Industry</option>
                    </select>

                    <select name="state_id" id="state_id" required>
                        <option value="">Loading States...</option>
                    </select>

                    <select name="city" id="city" disabled required>
                        <option value="">Select City</option>
                    </select>

                    <input name="dimensions" placeholder="Dimensions (e.g., 50mm x 20mm x 35mm)">
                </div>
                <div class="alert_box_footer">
                    <textarea name="description" rows="3" placeholder="Product Description"></textarea>
                    <label for="imageUpload" class="upload-box">
                        <i class="fas fa-upload"></i><br>
                        Click to upload Product Image
                        <input type="file" name="image" accept="image/*" id="imageUpload" style="display:none">
                    </label>
                </div>
                
            </form>`;

            await Swal.fire({
                title: 'Add Product',
                html: formHtml,
                confirmButtonText: 'Submit',
                confirmButtonColor: '#e3342f',
                showCancelButton: true,
                didOpen: async () => {
                    // Make image clickable
                    document.querySelector('.upload-box').addEventListener('click', () => {
                        document.getElementById('imageUpload').click();
                    });

                    const unitSelect = document.getElementById('unit');
                    const industrySelect = document.getElementById('industry');
                    const subIndustrySelect = document.getElementById('sub_industry');
                    const stateSelect = document.getElementById('state_id');
                    const citySelect = document.getElementById('city');

                    let subIndustriesAll = [];
                    let citiesAll = [];

                    // Fetch Units
                    try {
                        const res = await fetch(`${BASE_URL}/product/get_units`, {
                            headers: {
                                Authorization: `Bearer ${authToken}`,
                                Accept: 'application/json'
                            },
                        });
                        const units = (await res.json()).data || [];
                        unitSelect.innerHTML = '<option value="">Select Unit</option>' +
                            units.map(u => `<option value="${u}">${u}</option>`).join('');
                    } catch {
                        unitSelect.innerHTML = '<option value="">Failed to load</option>';
                    }

                    // Fetch Industries
                    try {
                        const res = await fetch(`${BASE_URL}/industry`, {
                            headers: {
                                Authorization: `Bearer ${authToken}`,
                                Accept: 'application/json'
                            },
                        });
                        const industries = (await res.json()).data || [];
                        industrySelect.innerHTML = '<option value="">Select Industry</option>' +
                            industries.map(i => `<option value="${i.id}">${i.name}</option>`).join('');
                    } catch {
                        industrySelect.innerHTML = '<option value="">Failed to load</option>';
                    }

                    // Fetch Sub-Industries
                    try {
                        const res = await fetch(`${BASE_URL}/sub_industry`, {
                            headers: {
                                Authorization: `Bearer ${authToken}`,
                                Accept: 'application/json'
                            },
                        });
                        subIndustriesAll = (await res.json()).data || [];
                    } catch {
                        console.error("Sub-industries failed");
                    }

                    // Fetch States
                    try {
                        const res = await fetch(`${BASE_URL}/states`, {
                            headers: {
                                Authorization: `Bearer ${authToken}`,
                                Accept: 'application/json'
                            },
                        });
                        const states = (await res.json()).data || [];
                        stateSelect.innerHTML = '<option value="">Select State</option>' +
                            states.map(s => `<option value="${s.id}">${s.name}</option>`).join('');
                    } catch {
                        stateSelect.innerHTML = '<option value="">Failed to load</option>';
                    }

                    // Fetch Cities
                    try {
                        const res = await fetch(`${BASE_URL}/cities`, {
                            headers: {
                                Authorization: `Bearer ${authToken}`,
                                Accept: 'application/json'
                            },
                        });
                        citiesAll = (await res.json()).data || [];
                    } catch {
                        console.error("Cities failed");
                    }

                    // Handle Industry → Sub-Industry linkage
                    industrySelect.addEventListener('change', function () {
                        const selectedId = this.value;
                        const filtered = subIndustriesAll.filter(si => si.slug.startsWith(`${selectedId}_`));
                        subIndustrySelect.disabled = filtered.length === 0;
                        subIndustrySelect.innerHTML = '<option value="">Select Sub-Industry</option>' +
                            filtered.map(si => `<option value="${si.id}">${si.name}</option>`).join('');
                    });

                    // Handle State → City linkage
                    stateSelect.addEventListener('change', function () {
                        const selectedStateId = parseInt(this.value);
                        const selectedStateName = this.options[this.selectedIndex].text;
                        const filteredCities = citiesAll.filter(c => c.state_name === selectedStateName);
                        citySelect.disabled = filteredCities.length === 0;
                        citySelect.innerHTML = '<option value="">Select City</option>' +
                            filteredCities.map(c => `<option value="${c.name}">${c.name}</option>`).join('');
                    });
                },
                preConfirm: async () => {
                    const getVal = (name) => document.querySelector(`[name="${name}"]`)?.value?.trim() || "";

                    const body = {
                        product_name: getVal("product_name"),
                        original_price: parseFloat(getVal("original_price")),
                        selling_price: parseFloat(getVal("selling_price")),
                        offer_quantity: parseInt(getVal("offer_quantity")),
                        minimum_quantity: parseInt(getVal("minimum_quantity")),
                        unit: getVal("unit"),
                        industry: parseInt(getVal("industry")),
                        sub_industry: parseInt(getVal("sub_industry")),
                        state_id: parseInt(getVal("state_id")),
                        city: getVal("city"),
                        description: getVal("description"),
                        dimensions: getVal("dimensions")
                    };

                    // basic validation
                    if (!body.product_name) {
                        Swal.showValidationMessage("Product Name is required");
                        return false;
                    }

                    try {
                        const response = await fetch(`${BASE_URL}/product`, {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json",
                                Authorization: `Bearer ${authToken}`,
                                Accept: "application/json"
                            },
                            body: JSON.stringify(body)
                        });

                        const res = await response.json();
                        if (!res.success) throw new Error(res.message);
                        return res;
                    } catch (error) {
                        Swal.showValidationMessage(`Failed: ${error.message}`);
                    }
                }

            }).then(result => {
                if (result.isConfirmed && result.value?.success) {
                    Swal.fire('Success!', result.value.message, 'success').then(() => {
                        window.location.href = 'pages/account.php';
                    });
                }
            });

        });
    });
</script>
<?php include("../footer.php") ?>