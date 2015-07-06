

[![Build Status](https://travis-ci.org/Antoine07/myFramework.svg?branch=refac)](https://travis-ci.org/Antoine07/myFramework)
# Framework PHP
- This is documentation for Framework. MyFramework is a small Framework PHP experimental. He use a Dependency Injection Container:

```php
$container = new Services\Container;

$container['engine'] = function($c){
    return new Engine;
};
```
You can also make a static instance of your dependency:

```php
$container['model'] = $container->asShared(function ($c) {
    return new Model($c['connection']);
});

```

- This Container is injected into the Services\Controller

Installation
------------

Before using MyFramework in your project, add it to your ``composer.json`` file:

```
    composer require myframework/myframework

```
 Alternatively, MyFramework is also available as git clone

```
    $ git clone https://github.com/Antoine07/myFramework
```
## Initialize

This section motivates and explains MyFramework's use of DI.

You have only define configuration in app.php. And you use simple Container to configure your application.

## Routing configuration

You will define most of the routes for your app in the  ``config/routes.yaml`` file, which is loaded by the Container:

```php

$container['routes'] = Yaml::parse(ROUTES_PATH . '/routes.yaml');

$container['router'] = function ($c) {
    $router = new Router;
    foreach ($c['routes'] as $route) {
        $router->addRoute(new Route($route));
    }

    return $router;
};

```
### Basic routing

```yaml

BlogController_index:
    pattern:   \/
    connect:  Controllers\BlogController:index

```

### Route parameters

Sometimes you will need to capture segments of the URI within your route. For example, you may need to capture a post's ID from the URL.
You may do so by defining pattern and params

```yaml

BlogController_show:
    pattern:   \/post\/(?P<id>[1-9][0-9]*)
    connect:  Controllers\BlogController:show
    params: id

```
You may define as many route parameters as required by your route:

```yaml

CategoryController_show:
    pattern:   \/cat\/[a-zA-Z0-9\-_]+\/(?P<cat_id>[1-9][0-9]*)\/(?P<user_id>[1-9][0-9]*)
    connect:  Controllers\CategoryController:show
    params: cat_id, user_id
```

Alternatively, you may define route with array PHP into app.php

```php

$routes = [
    'BlogController_index' =>
        [
            'pattern' => '\/post\/(?P[1-9][0-9]*)'
            'connect' => 'Controllers\BlogController:show'
            'params' => 'id'
        ]
];

$container['routes'] = $routes;

```

### RESTful Resource

This code, in the file routes.yaml, declaration creates multiple routes to handle a variety of RESTful actions on the student resource:

```
StudentController:
    resource: \/student
    connect: Controllers\StudentController
    action: '*'

```
Actions handled by resources Controller

Verb          | Path                | Action
------------- | -------------       | ---------
GET           | /student            | index
GET           | /student/create     | create
POST          | /student            | store
GET           | /student/{id}       | show
PUT/PATCH     | /student/{id}/edit  | update
DELETE        | /student/{id}       | destroy

In your application PHP, you can use verb POST for PUT/PATCH and DELETE with hidden post value:

```php
// PUT/PATCH
$_POST['_method']='PUT';  //  $_POST['_method'] = 'PATH';

// DELETE
$_POST['_method'] = 'DELETE';

```

### Model

Active record pattern

```php

$Post = $this->pdo->setObject('Models\\Post');
$Post->id = 1;
$Post->title = 'hello world';
$Post->save();

$posts = $Post->all();

```

### Template

all template views are compiled into plain PHP code. The template view file use the .php extension, and are typically stored in the resources/views directory

#### Defining a layout

Layout can be defined in the application controller, is stored in the resources/views/layouts

```php

 protected $layout = 'layouts.master';

```
In an application controller you can define a partial view

```php

$this->view->setRender('layouts.partials.header', []);

```

```php

{{$header}}
<body>
<div class="header-container">
    <header class="wrapper clearfix">
        <h1 class="title"><a href="{{url('/')}}">{{$title}}</a></h1>
        {{$menu}}
    </header>
</div>
{{$content}}
<!-- #main -->
</div> <!-- #main-container -->
<div class="footer-container">
    <footer class="wrapper">
        <h3>footer</h3>
    </footer>
</div>
{{$footer}}
</body>
</html>

```
### define a child page

```php

<h2>main contain</h2>
@if(isset($posts))
<ul>
    @foreach($posts as $post)
    <li><h2><a href="{{url('post/'.$post->id)}}">{{$post->title}}</a></h2>
        id: {{$post->id}}</li>
    @endforeach
</ul>
@endif

```

