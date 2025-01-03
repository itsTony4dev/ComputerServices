<?php
session_start();
require_once "connection.php";

$res = mysqli_query(mysql: $conn, query:"SELECT products.*, category.name as cat_name 
                                         FROM products 
                                         JOIN category ON products.category_id = category.id 
                                         WHERE category.id != 1;");

while ($row = mysqli_fetch_array(result: $res)) {
    $data[] = $row;
}
$json_data = json_encode(value: $data);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="css/build.css" />
    <link rel="icon" href="pictures/loginlogo.png">
    <script src="https://kit.fontawesome.com/9d214354b3.js" crossorigin="anonymous"></script>
    <title>CT ZONE</title>
</head>

<body>
    <script src="js/addToCart.js"></script>
    <header>
        <nav>
            <div class="logo">
                <a href="home.php"><i class="fas fa-microchip"></i></a>
                <a href="home.php">CT ZONE</a>
            </div>
            <div class="nav-links">
                <ul>
                    <li><a href="home.php">Home</a></li>
                    <li><a href="home.php#buy-Build">Buy</a></li>
                    <li><a href="home.php#contact">Repair</a></li>
                    <?php 
                    if ($_SESSION['is_logged_in']) {
                        echo '<li class="dropdown">
                    <a href="#" onclick="show()">' . $_SESSION['name'] . '</a>
                    <ul class="dropdown-menu" id="dropdown-menu">
                        <li><a href="cart.php">Cart</a></li>
                        <li><a href="history.php?page=build">History</a></li>
                        <li><a href="logout.php?page=build">Logout</a></li>
                    </ul>
                </li>';
                    } else {
                        echo '<li><a href="login.php">Login</a></li>';
                    } ?>
                </ul>
            </div>
        </nav>
    </header>
    <main >
        <section class="hero">
            <h1>Available Parts</h1>
            <p>Choose from a wide range of components to create your perfect custom build.</p>
        </section>


        <section class="components" style="background-color: rgba(221, 221, 221, 0.7);">
            <h2>Components</h2>
            <div class="sort-options">
                <label for="sort">Sort by:</label>
                <select id="sort">
                    <option value="default">Default</option>
                    <option value="name-asc">Name (A-Z)</option>
                    <option value="price-asc">Price (Low to High)</option>
                    <option value="price-desc">Price (High to Low)</option>
                </select>
            </div>
            <div class="component-list">

            </div>
        </section>


        <script type="text/javascript">
            const componentList = document.querySelector('.component-list');
            const sortSelect = document.getElementById('sort');


            var components = <?= $json_data; ?>;

           
            function createComponentCard(component) {
                const card = document.createElement('div');
                card.classList.add('component-card');
                card.innerHTML = `
                <img src="uploads/${component.image}" alt="${component.name}">
                <h3>${component.name}</h3>
                <p>${component.cat_name}</p>
                <p class="price">$${component.price}</p>
                <button class="btn addToCartBtn" type="submit" data-component-id="${component.id}">Add to cart</button>
            `;
                return card;
            }


            
            function renderComponents(sortOption) {
                componentList.innerHTML = '';

                let sortedComponents;
                switch (sortOption) {
                    case 'name-asc':
                        sortedComponents = [...components].sort((a, b) => a.name.localeCompare(b.name));
                        break;
                    case 'price-asc':
                        sortedComponents = [...components].sort((a, b) => a.price - b.price);
                        break;
                    case 'price-desc':
                        sortedComponents = [...components].sort((a, b) => b.price - a.price);
                        break;
                    default:
                        sortedComponents = [...components];
                }

                sortedComponents.forEach(component => {
                    const card = createComponentCard(component);
                    componentList.appendChild(card);
                });
            }

            
            renderComponents();

            sortSelect.addEventListener('change', (event) => {
                const sortOption = event.target.value;
                renderComponents(sortOption)
            });
        </script>
    </main>
    <footer>
        <p>&copy; 2024 CT ZONE Repair & Buy. All rights reserved.</p>
    </footer>
</body>
<script>
    const show = () => {
        if (document.getElementById('dropdown-menu').style.display != "block") {

            document.getElementById('dropdown-menu').style.display = "block";
        } else {
            return document.getElementById('dropdown-menu').style.display = "none";
        }
    }
</script>

</html>