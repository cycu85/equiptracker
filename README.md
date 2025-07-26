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

### Wymagania
- PHP 8.3+
- MySQL 8.0+
- Composer
- Node.js (opcjonalnie)

### Kroki instalacji

1. **Sklonuj repozytorium**
```bash
git clone https://github.com/nazwa-firmy/equiptracker.git
cd equiptracker
```

2. **Zainstaluj zależności**
```bash
composer install
```

3. **Konfiguracja środowiska**
```bash
cp .env.example .env
php artisan key:generate
```

4. **Konfiguracja bazy danych**
Edytuj plik `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=equiptracker
DB_USERNAME=root
DB_PASSWORD=twoje_haslo
```

5. **Migracja i seedowanie**
```bash
php artisan migrate
php artisan db:seed
```

6. **Uruchomienie serwera**
```bash
php artisan serve
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
