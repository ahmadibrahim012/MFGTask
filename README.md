<p align="center">
  <a href="https://laravel.com" target="_blank">
    <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo">
  </a>
</p>

# Laravel API Project

This project is used as an API backend for React and Flutter applications.

## Requirements

- PHP 8.2  
- Laravel 12  
- MySQL  

## Installation

1. Clone the repository.  
2. Install dependencies:  
   composer install  
3. Copy `.env.example` to `.env` and fill in your database credentials.  
4. Create the database and run migrations:  
   php artisan migrate  
5. Start the local server:  
   php artisan serve  

## API Documentation

We use Scramble for API documentation.  
After running the project, visit:  
http://127.0.0.1:8000/docs/api#/  

## Testing Endpoints

During development, endpoints were tested using Postman.  
Screenshots are available in the `/screenshots` folder:  

- LoginImage.png → Login endpoint  
- RegistrationImage.png → Register endpoint  
- HomeImage.png → Home endpoint  
- TransferImage.png → Transfer endpoint  
- InformationImage.png → Information endpoint  
- TransferWithError.png → Transfer endpoint 
- APIDocumentation.png → API Documentation
- Database.png → Database
- Validation.png  → Validation Parameters




## Authentication

All authenticated requests require a Bearer token in the Authorization header:  

Authorization: Bearer <your_token_here>  
