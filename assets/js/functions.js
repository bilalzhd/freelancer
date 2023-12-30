function addPictureToInput(inputId) {
  const imageInput = document.getElementById(inputId);

  imageInput?.addEventListener("change", (event) => {
    const file = event.target.files[0];

    // Check if the selected file is an image
    if (file.type.startsWith("image/")) {
      const reader = new FileReader();

      reader.onload = (event) => {
        const img = document.querySelector(".relative > .space-y-1 > svg");
        img.classList.add("hidden"); // Hide the placeholder SVG

        const imgContainer = document.querySelector(".relative");
        // if (imgContainer) {
          imgContainer.style.backgroundImage = `url(${event.target.result})`;
          imgContainer.style.backgroundSize = "contain";
          imgContainer.style.backgroundPosition = "center";
          imgContainer.style.backgroundRepeat = "no-repeat";
        // }
      };

      reader.readAsDataURL(file);
    } else {
      alert("Please select an image file.");
    }
  });
}
