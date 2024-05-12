# Booking Management API

The purpose of this API is for users to be able to create, update and delete an appointment for the date they specify. And the created appointments can be viewed simultaneously via the application calendar (Google Calendar).

### Attention

Laravel Sail is supported on macOS, Linux, and Windows (via WSL2). So make sure you use one of these environments to run the project.

### Clone project

```
git clone https://github.com/hakansoyturk/mobile-subscription-management-api.git
```

### Downloading the packages of the project

You should open a terminal in the project folder and run the following commands one by one.

### Install dependencies

```
composer install
```

### Publish GoogleCalendarServiceProvider

```
php artisan vendor:publish --provider="Spatie\GoogleCalendar\GoogleCalendarServiceProvider" 
```

### How to run project with Docker

To run Docker:

```
./vendor/bin/sail up --build -d
```

Note: Once the project is built, you will only need to Docker up with the following command.

```
./vendor/bin/sail up -d
```

To migrate database salons table with seeds (Salon 1, Salon 2):

```
./vendor/bin/sail php artisan migrate:fresh --seed --seeder=AdminSeeder
```

## About API

### localhost/api/register

- Creates a new user.

Request Type: POST

Headers field:

    "Accept": "application/json"

Params:

     "email": ""
     "password": ""
     "password_confirmation": ""
     "name": ""

### localhost/api/login

- It is used to create a new token so that you can use the API.

Request Type: POST

Headers field:

    "Accept": "application/json"

Params:

     "email": ""
     "password": ""

### localhost/api/logout

- Terminates the session of the user belonging to the current token.

Request Type: POST

Headers field:

    "Accept": "application/json"
    "Authorization": "Bearer YOURTOKEN"

### localhost/api/appointments

- Returns a list of all appointments for a salon based on the salonId specified in the parameter.

Request Type: GET

Headers field:

    "Accept": "application/json"
    "Authorization": "Bearer YOURTOKEN"

Params:

     "salonId": ""

Note: The current demo only includes Salon 1 and Salon 2.

### localhost/api/appointments

- Creates an appointment date for a salon whose salonId is given.
- startDateTime is the start time of the appointment and endDateTime is the end time of the appointment.
- Date values must be in "Y-m-d H:i" format.

Request Type: POST

Headers field:

    "Accept": "application/json"
    "Authorization": "Bearer YOURTOKEN"

Params:

     "salonId": ""
     "startDateTime": ""
     "endDateTime": ""

### localhost/api/appointments/{id}

- It updates the date of a created appointment.
- The {id} value represents the id of the created appointment.
- startDateTime is the start time of the appointment and endDateTime is the end time of the appointment.
- Date values must be in "Y-m-d H:i" format.

Request Type: PUT

Headers field:

    "Accept": "application/json"
    "Authorization": "Bearer YOURTOKEN"

Params:

     "salonId": ""
     "startDateTime": ""
     "endDateTime": ""

### localhost/api/delete/{id}

- It deletes a created appointment.<br>
- The {id} value represents the id of the created appointment.

Request Type: DELETE

Headers field:

    "Accept": "application/json"
    "Authorization": "Bearer YOURTOKEN"

### localhost/api/salons

- Returns a list of all Salons in the API.

Request Type: GET

Headers field:

    "Accept": "application/json"
    "Authorization": "Bearer YOURTOKEN"
