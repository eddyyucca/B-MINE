# B'MINE - Mining Identity Number Electronic

B'MINE is a comprehensive web application designed for managing mining permits and employee identification in the mining industry. The system streamlines the process of issuing, tracking, and managing both Mine Permits and SIMPER (Safety, Identity, and Permit) cards for mining operations.

## Overview

This application is built for Bukit Makmur Mandiri Utama (BUMA), one of Indonesia's largest mining contractors. It digitizes the traditional permit processes, reducing administrative overhead and providing real-time insights into compliance status across mining operations.

## Features

-   **User Authentication System**: Multi-level user authentication with role-based access control (Admin, SHE, PJO, BEC, KTT, etc.)
-   **Permit Request Management**: Complete workflow for request submission, approval, and tracking
-   **Document Management**: Upload and storage of required documents (medical certificates, driver's licenses, SIO certificates)
-   **Access Management**: Control access permissions for different mining areas (CHR, CP, PIT)
-   **Unit Tracking**: Management of equipment operation permissions with PRTIO classification
-   **QR Code Generation**: Digital verification of permits via QR codes
-   **ID Card Generation**: Automatic generation of employee ID cards with relevant permit information
-   **Expiry Alerts**: Notification system for permits nearing expiration
-   **Dashboard Analytics**: Real-time visualizations of permit statuses and distribution

## Technology Stack

-   **Backend**: PHP with Laravel Framework
-   **Frontend**: HTML, CSS, JavaScript with AdminLTE template
-   **Database**: MySQL
-   **Libraries**:
    -   Chart.js for data visualization
    -   SimpleSoftwareIO/QrCode for QR code generation
    -   PDF.js for document handling

## Installation

1. Clone the repository

    ```
    git clone [repository-url]
    ```

2. Install dependencies

    ```
    composer install
    npm install
    ```

3. Configure environment variables

    ```
    cp .env.example .env
    php artisan key:generate
    ```

4. Configure database settings in `.env` file

    ```
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=bmine
    DB_USERNAME=root
    DB_PASSWORD=
    ```

5. Run migrations

    ```
    php artisan migrate
    ```

6. Create symbolic link for storage

    ```
    php artisan storage:link
    ```

7. Start the development server
    ```
    php artisan serve
    ```

## System Architecture

### Models

The application uses several key models:

-   `DataReqModel`: Stores permit requests
-   `KaryawanModel`: Manages employee data
-   `UserModel`: Handles external user accounts
-   `UnitModel`: Manages equipment units
-   `Data_m_s_Model`: Stores approved and active permits

### Controllers

Key controllers include:

-   `AuthController`: Manages user authentication
-   `RequestController`: Handles permit request submission
-   `PersonalTaskController`: Manages task assignments based on user roles
-   `DashboardController`: Handles dashboard analytics and visualizations

### Permission Workflow

1. Request submission by department admin
2. SHE approval
3. PJO approval
4. BEC approval
5. KTT approval (for different areas)
6. Final issuance of permit/ID card

## Customization

### Adding New User Roles

To add new user roles, modify the following:

1. Update the `EnsureUserIsLoggedIn` middleware
2. Add relevant role-specific routes in `web.php`
3. Update views to include new role permissions

### Adding New Permit Types

To add new permit types:

1. Update the request form in `request/get_data.blade.php`
2. Add validation rules in `RequestController.php`
3. Update the database schema as needed

## License

This project is proprietary software developed for BUMA.

## Developer

Developed by Eddy Adha Saputra.

---

For more information, please contact the development team.
