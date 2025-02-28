# Kaizen E-Commerce API

## Overview
This project is built using **Laravel** and utilizes **Blueprint** for model and migration generation. Below are the setup instructions and workflow for managing models, migrations, and database structure.

---

## 📌 Prerequisites
Ensure you have the following installed:
- **PHP 8.2+**
- **Laravel** (latest version)
- **Docker** (if using a containerized environment)
- **Blueprint** (installed via Composer)

If you haven’t installed Blueprint yet, run:
```bash
composer require --dev laravel-shift/blueprint
```

---

## 🚀 Workflow: Creating Models and Migrations with Blueprint

### 1️⃣ **Create a Blueprint YAML File**
Blueprint uses a YAML file to define models, migrations, and controllers.

```bash
mkdir -p drafts && touch drafts/schema.yaml
```

This will create a `drafts` folder and an empty `schema.yaml` file.

### 2️⃣ **Define Models in `schema.yaml`**
Edit `drafts/schema.yaml` and add your models. Example:

```yaml
models:
  User:
    name: string
    email: string unique
    password: string
    timestamps: true

  Product:
    name: string
    description: text nullable
    price: decimal:8,2
    stock: integer
    user_id: id foreign
    timestamps: true

  Order:
    user_id: id foreign
    total_price: decimal:8,2
    status: enum:pending,shipped,delivered,canceled
    timestamps: true

  OrderItem:
    order_id: id foreign
    product_id: id foreign
    quantity: integer
    price: decimal:8,2
```

### 3️⃣ **Generate Laravel Files with Blueprint**
Run the following command:

```bash
docker exec -it api.kaizen-e-commerce php artisan blueprint:build drafts/draft.yaml
```

This will generate:
- **Models** in `app/Models/`
- **Migrations** in `database/migrations/`
- **Factories** in `database/factories/`

### 4️⃣ **Run Migrations**
To apply database changes, run:

```bash
php artisan migrate
```

---

## Blueprint commands
- docker exec -it api.kaizen-e-commerce php artisan blueprint:build drafts/draft.yaml -> rebuild the whole migration files. delete all migration files if running this because it can stack the migration files unnecessarily
- docker exec -it api.kaizen-e-commerce php artisan blueprint:build --only=models -> creates migration files based on model changes

## 🔧 Additional Instructions
- Add Eloquent relationships (e.g., `belongsTo`, `hasMany`) to models.
- Use factories for database seeding.
- Extend this README for additional setup guides.

---

## 📜 Future Updates
This README follows a structured format. Feel free to add more sections for API documentation, testing, or deployment steps.

