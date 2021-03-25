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
- List of default Options

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

> PDO supports positional (?) and named (:name) placeholders

**\*Example of positional placeholders**

```php
  $sql = "SELECT * FROM users WHERE name = ? AND email = ?
```

**_Example of named placeholders_**

```php
  $sql = "SELECT * FROM users WHERE name = :name AND email = :email
```

**_Complete named placeholder example_**

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

**_Complete positional placeholder example_**

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

# Binding methods

By defualt when using the execute() method the variable are saved as strings. It is always a good idea to explicitly bind the params using the bindValue() or bindParam() methods

> Note that only strings and numeric literals can be bound

# The bindParam() method

## Binding named placeholders using the the bindParam() method

```php
//bind values
$stmt->bindParam(":last_name", $name, PDO::PARAM_STR);
$stmt->bindParam(":email", $email, PDO::PARAM_STR);

// Execute prepared query
$stmt->execute();
```

## Binding positional placeholders using the bindParam() method

```php
//bind values
$stmt->bindParam(1, $name, PDO::PARAM_STR);
$stmt->bindParam(2, $email, PDO::PARAM_STR);

// Execute prepared query
$stmt->execute();
```

## A list of all the datatypes that can be bound by the bindParam() method

```php
PDO::PARAM_BOOL (integer)
//Represents a boolean data type.
PDO::PARAM_NULL (integer)
//Represents the SQL NULL data type.
PDO::PARAM_INT (integer)
//Represents the SQL INTEGER data type.
PDO::PARAM_STR (integer)
//Represents the SQL CHAR, VARCHAR, or other string data type.
PDO::PARAM_LOB (integer)
//Represents the SQL large object data type.
PDO::PARAM_STMT (integer)
//Represents a recordset type. Not currently supported by any drivers.
PDO::PARAM_INPUT_OUTPUT (integer)
//Specifies that the parameter is an INOUT parameter for a stored procedure. You must bitwise-OR this value with an explicit PDO::PARAM_* data type.
```

# The bindValue() method

## Binding named placeholders using the the bindValue() method

```php
//bind values
$stmt->bindValue(":last_name", $name, PDO::PARAM_STR);
$stmt->bindValue(":email", $email, PDO::PARAM_STR);

// Execute prepared query
$stmt->execute();
```

## Binding positional placeholders using the bindValue() method

```php
//bind values
$stmt->bindValue(1, $name, PDO::PARAM_STR);
$stmt->bindValue(2, $email, PDO::PARAM_STR);

// Execute prepared query
$stmt->execute();
```

# Difference between bindValue() and bindParam()

[With bindParam] Unlike PDOStatement::bindValue(), the variable is bound as a reference and will only be evaluated at the time that PDOStatement::execute() is called.

## Example

```php
$sex = 'male';
$stmt = $conn->prepare('SELECT name FROM students WHERE sex = :sex');
$stmt->bindParam(':sex', $sex); // use bindParam to bind the variable
$sex = 'female';
$s->execute(); // executed with WHERE sex = 'female'
```

```php
$sex = 'male';
$stmt = $conn->prepare('SELECT name FROM students WHERE sex = :sex');
$s->bindValue(':sex', $sex); // use bindValue to bind the variable's value
$sex = 'female';
$stmt->execute(); // executed with WHERE sex = 'male'
```
