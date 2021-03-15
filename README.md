# PDO CHEATSHEET
PDO is a Database Access Abstraction Layer

## Benefits of using PDO
- **Security** - Using prepared statements
- **Usability** - PDO has many helper functions to automate routine operations
- **Reusability** - unified API to access multitude of databases, from SQLite to Oracle


# Connecting to the Datebase using PDO

In order to connect to the Database one needs
- DSN - Data Source Name; List of options including (database driver, database name, host and charset)
- Username and password
- List of  default Options



```php
<?php
$host = 'localhost';
$user = 'root';
$password = '';
$database = 'chatone';
$charset = 'utf8mb4';


// Setting the dsn - data source name

$dsn = "mysql:host={$host};dbname={$database};charste={$charset}";

// List of default options
 $options = [
       PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
       PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
       PDO::ATTR_EMULATE_PREPARES => false
 ];

 // connecting to the Database

 try {
     $conn = new PDO($dsn, $user, $password, $options);
 } catch (PDOException $e) {
     throw new PDOException($e->getMessage(). (int) $e->getCode());
     //throw $th;
 }

```

# Running queries in PDO PDO::query()
There are two ways to run queries in PDO 
1.  If no there are not variables to be used in the query use PDO::query()
**Example**
```php
<?php
include_once __DIR__. "/connection_pdo.php";

// sql query
$sql = 'SELECT * FROM users';

$stmt = $conn->query($sql);

$result = $stmt->fetchAll();

var_dump($result);

```

2. Using prepared statements. Protection against SQL imjections
Prepared statement is the only correct way to run a query,if any variable is going to be used.
## Process of prepared statements
- Substitute a variable with a **Placeholder**
- Prapare your query 
- Execute it passing the variables

> PDO supports positional  (?) and named  (:name) placeholders

***Example of positional placeholders**

```php
  $sql = "SELECT * FROM users WHERE name = ? AND email = ?
```

***Example of named placeholders***
```php
  $sql = "SELECT * FROM users WHERE name = :name AND email = :email
```

***Complete named placeholder example***

```php
<?php
include_once __DIR__. "/connection_pdo.php";

// sql query 
$sql = "SELECT * FROM users WHERE last_name = :last_name AND email = :email";

// Prepare the sql query
$stmt = $conn->prepare($sql);


// Variables to be used
$name ='Caster';

$email = 'castercodes@gmail.com';

// Execute prepared query
$stmt->execute(['last_name'=> $name, 'email' => $email]);

// Fetch the results
$results = $stmt->fetchAll();

// Dump the results
var_dump($results);
```

***Complete positional placeholder example***

```php
<?php
include_once __DIR__. "/connection_pdo.php";

// sql query 
$sql = "SELECT * FROM users WHERE last_name = ? AND email = ?";

// Prepare the sql query
$stmt = $conn->prepare($sql);


// Variables to be used
$name ='Caster';

$email = 'castercodes@gmail.com';

// Execute prepared query
$stmt->execute([$name,  $email]);

// Fetch the results
$results = $stmt->fetchAll();

// Dump the results
var_dump($results);
```

> Note - For positional placeholders we supply a regular array with the values and the values have to be in the order they are positioned in the query

> Note - For named placeholders we supply an associative array,where keys have to match the placeholder names in the query.

> Note - Positional and named placeholders can not be used in the same query


