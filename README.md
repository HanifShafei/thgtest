## Installation


LARAGON
- Download & install [Laragon](https://laragon.org/)
- download ```thgtest``` from github & put in Laragon folder: ```../laragon/www/thgtest```
- run Laragon, reload apache, Laragon will auto create virtual host: ```thgtest.test```


ENV
- create file ```.env``` and copy its content from ```env.example```
- create DB and update its details into ```.env```


Open terminal (can use terminal from laragon). ```cd``` into ```thgtest``` folder.
run in terminal: 
```
composer install
php artisan key:generate
php artisan migrate
```


run your site:
- thgtest.test


## Login credentials
```
user 1 = [
    'email' => 'user@mail.com', 
    'username' => 'John Johnny James', 
    'password' => bcrypt('pass1234'), 
    'role' => 'user'
]

user 2 = [
    'email' => 'admin@mail.com', 
    'username' => 'Administrator', 
    'password' => bcrypt('pass1234'), 
    'role' => 'admin'
]
```


## Roles ability

role: user
- apply new loan
- see list of own loan
- click name to see own loan detail & payment table
- pay own loans

role: admin
- see list of loans for all user
- approve loan
- click name to see any user loan detail & payment table
