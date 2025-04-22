document.addEventListener("contextmenu", e => e.preventDefault());

document.addEventListener("keydown", e => {
    // Block F12
    if (e.key === "F12") {
        e.preventDefault();
        e.stopPropagation();
    }

    // Block Ctrl+U
    if (e.ctrlKey && e.key.toLowerCase() === "u") {
        e.preventDefault();
        e.stopPropagation();
    }

    // Block Ctrl+Shift+I
    if (e.ctrlKey && e.shiftKey && e.key.toLowerCase() === "i") {
        e.preventDefault();
        e.stopPropagation();
    }
});
