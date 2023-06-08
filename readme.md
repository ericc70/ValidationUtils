# ValidationUtils

A package that gathers various validation utilities.

------

## Table of Contents

- [Installation](#installation)
- [EmailValidator](#emailvalidator)
- [StringValidator](#stringvalidator)
- [PhoneValidator](#phonevalidator)
- PasswordValidator

------

## Installation

Run the following command to install via Composer:

```shell
composer require ...
```

---

## Getting started

```php
// Simple usage
use Ericc70\ValidationUtils\Lib\EmailValidator;
use Ericc70\ValidationUtils\Lib\StringValidator;
use Ericc70\ValidationUtils\Lib\PasswordValidator;
use Ericc70\ValidationUtils\Lib\PhoneValidator;

$validator = new EmailValidator();
$validator->validate('mail@domain.com');

$validator = new StringValidator();
$validator->validate('Hello World');

$validator = new PasswordValidator;
$validator->validate('As56*§cd3+heH*5s-5qs5d');

$validator = new PhoneValidator();
$validator->validate("+330304050607");

// Usage with options
$options = [
    'minLength' => 5,
    'maxLength' => 10,
    'regex' => '/^[a-zA-Z0-9]+$/',
    'required' => true,
];
$validator->validate('example', $options);
```

---
## EmailValidator
A utility for validating email addresses.

Available options:

| Option         | Description                                                           | Default Value |
|----------------|-----------------------------------------------------------------------|---------------|
| banDomain      | Indicates whether specific email domains are banned (e.g., disposable emails)    | false         |
| validDomain    | Indicates whether the email domain must be valid (DNS verification)     | true          |

---
## PasswordValidator
A utility for validating passwords.

Available options:

| Option                  | Description                                                               | Default Value |
|-------------------------|---------------------------------------------------------------------------|---------------|
| minLength               | Minimum password length                                                    | 10            |
| maxLength               | Maximum password length                                                    | 255           |
| minSpecialCharacters    | Minimum number of required special characters in the password              | 1             |
| minNumericCharacters    | Minimum number of required numeric characters in the password              | 1             |
| minAlphaCharacters      | Minimum number of required alphabetic characters in the password           | 1             |
| minLowerCaseCharacters  | Minimum number of required lowercase characters in the password            | 1             |
| minUpperCaseCharacters  | Minimum number of required uppercase characters in the password            | 1             |
| maxRepeatedCharacters   | Maximum allowed number of repeated characters in the password              | 3             |
| forbiddenPassword       | Indicates whether specific common passwords are forbidden (e.g., a list)   | true          |

---
## StringValidator
A utility for validating strings.

Available options:

| Option    | Description                                                      | Default Value |
|-----------|------------------------------------------------------------------|---------------|
| minLength | Minimum required length for the string                            | 1             |
| maxLength | Maximum allowed length for the string                             | 255           |
| regex     | Regular expression or use `RegexCollection::getRegex('regexName')` | ""            |
| required  | Indicates whether the string is required or not                   | false         |

---

## PhoneValidator
A utility for validating phone numbers.

Dependency: @libphonenumber

| Option                | Description                                                                   | Default Value |
|-----------------------|-------------------------------------------------------------------------------|---------------|
| mobile                | Indicates whether the phone number must be a mobile number                     | false         |
| fixed                 | Indicates whether the phone number must be a landline number                   | false         |
| formatE164            | Indicates whether the phone number must be in E.164 format (e.g., +33612345678) | false         |
| restrictedCountries   | List of restricted countries for phone number validation                       | []            |
| allowedCountries      | List of allowed countries for phone number validation                          | []            |
| forbiddenNumber       | Indicates whether specific phone numbers are forbidden                        | false         |
| currentCountry        | Country code (to check if the number belongs to the country)                   | ''            |
| specialCharacters     | Indicates whether special characters are allowed in the phone number           | false         |


---

## Utilities

### RegexCollection::Class

A class that contains reusable regular expressions.

#### Available regexes:

| Regex           | Description                                          |
|-----------------|------------------------------------------------------|
| alphaNumeric    | Validates an alphanumeric string                      |
| email           | Validates an email address                            |
| url             | Validates a URL                                       |

Use the `getRegex` method of the `RegexCollection` class to get the corresponding regular expression.

Example usage:

```php
use Ericc70\ValidationUtils\Class\RegexCollection;

$regex = RegexCollection::getRegex('email');
```

