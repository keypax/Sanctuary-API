# Sanctuary API
Sanctuary API is the API component that complements the main Sanctuary system. It serves as the interface for managing the animal shelter operations by exposing endpoints to perform queries on the underlying data. Designed to work together with Sanctuary, the API ensures proper data replication and isolation, prioritizing the safety and performance of the core system. Work in progress.

# Sanctuary

Sanctuary is an animal management system designed for use in animal shelters. Although it is currently in development, the project is intended to be available pro bono for the public good.
[More info](https://github.com/keypax/Sanctuary)

## Requirements

- [Sanctuary](https://github.com/keypax/Sanctuary) + all things Sanctuary needs
- Sanctuary needs to be running during installation.

## Database
Currently, this repository (subscriber) uses logical replication from the PostgreSQL database within the Sanctuary container (publisher). This is intended to prevent API abuse, ensuring that it does not affect the main database and that shelter management functions continue to operate. The replication also sends changes only from a few tables, which means that this repository does not have access to sensitive data, such as user information.

## Installation

Clone the repository:

```bash
git clone https://github.com/keypax/Sanctuary-API
```

Navigate to the project directory:

```bash
cd Sanctuary-API
```

Build and start the application:

```bash
make build
make start
make composer-install
make create-db
make create-schema
make create-subscription
```

Once the setup is complete, visit: [http://localhost:8100/api/doc](http://localhost:8100/api/doc)

## Features
| Feature                                      | Status |
|----------------------------------------------|--------|
| Basic endpoints                              | Done   |
| Basic, automatic API documentation           | Done   |
| Rate Limiter                                 | Todo   |
| Pagination, filtering, sorting               | Todo   |
| Caching                                      | Todo   |
| Optional authorization for external entities | Todo   |
| Advanced, automatic API documentation        | Todo   |
