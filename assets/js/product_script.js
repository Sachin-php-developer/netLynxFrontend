const base_url = 'http://localhost/netLynxFrontend/';

var local_location_id = localStorage.getItem("location_id");
var local_product_id = '';
var local_category_id = '';
var local_location_address = localStorage.getItem("location_address");
var local_product_price = '';
var local_product_name = '';


goto_product_tab();

function toggleDrop() {
  const dropdownContent = document.querySelector('.dropdown-content');
  dropdownContent.classList.toggle('active');
  const dropDownIcon = document.querySelector('.service-drop-icon');
  const dropUpIcon = document.querySelector('.drop-up-icon');

  if (dropdownContent.classList.contains('active')) {
    dropDownIcon.style.display = 'none';
    dropUpIcon.style.display = 'inline-block';
  } else {
    dropDownIcon.style.display = 'inline-block';
    dropUpIcon.style.display = 'none';
  }
}

function toggleDropTwo() {
  const dropdownContent = document.querySelector('.dropdown-contentTwo');
  dropdownContent.classList.toggle('active');
  const dropDownIcon = document.querySelector('.service-drop-iconTwo');
  const dropUpIcon = document.querySelector('.drop-up-iconTwo');

  if (dropdownContent.classList.contains('active')) {
    dropDownIcon.style.display = 'none';
    dropUpIcon.style.display = 'inline-block';
  } else {
    dropDownIcon.style.display = 'inline-block';
    dropUpIcon.style.display = 'none';
  }
}

function toggleDropTh() {
  const dropdownContent = document.querySelector('.dropdown-contentTh');
  dropdownContent.classList.toggle('active');
  const dropDownIcon = document.querySelector('.service-drop-iconTh');
  const dropUpIcon = document.querySelector('.drop-up-iconTh');

  if (dropdownContent.classList.contains('active')) {
    dropDownIcon.style.display = 'none';
    dropUpIcon.style.display = 'inline-block';
  } else {
    dropDownIcon.style.display = 'inline-block';
    dropUpIcon.style.display = 'none';
  }
}

function toggleDropdown() {
  const dropdownContent = document.querySelector('.dropdown-content-show');
  dropdownContent.classList.toggle('active');
}

function toggleDropdownOpen() {
  const dropdownContent = document.querySelector('.dropdown-content-shows');
  dropdownContent.classList.toggle('active');
}

function selectedItem(serviceSubItem) {
  serviceSubItem.classList.toggle('selected');
}

// Product dynamic html start
function goto_product_tab() {
    goto_product_html();
  
}
function goto_product_html()
  {
    $.ajax({
      type: 'POST',
      dataType: 'json',
      url: '' + base_url + 'Productcontroller/get_product_list',
      data: { },
      success: function (res, status, xhr) {
        if (res.status == false) {
          Swal.fire({
            title: "Error",
            text: res.message,
            icon: "error"
          });
        }
        else {
          var html = `<header id="header">
          <div class="container header-container">
              <h1 class="heading">Choose a Product</h1>
          </div>
       </header>
       <div class="container">
       <div class="main- m-staff-main">
         <div class="selected-service">`;
          $.each(res.data, function (key, val) {
            html += `<div class="wrap-drop mT-2 mmT-1">
            <div class="service-item" onclick="toggleDrop()">
              <div>
                <p class="service-text">`+ val.category_name + `</p>
              </div>
              <div class="dropdown-container">
                <div>
                  <i class="fa-solid fa-angle-down service-drop-icon" onclick="toggleDrop()"></i>
                  <i class="fa-solid fa-angle-up service-drop-icon drop-up-icon" onclick="toggleDrop()"></i>
                </div>
              </div>
            </div>
            <div class="dropdown-content">`;
            $.each(val.product, function (key1, val1) {
              html += `<div class="dropdown__ service-two">
                <div class="drop-details">
                 <div class="drop-img-box">
                   <img src="`+ val1.image + `" class="drop-img-"/>
                 </div>
                  <div class="service-details">
                    <h3 class="ser-name">`+ val1.product_name + `</h3>
                  </div>
                </div>
                <div>
                  <p class="ser-price">$`+ val1.price + `</p>
                </div>
                <div><button class="btn btn-success" onclick="goto_cart(` + val1.id + `,'`+val1.price+`',`+val.id+`,'`+val1.product_name+`')">Add to cart</button></div>
               </div>`;
            });
            html += `</div>
          </div>`;
          });
          html += `</div>
          </div>
          <footer id="footer" class="mt-auto service-footer">
         <div class="help-btn">
           <div>
               <a href="`+base_url+`" class="btn btn-primary back-btn">Back</a>
           </div>
           <div>
             <button type="button" class="btn btn-danger need-help-btn">Need Help?</button>
           </div>
          </div>
        </footer>
      </div>
      </div>`;
  
          $("#product_html").html(html);
  
        }
      }
    });
}

