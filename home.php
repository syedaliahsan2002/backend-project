<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Website</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color:#cfe1e1;
    /* background-image: url("bg img.jpg");
    background-repeat: no-repeat;
    background-size: 100% 100vh;
    background-attachment: fixed; */
        }

        header {
            background-color: transparent;
            color: white;
            padding: 10px;
            text-align: center;
        }
        .hero-section {
    background-image: url("bg img.jpg"); /* Replace with your actual image path */
    background-size: cover;
    background-position: center;
    width:100vw;
    height: 150vh; /* Adjust the height as needed */
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
    color: #darkgray; /* Text color */
    margin:0px;
}

.hero-content {
    max-width: 800px;
}

.hero-content h1 {
    
    margin-top:-350px;
    font-size: 2.5em;
    margin-bottom: 20px;
}

.hero-content p {
    font-size: 1.5em;
    margin-bottom: 30px;
    line-height:30px;
}

.btn {
 padding: 1.1em 2em;
 background: none;
 border: 2px solid #fff;
 font-size: 15px;
 color: #131313;
 cursor: pointer;
 position: relative;
 overflow: hidden;
 transition: all 0.3s;
 border-radius: 12px;
 background-color: #ecd448;
 font-weight: bolder;
 box-shadow: 0 2px 0 2px #000;
}

.btn:before {
 content: "";
 position: absolute;
 width: 100px;
 height: 120%;
 background-color: #ff6700;
 top: 50%;
 transform: skewX(30deg) translate(-150%, -50%);
 transition: all 0.5s;
}

.btn:hover {
 background-color: #4cc9f0;
 color: #fff;
 box-shadow: 0 2px 0 2px #0d3b66;
}

.btn:hover::before {
 transform: skewX(30deg) translate(150%, -50%);
 transition-delay: 0.1s;
}

.btn:active {
 transform: scale(0.9);
}

        nav {
            background-color: #D8B4F8;
            color: white;
            padding: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom:1px solid black;
        }

        nav img {
            width: 100px;
            height: 100px;
        }

        nav a {
            color: white;
            text-decoration: none;
            margin: 0 10px;
            font-size:30px;
            transition: color 0.3s ease;
        }
        nav a:hover{
            color: purple;
        }
        .product-category {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
            margin: 20px;
            
        }
        .product-category-title {
    font-size: 34px; /* Adjust the font size as needed */
    color: #333; /* Adjust the color as needed */
    margin-bottom: 10px; /* Adjust the margin as needed */
    text-align: center; /* Center the text */
    width: 100%; /* Make the width 100% */
    display: block; /* Ensure it takes up the full width */
    text-shadow: 3px 3px 0px rgba(0,0,0,0.5);
}
        .product-card {
            border: 1px solid #ddd;
            padding: 10px;
            margin: 10px;
            width: 200px;
            text-align: center;
            background-color: #fff;
            box-shadow: 10px 10px 05px rgba(0, 0, 0, 0.3);
            border-radius:20px;
            transition:all 0.2s ease;
        }
        .product-card:hover{
            box-shadow: 10px 10px 20px rgba(0, 0, 0, 0.5);

        }
    
        .button {
  position: relative;
  padding: 10px 20px;
  border-radius: 7px;
  border: 1px solid rgb(61, 106, 255);
  font-size: 14px;
  text-transform: uppercase;
  font-weight: 600;
  letter-spacing: 2px;
  background: #b6b2c9;
  color: #fff;
  overflow: hidden;
  box-shadow: 0 0 0 0 transparent;
  -webkit-transition: all 0.2s ease-in;
  -moz-transition: all 0.2s ease-in;
  transition: all 0.2s ease-in;
}

.button:hover {
  background: rgb(61, 106, 255);
  box-shadow: 0 0 30px 5px rgba(0, 142, 236, 0.815);
  -webkit-transition: all 0.2s ease-out;
  -moz-transition: all 0.2s ease-out;
  transition: all 0.2s ease-out;
}

.button:hover::before {
  -webkit-animation: sh02 0.5s 0s linear;
  -moz-animation: sh02 0.5s 0s linear;
  animation: sh02 0.5s 0s linear;
}

.button::before {
  content: '';
  display: block;
  width: 0px;
  height: 86%;
  position: absolute;
  top: 7%;
  left: 0%;
  opacity: 0;
  background: #fff;
  box-shadow: 0 0 50px 30px #fff;
  -webkit-transform: skewX(-20deg);
  -moz-transform: skewX(-20deg);
  -ms-transform: skewX(-20deg);
  -o-transform: skewX(-20deg);
  transform: skewX(-20deg);
}

@keyframes sh02 {
  from {
    opacity: 0;
    left: 0%;
  }

  50% {
    opacity: 1;
  }

  to {
    opacity: 0;
    left: 100%;
  }
}

.button:active {
  box-shadow: 0 0 0 0 transparent;
  -webkit-transition: box-shadow 0.2s ease-in;
  -moz-transition: box-shadow 0.2s ease-in;
  transition: box-shadow 0.2s ease-in;
}
.others_link{
    text-align:center;
    margin:50px;
    font-size:50px;
}

        section {
            margin: 20px;
        }

       

        footer {
            background-color: #333;
            color: white;
            text-align: center;
            padding: 10px;
        }
    </style>
