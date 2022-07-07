## Loan Application

## Project Description

This aplication is about RESTful APIs to create loan requests, approve and decline.

This includes the following:
### Admin View
• Approve a Loan Request
• Decline a Loan Request

### Employee View
• Create a loan request
• Update a loan request
• View a loan request
• List all loan requests
• Delete a loan request

## Project Setup

### Cloning the GitHub Repository

Clone the repository to your local machine by running the terminal command below.

```bash
git clone https://github.com/Oluwablin/prodev_loan
```

### Setup Database

Create a MySQL database and note down the required connection parameters. (DB Host, Username, Password, Name)

### Install Composer Dependencies

Navigate to the project root directory via terminal and run the following command.

```bash
composer install
```

### Create a copy of your .env file

Run the following command

```bash
cp .env.example .env
```

This should create an exact copy of the .env.example file. Name the newly created file .env and update it with your local environment variables (database connection info and others).

### Generate an app encryption key

```bash
php artisan key:generate
```

### Generate a jwt encryption secret key

```bash
php artisan jwt:secret
```

### Migrate the database

```bash
php artisan migrate
```

### Run the database seeds

```bash
php artisan db:seed
```

## Postman Collection

https://documenter.getpostman.com/view/9649360/UzJLQGkr

