**PHP Cart System**

**Description:**
This is my project of ServerSide Development in ITE.
I used Bootstrap for styles, PHP for serverside.

**How It Works**

1.  **Connecting to the Database:**
   'index.php', 'product.php', and 'cart.php' connect to the database using require 'db.php'.

2. **Displaying Products:**
    In 'index.php', the product table is retrieved from the database, and all products are displayed on the page.

3.  **Viewing Product Details:**
    In 'product.php', the product ID is obtained from 'index.php' when the user clicks 'view product'.
    
4.  **Adding to Cart:**
    When the user clicks 'add to cart' in product.php, the product ID is added to the 'cart' table in the database.

5.  **Displaying and Managing Cart:**
    cart.php' retrieves all items from the 'cart' table and displays them. Users can change the quantity and delete items from the cart.
    
6.   **Checkout Process:**
     When the user clicks 'Checkout' in cart.php, all items in the cart are moved to the 'checkout' database with an assigned order ID.

**Database Schema**

-  **Table: 'tempcart'**
  'id', 'name', 'price', 'quantity'

-  **Table: 'products'**
  'id', 'name', 'price', 'ImageRef', 'Description'

-  **Table: 'checkout'**
  'orderID', 'product_id', 'product_name', 'product_price', 'product_quantity'
