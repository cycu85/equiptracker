# EquipTracker

**Modułowa aplikacja webowa do zarządzania narzędziami, sprzętem wysokościowym, sprzętem IT i pracownikami.**

## 📋 Opis projektu

EquipTracker to kompleksowa aplikacja webowa stworzona w Laravel 11, przeznaczona do zarządzania różnymi typami sprzętu i narzędzi w firmie. Aplikacja została zaprojektowana z myślą o modularności, bezpieczeństwie i łatwości użytkowania.

## ✨ Kluczowe funkcjonalności

### 🔧 Zarządzanie sprzętem
- **Narzędzia** - zarządzanie narzędziami warsztatowymi
- **Sprzęt wysokościowy** - sprzęt do pracy na wysokości z certyfikacjami
- **Sprzęt IT** - komputery, drukarki, telefony, serwery
- **Pracownicy** - baza danych pracowników i ich uprawnień

### 🔐 System autoryzacji
- **Lokalna autoryzacja** - wbudowany system użytkowników
- **Integracja LDAP** - możliwość połączenia z Active Directory
- **Role użytkowników** - admin, manager, user
- **Bezpieczeństwo** - hashowane hasła, tokeny sesji

### 📄 Protokoły i dokumentacja
- **Generator PDF** - automatyczne tworzenie protokołów przekazania
- **Historia transferów** - pełna dokumentacja przekazań sprzętu
- **Raporty** - szczegółowe zestawienia wykorzystania

### 🔧 Zarządzanie modułami
- **Włączanie/wyłączanie modułów** - elastyczna konfiguracja
- **Panel administracyjny** - zarządzanie systemem
- **Czyszczenie danych** - możliwość resetu bazy danych

### 📧 System powiadomień email
- **Powiadomienia o transferach** - automatyczne emale przy przekazaniu i zwrocie sprzętu
- **Przypomnienia o przeglądach** - alerty o nadchodzących terminach kontroli
- **Harmonogram kontroli** - cotygodniowe sprawdzenia terminów
- **Statusy sprzętu** - powiadomienia o zmianach statusu

## 🏗️ Architektura techniczna

### Backend
- **Framework**: Laravel 11
- **PHP**: 8.3+
- **Baza danych**: MySQL 8.0
- **Autoryzacja**: Laravel Auth + LDAP

### Frontend
- **Templates**: Blade
- **CSS Framework**: Bootstrap 5 (styl Metronic)
- **JavaScript**: Vanilla JS / jQuery
- **Icons**: FontAwesome

### Moduły
```
app/
├── Modules/
│   ├── Tools/              # Narzędzia
│   ├── HeightEquipment/    # Sprzęt wysokościowy
│   ├── ITEquipment/        # Sprzęt IT
│   └── Employees/          # Pracownicy
├── Core/                   # Rdzeń systemu
└── Admin/                  # Panel administracyjny
```

## 🗄️ Struktura bazy danych

### Główne tabele
- `users` - użytkownicy systemu (local/LDAP)
- `employees` - pracownicy firmy
- `modules` - konfiguracja modułów
- `transfers` - protokoły przekazań

### Tabele sprzętu
- `tools` - narzędzia warsztatowe
- `height_equipment` - sprzęt wysokościowy
- `it_equipment` - sprzęt informatyczny

## 🚀 Instalacja

### Wymagania systemowe
- **OS**: Ubuntu 24.04 LTS (lub nowszy)
- **PHP**: 8.3+
- **MySQL**: 8.0+
- **Composer**: 2.0+
- **Node.js**: 18+ (opcjonalnie)
- **Git**: najnowsza wersja

### 📦 Instalacja na Ubuntu 24.04

#### 1. Aktualizacja systemu
```bash
sudo apt update && sudo apt upgrade -y
```

