# Comment Plugin

For cakePHP 1.3

Plugin to add Comment to any model item for CakePHP

## Installation

1. Put the content of this plugin in "app/plugins/" in a folder named "comment".
2. Run "database.sql" in the database.

## Getting started

In the controller you want to allow to add comment

```php
var $components = array('Comment.Commenting');
```

In the model

```php
var $actsAs = array("Comment.Commented");
```

In the view

```php
echo $this->element('comments_box',array('plugin'=>'comment'));
```