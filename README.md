# Dockerized Laravel Order Processing Application

This repository contains a simple Laravel application that demonstrates order processing with Docker. The app validates incoming payloads, saves orders to a database, and processes subscription items asynchronously with third-party APIs.

---

## Features

- **Dockerized Environment**:
  Set up with `docker-compose` and Laravel Sail for easy local development.

- **RESTful API**:
  Endpoint to receive and process customer orders.

- **Database Integration**:
  Orders and items are saved into a MySQL database.

- **Asynchronous Processing**:
  Handles subscription items asynchronously to interact with slow APIs without blocking.

---

## Prerequisites

Before you start, make sure you have the following installed:
- [Docker](https://www.docker.com/)
- [Docker Compose](https://docs.docker.com/compose/)
- [Git](https://git-scm.com/)

---

## Installation

### Step 1: Clone the Repository
```bash
git clone https://github.com/vaibhavisojitra25/order-management.git
cd order-management
```

### Step 2: Set Up Environment
- Copy `.env.example` to `.env`:
  ```bash
  cp .env.example .env
  ```
- Modify database configuration in `.env` as necessary.

### Step 3: Start Docker Services
```bash
docker-compose up -d
```

### Step 4: Install Dependencies
```bash
docker-compose exec app composer install
```

### Step 5: Generate Application Key
```bash
docker-compose exec app php artisan key:generate
```

### Step 6: Run Migrations
```bash
docker-compose exec app php artisan migrate
```

---

## Usage

### API Endpoint

#### **Create Order**
- **URL**: `/api/orders`
- **Method**: `POST`
- **Request Payload**:
  ```json
  {
    "first_name": "Alan",
    "last_name": "Turing",
    "address": "123 Enigma Ave, Bletchley Park, UK",
    "basket": [
      {
        "name": "Smindle ElePHPant plushie",
        "type": "unit",
        "price": 295.45
      },
      {
        "name": "Syntax & Chill",
        "type": "subscription",
        "price": 175.00
      }
    ]
  }
  ```

- **Response**:
  - `201 Created`: Order successfully processed.
  - `422 Unprocessable Entity`: Validation failed.

---

## Project Structure

- **API Endpoint**: `/api/orders` for creating orders.
- **Database**:
  - Orders are stored in a MySQL database.
  - Includes tables for orders and items.
- **Asynchronous Queue**:
  - Subscription items are processed asynchronously and sent to the `https://very-slow-api.com/orders` endpoint using Laravel queues.

---

## Built With

- **Laravel**: PHP Framework for building web applications.
- **MySQL**: Relational database for storing orders and items.
- **Docker & Docker Compose**: Containerized environment setup.
- **Laravel Queues**: Asynchronous processing of tasks.

---

## License

This project is licensed under the MIT License. See the `LICENSE` file for details.

---

## Acknowledgements

Special thanks to Laravel's official documentation and the open-source community for their guidance and tools.
