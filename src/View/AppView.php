<?php
declare(strict_types=1);

/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     3.0.0
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\View;

use Cake\View\View;

/**
 * Application View
 *
 * Your application's default view class
 *
 * @link https://book.cakephp.org/4/en/views.html#the-app-view
 */
class AppView extends View
{
    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading helpers.
     *
     * e.g. `$this->loadHelper('Html');`
     *
     * @return void
     */
    public function initialize(): void
    {
    	$this->loadHelper('Fraction');
    	$this->loadHelper('Markdown');

        $this->loadHelper('Form', [
            'templates' => [
                'inputContainer' => '<div class="mb-3">{{content}}</div>',
                'inputContainerError' => '<div class="mb-3 has-validation">{{content}}{{error}}</div>',
                'label' => '<label class="form-label"{{attrs}}>{{text}}</label>',
                'input' => '<input type="{{type}}" name="{{name}}" class="form-control"{{attrs}}/>',
                'textarea' => '<textarea name="{{name}}" class="form-control"{{attrs}}>{{value}}</textarea>',
                'select' => '<select name="{{name}}" class="form-select"{{attrs}}>{{content}}</select>',
                'selectMultiple' => '<select name="{{name}}[]" multiple="multiple" class="form-select"{{attrs}}>{{content}}</select>',
                'checkbox' => '<input type="checkbox" name="{{name}}" value="{{value}}" class="form-check-input"{{attrs}}>',
                'checkboxWrapper' => '<div class="form-check">{{label}}</div>',
                'error' => '<div class="invalid-feedback d-block">{{content}}</div>',
                'submitContainer' => '<div class="submit">{{content}}</div>',
                'nestingLabel' => '{{hidden}}<label class="form-check-label"{{attrs}}>{{input}}{{text}}</label>',
            ],
        ]);

        $this->loadHelper('Paginator', [
            'templates' => [
                'nextActive' => '<li class="page-item"><a class="page-link ajaxLink" href="{{url}}">{{text}}</a></li>',
                'nextDisabled' => '<li class="page-item disabled"><a class="page-link" href="" onclick="return false;">{{text}}</a></li>',
                'prevActive' => '<li class="page-item"><a class="page-link ajaxLink" href="{{url}}">{{text}}</a></li>',
                'prevDisabled' => '<li class="page-item disabled"><a class="page-link" href="" onclick="return false;">{{text}}</a></li>',
                'number' => '<li class="page-item"><a class="page-link ajaxLink" href="{{url}}">{{text}}</a></li>',
                'current' => '<li class="page-item active"><a class="page-link" href="">{{text}}</a></li>',
                'first' => '<li class="page-item"><a class="page-link ajaxLink" href="{{url}}">{{text}}</a></li>',
                'last' => '<li class="page-item"><a class="page-link ajaxLink" href="{{url}}">{{text}}</a></li>',
                'ellipsis' => '<li class="page-item disabled"><a class="page-link" href="">...</a></li>',
                'sort' => '<a class="ajaxLink" href="{{url}}">{{text}}</a>',
                'sortAsc' => '<a class="ajaxLink" href="{{url}}">{{text}} <i class="bi bi-sort-up"></i></a>',
                'sortDesc' => '<a class="ajaxLink" href="{{url}}">{{text}} <i class="bi bi-sort-down"></i></a>',
            ],
        ]);
    }
}
