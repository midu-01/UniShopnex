# UniShopnex Architecture

## 1. Project architecture

### Folders

- `app/Http/Controllers/Storefront` public storefront
- `app/Http/Controllers/Customer` customer dashboard and commerce flow
- `app/Http/Controllers/Vendor` vendor store and product management
- `app/Http/Controllers/Admin` platform management
- `app/Http/Controllers/Api` Sanctum API
- `app/Http/Requests` form request validation by domain
- `app/Http/Resources` JSON API resources
- `app/Services` business logic layer
- `app/Contracts/Repositories` repository interfaces
- `app/Repositories/Eloquent` repository implementations
- `app/Policies` authorization rules
- `app/Events`, `app/Listeners`, `app/Jobs`, `app/Notifications` async/event-driven flow
- `app/Observers` cache invalidation and model side effects
- `resources/views/components/ui` reusable Blade UI system
- `resources/views/storefront`, `customer`, `vendor`, `admin` page groups
- `database/migrations`, `factories`, `seeders` persistence and demo data

### Main models

- `User`
- `Store`
- `Category`
- `Product`
- `ProductImage`
- `Address`
- `Cart`
- `CartItem`
- `Order`
- `OrderItem`
- `Payment`
- `Wishlist`
- `ActivityLog`
- `Setting`
- `Review`

### Services

- `CatalogService`
- `CartService`
- `CheckoutService`
- `VendorAnalyticsService`
- `AdminDashboardService`
- `ActivityLogService`
- `SettingService`

### Repositories

- `ProductRepositoryInterface` -> `ProductRepository`
- `OrderRepositoryInterface` -> `OrderRepository`

### Policies

- `ProductPolicy`
- `OrderPolicy`
- `StorePolicy`
- `CategoryPolicy`
- `AddressPolicy`
- `UserPolicy`

### Events and async flow

- `OrderPlaced`
- `VendorApproved`
- `SendOrderPlacedNotifications`
- `SendVendorApprovedNotification`
- `SendOrderConfirmationJob`
- `SendDailySalesSummaryJob`
- `CheckLowStockJob`

### Notifications

- `OrderPlacedNotification`
- `VendorApprovedNotification`
- `DailySalesSummaryNotification`
- `LowStockAlertNotification`

### API structure

- Public: products, categories
- Auth: register, login, logout
- Protected: profile, cart, orders
- Serialization via API Resources

## 2. Database schema and relationships

### Tables

- `users`
- `password_reset_tokens`
- `sessions`
- `roles`, `permissions`, pivot tables from Spatie
- `personal_access_tokens`
- `stores`
- `categories`
- `products`
- `product_images`
- `addresses`
- `carts`
- `cart_items`
- `orders`
- `order_items`
- `payments`
- `wishlists`
- `reviews`
- `settings`
- `activity_logs`
- `notifications`
- `jobs`, `job_batches`, `failed_jobs`
- `cache`, `cache_locks`

### Key relationships

- User `hasOne` Store
- Store `belongsTo` User
- Store `hasMany` Products
- Category `hasMany` Products
- Product `belongsTo` Store
- Product `belongsTo` Category
- Product `hasMany` ProductImages
- Product `hasMany` Reviews
- User `hasMany` Addresses
- User `hasOne` Cart
- Cart `hasMany` CartItems
- CartItem `belongsTo` Product
- User `hasMany` Orders
- Order `hasMany` OrderItems
- Order `hasOne` Payment
- OrderItem `belongsTo` Product
- User `belongsToMany` Products through `wishlists`
- ActivityLog uses a polymorphic `subject`

## 3. Implementation roadmap

### Phase 1: Foundation

- Scaffold Laravel, Breeze, Sanctum, Spatie Permission
- Configure bootstrap, middleware aliases, providers
- Design migrations, models, factories, seeders

### Phase 2: Storefront and Auth

- Landing page, catalog, product details, store pages
- Registration, login, logout, password reset, email verification
- Theme support and reusable UI primitives

### Phase 3: Vendor System

- Vendor dashboard
- Store profile
- Product CRUD
- Vendor order visibility
- Vendor analytics

### Phase 4: Cart and Orders

- Address management
- Cart service
- Checkout flow
- Order placement
- Notifications and activity logging

### Phase 5: Admin System

- Admin dashboard
- User management
- Vendor approval workflow
- Category management
- Product moderation
- Order status updates
- Platform settings

### Phase 6: API

- Sanctum token auth
- Products and categories resources
- Cart endpoints
- Order endpoints
- Profile endpoints

### Phase 7: Queues, Events, Cache, Testing

- Cached storefront sections
- Product observer invalidation
- Order placed event flow
- Vendor approval notifications
- Scheduler commands
- Feature tests

### Phase 8: UI polish and deployment

- Responsive Blade layouts
- Light/dark mode
- Docker config
- CI workflow
- Future Livewire/Filament hooks
