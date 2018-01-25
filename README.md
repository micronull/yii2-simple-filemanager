# Yii2 simple filemanager
A simple file manager. Having minimal dependencies, but great opportunities for expansion.

## Features

* Do not need a database. Consequently, there are no migrations.
* It's simple.

## TODO

* Preview for images.
* Extended information about files.
* Column with the file size.
* Possibility to limit the types of downloaded files through the configuration.
* Add support RBAC.

## Screenshots

Basic app template

![base app en](https://raw.githubusercontent.com/De-Luxis/yii2-simple-filemanager/master/screenshots/base-app-en.png)

Empty files. Basic app template i18n.

![base app en](https://raw.githubusercontent.com/De-Luxis/yii2-simple-filemanager/master/screenshots/base-app-ru-empty.png)

Submodule.

![base app en](https://raw.githubusercontent.com/De-Luxis/yii2-simple-filemanager/master/screenshots/submodule.png)

Submodule i18n.

![base app en](https://raw.githubusercontent.com/De-Luxis/yii2-simple-filemanager/master/screenshots/submodule-ru.png)

## Installation

Run the command.

`composer require de-luxis/yii2-simple-filemanager`

Or add to your composer.json

`"de-luxis/yii2-simple-filemanager": "*"`

Now, register the module in the configuration of your application.

On an example of the [basic application template](https://github.com/yiisoft/yii2-app-basic) `config/web.php`

```
'modules' => [
    'filemanager' => [
        'class' => 'DeLuxis\Yii2SimpleFilemanager\SimpleFilemanagerModule'
    ],
],
```

The file manager will be available at `index.php?r=filemanager`

## Submodule

The file manager can be included as a submodule. For example, for your administration panel.
To do this, in the method of initializing your module, you need to add an entry that the file manager will connect.

```
public function init()
{
    parent::init();

    $this->modules = [
        'filemanager' => [
            'class' => 'DeLuxis\Yii2SimpleFilemanager\SimpleFilemanagerModule',
            'as access' => [
                'class' => '\yii\filters\AccessControl',
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ]
            ]
        ]
    ];
}
```
With the help of a record `as access` you can regulate access rights.