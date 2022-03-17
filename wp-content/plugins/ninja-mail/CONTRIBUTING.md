# Contributing

## Organization

The `/lib` directory contains files which are required by the plugin, but are not specific to the plugin itself. This includes base classes (ex. `/lib/wordpress/plugin.php` ) and interfaces/contracts (ex. `/lib/wordpress/mailer.php` ), or any functionality that is otherwise extracted for "common" use. Inspecting these files should not be required for the understanding of the plugin functionality. This top level folder is similar to a `vendor` directory, except that these files are maintained locally (or manually), as opposed to a remote source.

The `/includes` directory contains files which are specific to the plugin. This includes the plugin singleton (`/includes/plugin.php`) which is used to global/static access to the plugin functionality. Other top level items in this folder include functionality that is specific to setting up the plugin, but is not core to the application (ex. `/includes/admin.php` contains admin related actions and filters, which are necessary but not "core" functionality). Files containing "core" functionality (generally classes and objects) should be contained one (1) level deeper within the `/includes/app` directory.

The `/includes/app` directory contains files which are specific to the "core" functionality of the application; These are usually objects (ex. `/includes/app/mailer.php`), as opposed to procedural code (with the exception of the plugin singleton). Nested directories are then used for further organization.

The `/includes/resources` directory contains files which are served to the browser for consumption by the client (as opposed to the server). This includes view files (see `includes/resources/views`) which are used as templates.
