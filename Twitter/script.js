let dropdown = document.getElementById("postSorterDropDown");
const lastSelected = localStorage.getItem("lastSelected");

dropdown.value = lastSelected || "recency";

function submitForm() {
  localStorage.setItem("lastSelected", dropdown.value);
  document.getElementById("postSorterContainer").submit();
}

window.addEventListener("load", function() {
  dropdown.addEventListener("change", submitForm);
});