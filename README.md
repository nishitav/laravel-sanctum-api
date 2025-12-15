# Laravel API + Nuxt 3 Frontend (TypeScript)

A fullstack starter template using:

- **Laravel 11 API**
- **Sanctum Token Authentication**
- **Role → Ability Permission System**
- **Nuxt 3 + TypeScript**
- **API-first architecture**

---

## 📁 Project Structure

project-root/

api/ # Laravel Backend

frontend/ # Nuxt 3 Frontend

---

# 🔧 Backend Setup (`api/`)

### 1. Install dependencies
```bash
cd api
composer install
cp .env.example .env
php artisan key:generate
``` 

### 2. Update .env database settings
```bash
DB_DATABASE=your_db
DB_USERNAME=your_user
DB_PASSWORD=your_pass
```

### 3. Run migrations
```bash
php artisan migrate
```

### 3. Tinker (You can also create seeders)
```bash
$user = \App\Models\User::create([
    'name' => 'Admin User',
    'email' => 'admin@example.com',
    'password' => bcrypt('secret'),
]);

$admin = \App\Models\Role::create(['name' => 'admin']);
$staff = \App\Models\Role::create(['name' => 'staff']);
$customer = \App\Models\Role::create(['name' => 'customer']);

$read    = \App\Models\Ability::create(['name' => 'products:read']);
$create  = \App\Models\Ability::create(['name' => 'products:create']);
$update  = \App\Models\Ability::create(['name' => 'products:update']);
$delete  = \App\Models\Ability::create(['name' => 'products:delete']);

$admin->abilities()->attach([$read->id, $create->id, $update->id, $delete->id]);


$staff->abilities()->attach([$read->id, $update->id]);

$customer->abilities()->attach([$read->id]);

$user->roles()->attach($admin->id);

\App\Models\Product::factory()->count(10)->create();
```

### 5. Start backend server
```bash
php artisan serve
```

### 6. Check login API
```bash
curl -X POST http://localhost:8000/api/auth/login \
 -H "Content-Type: application/json" \
 -d '{"email":"admin@example.com","password":"secret"}'
 ```

 ### 7. To fetch products
 ```bash
 curl http://localhost:8000/api/products \
 -H "Authorization: Bearer <TOKEN>"
 ```