#### 2. Instalacja PHP 8.3 i rozszerzeń
```bash
# Dodaj repozytorium PHP
sudo apt install software-properties-common
sudo add-apt-repository ppa:ondrej/php
sudo apt update

# Zainstaluj PHP 8.3 i wymagane rozszerzenia
sudo apt install -y php8.3 php8.3-cli php8.3-fpm php8.3-mysql php8.3-xml php8.3-curl \
    php8.3-mbstring php8.3-zip php8.3-intl php8.3-bcmath php8.3-gd php8.3-soap \
    php8.3-ldap php8.3-redis php8.3-memcached php8.3-imagick

# Sprawdź wersję PHP
php -v
```

#### 3. Instalacja MySQL 8.0
```bash
# Zainstaluj MySQL Server
sudo apt install -y mysql-server mysql-client

# Uruchom skrypt bezpieczeństwa
sudo mysql_secure_installation

# Uruchom MySQL
sudo systemctl start mysql
sudo systemctl enable mysql

# Sprawdź status
sudo systemctl status mysql
```

#### 4. Instalacja Composer
```bash
# Pobierz i zainstaluj Composer
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer
sudo chmod +x /usr/local/bin/composer

# Sprawdź wersję
composer --version
```

#### 5. Instalacja Git
```bash
# Zainstaluj Git
sudo apt install -y git

# Skonfiguruj Git (zamień na swoje dane)
git config --global user.name "Twoje Imię Nazwisko"
git config --global user.email "twoj-email@example.com"

# Sprawdź wersję
git --version
```

#### 6. Instalacja Node.js (opcjonalnie)
```bash
# Zainstaluj Node.js LTS
curl -fsSL https://deb.nodesource.com/setup_lts.x | sudo -E bash -
sudo apt install -y nodejs

# Sprawdź wersje
node --version
npm --version
```

#### 7. Instalacja dodatkowych narzędzi
```bash
# Narzędzia do kompilacji i inne przydatne pakiety
sudo apt install -y build-essential curl wget unzip vim nano htop

# Redis (dla cache i kolejek)
sudo apt install -y redis-server
sudo systemctl start redis
sudo systemctl enable redis

# Supervisor (dla queue workers)
sudo apt install -y supervisor
```

#### 8. Konfiguracja Nginx (zalecane dla produkcji)
```bash
# Zainstaluj Nginx
sudo apt install -y nginx

# Uruchom i włącz autostart
sudo systemctl start nginx
sudo systemctl enable nginx

# Przykładowa konfiguracja dla EquipTracker
sudo nano /etc/nginx/sites-available/equiptracker
```

**Przykład konfiguracji Nginx:**
```nginx
server {
    listen 80;
    server_name equiptracker.local;
    root /var/www/equiptracker/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-XSS-Protection "1; mode=block";
    add_header X-Content-Type-Options "nosniff";

    index index.html index.htm index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.3-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

#### 9. Aktywacja konfiguracji Nginx
```bash
# Aktywuj stronę
sudo ln -s /etc/nginx/sites-available/equiptracker /etc/nginx/sites-enabled/

# Usuń domyślną konfigurację
sudo rm /etc/nginx/sites-enabled/default

# Testuj konfigurację
sudo nginx -t

# Przeładuj Nginx
sudo systemctl reload nginx
```

#### 10. Konfiguracja uprawnień
```bash
# Utwórz katalog dla aplikacji
sudo mkdir -p /var/www/equiptracker
sudo chown -R $USER:www-data /var/www/equiptracker
sudo chmod -R 755 /var/www/equiptracker
```

### 🔧 Instalacja aplikacji EquipTracker

Po zainstalowaniu środowiska systemowego, wykonaj następujące kroki:

#### 1. Sklonuj repozytorium
```bash
# Przejdź do katalogu web
cd /var/www

# Sklonuj repozytorium
sudo git clone https://github.com/cycu85/equiptracker.git

# Ustaw właściciela
sudo chown -R $USER:www-data equiptracker
```

#### 2. Zainstaluj zależności PHP
```bash
cd /var/www/equiptracker