function goto_cart(product_id, product_price,category_id,product_name) {
    local_product_id = product_id;
    local_product_price = product_price;
    local_category_id = category_id;
    local_product_name = product_name;
    goto_cart_html();
}
function goto_cart_html()
{
var html = `<header id="header">
<div class="container header-container">
    <div class="cart-header">
        <h1 class="heading">Verify Confirmation</h1>
        <div class="cart-img-box">
        <img src="`+base_url+`assets/images/cartImg.png" class="cart-img-"/>
        </div>
    </div>
</div>
</header>
<div class="container">
<div class="main-">
<div class="cart-main">
<h2 class="confirmtext m-none">Your Confirmation</h2>
<div class="info-details">
    <div class="cart-info-details">
    <div>
        <h3 class="staff-cart-name-">Lineups
        <span>
        <div class="staff-cart-details-">
            <div class="cart-dots-icon">
            <i class="fa-solid fa-ellipsis-vertical"></i>
            </div>
        </div>
        </span>
        </h3>
    </div>
    <div>
        <p class="staff-info_">Product :
        <span class="staff-span-info_">
        `+local_product_name+`
        </span>
        </p>
    </div>
    <div>
        <p class="staff-info_">Location :
        <span class="staff-span-info_">
        `+local_location_address+`
        </span>
        </p>
    </div>
    <div>
        <p class="staff-info_ ">Amount :
        <span class="staff-span-info_ price-text">
        $`+local_product_price+`
        </span>
        </p>
    </div>
    <div class="confirm-btn">
    <button type="button" class="btn new-loc-btn" onclick="goto_information();">
        <i class="fa-regular fa-circle-check new-loc-btn-icon"></i>
        <p class="new-loc-btn-text">Confirm</p>
        </button>
    </div>
    </div>
</div>
</div>
</div>
<footer id="footer" class="mt-auto cart-footer m-cart-footer">
<div class="help-both-btns ">
<div class="help-btn m-help-btn-">
    <div>
    </div>
    <div>
    <button class="btn add-new-btn-" onclick="goto_product_html();"><img class="add-new-btn-img" src="`+base_url+`assets/images/add-circle.png"/>Add Another Product</button>
    </div>
</div>
<div class="help-btn m-help-btn">
    <div>
    <button type="button" class="btn btn-primary back-btn" onclick="goto_product_html();">Back</button>
    </div>
    <div>
    <button type="button" class="btn btn-danger need-help-btn">Need Help?</button>
    </div>
</div>
</div>
</footer>
</div>
</div>`;
$("#product_html").html(html);
}

