Yii-jade
========
Yii's extension for Jade template system

## Instructions
* Code must be in this folder 'protected/extensions/yii-jade/'
* Since I'm using git submodules, you need to init them:

    ```bash
    cd protected/extensions/yii-jade
    git submodule init
    git submodule update
    ```
    
* Add this to your 'config/main.php' file:
    
    ```php
    'components'=>array(
        ...
        'viewRenderer'=>array(
            'class' => 'ext.yii-jade.CJadeViewRenderer',
        ),
        ...
    ```
* You may want to add the following line, so the compiled templates will have passed data to a template in the main var list

   ```php
            'prepend' => array('<?php extract((array)$data); ?>'),
   ```

* Jade templates must have '.jade' extension