# Zainstaluj pakiety Composer
composer install --optimize-autoloader --no-dev

# Lub dla rozwoju (z pakietami dev)
composer install
```

#### 3. Konfiguracja środowiska
```bash
# Skopiuj przykładowy plik konfiguracji
cp .env.example .env

# Wygeneruj klucz aplikacji
php artisan key:generate

# Ustaw uprawnienia
sudo chown -R www-data:www-data storage bootstrap/cache
sudo chmod -R 775 storage bootstrap/cache
```

#### 4. Konfiguracja bazy danych
```bash
# Utwórz bazę danych
sudo mysql -u root -p -e "CREATE DATABASE equiptracker CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
sudo mysql -u root -p -e "CREATE USER 'equiptracker'@'localhost' IDENTIFIED BY 'SecurePassword123!';"
sudo mysql -u root -p -e "GRANT ALL PRIVILEGES ON equiptracker.* TO 'equiptracker'@'localhost';"
sudo mysql -u root -p -e "FLUSH PRIVILEGES;"
```

Edytuj plik `.env`:
```env
APP_NAME=EquipTracker
APP_ENV=production
APP_DEBUG=false
APP_URL=http://twoja-domena.com

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=equiptracker
DB_USERNAME=equiptracker
DB_PASSWORD=SecurePassword123!

QUEUE_CONNECTION=redis
CACHE_DRIVER=redis
SESSION_DRIVER=redis
```

#### 5. Uruchomienie instalatora
```bash
# Uruchom serwer tymczasowo (dla instalatora)
php artisan serve --host=0.0.0.0 --port=8000