function goto_information() {
    var html = `<header id="header">
    <div class="container header-container">
        <div class="cart-header">
          <h1 class="heading">Fill in your Information</h1>
          <div class="cart-img-box">
            <img src="`+base_url+`assets/images/cartImg.png" class="cart-img-"/>
          </div>
        </div>
    </div>
  </header>
  <form id="bookingForm" method="post">
  <div class="container">
  <div class="main- information-main-">
  <div class="cart-main info-main">
    <h2 class="confirmtext">Your Information</h2>
        <div class="info-main--">
          <div class="information-box">
            <div class="input-box">
              <label for="first_name" class="form-label">First Name<span>*</span></label>
              <input type="text" class="form-control" id="first_name" name="first_name" placeholder="First Name">
            </div>
            <div class="input-box">
              <label for="last_name" class="form-label">Last Name<span>*</span></label>
              <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Last Name">
            </div>
            <div class="input-box">
              <label for="email" class="form-label">Email<span>*</span></label>
              <input type="email" class="form-control" id="email" name="email" placeholder="staff@gmail.com">
            </div>
            <div class="input-box">
              <label for="phone" class="form-label">Phone<span>*</span></label>
              <input type="tel" class="form-control" id="phone" name="phone" placeholder="(111) 222-3333">
            </div>
            <input type="file" name="cust_image" id="cust_image">
            <div class="customer-img-box">
              <div class="customer-img-main">
                  <p class="form-label">Customer Picture</p>
                  <div class="customer-img-details">
                    <div class="customer-img-">
                      <img src="`+base_url+`assets/images/customer-img.png"/>
                  </div>
                  <div class="confirm-btn">
                    <button type="button" class="btn m-btns new-loc-btn">Search Image</button>
                  </div>
              </div>
              </div>
            </div>
          </div>
        </div>
  </div>
  </div>
  <footer id="footer" class="mt-auto cart-footer">
   <div class="help-both-btns ">
     <div class="help-btn">
      <div>
        <button type="button" class="btn m-btns btn-primary back-btn m-back-btn" onclick="goto_cart_html();">Back</button>
      </div>
      <div>
          <button type="button" class="btn m-btns email-btn" onclick="save_product_booking();">Send SMS / Email</button>
      </div>
      <div>
        <button type="button" class="btn m-btns btn-danger need-help-btn">Need Help?</button>
      </div>
     </div>
   </div>
  </footer>
  </form>
  </div>`;
  $("#product_html").html(html);
}

