document.addEventListener("DOMContentLoaded", function () {
  const addProductBtn = document.getElementById("add-product");
  const productList = document.getElementById("product-list");
  const productTemplate = document.getElementById("product-template");

  if (addProductBtn) {
    addProductBtn.addEventListener("click", function () {
      const newItem = productTemplate.firstElementChild.cloneNode(true);
      productList.appendChild(newItem);
    });
  }

  if (productList) {
    productList.addEventListener("click", function (e) {
      if (
        e.target &&
        (e.target.matches(".remove-product") ||
          e.target.parentElement.matches(".remove-product"))
      ) {
        const productItem = e.target.closest(".product-item");
        if (productItem) {
          productItem.remove();
        }
      }
    });
  }
});
