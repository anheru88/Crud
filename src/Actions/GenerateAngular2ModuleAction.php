<?php

namespace llstarscreamll\Crud\Actions;

use Illuminate\Http\Request;

use llstarscreamll\Crud\Tasks\CreateAngular2DirsTask;
use llstarscreamll\Crud\Tasks\CreateNgModulesTask;

/**
 * GenerateAngular2ModuleAction Class.
 *
 * @author Johan Alvarez <llstarscreamll@hotmail.com>
 */
class GenerateAngular2ModuleAction
{
    public function run(Request $request)
    {
        // generate the base folders
        $createAngular2DirsTask = new CreateAngular2DirsTask($request);
        $createAngular2DirsTask->run();

        // generate module and routing module
        $createNgModulesTask = new CreateNgModulesTask($request);
        $createNgModulesTask->run();
    }
}
