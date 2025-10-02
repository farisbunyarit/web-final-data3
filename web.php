<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />
  <title>Fire Parts Store</title>
  <link rel="stylesheet" href="web.css" />
</head>

<body>
  <!-- Header -->
  <header>
    <div class="logo">
      <img src="https://thumbs.dreamstime.com/b/abstract-fire-logo-design-flame-line-icon-vector-concept-399153878.jpg"
        alt="Logo" />
      <h4>Fire Part</h4>
    </div>

    <div class="contact-info">
      <div class="contact-item">
        <span class="icon">📞</span>
        <a href="tel:+1234567890">+0618851311</a>
      </div>
      <div class="contact-item">
        <span class="icon">✉️</span>
        <a href="mailto:info@example.com">faris.bunyarit1@gmail.com</a>
      </div>
    </div>

    <!-- شريط التنقل -->
    <nav class="navbar" id="navbar">
      <ul>
        <li><a href="#bestsellers">best sellers</a></li>
        <li><a href="#products">products</a></li>
        <li><a href="#contact">Contact</a></li>
        <li><a href="#footer">Bottom</a></li>
      </ul>
    </nav>

    <!-- تاب بار للأجهزة اللوحية -->
    <nav id="tabBar" class="tab-bar">
      <ul>
        <li><a href="#navbar">Top</a></li>
        <li><a href="#bestsellers">best sellers</a></li>
        <li><a href="#products">products</a></li>
        <li><a href="#contact">Contact</a></li>
        <li><a href="#footer">Bottom</a></li>
      </ul>
    </nav>

    <!-- همبرغر مينو للأجهزة المحمولة -->
    <div id="hamburgerMenu" class="hamburger-menu" onclick="toggleHamburgerMenu()">
      &#9776;
    </div>

    <!-- قائمة التنقل (الهامبرغر) عند الضغط عليها -->
    <div id="mobileMenu" class="mobile-menu">
      <ul>
        <li><a href="#navbar">Top</a></li>
        <li><a href="#bestsellers">Best Sellers</a></li>
        <li><a href="#products">Products</a></li>
        <li><a href="#contact">Contact</a></li>
        <li><a href="#footer">Bottom</a></li>
      </ul>
    </div>
  </header>

  <!-- Search Form -->
  <section id="search-section">
    <input type="text" id="search-input" placeholder="Search for products..." onkeyup="searchProducts()" />
  </section>

  <div id="top-products-container">
    <h2>Most interactive:</h2>
    <div id="top-products-list">
      <!-- الكروت الأعلى راح تنعرض هنا -->
    </div>
  </div>

  <h2 style="text-align: center">Come Soon !!</h2>

  <div class="slideshow-container">
    <div class="mySlides fade">
      <div class="numbertext">1 / 3</div>
      <img
        src="https://m.media-amazon.com/images/I/71oO5BytTsL.jpg_BO30,255,255,255_UF900,850_SR1910,1000,0,C_QL100_.jpg"
        style="width: 100%" />
      <div class="text">Soon!!</div>
    </div>

    <div class="mySlides fade">
      <div class="numbertext">2 / 3</div>
      <img src="https://hips.hearstapps.com/hmg-prod.s3.amazonaws.com/images/test-pop-motorcyclegear-1583419560.jpg"
        style="width: 100%" />
      <div class="text">Soon!!</div>
    </div>

    <div class="mySlides fade">
      <div class="numbertext">3 / 3</div>
      <img
        src="https://m.media-amazon.com/images/I/71AynaGHzdL.jpg_BO30,255,255,255_UF900,850_SR1910,1000,0,C_QL100_.jpg"
        style="width: 100%" />
      <div class="text">Soon!!</div>
    </div>

    <a class="prev" onclick="plusSlides(-1)">❮</a>
    <a class="next" onclick="plusSlides(1)">❯</a>
  </div>
  <br />

  <div style="text-align: center">
    <span class="dot" onclick="currentSlide(1)"></span>
    <span class="dot" onclick="currentSlide(2)"></span>
    <span class="dot" onclick="currentSlide(3)"></span>
  </div>

   
<section id="products" class="products">
  <h2>Our Products</h2>
  <div class="product-cards">
    <?php 
    // 1. تضمين ملف الاتصال بقاعدة البيانات. (يجب أن يكون قد عرف متغير الاتصال مثل $conn)
    include '../includes/db_connection.php'; 
    
    // ** 2. الخطوة المفقودة: جلب البيانات وتخزينها في $result **
    $sql = "SELECT * FROM products";
    $result = $conn->query($sql);
    
    // 3. التحقق من وجود نتائج قبل بدء الحلقة
    if ($result && $result->num_rows > 0): 
      
      // عرض المنتجات بشكل ديناميكي
      while ($row = $result->fetch_assoc()): // تم تعديل { إلى : ليتناسب مع الكود HTML
        // لكل منتج سيتم استبدال القيم بالبيانات من قاعدة البيانات 
        ?> 
        <div class="product-card" onclick="increaseClickCount(this)">
          <img src="<?= $row['image_url'] ?>" alt="<?= $row['name'] ?>" />
          <div class="product-info">
            <h3><?= $row['name'] ?></h3>
            <p><?= $row['description'] ?></p>
            <span class="price"><?= $row['price'] ?> Baht</span>
            <form method="post" action="cart_action.php">
                <input type="hidden" name="action" value="add">
                <input type="hidden" name="product_id" value="<?= $row['id'] ?>">
                <input type="hidden" name="product_name" value="<?= $row['name'] ?>">
                <input type="hidden" name="product_price" value="<?= $row['price'] ?>">
                
                <input type="number" name="quantity" value="1" min="1" style="width: 50px;"> 
                <button type="submit" class="btn-primary">Add to Cart</button>
            </form>
          </div>
        </div>
      <?php 
      endwhile; // إغلاق حلقة while
    endif; // إغلاق شرط if
    
    // 4. إغلاق اتصال قاعدة البيانات (اختياري لكن يفضل)
    $conn->close();
    ?>
  </div>