function save_product_booking()
{
  var file_data = $('#cust_image').prop('files')[0];   
    var form_data = new FormData();                  
    form_data.append('file', file_data);
    form_data.append('location_id', local_location_id);
    form_data.append('product_id', local_product_id);
    form_data.append('category_id', local_category_id);
    form_data.append('first_name', $("#first_name").val());
    form_data.append('last_name', $("#last_name").val());
    form_data.append('email', $("#email").val());
    form_data.append('phone', $("#phone").val());

  $.ajax({
    type: 'POST',
    dataType: 'json',
    url: '' + base_url + 'Productcontroller/save_product_booking',
    data: form_data,
    cache: false,
        contentType: false,
        processData: false,
    success: function (res, status, xhr) {
      if (res.status == false) {
        Swal.fire({
          title: "Error",
          text: res.message,
          icon: "error"
        });
      }
      else 
      {
        Swal.fire({
          title: res.message,
          icon: 'info',
          confirmButtonText: 'OK'
        }).then((result) => {
          if (result['isConfirmed']){
            goto_finish(res.booking_id);
          }
        })
      }
    }
  });
}
function goto_finish(booking_id)
{
  var html = `<header id="header">
  <div class="container header-container">
      <div class="cart-header">
        <h1 class="heading">Payment Method</h1>
        <div class="cart-img-box">
          <img src="`+base_url+`assets/images/cartImg.png" class="cart-img-"/>
        </div>
      </div>
  </div>
</header>
<div class="container">
<div class="main- m-staff-main">
<div class="cart-main">
  <h2 class="confirmtext">Select Payment Method</h2>
   <div class="payment-method">
     <div class="wrap-drop">
      <div class="pay-salon">
          <div class="pay-salon-details" onclick="goto_confirmed(`+booking_id+`)">
              <img src="`+base_url+`assets/images/pay-salonOne.png" class="pay-salon-img"/>
              <p class="pay-text">Pay At Salon</p>
              <img src="`+base_url+`assets/images/pay-salonTwo.png" class="pay-salon-img"/>
          </div>
      </div>
      <div class="dropdown-content-shows">
          <!-- <h1>hello</h1> -->
      </div>
     </div>
      <div class="wrap-drop">
          <div class="pay-salon mt-3" onclick="toggleDropdown()" >
              <div class="pay-salon-details">
                  <img src="`+base_url+`assets/images/credit-card.png" class="pay-salon-img"/>
                  <p class="pay-text">Credit Card</p>
              </div>
          </div>
          <div class="dropdown-content-show">
               <!-- Your dropdown text goes here -->
            <div class="inputs__">
              <div class="input-box">
                <label for="exampleFormControlInput1" class="form-label">Name as shown on card</label>
                <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="Name on card">
              </div>
              <div></div>
           </div>
           <div class="input-box card-number-input">
            <label for="exampleFormControlInput1" class="form-label">Credit card number</label>
            <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="Card number">
            <div class="all-cards">
              <img src="`+base_url+`assets/images/Payment.png" class="input-card-img"/>
              <img src="`+base_url+`assets/images/american-express.png" class="input-card-img"/>
              <img src="`+base_url+`assets/images/master-card.png" class="input-card-img"/>
              <img src="`+base_url+`assets/images/Diners.png" class="input-card-img"/>
            </div>
           </div>
           <div class="inputs__">
              <div class="input-box">
                <label for="exampleFormControlInput1" class="form-label">Expiry Date MM/YY</label>
                <input type="date" class="form-control" id="exampleFormControlInput1" placeholder="MM/YY">
              </div>
              <div class="input-box">
                <label for="exampleFormControlInput1" class="form-label">Security code</label>
                <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="Security code">
              </div>
              <div class="input-box country_">
               <label for="exampleFormControlInput1" class="form-label">Country</label>
               <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="Canada">
               <i class="fa-solid fa-angle-down country_icon"></i>
              </div>
              <div class="input-box">
                  <label for="exampleFormControlInput1" class="form-label">Postal code</label>
                  <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="Postal code">
                 </div>
           </div>
          </div>
      </div>
   </div>
</div>
</div>
<footer id="footer" class="mt-auto cart-footer">
 <div class="help-both-btns ">
   <div class="help-btn">
    <div>
      <button type="button" class="btn m-btns btn-primary back-btn m-back-btn" onclick="goto_product_html();">Back</button>
    </div>
    <div>
        <button type="button" class="btn m-btns new-loc-btn">Submit Payment</button>
    </div>
    <div>
      <button type="button" class="btn m-btns btn-danger need-help-btn">Need Help?</button>
    </div>
   </div>
 </div>
</footer>
  </div>`;
  $("#product_html").html(html);
}
function goto_confirmed(booking_id)
{
  var html = `<header id="header" class="confirmed-header">
  <div class="container header-container">
      <div class="cart-header confirmed-header">
        <h1 class="heading none">Verify Confirmation</h1>
      </div>
  </div>
</header>
<div class="container">
<div class="main- confirm-main mmain">
<div class="confirmed-card-main">
   <div class="confirmed-svg">
      <svg xmlns="http://www.w3.org/2000/svg" width="150" height="150" viewBox="0 0 213 213" fill="none">
          <path opacity="0.4" d="M106.5 195.25C155.515 195.25 195.25 155.515 195.25 106.5C195.25 57.4847 155.515 17.75 106.5 17.75C57.4847 17.75 17.75 57.4847 17.75 106.5C17.75 155.515 57.4847 195.25 106.5 195.25Z" fill="#04AC15"/>
          <path d="M93.8975 138.273C92.1225 138.273 90.4362 137.563 89.1937 136.32L64.0775 111.204C61.5037 108.63 61.5037 104.37 64.0775 101.796C66.6512 99.2227 70.9112 99.2227 73.485 101.796L93.8975 122.209L139.515 76.5914C142.089 74.0177 146.349 74.0177 148.923 76.5914C151.496 79.1652 151.496 83.4252 148.923 85.9989L98.6012 136.32C97.3587 137.563 95.6725 138.273 93.8975 138.273Z" fill="#04AC15"/>
        </svg>
   </div>
   <h2 class="confirm-text">Thank you for your purchase/s</h2>
   <p class="confirm-number-text">Your confirmation number :</p>
   <p class="confirm-number-number">#`+booking_id+`</p>
 </div>
</div>
  </div>`;
  $("#product_html").html(html);
}