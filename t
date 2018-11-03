[33mcommit d6eca9368de4220f2cda047a02c32ad2b32e0a9c[m[33m ([m[1;36mHEAD -> [m[1;32mmaster[m[33m, [m[1;32mdeveloper[m[33m)[m
Author: oliraug <masiga2005@gmail.com>
Date:   Fri Nov 2 14:06:40 2018 +0300

    Adding Marketify Project to GitHub for the first time

[1mdiff --git a/.env.example b/.env.example[m
[1mnew file mode 100644[m
[1mindex 0000000..668c06f[m
[1m--- /dev/null[m
[1m+++ b/.env.example[m
[36m@@ -0,0 +1,33 @@[m
[32m+[m[32mAPP_NAME=Laravel[m
[32m+[m[32mAPP_ENV=local[m
[32m+[m[32mAPP_KEY=[m
[32m+[m[32mAPP_DEBUG=true[m
[32m+[m[32mAPP_LOG_LEVEL=debug[m
[32m+[m[32mAPP_URL=http://localhost[m
[32m+[m
[32m+[m[32mDB_CONNECTION=mysql[m
[32m+[m[32mDB_HOST=127.0.0.1[m
[32m+[m[32mDB_PORT=3306[m
[32m+[m[32mDB_DATABASE=homestead[m
[32m+[m[32mDB_USERNAME=homestead[m
[32m+[m[32mDB_PASSWORD=secret[m
[32m+[m
[32m+[m[32mBROADCAST_DRIVER=log[m
[32m+[m[32mCACHE_DRIVER=file[m
[32m+[m[32mSESSION_DRIVER=file[m
[32m+[m[32mQUEUE_DRIVER=sync[m
[32m+[m
[32m+[m[32mREDIS_HOST=127.0.0.1[m
[32m+[m[32mREDIS_PASSWORD=null[m
[32m+[m[32mREDIS_PORT=6379[m
[32m+[m
[32m+[m[32mMAIL_DRIVER=smtp[m
[32m+[m[32mMAIL_HOST=smtp.mailtrap.io[m
[32m+[m[32mMAIL_PORT=2525[m
[32m+[m[32mMAIL_USERNAME=null[m
[32m+[m[32mMAIL_PASSWORD=null[m
[32m+[m[32mMAIL_ENCRYPTION=null[m
[32m+[m
[32m+[m[32mPUSHER_APP_ID=[m
[32m+[m[32mPUSHER_APP_KEY=[m
[32m+[m[32mPUSHER_APP_SECRET=[m
[1mdiff --git a/.gitattributes b/.gitattributes[m
[1mnew file mode 100644[m
[1mindex 0000000..967315d[m
[1m--- /dev/null[m
[1m+++ b/.gitattributes[m
[36m@@ -0,0 +1,5 @@[m
[32m+[m[32m* text=auto[m
[32m+[m[32m*.css linguist-vendored[m
[32m+[m[32m*.scss linguist-vendored[m
[32m+[m[32m*.js linguist-vendored[m
[32m+[m[32mCHANGELOG.md export-ignore[m
[1mdiff --git a/.gitignore b/.gitignore[m
[1mnew file mode 100644[m
[1mindex 0000000..b6a4b86[m
[1m--- /dev/null[m
[1m+++ b/.gitignore[m
[36m@@ -0,0 +1,12 @@[m
[32m+[m[32m/node_modules[m
[32m+[m[32m/public/hot[m
[32m+[m[32m/public/storage[m
[32m+[m[32m/storage/*.key[m
[32m+[m[32m/vendor[m
[32m+[m[32m/.idea[m
[32m+[m[32m/.vagrant[m
[32m+[m[32mHomestead.json[m
[32m+[m[32mHomestead.yaml[m
[32m+[m[32mnpm-debug.log[m
[32m+[m[32myarn-error.log[m
[32m+[m[32m.env[m
[1mdiff --git a/app/Category.php b/app/Category.php[m
[1mnew file mode 100644[m
[1mindex 0000000..a2bac7c[m
[1m--- /dev/null[m
[1m+++ b/app/Category.php[m
[36m@@ -0,0 +1,24 @@[m
[32m+[m[32m<?php[m
[32m+[m
[32m+[m[32mnamespace App;[m
[32m+[m
[32m+[m[32muse Illuminate\Database\Eloquent\Model;[m
[32m+[m
[32m+[m[32mclass Category extends Model[m
[32m+[m[32m{[m
[32m+[m[32m    protected $primaryKey = 'id';[m
[32m+[m[32m    protected $table = 'olify_category';[m
[32m+[m
[32m+[m[32m    protected $fillable = array([m
[32m+[m[41m    [m		[32m'user_id', /*Contains our foreign key to the users table*/[m
[32m+[m[41m    [m		[32m'category_name',[m
[32m+[m[41m    [m		[32m'category_status',[m
[32m+[m[41m    [m		[32m'description'[m
[32m+[m[32m    );[m
[32m+[m
[32m+[m[32m    //Define relationships, each market user has many product categories[m
[32m+[m[32m    public function user()[m
[32m+[m[32m    {[m
[32m+[m[41m    [m	[32mreturn $this->hasMany('User');[m
[32m+[m[32m    }[m
[32m+[m[32m}[m
[1mdiff --git a/app/Console/Kernel.php b/app/Console/Kernel.php[m
[1mnew file mode 100644[m
[1mindex 0000000..622e774[m
[1m--- /dev/null[m
[1m+++ b/app/Console/Kernel.php[m
[36m@@ -0,0 +1,40 @@[m
[32m+[m[32m<?php[m
[32m+[m
[32m+[m[32mnamespace App\Console;[m
[32m+[m
[32m+[m[32muse Illuminate\Console\Scheduling\Schedule;[m
[32m+[m[32muse Illuminate\Foundation\Console\Kernel as ConsoleKernel;[m
[32m+[m
[32m+[m[32mclass Kernel extends ConsoleKernel[m
[32m+[m[32m{[m
[32m+[m[32m    /**[m
[32m+[m[32m     * The Artisan commands provided by your application.[m
[32m+[m[32m     *[m
[32m+[m[32m     * @var array[m
[32m+[m[32m     */[m
[32m+[m[32m    protected $commands = [[m
[32m+[m[32m        //[m
[32m+[m[32m    ];[m
[32m+[m
[32m+[m[32m    /**[m
[32m+[m[32m     * Define the application's command schedule.[m
[32m+[m[32m     *[m
[32m+[m[32m     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule[m
[32m+[m[32m     * @return void[m
[32m+[m[32m     */[m
[32m+[m[32m    protected function schedule(Schedule $schedule)[m
[32m+[m[32m    {[m
[32m+[m[32m        // $schedule->command('inspire')[m
[32m+[m[32m        //          ->hourly();[m
[32m+[m[32m    }[m
[32m+[m
[32m+[m[32m    /**[m
[32m+[m[32m     * Register the Closure based commands for the application.[m
[32m+[m[32m     *[m
[32m+[m[32m     * @return void[m
[32m+[m[32m     */[m
[32m+[m[32m    protected function commands()[m
[32m+[m[32m    {[m
[32m+[m[32m        require base_path('routes/console.php');[m
[32m+[m[32m    }[m
[32m+[m[32m}[m
[1mdiff --git a/app/Currency.php b/app/Currency.php[m
[1mnew file mode 100644[m
[1mindex 0000000..0a06a2a[m
[1m--- /dev/null[m
[1m+++ b/app/Currency.php[m
[36m@@ -0,0 +1,10 @@[m
[32m+[m[32m<?php[m
[32m+[m
[32m+[m[32mnamespace App;[m
[32m+[m
[32m+[m[32muse Illuminate\Database\Eloquent\Model;[m
[32m+[m
[32m+[m[32mclass Currency extends Model[m
[32m+[m[32m{[m
[32m+[m[32m    //[m
[32m+[m[32m}[m
[1mdiff --git a/app/Customers.php b/app/Customers.php[m
[1mnew file mode 100644[m
[1mindex 0000000..cddd2d8[m
[1m--- /dev/null[m
[1m+++ b/app/Customers.php[m
[36m@@ -0,0 +1,10 @@[m
[32m+[m[32m<?php[m
[32m+[m
[32m+[m[32mnamespace App;[m
[32m+[m
[32m+[m[32muse Illuminate\Database\Eloquent\Model;[m
[32m+[m
[32m+[m[32mclass Customers extends Model[m
[32m+[m[32m{[m
[32m+[m[32m    //[m
[32m+[m[32m}[m
[1mdiff --git a/app/Employees.php b/app/Employees.php[m
[1mnew file mode 100644[m
[1mindex 0000000..21384d2[m
[1m--- /dev/null[m
[1m+++ b/app/Employees.php[m
[36m@@ -0,0 +1,10 @@[m
[32m+[m[32m<?php[m
[32m+[m
[32m+[m[32mnamespace App;[m
[32m+[m
[32m+[m[32muse Illuminate\Database\Eloquent\Model;[m
[32m+[m
[32m+[m[32mclass Employees extends Model[m
[32m+[m[32m{[m
[32m+[m[32m    //[m
[32m+[m[32m}[m
[1mdiff --git a/app/Exceptions/CategoryNotFoundException.php b/app/Exceptions/CategoryNotFoundException.php[m
[1mnew file mode 100644[m
[1mindex 0000000..f32c5d2[m
[1m--- /dev/null[m
[1m+++ b/app/Exceptions/CategoryNotFoundException.php[m
[36m@@ -0,0 +1,9 @@[m
[32m+[m[32m<?php[m
[32m+[m
[32m+[m[32mnamespace App\Olify\Marketify\Exceptions;[m
[32m+[m
[32m+[m[32mclass CategoryNotFoundException extends \Exception[m
[32m+[m[32m{[m
[32m+[m[41m	[m
[32m+[m[32m}[m
[32m+[m[32m?>[m
\ No newline at end of file[m
[1mdiff --git a/app/Exceptions/CreateCategoryErrorException.php b/app/Exceptions/CreateCategoryErrorException.php[m
[1mnew file mode 100644[m
[1mindex 0000000..67a25c0[m
[1m--- /dev/null[m
[1m+++ b/app/Exceptions/CreateCategoryErrorException.php[m
[36m@@ -0,0 +1,9 @@[m
[32m+[m[32m<?php[m
[32m+[m
[32m+[m[32mnamespace App\Olify\Marketify\Exceptions;[m
[32m+[m
[32m+[m[32mclass CreateCategoryErrorException extends \Exception[m
[32m+[m[32m{[m
[32m+[m[41m	[m
[32m+[m[32m}[m
[32m+[m[32m?>[m
\ No newline at end of file[m
[1mdiff --git a/app/Exceptions/Handler.php b/app/Exceptions/Handler.php[m
[1mnew file mode 100644[m
[1mindex 0000000..a747e31[m
[1m--- /dev/null[m
[1m+++ b/app/Exceptions/Handler.php[m
[36m@@ -0,0 +1,65 @@[m
[32m+[m[32m<?php[m
[32m+[m
[32m+[m[32mnamespace App\Exceptions;[m
[32m+[m
[32m+[m[32muse Exception;[m
[32m+[m[32muse Illuminate\Auth\AuthenticationException;[m
[32m+[m[32muse Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;[m
[32m+[m
[32m+[m[32mclass Handler extends ExceptionHandler[m
[32m+[m[32m{[m
[32m+[m[32m    /**[m
