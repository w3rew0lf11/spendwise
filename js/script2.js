const currencies = [
  { code: "NPR", name: "Nepalese Rupee" },          // Default selected
  { code: "INR", name: "Indian Rupee" },
  { code: "CNY", name: "Chinese Yuan" },
  { code: "USD", name: "United States Dollar" },
  { code: "EUR", name: "Euro" },
  { code: "GBP", name: "British Pound" },
  { code: "JPY", name: "Japanese Yen" },
  { code: "AUD", name: "Australian Dollar" }
];

const currencyDropdown = document.getElementById("currency-dropdown");

currencies.forEach(curr => {
  const option = document.createElement("option");
  option.value = curr.code;
  option.text = `${curr.code} - ${curr.name}`;
  
  // Set NPR as default selected
  if (curr.code === "NPR") {
    option.selected = true;
  }

  currencyDropdown.appendChild(option);
});
const categories = [
  "Housing & Utilities",
  "Transportation",
  "Food & Dining",
  "Shopping & Personal",
  "Health & Wellness",
  "Travel & Vacation",
  "Education",
  "Entertainment & Leisure",
  "Gifts & Donations",
  "Financial & Insurance",
  "Miscellaneous"
];

function populateCategoryDropdown() {
  const select = document.querySelector('select[name="category"]');
  select.innerHTML = '<option disabled selected>Select category</option>';

  categories.forEach(category => {
    const option = document.createElement("option");
    option.textContent = category;
    option.value = category;
    select.appendChild(option);
  });
}

// Initialize on page load
document.addEventListener("DOMContentLoaded", populateCategoryDropdown);
