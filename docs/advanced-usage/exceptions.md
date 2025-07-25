# Exceptions

If you need to override exceptions thrown by this package, you can simply use normal [Laravel practices for handling exceptions](https://laravel.com/docs/errors#rendering-exceptions).

An example is shown below for your convenience, but nothing here is specific to this package other than the name of the exception.

You can find all the exceptions added by this package in the code here: [https://github.com/osenco/laravel-role-permission-policies/tree/main/src/Exceptions](https://github.com/osenco/laravel-role-permission-policies/tree/main/src/Exceptions)


**Laravel 10: app/Exceptions/Handler.php**
```php

public function register()
{
    $this->renderable(function (\Osen\Permission\Exceptions\UnauthorizedException $e, $request) {
        return response()->json([
            'responseMessage' => 'You do not have the required authorization.',
            'responseStatus'  => 403,
        ]);
    });
}
```

**Laravel 11: bootstrap/app.php**
```php

->withExceptions(function (Exceptions $exceptions) {
    $exceptions->render(function (\Osen\Permission\Exceptions\UnauthorizedException $e, $request) {
        return response()->json([
            'responseMessage' => 'You do not have the required authorization.',
            'responseStatus'  => 403,
        ]);
    });
}
```
