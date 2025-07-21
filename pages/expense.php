<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>SpendWise - Add Expense</title>
 
  <link rel="stylesheet" href="/spendwise/css/sidebar.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <style>
   body {
  margin: 0;
  font-family: 'Segoe UI', sans-serif;
  background: linear-gradient(135deg, #dceeff, #f0faff);
  height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
  overflow: hidden;
  position: relative;
}

canvas#animated-bg {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  z-index: -1;
}

.container {
  width: 100%;
  max-width: 800px;
  padding: 20px;
}

.expense-form-wrapper {
  background: rgba(255, 255, 255, 0.95);
  padding: 40px 30px;
  border-radius: 18px;
  box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
  backdrop-filter: blur(4px);
  animation: fadeIn 0.6s ease-in-out;
}

.section-title {
  text-align: center;
  font-size: 24px;
  color: #2563eb;
  margin-bottom: 30px;
}

.form-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
  gap: 20px;
}

.form-group {
  display: flex;
  flex-direction: column;
}

.full-width {
  grid-column: span 2;
}

label {
  font-weight: 600;
  margin-bottom: 8px;
  color: #333;
}

input[type="text"],
input[type="number"],
input[type="date"],
select {
  padding: 12px 14px;
  border: 1px solid #d1d5db;
  border-radius: 10px;
  font-size: 15px;
  background-color: #fff;
  transition: border 0.2s ease;
}

input:focus,
select:focus {
  border-color: #2563eb;
  outline: none;
}

.file-upload {
  border: 2px dashed #cbd5e1;
  text-align: center;
  padding: 20px;
  border-radius: 12px;
  transition: background 0.3s ease;
  cursor: pointer;
  background: #f9fafb;
}

.file-upload:hover {
  background-color: #f1f5f9;
}

.form-buttons {
  margin-top: 30px;
  display: flex;
  justify-content: center;
  gap: 15px;
}

.btn {
  padding: 12px 20px;
  border-radius: 10px;
  font-size: 15px;
  font-weight: 600;
  cursor: pointer;
  border: none;
  transition: background-color 0.3s ease;
}

.btn-primary {
  background-color: #2563eb;
  color: white;
}

.btn-primary:hover {
  background-color: #1746c7;
}

.btn-secondary {
  background-color: #e2e8f0;
}

.btn-secondary:hover {
  background-color: #cbd5e1;
}

@keyframes fadeIn {
  from { opacity: 0; transform: translateY(-10px); }
  to { opacity: 1; transform: translateY(0);}
}

  </style>