# LUB użyj graficznego instalatora w przeglądarce
# Przejdź do: http://twoja-domena.com/install
```

#### 6. Konfiguracja queue workers (dla emaili)
```bash
# Utwórz konfigurację Supervisor
sudo nano /etc/supervisor/conf.d/equiptracker-worker.conf
```

**Zawartość pliku Supervisor:**
```ini
[program:equiptracker-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /var/www/equiptracker/artisan queue:work redis --sleep=3 --tries=3 --max-time=3600
autostart=true
autorestart=true
stopasgroup=true
killasgroup=true
user=www-data
numprocs=2
redirect_stderr=true
stdout_logfile=/var/www/equiptracker/storage/logs/worker.log
stopwaitsecs=3600
```

```bash
# Uruchom worker
sudo supervisorctl reread
sudo supervisorctl update
sudo supervisorctl start equiptracker-worker:*
```

#### 7. Konfiguracja CRON (dla automatycznych powiadomień)
```bash
# Edytuj crontab dla www-data
sudo crontab -u www-data -e

# Dodaj wpisy:
* * * * * cd /var/www/equiptracker && php artisan schedule:run >> /dev/null 2>&1
0 8 * * * cd /var/www/equiptracker && php artisan equiptracker:check-inspections
```

#### 8. Finalne sprawdzenie
```bash
# Sprawdź uprawnienia
ls -la /var/www/equiptracker/storage/
ls -la /var/www/equiptracker/bootstrap/cache/

# Testuj konfigurację
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Sprawdź status serwisów
sudo systemctl status nginx
sudo systemctl status php8.3-fpm
sudo systemctl status mysql
sudo systemctl status redis
sudo supervisorctl status
```

### 🎯 Graficzny instalator

EquipTracker posiada wbudowany graficzny instalator dostępny pod adresem `/install`:

1. **Otwórz przeglądarkę** i przejdź do `http://localhost:8000/install`
2. **Sprawdź wymagania** - automatyczna kontrola PHP i rozszerzeń
3. **Konfiguruj bazę danych** - interfejs z testowaniem połączenia
4. **Utwórz konto admina** - podstawowa konfiguracja użytkownika
5. **Wybierz moduły** - aktywuj potrzebne komponenty
6. **Załaduj dane demo** - opcjonalne przykładowe dane

Instalator przeprowadzi przez wszystkie kroki i skonfiguruje system automatycznie.

## 📊 Dane demonstracyjne

Aplikacja zawiera przykładowe dane:
- 10-15 pracowników
- 20-30 narzędzi różnych kategorii
- 10-15 urządzeń IT
- 8-12 elementów sprzętu wysokościowego
- Przykładowe protokoły i transfery

## 🔧 Konfiguracja

### Moduły
Moduły można włączać/wyłączać w panelu administracyjnym lub bezpośrednio w bazie danych:

```sql
UPDATE modules SET is_enabled = 0 WHERE name = 'Tools';
```

### LDAP
Konfiguracja LDAP w pliku `.env`:
```env
LDAP_HOST=ldap://twoj-serwer.local
LDAP_PORT=389
LDAP_BASE_DN=dc=firma,dc=local
LDAP_USERNAME=cn=admin,dc=firma,dc=local
LDAP_PASSWORD=haslo_ldap
```

### 📧 Konfiguracja systemu email

Skonfiguruj wysyłanie emaili w pliku `.env`:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=twoj-email@gmail.com
MAIL_PASSWORD=haslo-aplikacji
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=twoj-email@gmail.com
MAIL_FROM_NAME="EquipTracker"
```

### ⏰ Automatyczne sprawdzanie przeglądów

Aby aktywować automatyczne powiadomienia o przeglądach, dodaj do crona:

```bash
# Sprawdzaj przeglądy codziennie o 8:00
0 8 * * * cd /path/to/equiptracker && php artisan equiptracker:check-inspections
```

Lub uruchom ręcznie:
```bash
php artisan equiptracker:check-inspections
```

## 👥 Role użytkowników

- **Admin** - pełny dostęp do systemu i panelu administracyjnego
- **Manager** - zarządzanie sprzętem i pracownikami
- **User** - podstawowe funkcje przeglądania i transferów

## 📈 Rozwój projektu

### Zaimplementowane funkcjonalności
- [x] **System modułowy** - elastyczne włączanie/wyłączanie funkcji
- [x] **Autoryzacja local/LDAP** - wielopoziomowy system dostępu
- [x] **Generator PDF** - automatyczne protokoły przekazań
- [x] **Panel administracyjny** - zarządzanie systemem i danymi
- [x] **Graficzny instalator** - łatwa instalacja krok po kroku
- [x] **System powiadomień email** - automatyczne alerty i przypomnienia
- [x] **Zarządzanie transferami** - pełna dokumentacja przekazań sprzętu

### Planowane funkcjonalności
- [ ] API REST
- [ ] Aplikacja mobilna
- [ ] Zaawansowane raporty
- [ ] Integracja z systemami ERP
- [ ] Kody QR/kreskowe
- [ ] Geolokalizacja sprzętu

### Jak kontrybuować
1. Fork repozytorium
2. Utwórz branch feature (`git checkout -b feature/nowa-funkcja`)
3. Commit zmian (`git commit -am 'Dodanie nowej funkcji'`)
4. Push do branch (`git push origin feature/nowa-funkcja`)
5. Utwórz Pull Request

## 📝 Licencja

Ten projekt jest udostępniony na licencji MIT. Zobacz plik `LICENSE` dla szczegółów.

## 🆘 Wsparcie

Jeśli napotkasz problemy lub masz pytania:
- Otwórz [Issue](https://github.com/nazwa-firmy/equiptracker/issues)
- Sprawdź [Wiki](https://github.com/nazwa-firmy/equiptracker/wiki)
- Skontaktuj się z zespołem deweloperskim

## 🙏 Podziękowania

- Laravel Framework
- Bootstrap Team
- FontAwesome
- Społeczność Open Source

---

**EquipTracker** - Zarządzaj sprzętem firmowym profesjonalnie i efektywnie! 🚀
