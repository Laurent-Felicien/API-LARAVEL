# Laravel REST API with Sanctum

I was learning how to create a Laravel API with Sanctum, but the tutorial was for Laravel v10 while I was using version 12. Everything was going well until I got to the token. The instructor used `createToken` without showing that Sanctum needed to be installed and configured separately. So it didn't work.

After some research and debugging, I managed to get everything working with Laravel 12 and Sanctum v4. The API is now fully functional with token-based authentication.

## Features

- User registration and login with token generation
- Token-based authentication using Laravel Sanctum
- CRUD operations on posts (protected routes)
- Logout with token revocation

## API Endpoints

### Public routes
| Method | Endpoint          | Description          |
|--------|-------------------|----------------------|
| POST   | `/api/register`   | Register a new user  |
| POST   | `/api/login`      | Login and get token  |

### Protected routes (Bearer Token required)
| Method | Endpoint                | Description         |
|--------|-------------------------|---------------------|
| GET    | `/api/posts`            | List all posts      |
| POST   | `/api/posts/create`     | Create a post       |
| PUT    | `/api/posts/edit/{id}`  | Update a post       |
| DELETE | `/api/posts/{id}`       | Delete a post       |
| POST   | `/api/logout`           | Logout              |

## Tech Stack

- PHP 8.4
- Laravel 12
- Laravel Sanctum v4
- MySQL