</section>

  <!-- Best Sellers Section -->
  <section id="bestsellers" class="best-sellers">
    <h2>Best Sellers</h2>
    <table>
      <thead>
        <tr>
          <th>Product</th>
          <th>Price</th>
          <th>Sales</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>Motorcycle Helmet</td>
          <td>4,700 Baht</td>
          <td>320</td>
        </tr>
        <tr>
          <td>Brake Disc Rotor</td>
          <td>1,800 Baht</td>
          <td>280</td>
        </tr>
        <tr>
          <td>Throttle Grip</td>
          <td>650 Baht</td>
          <td>150</td>
        </tr>
      </tbody>
    </table>
  </section>

  <!-- Video Section -->
  <section id="video" class="video">
    <h2>Watch Our Product Video</h2>
    <iframe width="560" height="315" src="https://www.youtube.com/embed/qTur4tZHDus?si=H7tkN_BEzqZoSZI0"
      title="YouTube video player"
      allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
      allowfullscreen></iframe>
  </section>

  <!-- Special Offers Section -->
  <section id="offers" class="offers">
    <div class="offer-card">
      <h3>20% Off All Products!</h3>
      <p>Use code "FIRE20" at checkout.</p>
    </div>
    <div class="offer-card">
      <h3>Free Shipping on Orders over $500 Baht</h3>
      <p>Shop now and get free shipping on orders above $100 Baht!</p>
    </div>
    <div class="offer-card">
      <h3>Buy 2 Get 1 Free!</h3>
      <p>Buy any two products and get the third free! Limited time offer.</p>
    </div>
  </section>

  <!-- Customer Reviews Section -->
  <section id="reviews" class="reviews">
    <h2>Customer Reviews</h2>
    <div class="review">
      <p>"Great quality parts, highly recommended!" - Ali</p>
    </div>
    <div class="review">
      <p>"Fast delivery and excellent customer service!" - Sarah</p>
    </div>
    <div class="review">
      <p>
        "I’m very happy with the products I received, will definitely buy
        again!" - Mohammed
      </p>
    </div>
    <div class="review">
      <p>"Affordable and reliable. Highly recommend the store." - Maya</p>
    </div>
  </section>

  <!-- نموذج الاتصال -->
  <section id="contact">
    <h2>Contact Me</h2>
    <!--خاصية action تحدد المكان الذي سيتم إرسال البيانات إليه عندما يُرسل النموذج. # تعني أنه لا يتم إرسال البيانات إلى مكان آخر حاليًا (قد تحتاج إلى استبداله بعنوان URL حقيقي في تطبيقك-->
    <!--هناك أيضًا طريقة أخرى هي GET، لكننا نستخدم POST هنا لأن البيانات قد تكون كبيرة أو حساسة.-->
    <form id="contactForm" action="../includes/contact.php" method="POST">
      <!-- الاسم -->
      <input type="text" name="name" placeholder="Your Name" required title="Please enter your name." />

      <!-- الموضوع -->
      <input type="text" name="subject" placeholder="Subject" required title="Please enter a subject." />

      <!-- رقم الهاتف مع التحقق من أن الرقم يتكون من أرقام فقط -->
      <input type="tel" name="phone" placeholder="Phone Number" pattern="\d{10}" required
        title="Phone number must contain only 10 digits." />

      <!-- البريد الإلكتروني -->
      <input type="email" name="email" placeholder="Email" required pattern="[a-zA-Z0-9._%+-]+@ftu\.ac\.th"
        title="Email must be from @ftu.ac.th domain."
        oninvalid="this.setCustomValidity('Please enter an email that ends with @ftu.ac.th')"
        oninput="this.setCustomValidity('')" />

      <!-- كلمة السر مع شروط (حروف كبيرة، حروف صغيرة، أرقام، وحروف خاصة) -->
      <input type="password" name="secretword" placeholder="Secret Word" required
        pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*]).{8,}$"
        title="Password must have at least one uppercase letter, one lowercase letter, one number, one special character, and be at least 8 characters long." />

      <!-- رسالة المستخدم -->
      <textarea name="message" placeholder="Your Message" required title="Please enter your message."></textarea>

      <!-- زر إرسال -->
      <button type="submit">Send</button>
    </form>
  </section>

  <div class="count">
    <h4 id="h4">Visitor Count</h4>
    <!-- hitwebcounter Code START -->
    <a href="https://www.hitwebcounter.com/" target="_blank">
      <img src="https://hitwebcounter.com/counter/counter.php?page=21441273&style=0005&nbdigits=1&type=page&initCount=0"
        title="Counters" alt="Counters" border="0" class="counter-img" />
    </a>
  </div>

  <section class="weather-container">
    <div id="temp" class="temp"></div>
    <div id="condition" class="condition"></div>
    <div id="humidity" class="humidity"></div>
    <div id="wind" class="wind"></div>
    <div id="feelslike" class="feelslike"></div>
    <img id="weather-icon" alt="Weather Icon" />
  </section>

  <!-- Footer Section -->
  <footer id="footer">
    <p>© 2025 Motorcycle Spare Parts Store</p>
  </footer>
  <!-- Footer Navigation for Tablet -->

  <!-- زر العودة إلى الأعلى -->
  <button id="goToTop" onclick="window.scrollTo(0, 0)">Go to Top</button>
  <script src="web.js"></script>
</body>

</html>