Yii-jade
========
Yii's extension for Jade template system

## Instructions

### Installation

Install yii-jade with composer. Because it is not in the standard composer
repositories, you will need to add the repository to your composer.json file as
well:

    ```
    "repositories": [
        {
            "url": "https://github.com/greenhost/yii-jade",
            "type": "vcs"
        }
    ]    
    "require": {
        "greenhost/yii-jade": "dev-dev@dev",
    },

    ```

### Configuration


To enable yii-jade, add this to your 'config/main.php' file:
    
    ```php
    'components'=>array(
        ...
        'viewRenderer'=>array(
            'class' => 'ext.yii-jade.CJadeViewRenderer',
        ),
        ...
    ```

You may want to add the following line, so the compiled templates will have passed data to a template in the main var list


   ```php
            'prepend' => array('<?php extract((array)$data); ?>'),
   ```

It is possible to configure other variables: check the class variables in
`CJadeViewRenderer.php`. Each public variable can be configured in your main.php
yii configuration file, e.g.:

    ```php
    'components'=>array(
        ...
        'viewRenderer'=>array(
            'class' => 'ext.yii-jade.CJadeViewRenderer',
            'filePermission' => '775',
        ),
        ...
    ```

sets the file permissions of all the files yii-jade creates to 775.
