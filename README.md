# Symfony and API Platform

---

### Install Dependencies

`composer install`

---

### Configure Database, Environment Variables

- Make a copy of `.env` and rename it to `.env.local`
- Update it with your database credentials

If you haven't created a database, you can create it with doctrine:



```bash
php bin/console doctrine:database:create
```

- `php bin/console doctrine:schema:update --dump-sql` - prints the raw sql queries to be executed
- `php bin/console doctrine:schema:update --force` - executes the queries to sync the database with its entities

---

### Run Project

`symfony server:start`

(**Note**: This recipe uses the [Symfony binary](https://symfony.com/download), so it may not work if you're using another server like Apache/NgInx to serve your files. Installing the binary is necessary to use this recipe)

- `php bin/console cache:clear --env=prod` - clears and warmup/refresh cache

---