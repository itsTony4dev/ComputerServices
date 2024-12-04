<?php
$conn = mysqli_connect(hostname: "localhost", username: "root", password: "", database: "computerservices");
$res = mysqli_query($conn, "SELECT * FROM available_parts");

while ($row = mysqli_fetch_array($res)) {
    $data[] = $row;
}
$json_data = json_encode($data);

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="build.css" />
    <link rel="icon" href="pictures/loginlogo.png">
    <title>Computer Services</title>
</head>

<body>
    <header>
        <nav>
            <div class="logo">
                <a href="admin.php"><img src="pictures/Logo.png" alt="" /></a>
                <a href="admin.php">CT ZONE</a>
            </div>
            <div class="nav-links">
                <ul>
                    <li><a href="admin.php">Home</a></li>
                    <li><a href="admin.php#buy-Build">Buy </a></li>
                    <li><a href="admin.php#contact">Repair</a></li>
                    <?php session_start();
                    if ($_SESSION['is_logged_in']) {
                        echo '<li><a href="logout.php">Logout</a></li>';
                    } else {
                        echo '<li><a href="login.php">Login</a></li>';
                    } ?>
                </ul>
            </div>
        </nav>
    </header>
    <main>
        <section class="hero">
            <h1>Available Parts</h1>
            <p>Choose from a wide range of components to create your perfect custom build.</p>
        </section>

        <section class="components">
            <h2>Components</h2>
            <div class="sort-options">
                <label for="sort">Sort by:</label>
                <select id="sort">
                    <option value="default">Default</option>
                    <option value="name-asc">Name (A-Z)</option>
                    <!-- <option value="name-desc">Name (Z-A)</option> -->
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


            var components = <?php echo $json_data; ?>;
            console.log(components);


            // Helper function to create component card HTML
            function createComponentCard(component) {
                const card = document.createElement('div');
                card.classList.add('component-card');
                card.innerHTML = `
                <img src="uploads/${component.image}" alt="${component.name}">
                <h3>${component.name}</h3>
                <p>${component.cat_name}</p>
                <p class="price">$${component.price}</p>
                </div >
                    <div class="action-buttons">
                        <button class="edit-btn">Edit</button>
                        <button class="delete-btn">Delete</button>
                        </div>
            `;
                return card;
            }

            // Function to render component cards



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

            // Initial render
            renderComponents();

            // Event listener for sort select
            sortSelect.addEventListener('change', (event) => {
                const sortOption = event.target.value;
                renderComponents(sortOption)
            });
        </script>
        <h2 style=" text-align: center;margin: 40px; color:red">Upload Parts</h2>
        <form action="POST" class="upload-form">
            <label for="image">Choose an image</label>
            <input type="file" id="image">

            <label for="name">Name</label>
            <textarea id="name" rows="4" placeholder="Enter the name"></textarea>

            <label for="category">Category</label>
            <input type="text" id="category" placeholder="Enter the category">

            <label for="price">Price</label>
            <input type="text" id="price" placeholder="Enter price">

            <button type="submit" class="btn">UPLOAD</button>
        </form>

    </main>
    <footer>
        <p>&copy; 2024 CT ZONE Repair & Buy. All rights reserved.</p>
    </footer>
</body>
<style>
    .component-card {
        height: 102%;

    }

    .component-list {
        box-shadow: none;
    }
</style>

</html>