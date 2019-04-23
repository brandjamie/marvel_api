This is a simple web app to browse marvels API of characters, comics, events and stories.

It is created using the laravel framework.

Marvels api uses an etag system to allow you to cache data. Each request has an 'etag' fingerprint which you can submit with your request. If the data has not changed an empty body and a 304/Not Modified HTTP header. This allows much faster loading of previously viewed pages.

The app uses an MVC architecture for caching the data. 


Models are found in 
/app/

Views are found in 
/resources/views

Controllers are found in 
/app/Http/Controllers/

Migrations (database schema) are found in
/database/migrations/

To deploy the app you need to create a .env file from the template, enter your database details and obtain an API key from Marvel.