</head>
<body>
  <canvas id="animated-bg"></canvas>

  <div class="container">
    <!-- Sidebar -->
     <div class="sidebar">
     <?php include('../includes/sidebar.php'); ?>
     </div>
    <div class="expense-form-wrapper">
      <h2 class="section-title"><i class="fas fa-wallet"></i> Add New Expense</h2>
      <form class="form expense-form" method="POST" action="includes/saveExpense.php" enctype="multipart/form-data">

        <div class="form-grid">
          <!-- Amount -->
          <div class="form-group">
            <label><i class="fas fa-money-bill-wave"></i> Amount</label>
            <input type="number" name="amount" placeholder="Enter amount" required />
          </div>

          <!-- Currency -->
          <div class="form-group">
            <label><i class="fas fa-coins"></i> Currency</label>
            <select id="currency-dropdown" name="currency" required></select>
          </div>

          <!-- Category -->
          <div class="form-group full-width">
            <label><i class="fas fa-list"></i> Category</label>
            <select name="category" required>
              <option disabled selected>Select category</option>
              <optgroup label="Housing & Utilities">
                <option>Rent</option>
                <option>Mortgage</option>
                <option>Electricity</option>
                <option>Water</option>
                <option>Gas</option>
                <option>Internet</option>
                <option>Mobile Phone</option>
                <option>Home Repairs</option>
              </optgroup>
              <optgroup label="Transportation">
                <option>Fuel</option>
                <option>Public Transport</option>
                <option>Taxi</option>
                <option>Car Maintenance</option>
                <option>Car Insurance</option>
                <option>Parking</option>
              </optgroup>
              <optgroup label="Food & Dining">
                <option>Groceries</option>
                <option>Restaurants</option>
                <option>Takeout</option>
                <option>Snacks</option>
              </optgroup>
              <optgroup label="Shopping & Personal">
                <option>Clothing</option>
                <option>Electronics</option>
                <option>Personal Care</option>
              </optgroup>
              <optgroup label="Health & Wellness">
                <option>Doctor Visits</option>
                <option>Medications</option>
                <option>Dental Care</option>
                <option>Health Insurance</option>
                <option>Fitness</option>
              </optgroup>
              <optgroup label="Travel & Vacation">
                <option>Flight</option>
                <option>Hotel</option>
                <option>Tour</option>
                <option>Transport</option>
              </optgroup>
              <optgroup label="Education">
                <option>Tuition</option>
                <option>Books</option>
                <option>Courses</option>
              </optgroup>
              <optgroup label="Entertainment & Leisure">
                <option>Movies</option>
                <option>Streaming</option>
                <option>Hobbies</option>
              </optgroup>
              <optgroup label="Gifts & Donations">
                <option>Gift</option>
                <option>Donation</option>
                <option>Offering</option>
              </optgroup>
              <optgroup label="Financial & Insurance">
                <option>Loan</option>
                <option>Credit Card</option>
                <option>Investment</option>
                <option>Tax</option>
              </optgroup>
              <optgroup label="Miscellaneous">
                <option>Pet</option>
                <option>Laundry</option>
                <option>Emergency</option>
                <option>Other</option>
              </optgroup>
            </select>
          </div>

          <!-- Date -->
          <div class="form-group">
            <label><i class="fas fa-calendar-alt"></i> Date</label>
            <input type="date" name="date" required />
          </div>

          <!-- Description -->
          <div class="form-group">
            <label><i class="fas fa-align-left"></i> Description</label>
            <input type="text" name="description" placeholder="E.g., Office lunch or taxi ride" />
          </div>

          <!-- File Upload -->
          <div class="form-group full-width">
            <label><i class="fas fa-file-upload"></i> Upload Receipt (Optional)</label>
            <div class="file-upload">
              <label for="receipt-upload">
                <img src="https://cdn-icons-png.flaticon.com/512/3585/3585207.png" width="40" />
                <p>Choose file or drag here</p>
                <input type="file" id="receipt-upload" name="receipt" hidden />
              </label>
            </div>
          </div>
        </div>

        <!-- Buttons -->
        <div class="form-buttons">
          <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Save</button>
          <button type="reset" class="btn btn-secondary">Cancel</button>
        </div>
      </form>
    </div>
  </div>
  </body>
  </html>

  <script >
    const currencies = [
  { code: "AED", name: "United Arab Emirates Dirham" },
  { code: "AFN", name: "Afghan Afghani" },
  { code: "ALL", name: "Albanian Lek" },
  { code: "AMD", name: "Armenian Dram" },
  { code: "ANG", name: "Netherlands Antillean Guilder" },
  { code: "AOA", name: "Angolan Kwanza" },
  { code: "ARS", name: "Argentine Peso" },
  { code: "AUD", name: "Australian Dollar" },
  { code: "AWG", name: "Aruban Florin" },
  { code: "AZN", name: "Azerbaijani Manat" },
  { code: "BAM", name: "Bosnia-Herzegovina Convertible Mark" },
  { code: "BBD", name: "Barbadian Dollar" },
  { code: "BDT", name: "Bangladeshi Taka" },
  { code: "BGN", name: "Bulgarian Lev" },
  { code: "BHD", name: "Bahraini Dinar" },
  { code: "BIF", name: "Burundian Franc" },
  { code: "BMD", name: "Bermudian Dollar" },
  { code: "BND", name: "Brunei Dollar" },
  { code: "BOB", name: "Bolivian Boliviano" },
  { code: "BRL", name: "Brazilian Real" },
  { code: "BSD", name: "Bahamian Dollar" },
  { code: "BTN", name: "Bhutanese Ngultrum" },
  { code: "BWP", name: "Botswana Pula" },
  { code: "BYN", name: "Belarusian Ruble" },
  { code: "BZD", name: "Belize Dollar" },
  { code: "CAD", name: "Canadian Dollar" },
  { code: "CDF", name: "Congolese Franc" },
  { code: "CHF", name: "Swiss Franc" },
  { code: "CLP", name: "Chilean Peso" },
  { code: "CNY", name: "Chinese Yuan" },
  { code: "COP", name: "Colombian Peso" },
  { code: "CRC", name: "Costa Rican Colón" },
  { code: "CUC", name: "Cuban Convertible Peso" },
  { code: "CUP", name: "Cuban Peso" },
  { code: "CVE", name: "Cape Verdean Escudo" },
  { code: "CZK", name: "Czech Koruna" },
  { code: "DJF", name: "Djiboutian Franc" },
  { code: "DKK", name: "Danish Krone" },
  { code: "DOP", name: "Dominican Peso" },
  { code: "DZD", name: "Algerian Dinar" },
  { code: "EGP", name: "Egyptian Pound" },
  { code: "ERN", name: "Eritrean Nakfa" },
  { code: "ETB", name: "Ethiopian Birr" },
  { code: "EUR", name: "Euro" },
  { code: "FJD", name: "Fijian Dollar" },
  { code: "FKP", name: "Falkland Islands Pound" },
  { code: "GBP", name: "British Pound Sterling" },
  { code: "GEL", name: "Georgian Lari" },
  { code: "GGP", name: "Guernsey Pound" },
  { code: "GHS", name: "Ghanaian Cedi" },
  { code: "GIP", name: "Gibraltar Pound" },
  { code: "GMD", name: "Gambian Dalasi" },
  { code: "GNF", name: "Guinean Franc" },
  { code: "GTQ", name: "Guatemalan Quetzal" },
  { code: "GYD", name: "Guyanese Dollar" },
  { code: "HKD", name: "Hong Kong Dollar" },
  { code: "HNL", name: "Honduran Lempira" },
  { code: "HRK", name: "Croatian Kuna" },
  { code: "HTG", name: "Haitian Gourde" },
  { code: "HUF", name: "Hungarian Forint" },
  { code: "IDR", name: "Indonesian Rupiah" },
  { code: "ILS", name: "Israeli New Shekel" },
  { code: "INR", name: "Indian Rupee" },
  { code: "IQD", name: "Iraqi Dinar" },
  { code: "IRR", name: "Iranian Rial" },
  { code: "ISK", name: "Icelandic Króna" },
  { code: "JMD", name: "Jamaican Dollar" },
  { code: "JOD", name: "Jordanian Dinar" },
  { code: "JPY", name: "Japanese Yen" },
  { code: "KES", name: "Kenyan Shilling" },
  { code: "KGS", name: "Kyrgystani Som" },
  { code: "KHR", name: "Cambodian Riel" },
  { code: "KMF", name: "Comorian Franc" },
  { code: "KPW", name: "North Korean Won" },
  { code: "KRW", name: "South Korean Won" },
  { code: "KWD", name: "Kuwaiti Dinar" },
  { code: "KYD", name: "Cayman Islands Dollar" },
  { code: "KZT", name: "Kazakhstani Tenge" },
  { code: "LAK", name: "Laotian Kip" },
  { code: "LBP", name: "Lebanese Pound" },
  { code: "LKR", name: "Sri Lankan Rupee" },
  { code: "LRD", name: "Liberian Dollar" },
  { code: "LSL", name: "Lesotho Loti" },
  { code: "LYD", name: "Libyan Dinar" },
  { code: "MAD", name: "Moroccan Dirham" },
  { code: "MDL", name: "Moldovan Leu" },
  { code: "MGA", name: "Malagasy Ariary" },
  { code: "MKD", name: "Macedonian Denar" },
  { code: "MMK", name: "Myanma Kyat" },
  { code: "MNT", name: "Mongolian Tugrik" },
  { code: "MOP", name: "Macanese Pataca" },
  { code: "MRU", name: "Mauritanian Ouguiya" },
  { code: "MUR", name: "Mauritian Rupee" },
  { code: "MVR", name: "Maldivian Rufiyaa" },
  { code: "MWK", name: "Malawian Kwacha" },
  { code: "MXN", name: "Mexican Peso" },
  { code: "MYR", name: "Malaysian Ringgit" },
  { code: "MZN", name: "Mozambican Metical" },
  { code: "NAD", name: "Namibian Dollar" },
  { code: "NGN", name: "Nigerian Naira" },
  { code: "NIO", name: "Nicaraguan Córdoba" },
  { code: "NOK", name: "Norwegian Krone" },
  { code: "NPR", name: "Nepalese Rupee" },
  { code: "NZD", name: "New Zealand Dollar" },
  { code: "OMR", name: "Omani Rial" },
  { code: "PAB", name: "Panamanian Balboa" },
  { code: "PEN", name: "Peruvian Nuevo Sol" },
  { code: "PGK", name: "Papua New Guinean Kina" },
  { code: "PHP", name: "Philippine Peso" },
  { code: "PKR", name: "Pakistani Rupee" },
  { code: "PLN", name: "Polish Zloty" },
  { code: "PYG", name: "Paraguayan Guarani" },
  { code: "QAR", name: "Qatari Rial" },
  { code: "RON", name: "Romanian Leu" },
  { code: "RSD", name: "Serbian Dinar" },
  { code: "RUB", name: "Russian Ruble" },
  { code: "RWF", name: "Rwandan Franc" },
  { code: "SAR", name: "Saudi Riyal" },
  { code: "SBD", name: "Solomon Islands Dollar" },
  { code: "SCR", name: "Seychellois Rupee" },
  { code: "SDG", name: "Sudanese Pound" },
  { code: "SEK", name: "Swedish Krona" },
  { code: "SGD", name: "Singapore Dollar" },
  { code: "SHP", name: "Saint Helena Pound" },
  { code: "SLL", name: "Sierra Leonean Leone" },
  { code: "SOS", name: "Somali Shilling" },
  { code: "SRD", name: "Surinamese Dollar" },
  { code: "SSP", name: "South Sudanese Pound" },
  { code: "STN", name: "São Tomé and Príncipe Dobra" },
  { code: "SYP", name: "Syrian Pound" },
  { code: "SZL", name: "Swazi Lilangeni" },
  { code: "THB", name: "Thai Baht" },
  { code: "TJS", name: "Tajikistani Somoni" },
  { code: "TMT", name: "Turkmenistani Manat" },
  { code: "TND", name: "Tunisian Dinar" },
  { code: "TOP", name: "Tongan Paʻanga" },
  { code: "TRY", name: "Turkish Lira" },
  { code: "TTD", name: "Trinidad and Tobago Dollar" },
  { code: "TWD", name: "New Taiwan Dollar" },
  { code: "TZS", name: "Tanzanian Shilling" },
  { code: "UAH", name: "Ukrainian Hryvnia" },
  { code: "UGX", name: "Ugandan Shilling" },
  { code: "USD", name: "United States Dollar" },
  { code: "UYU", name: "Uruguayan Peso" },
  { code: "UZS", name: "Uzbekistan Som" },
  { code: "VES", name: "Venezuelan Bolívar Soberano" },
  { code: "VND", name: "Vietnamese Dong" },
  { code: "VUV", name: "Vanuatu Vatu" },
  { code: "WST", name: "Samoan Tala" },
  { code: "XAF", name: "Central African CFA Franc" },
  { code: "XCD", name: "East Caribbean Dollar" },
  { code: "XOF", name: "West African CFA Franc" },
  { code: "XPF", name: "CFP Franc" },
  { code: "YER", name: "Yemeni Rial" },
  { code: "ZAR", name: "South African Rand" },
  { code: "ZMW", name: "Zambian Kwacha" },
  { code: "ZWL", name: "Zimbabwean Dollar" }
];

const currencyDropdown = document.getElementById("currency-dropdown");
currencies.forEach(curr => {
  const option = document.createElement("option");
  option.value = curr.code;
  option.text = ${curr.code} - ${curr.name};
  currencyDropdown.appendChild(option);
});
  </script>
