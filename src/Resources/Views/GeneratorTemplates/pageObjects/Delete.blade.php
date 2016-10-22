<?php
/* @var $gen llstarscreamll\CrudGenerator\Providers\TestsGenerator */
/* @var $fields [] */
/* @var $test [] */
/* @var $request Request */
?>
<?='<?php'?>


<?= $gen->getClassCopyRightDocBlock() ?>


namespace Page\Functional\{{$gen->studlyCasePlural()}};

use Page\Functional\{{$gen->studlyCasePlural()}}\Base;

class {{$test}} extends Base
{
    // include url of current page
    public static $URL = '/{{$gen->route()}}';

    /**
     * Los atributos del botón de mover a la papelera.
     * @var array
     */
    static $deleteBtn = array();

    /**
     * Los atributos del botón de confirmación de mover a la papelera.
     * @var array
     */
    static $deleteBtnConfirm = array();

    /**
     * Los atributos del mensaje de confirmación de la operación.
     * @var array
     */
    static $msgSuccess = array();

    /**
     * Los atributos del mensaje cuando no se encontran datos.
     * @var array
     */
    static $msgNoDataFount = array();

    public function __construct(\FunctionalTester $I)
    {
        parent::__construct($I);

        self::$deleteBtn = [
            'txt'       => trans('{{$gen->getLangAccess()}}/views.show.btn-trash'),
            'selector'  => 'button.btn.btn-danger'
        ];

        self::$deleteBtnConfirm = [
            'txt'       => trans('{{$gen->getLangAccess()}}/views.show.modal-confirm-trash-btn-confirm'),
            'selector'  => 'form[name=delete-{{$gen->getDashedModelName()}}-form] .btn.btn-danger'
        ];

        self::$msgSuccess = [
            'txt'       => trans_choice('{{$gen->getLangAccess()}}/messages.destroy_{{$gen->snakeCaseSingular()}}_success', 1),
            'selector'  => '{{config('modules.CrudGenerator.uimap.alert-success-selector')}}'
        ];

        self::$msgNoDataFount = [
            'txt'       => trans('{{$gen->getLangAccess()}}/views.index.no-records-found'),
            'selector'  => '{{config('modules.CrudGenerator.uimap.alert-warning-selector')}}'
        ];
    }
}