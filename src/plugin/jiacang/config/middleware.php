<?php

return [
    '' => [
        plugin\jicang\app\middleware\AccessControl::class,
        plugin\jicang\app\middleware\LoginControl::class,
        plugin\jicang\app\middleware\AuthControl::class,
        plugin\jicang\app\middleware\OperationLog::class
    ]
];
