/**
 * Normalize camera/gallery picks so uploads work reliably on mobile browsers.
 * Resizes and compresses to avoid nginx/body-size "Failed to fetch" errors.
 */
const IMAGE_MAX_DIMENSION = 1600;
const IMAGE_JPEG_QUALITY = 0.78;
const IMAGE_MAX_BYTES = 2.5 * 1024 * 1024; // ~2.5MB after compress

async function normalizeImageFiles(fileList) {
  const files = Array.from(fileList || []);
  const normalized = [];
  for (const file of files) {
    const out = await normalizeImageFile(file);
    if (out) normalized.push(out);
  }
  return normalized;
}

async function normalizeImageFile(file) {
  if (!file) return null;

  const name = (file.name || "").trim();
  const type = (file.type || "").toLowerCase();
  const isHeic =
    /\.heic$/i.test(name) ||
    /\.heif$/i.test(name) ||
    type === "image/heic" ||
    type === "image/heif";

  let working = file;

  if (isHeic && typeof heic2any !== "undefined") {
    try {
      const converted = await heic2any({ blob: file, toType: "image/jpeg", quality: 0.85 });
      const blob = Array.isArray(converted) ? converted[0] : converted;
      working = new File([blob], `camera_${Date.now()}.jpg`, {
        type: "image/jpeg",
        lastModified: Date.now(),
      });
    } catch (err) {
      console.warn("HEIC conversion failed:", err);
    }
  }

  const safeName = `product_${Date.now()}_${Math.random().toString(36).slice(2, 7)}.jpg`;

  try {
    const blob = await resizeAndCompress(working, IMAGE_MAX_DIMENSION, IMAGE_JPEG_QUALITY);
    return new File([blob], safeName, { type: "image/jpeg", lastModified: Date.now() });
  } catch (err) {
    console.warn("Image compress failed, using original/renamed file:", err);
    if (working.size > IMAGE_MAX_BYTES) {
      throw new Error("Image is too large. Please choose a smaller photo.");
    }
    return new File([working], safeName, {
      type: working.type || "image/jpeg",
      lastModified: Date.now(),
    });
  }
}

function resizeAndCompress(file, maxDim, quality) {
  return new Promise((resolve, reject) => {
    const reader = new FileReader();
    reader.onload = (e) => {
      const img = new Image();
      img.onload = () => {
        let width = img.naturalWidth || img.width;
        let height = img.naturalHeight || img.height;

        if (!width || !height) {
          reject(new Error("Invalid image dimensions"));
          return;
        }

        if (width > maxDim || height > maxDim) {
          const ratio = Math.min(maxDim / width, maxDim / height);
          width = Math.round(width * ratio);
          height = Math.round(height * ratio);
        }

        const canvas = document.createElement("canvas");
        canvas.width = width;
        canvas.height = height;
        const ctx = canvas.getContext("2d");
        ctx.fillStyle = "#fff";
        ctx.fillRect(0, 0, width, height);
        ctx.drawImage(img, 0, 0, width, height);

        const tryBlob = (q) => {
          canvas.toBlob(
            (blob) => {
              if (!blob) {
                reject(new Error("Canvas toBlob failed"));
                return;
              }
              // If still too big, compress harder once more
              if (blob.size > IMAGE_MAX_BYTES && q > 0.5) {
                tryBlob(Math.max(0.5, q - 0.15));
                return;
              }
              resolve(blob);
            },
            "image/jpeg",
            q
          );
        };

        tryBlob(quality);
      };
      img.onerror = () => reject(new Error("Image load failed"));
      img.src = e.target.result;
    };
    reader.onerror = () => reject(new Error("FileReader failed"));
    reader.readAsDataURL(file);
  });
}

function appendImageFilesToFormData(formData, files, fieldName = "files") {
  files.forEach((file) => {
    // Laravel accepts files[] for array uploads
    formData.append(`${fieldName}[]`, file, file.name || "product.jpg");
  });
}
