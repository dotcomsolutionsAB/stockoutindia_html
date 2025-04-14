<base href="../">
<?php include("../header.php") ?>
<?php include("../configs/config_static_data.php"); ?>

<main class="main global_page ">
    <nav aria-label="breadcrumb" class="breadcrumb-nav">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="../index.php">Home</a></li>
                <li class="breadcrumb-item"><a href="#">Faqs</a></li>
            </ol>
        </div>
    </nav>
    <section class="faq_section">
  <div class="faq_container">
    <!-- Left Title -->
    <div class="faq_title">
      <h2>Frequently<br>asked<br>questions</h2>
    </div>

    <!-- Right Accordion List -->
    <div id="faq_list" class="faq_list">
      <!-- FAQs will be injected here -->
    </div>
  </div>
</section>

</main>
<script>
  document.addEventListener("DOMContentLoaded", async function () {
    const faq_list = document.getElementById("faq_list");

    try {
      const response = await fetch('<?php echo BASE_URL; ?>/faqs');
      const result = await response.json();

      if (result.status && Array.isArray(result.data)) {
        faq_list.innerHTML = result.data.map((faq, index) => `
          <div class="faq_item">
            <button class="faq_question" onclick="faq_toggle(${index})">
              ${faq.question}
              <span id="faq_icon_${index}" class="faq_icon">&#9660;</span>
            </button>
            <div id="faq_answer_${index}" class="faq_answer">${faq.answer}</div>
          </div>
        `).join("");
      } else {
        faq_list.innerHTML = `<p>No FAQs found.</p>`;
      }
    } catch (error) {
      console.error("❌ FAQ fetch failed:", error);
      faq_list.innerHTML = `<p>Failed to load FAQs.</p>`;
    }
  });

  function faq_toggle(index) {
    // Close all first
    document.querySelectorAll('.faq_answer').forEach(el => el.style.display = 'none');
    document.querySelectorAll('.faq_icon').forEach(el => el.classList.remove('rotate'));

    const answer = document.getElementById(`faq_answer_${index}`);
    const icon = document.getElementById(`faq_icon_${index}`);

    if (answer.style.display !== 'block') {
      answer.style.display = 'block';
      icon.classList.add('rotate');
    }
  }
</script>

<style>
  .faq_section {
    max-width: 1200px;
    margin: 0 auto;
    padding: 60px 20px;
    font-family: Arial, sans-serif;
  }

  .faq_container {
    display: flex;
    flex-wrap: wrap;
    gap: 40px;
  }

  .faq_title {
    flex: 1;
    min-width: 250px;
  }

  .faq_title h2 {
    font-size: 42px;
    line-height: 1.2;
    color: #111;
  }

  .faq_list {
    flex: 2;
    min-width: 300px;
    display: flex;
    flex-direction: column;
    gap: 16px;
  }

  .faq_item {
    border-radius: 10px;
    background-color: #f6f4f5;
    overflow: hidden;
    border: 1px solid #e0e0e0;
  }

  .faq_question {
    width: 100%;
    padding: 18px 20px;
    text-align: left;
    font-size: 16px;
    font-weight: 600;
    background: transparent;
    border: none;
    outline: none;
    cursor: pointer;
    display: flex;
    justify-content: space-between;
    align-items: center;
  }

  .faq_question:hover {
    background-color: #eee;
  }

  .faq_icon {
    transition: transform 0.3s ease;
  }

  .faq_icon.rotate {
    transform: rotate(180deg);
  }

  .faq_answer {
    display: none;
    padding: 0 20px 16px;
    font-size: 14px;
    color: #555;
  }

  @media screen and (max-width: 768px) {
    .faq_container {
      flex-direction: column;
    }

    .faq_title {
      text-align: center;
    }
  }
</style>



<?php include("../footer.php") ?>