</head>

<body>
 

    <nav>
        
        <img src="logo.png" alt="Logo" class="navlogo">
        <div class="item">
        <a href="#">Home</a>
        <a href="login.html.php">Log In</a>
        <a href="#aboutus">About Us</a>
        <a href="#contactus">Contact Us</a>
</div>
        <div>
            <a href="cart.php" style="text-decoration:none;"><i class="fas fa-shopping-cart"></i></a>
            <span id="cartItemCount">0</span>
        </div>
    </nav>
   
    <section class="hero-section">
    <div class="hero-content">
    <h1>Aroma World</h1>
        <p>We invite you to embark on a journey with Aroma World. Explore our collection, indulge in the richness of natural scents, and let the transformative power of aromatherapy bring positive energy into your life. Discover the countless ways our products can transform your daily rituals into moments of pure bliss.   </p>
        <button class="btn"> Shop now
</button>
    </div>
</section>

<h1 class="head">OUR PRODUCTS</h1>
    <style>
        .head{
            text-align:center;
        }
    </style>
    <?php
    // Retrieve data from the product table
    include('connection.php');
    $result = $conn->query("SELECT * FROM product ORDER BY p_category");

    $currentCategory = "";
    while ($row = $result->fetch_assoc()) {
        // Display product cards based on p_category
        if ($row['p_category'] != $currentCategory) {
            // Start a new category section
            if ($currentCategory != "") {
                echo '</div>';
            }
            echo "<h2 class='product-category-title'>{$row['p_category']}</h2><div class='product-category'>";
            $currentCategory = $row['p_category'];
        }

        // Display product card
        echo "<div class='product-card'>
                    <img src='{$row['image']}' alt='{$row['name']}' style='width: 100px; height: 100px;'>
                    <h3>{$row['name']}</h3>
                    <p>Price: {$row['price']}</p>
                    <button class='button' onclick='addToCart(\"{$row['name']}\", {$row['price']}, \"{$row['image']}\")'>
                    Add to Cart
                </button>
                    </div>";
                    
    }

    // Close the last category section
    echo '</div>';
    ?>

    <section>
        <h2 class="others_link">Website Links</h2>
        <ul>
            <li class="ul_ki_li"><a href="#">Men</a></li>
            <li class="ul_ki_li"><a href="#">Women</a></li>
            <li class="ul_ki_li"><a href="#">Privacy Policy</a></li>
            <li class="ul_ki_li"><a href="#">Services</a></li>
            <li class="ul_ki_li"><a href="#">Contact</a></li>
        </ul>
    </section>
<style>
    .ul_ki_li a{
        text-decoration:none;
        color:black;
        font-size:20px;
        display:flex;
        flex-direction:column;
    }
    .ul_ki_li{
        list-style-type:none;
        margin-bottom:10px;
        
    }
    .ul_ki_li a:hover{
        text-decoration:underline;
    }
</style>
    <section>
        <h2>Our Address</h2>
        <p>F-44/1 Block 4, Clifton (E-Street), Karachi, Pakistan.</p>
        <h2>Our Timings</h2>
        <p>Mon - Sat 11:30am - 8:00pm</p>
    </section>
    <section id="aboutus">
        <h2>About Us</h2>
        <p>Welcome to Aroma World! We are dedicated to providing high-quality products that bring the transformative power of aromatherapy into your life. Explore our collection and discover the blissful experience that natural scents can offer.</p>
    </section>

    <section id="contactus">
        <h2>Contact Us</h2>
        <p>If you have any questions or inquiries, feel free to reach out to us. Our team is here to assist you.</p>
        <p>Email: info@aromaworld.com</p>
        <p>Phone: +123456789</p>
    </section>
    <footer>
        <p>© 1991 - 2023. All Rights Reserved. No Part Of This Website May Be Reproduced, Stored In A Retrieval System, Or Transmitted In Any Form By Any Means, Electronic, Mechanical, Or Otherwise, Without Obtaining The Written Permission.</p>
    </footer>

    <script>
        let cartItemCount = 0;
        let cartItems = {}; // To store added items

        function addToCart(name, price, image) {
            // Check if the product is already in the cart
            if (cartItems[name]) {
                alert('Item is already in the cart!');
            } else {
                // If not, increment the cart item count
                cartItemCount++;
                document.getElementById('cartItemCount').innerText = cartItemCount;

                // Add the product details to the cartItems object
                cartItems[name] = {
                    price: price,
                    image: image,
                    quantity: 1
                };

                // Use AJAX to send data to the server (addToCart.php) to store in the session
                fetch('addToCart.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify(cartItems),
                    })
                    .then(response => response.json())
                    .then(data => {
                        console.log('Success:', data);
                    })
                    .catch((error) => {
                        console.error('Error:', error);
                    });
            }
        }
    </script>
</body>

</html>
