# Attendance Tracker

This project was developed as part of a college project to track attendance.

## About the Project

Attendance Tracker is a web application designed to help manage and track attendance for various events and classes. The application is built using a combination of technologies including JavaScript, Blade, PHP, Docker, Hack, and CSS.

## Features

- User authentication and authorization
- Attendance tracking and reporting
- Event management
- Notifications and reminders

## Installation

To get started with the project, follow these steps:

1. Clone the repository:
    ```bash
    git clone https://github.com/ker00sama-dev/AttendanceTracker.git
    ```
2. Navigate to the project directory:
    ```bash
    cd AttendanceTracker
    ```
3. Install dependencies:
    ```bash
    composer install
    npm install
    ```
4. Set up the environment variables by copying the `.env.example` file to `.env` and updating it with your configuration:
    ```bash
    cp .env.example .env
    ```
5. Generate an application key:
    ```bash
    php artisan key:generate
    ```
6. Run database migrations:
    ```bash
    php artisan migrate
    ```

## Usage

To start the application, use the following command:
```bash
php artisan serve
