# MyMeetic

## Description
MyMeetic is an online dating website designed using **object-oriented PHP**, combined with **modern JavaScript (ES6+), AJAX, and Fetch API**. The project follows an **MVC architecture** and offers a smooth and intuitive user experience.

## Main Features
### 1. Registration and Login
- Registration form with front-end and back-end validation
- Age verification (registration restricted to 18+ users)
- Password hashing using **password_hash**
- Secure login with session management

### 2. User Account Management
- View profile information
- Modify password and email
- Permanent account deletion (without DELETE queries in the database)

### 3. Advanced Search and Filters
- Search based on multiple criteria:
  - **Gender** (Male, Female, Other)
  - **Location** (city)
  - **Hobbies** 
  - **Age range** (18/25, 25/35, 35/45, 45+)
- Results displayed in an **interactive JavaScript carousel**

### 4. Security and Validation
- Protection against SQL injections
- Client-side and server-side validations
- Secure user input handling

## Technologies Used
- **Front-end**: HTML5, CSS, JavaScript (ES6+), Fetch API, AJAX
- **Back-end**: PHP 8 (OOP), MySQL, PDO
- **Architecture**: MVC (Model-View-Controller)

## Installation and Usage
### Prerequisites
- **PHP 8+**
- **MySQL**
- **A local server** (e.g., Apache via XAMPP or standalone PHP)

### Installation Steps
1. Clone the project:
   ```bash
   git clone https://github.com/yumetia/my_meetic-project.git
   ```
2. Import the database using `Config/import.php`
3. Configure the database connection with ur informations in `Config/config.ini`
4. Start the server:
   ```bash
   php -S localhost:8000
   ```
5. Access the website via `http://localhost:8000`

## Improvements
- Added an internal messaging system between users
- Real-time notifications
- Design and animation optimizations

## Author
- **Yumetia** - Project Developer

## License
This project is licensed under the MIT License.
