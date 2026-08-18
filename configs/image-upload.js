/**
 * Normalize camera/gallery picks so uploads work reliably on mobile browsers.
 */
async function normalizeImageFiles(fileList) {
  const files = Array.from(fileList || []);
  const normalized = await Promise.all(files.map((file) => normalizeImageFile(file)));
  return normalized.filter(Boolean);
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

  if (isHeic && typeof heic2any !== "undefined") {
    try {
      const converted = await heic2any({ blob: file, toType: "image/jpeg", quality: 0.9 });
      const blob = Array.isArray(converted) ? converted[0] : converted;
      return new File([blob], `camera_${Date.now()}.jpg`, {
        type: "image/jpeg",
        lastModified: Date.now(),
      });
    } catch (err) {
      console.warn("HEIC conversion failed:", err);
    }
  }

  const needsRename =
    !name ||
    !name.includes(".") ||
    /^image\d*\.(jpe?g|png|webp|heic|heif)$/i.test(name);

  const outputType = type === "image/png" ? "image/png" : "image/jpeg";
  const outputExt = outputType === "image/png" ? "png" : "jpg";
  const safeName = needsRename
    ? `camera_${Date.now()}_${Math.random().toString(36).slice(2, 7)}.${outputExt}`
    : name;

  if (
    !type ||
    type === "image/jpeg" ||
    type === "image/jpg" ||
    type === "image/png" ||
    type === "image/webp"
  ) {
    try {
      const blob = await canvasReencode(file, outputType);
      return new File([blob], safeName, { type: blob.type, lastModified: Date.now() });
    } catch (err) {
      console.warn("Image re-encode failed, using renamed original:", err);
      return new File([file], safeName, {
        type: type || "image/jpeg",
        lastModified: Date.now(),
      });
    }
  }

  return new File([file], safeName, {
    type: type || "image/jpeg",
    lastModified: Date.now(),
  });
}

function canvasReencode(file, mimeType = "image/jpeg", quality = 0.92) {
  return new Promise((resolve, reject) => {
    const reader = new FileReader();
    reader.onload = (e) => {
      const img = new Image();
      img.onload = () => {
        const canvas = document.createElement("canvas");
        canvas.width = img.naturalWidth || img.width;
        canvas.height = img.naturalHeight || img.height;
        canvas.getContext("2d").drawImage(img, 0, 0);
        canvas.toBlob(
          (blob) => (blob ? resolve(blob) : reject(new Error("Canvas toBlob failed"))),
          mimeType,
          quality
        );
      };
      img.onerror = () => reject(new Error("Image load failed"));
      img.src = e.target.result;
    };
    reader.onerror = () => reject(new Error("FileReader failed"));
    reader.readAsDataURL(file);
  });
}

function appendImageFilesToFormData(formData, files, fieldName = "files") {
  files.forEach((file, index) => {
    formData.append(`${fieldName}[${index}]`, file, file.name);
  });
}
