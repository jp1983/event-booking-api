# Event Booking API (Laravel)

## Setup Instructions
1. Clone the repository:

git clone https://github.com/jp1983/event-booking-api.git

2. Install dependencies:
composer install

3. Set up the database:
php artisan migrate

4. Run the server:
php artisan serve

## API Endpoints
### check the routes/api.php for all api endpoints

### Authentication
- `POST /register` - Register a user
- `POST /login` - Authenticate a user
- `POST /logout` - Logout a user

### Event Management
- `GET /events` - List all events with Authication
- `POST /events` - Create an event
- `PUT /events/{id}` - Update an event
- `DELETE /events/{id}` - Delete an event

### Attendees Management
- `GET /attendees` - List all attendees
- `POST /attendees` - Create an attendees
- `PUT /attendees/{id}` - Update an attendees
- `DELETE /attendees/{id}` - Delete an attendees

### Booking System
- `POST /bookings` - Book an event
- `DELETE /bookings/{id}` - Delete an event
- `GET /bookings/{event_id}` - List all bookings

### Testing
Run:
php artisan test

### Swagger API Documentation

## Install Swagger:
composer require darkaonline/l5-swagger

## Generate API Docs:
php artisan l5-swagger:generate

### Dockerfile file  
FROM php:7.2-fpm
WORKDIR /var/www
COPY . .
RUN docker-php-ext-install pdo pdo_mysql
CMD php artisan serve --host=0.0.0.0
EXPOSE 8000

### Run Docker
docker build -t event-api .
docker run -p 8000:8000 event-api
