# ValidationUtils

Un package regroupant plusieurs utilitaires de validation.



------

## Sommaire


- [Installation](#installation)
- [EmailValidator](#emailvalidator)
- [StringValidator](#stringvalidator)
- [PhoneValidator](#phonevalidator)




------





## Installation

Exécutez la commande suivante pour l'installation via Composer :

```shell
composer require ...
```
---

## Démarrage
```php
// utilisation simple
use Ericc70\ValidationUtils\Lib\EmailValidator;
use Ericc70\ValidationUtils\Lib\StringValidator;
use Ericc70\ValidationUtils\Lib\PasswordValidator;
use Ericc70\ValidationUtils\Lib\PhoneValidator;

$validator = new EmailValidator();
$validator->validate('mail@domine.com');

$validator = new StringValidator();
$validator->validate('Hello World');

$validator = new PasswordValidator;
$validator->validate('As56*§cd3+heH*5s-5qs5d');

$validator = new PhoneValidator();
$validator->validate("+330304050607");

// utilisation avec options
$options = [
    'minLength' => 5,
    'maxLength' => 10,
    'regex' => '/^[a-zA-Z0-9]+$/',
    'required' => true,
];
$validator->validate('exemple', $options);
```

---
## EmailValidator
Un utilitaire pour valider les adresses e-mail.

Options disponibles :

| Option         | Description                                                                                       | Valeur par défaut |
|----------------|---------------------------------------------------------------------------------------------------|-------------------|
| banDomain      | Indique si certains domaines d'e-mail spécifiques sont interdits (d'apres une liste , (exemple mail jetable))                                  | false             |
| validDomain    | Indique si le domaine de l'e-mail doit être valide (vérification DNS)                              | true              |

---
## PasswordValidator

Un utilitaire pour valider les mots de passe.
Options disponibles :

| Option                  | Description                                                                               | Valeur par défaut |
|-------------------------|-------------------------------------------------------------------------------------------|-------------------|
| minLength               | Longueur minimale du mot de passe                                                        | 10                |
| maxLength               | Longueur maximale du mot de passe                                                        | 255               |
| minSpecialCharacters    | Nombre minimum de caractères spéciaux requis dans le mot de passe                         | 1                 |
| minNumericCharacters    | Nombre minimum de caractères numériques requis dans le mot de passe                       | 1                 |
| minAlphaCharacters      | Nombre minimum de caractères alphabétiques requis dans le mot de passe                     | 1                 |
| minLowerCaseCharacters  | Nombre minimum de caractères minuscules requis dans le mot de passe                        | 1                 |
| minUpperCaseCharacters  | Nombre minimum de caractères majuscules requis dans le mot de passe                        | 1                 |
| maxRepeatedCharacters   | Nombre maximal de caractères répétés autorisé dans le mot de passe                        | 3                 |
| forbiddenPassword       |  interdits les mots de passe courant (d'apres une liste)                             | true              |

A utility for validating passwords.

---
## StringValidator
Un utilitaire pour valider les chaînes de caractères.


Options disponibles :

| Option    | Description                                               | Valeur par défaut                   |
|-----------|-----------------------------------------------------------|-------------------------------------|
| minLength | Caractère minimum requis dans la chaîne de caractères      | 1                                   |
| maxLength | Caractère maximum autorisé dans la chaîne de caractères    | 255                                 |
| regex     | Expression régulière ou utilisez `RegexCollection::getRegex('nomRegex')` | ""  |
| required  | Indique si la chaîne de caractères est obligatoire ou non  | false                               |



---
## PhoneValidator
Un utilitaire pour valider les numéros de téléphone

dependance: @libphonenumber

| Option                | Description                                                                           | Valeur par défaut |
|-----------------------|---------------------------------------------------------------------------------------|-------------------|
| mobile                | Indique si le numéro de téléphone doit être un numéro de téléphone mobile             | false             |
| fixed                 | Indique si le numéro de téléphone doit être un numéro de téléphone fixe               | false             |
| formatE164            | Indique si le numéro de téléphone doit être au format E.164 (par exemple, +33612345678) | false             |
| restrictedCountries   | Liste des pays restreints pour la validation des numéros de téléphone                  | []                |
| allowedCountries      | Liste des pays autorisés pour la validation des numéros de téléphone                   | []                |
| forbiddenNumber       | Indique si certains numéros de téléphone sont interdits                                | false             |
| currentCountry        | Code du pays (pour vérifier si le numéro appartient au pays)                      | ''                |
| specialCharacters     | Indique si des caractères spéciaux sont autorisés dans le numéro de téléphone          | false             |


## Utilitaires

### `RegexCollection` Class

Classe contenant des expressions régulières réutilisables.

#### Regex disponibles :

| Regex           | Description                                  |
|-----------------|----------------------------------------------|
| alphaNumeric    | Permet de valider une chaîne alphanumérique   |
| email           | Permet de valider une adresse e-mail          |
| url             | Permet de valider une URL                     |

Utilisez la méthode `getRegex` de la classe `RegexCollection` pour obtenir l'expression régulière correspondante.

Exemple d'utilisation :

```php
use Ericc70\ValidationUtils\Class\RegexCollection;

$regex = RegexCollection::getRegex('email');
```