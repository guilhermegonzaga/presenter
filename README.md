# Laravel Presenter

[![Latest Stable Version](https://poser.pugx.org/guilhermegonzaga/presenter/v/stable)](https://packagist.org/packages/guilhermegonzaga/presenter) [![Total Downloads](https://poser.pugx.org/guilhermegonzaga/presenter/downloads)](https://packagist.org/packages/guilhermegonzaga/presenter) [![Latest Unstable Version](https://poser.pugx.org/guilhermegonzaga/presenter/v/unstable)](https://packagist.org/packages/guilhermegonzaga/presenter) [![License](https://poser.pugx.org/guilhermegonzaga/presenter/license)](https://packagist.org/packages/guilhermegonzaga/presenter)

Presenter is a design pattern for Laravel 5 which is used to modify the data that comes from your model to your views.
<br>
It causes the data to be displayed in a way understandable to humans.

## Installation

#### Laravel (5.0, 5.1 and 5.2)

Execute the following command to get the latest version of the package:

```terminal
composer require guilhermegonzaga/presenter
```

## Usage

The first step is to store your presenters somewhere - anywhere. These will be simple objects that do nothing more than format data, as required.
<br>
Note that your presenter class must extend ```Laracodes\Presenter\Presenter```:

```php
namespace App\Presenters;

use Laracodes\Presenter\Presenter;

class UserPresenter extends Presenter
{
    public function fullName()
    {
        return $this->model->first_name . ' ' . $this->model->last_name;
    }
    
    public function accountAge()
    {
        return $this->model->created_at->diffForHumans();
    }

    ...
}
```

Next, on your model, pull in the ```Laracodes\Presenter\Traits\Presentable``` trait, which will automatically instantiate your presenter class:

```php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laracodes\Presenter\Traits\Presentable;

class User extends Model
{
    use Presentable;
    
    protected $presenter = 'App\Presenters\UserPresenter';

    ...
}
```

Done, now you can call it in your views:

```php
<h1>Hello, {{ $user->present()->fullName }}</h1>
<h1>Hello, {{ $user->present()->full_name }}</h1> // automatically convert to camelCase
```

Notice how the call to the present() method (which will return your new or cached presenter object) also provides the benefit of making it perfectly clear where you must go, should you need to modify how a full name is displayed on the page.

## Notices

When you call a method that does not exist in its class presenter, this package will automatically call the property in the model with conversion to snake_case.

Ex:

```php
// automatically calls the property in the model
<h1>Hello, {{ $user->present()->firstName }}</h1> // automatically convert to snake_case
<h1>Hello, {{ $user->present()->first_name }}</h1>
```

## Credits

This package is largely inspired by <a href="https://github.com/laracasts/Presenter">this</a> great package by @laracasts.
