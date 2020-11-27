After you have cloned the repository:

- install [composer](https://getcomposer.org) dependencies  
```composer install```

- create sqlite db on file system  
```php bin/console doctrine:database:create```
  
- run migrations  
```php bin/console doctrine:migrations:migrate```  

- import projects  
```php bin/console app:import-projects```  

---
- start web server  
```symfony server:start```  
- open http://127.0.0.1:8000 (or similar) in browser

- projects listing page  
```http://127.0.0.1:8000/projects```

- click on some project thumbnail to view its preview page ("Hits" keep incrementing each time)