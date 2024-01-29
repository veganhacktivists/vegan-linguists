# Production notes

-   Make sure to run `artisan storage:link` to enable profile photos

# [Vegan Linguists](https://veganlinguists.org)

1. [Local development setup](#local-development-setup)
1. [Custom configuration options](#custom-configuration-options)
1. [Scheduled jobs](#scheduled-jobs)
1. [Custom commands](#custom-commands)
1. [Receiving emails locally](#recieving-emails-locally)

## Local development setup

This project uses [Laravel Sail](https://laravel.com/docs/9.x/sail#main-content) for local development.

### Docker

First, you must download [Docker](https://www.docker.com/).

### PHP

In order to install the dependencies required to set up Laravel Sail, you will need PHP installed locally.

-   For MacOS users, Homebrew is the recommended way of doing this: `Homebrew install php`
-   For Windows users, you may follow [these instructions](https://phptherightway.com/#windows_setup).
-   For Linux users, you should install PHP via your distribution's package manager.

### Setup

After you have Docker and PHP installed, navigate to the project directory and run the following:

```bash
composer install
./vendor/bin/sail up
./vendor/bin/sail pnpm
```

**Note:** If you have `node` and `pnpm` installed locally, you can run `pnpm` from your local machine instead of within the Docker container if you'd like.

**Pro tip!** Add the following (or something equivalent) to your shell configuration to use Sail more easily:

```bash
alias sail="bash vendor/bin/sail"
```

### Development

During development, it's recommended to run the following in parallel:

```bash
sail up # starts up Docker container
sail pnpm watch # watches for JS/CSS changes
```

## [Custom configuration](https://laravel.com/docs/9.x/structure#the-config-directory)

This project uses the following custom config files:

-   [vl.php](https://github.com/veganhacktivists/vegan-linguists/blob/main/config/vl.php)

## [Scheduled jobs](https://laravel.com/docs/9.x/scheduling#main-content)

This project has the following scheduled jobs:

-   [SendNewTranslationRequestsEmail](https://github.com/veganhacktivists/vegan-linguists/blob/main/app/Jobs/SendNewTranslationRequestsEmail.php): This job sends a weekly email to translators, letting them know about new requests for translations and reviews.
-   [ResizeNewProfilePhotos](https://github.com/veganhacktivists/vegan-linguists/blob/main/app/Jobs/ResizeNewProfilePhotos.php): This job resizes new/updated profile photos every hour to keep storage space in check.

## [Custom commands](https://laravel.com/docs/9.x/artisan#writing-commands)

This project has no custom commands implemented.

## Receiving emails locally

In order to check emails sent locally, visit `http://localhost:8025` to access [MailHog](https://github.com/mailhog/MailHog), which is [provided by Laravel Sail](https://laravel.com/docs/9.x/sail#previewing-emails)
