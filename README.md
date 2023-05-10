# CloudPRO PHP

This library is the abstraction of CloudPRO API for access from applications written with PHP.

## Installation

```bash
composer require akbaraditamasp/cloudpro-php
```

## Usage

### Create Box

Before creating a box, make sure you have created and obtained an **_access key_** from the app.

```php
$response = CloudPRO::begin()->useAppAccess("YOUR ACCESS KEY")->storeBox("Box Name");
```

### Create Folder

Use the **_box token_** that you got when you made the box.

```php
$response = CloudPRO::begin()->useBoxToken("BOX TOKEN")->storeFolder("FOLDER NAME", $options);
```

### Store File

```php
$response = CloudPRO::begin()->useBoxToken("BOX TOKEN")->storeFile("FILE NAME", "PATH", $options);
```

### Show Node

If the node key is a folder, then you will get a response detailing the folder and its childrens. But if the node key is a file, then you will get a file url response.

```php
$response = CloudPRO::begin()->useBoxToken("BOX TOKEN")->showNode("NODE KEY");
```

### Rename Node

```php
$response = CloudPRO::begin()->useBoxToken("BOX TOKEN")->renameNode("NODE KEY","NEW NAME");
```

### Move Node

```php
$response = CloudPRO::begin()->useBoxToken("BOX TOKEN")->moveNode("NODE KEY","PARENT KEY");
```

### Copy Node

```php
$response = CloudPRO::begin()->useBoxToken("BOX TOKEN")->copyNode("NODE KEY","PARENT KEY");
```

### Delete Node

```php
$response = CloudPRO::begin()->useBoxToken("BOX TOKEN")->deleteNode("NODE KEY");
```
