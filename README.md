Yiijade
========
Yii's extension for Jade template system

## Instructions
* Place this code into 'protected/extensions/yiijade/' folder
* Add this to your 'config/main.php' file:
    
    ```php
    'components'=>array(
        ...
        'viewRenderer'=>array(
            'class' => 'ext.yiijade.CJadeViewRenderer',
        ),
        ...
    ```

* Jade templates must have '.jade' extension
